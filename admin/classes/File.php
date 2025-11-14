<?php
declare(strict_types=1);

require_once __DIR__ . '/../../classes/DbConnection.php';

class File
{
    /**
     * Upload a file to the uploads directory and store metadata in database
     */
    public static function upload(array $fileData, string $type = 'other'): int
    {
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $fileData['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes, true)) {
            throw new Exception("Invalid file type. Only JPG, PNG, GIF, and WebP are allowed");
        }

        // Validate file size (max 5MB)
        if ($fileData['size'] > 5 * 1024 * 1024) {
            throw new Exception("File size exceeds 5MB limit");
        }

        // Check for duplicates by checksum
        $fileContent = file_get_contents($fileData['tmp_name']);
        $checksum = hash('sha256', $fileContent);
        
        $pdo = DbConnection::get();
        $checkDuplicate = $pdo->prepare('SELECT id FROM files WHERE checksum = :checksum LIMIT 1');
        $checkDuplicate->execute([':checksum' => $checksum]);
        $existing = $checkDuplicate->fetch(PDO::FETCH_ASSOC);
        
        if ($existing) {
            throw new Exception('DUPLICATE_FILE:' . $existing['id']);
        }

        // Generate unique filename
        $originalName = explode(".", $fileData['name']);
        $extension = strtolower(end($originalName));
        $uniqueFilename = rand(10000000, 99999999) . ".$extension";

        // Determine upload directory based on type
        $subFolder = ($type === 'demon') ? 'demons' : (($type === 'pact') ? 'pacts' : 'other');
        $uploadsDir = __DIR__ . "/../../public/assets/img/$subFolder";
        
        if (!file_exists($uploadsDir)) {
            mkdir($uploadsDir, 0755, true);
        }
        
        // Move uploaded file
        $filePath = $uploadsDir . '/' . $uniqueFilename;
        $fileUploaded = move_uploaded_file($fileData['tmp_name'], $filePath);
        
        if (!$fileUploaded) {
            throw new Exception("Failed to upload file to server");
        }

        // Save metadata to database
        $stmt = $pdo->prepare(
            'INSERT INTO files (filename, mime_type, byte_size, checksum) 
             VALUES (:filename, :mime_type, :byte_size, :checksum)'
        );

        $stmt->execute([
            ':filename' => "$subFolder/$uniqueFilename",
            ':mime_type' => $mimeType,
            ':byte_size' => $fileData['size'],
            ':checksum' => $checksum
        ]);

        return (int)$pdo->lastInsertId();
    }

    /**
     * Delete a file by ID (removes physical file and database record)
     */
    public static function delete(int $id): bool
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('SELECT filename FROM files WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $file = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$file) {
            return false;
        }

        // Delete physical file
        $filePath = __DIR__ . '/../../public/assets/img/' . $file['filename'];
        if (file_exists($filePath)) {
            $fileDeleted = unlink($filePath);
            if (!$fileDeleted) {
                throw new Exception("Failed to delete physical file");
            }
        }

        // Delete from database
        $stmt = $pdo->prepare('DELETE FROM files WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }



    /**
     * Serve file content directly (for image display)
     */
    public static function serve(int $id): void
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('SELECT filename, mime_type FROM files WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $file = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$file) {
            http_response_code(404);
            echo "File not found";
            exit;
        }

        $filePath = __DIR__ . '/../../public/assets/img/' . $file['filename'];

        if (!file_exists($filePath)) {
            http_response_code(404);
            echo "Physical file not found";
            exit;
        }

        header('Content-Type: ' . $file['mime_type']);
        header('Content-Disposition: inline; filename="' . $file['filename'] . '"');
        
        readfile($filePath);
        exit;
    }
}
