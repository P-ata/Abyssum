<?php
declare(strict_types=1);

require_once __DIR__ . '/../../classes/DbConnection.php';

class File
{
    public ?int $id = null;
    public ?string $filename = null;
    public ?string $mime_type = null;
    public ?int $byte_size = null;
    public ?string $checksum = null;
    public ?string $data = null; // base64 encoded
    public ?string $created_at = null;

    /**
     * Upload a file and store it in the database
     * 
     * @param array<string, mixed> $fileData File data from $_FILES
     * @return int The ID of the inserted file
     * @throws Exception if upload fails
     */
    public static function upload(array $fileData): int
    {
        // Validate file was uploaded
        if (empty($fileData['tmp_name']) || $fileData['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("No file uploaded or upload error occurred");
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $fileData['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes, true)) {
            throw new Exception("Invalid file type. Only JPG, PNG, GIF, and WebP are allowed");
        }

        // Validate file size (max 5MB)
        $fileSize = $fileData['size'];
        if ($fileSize > 5 * 1024 * 1024) {
            throw new Exception("File size exceeds 5MB limit");
        }

        // Read file content
        $fileContent = file_get_contents($fileData['tmp_name']);
        if ($fileContent === false) {
            throw new Exception("Failed to read uploaded file");
        }

        // Generate unique filename (timestamp + random number only)
        $extension = strtolower(pathinfo($fileData['name'], PATHINFO_EXTENSION));
        $uniqueFilename = time() . '_' . rand(100000, 999999) . '.' . $extension;

        // Calculate checksum
        $checksum = hash('sha256', $fileContent);
        
        // Check if file already exists by checksum (avoid duplicates)
        $pdo = DbConnection::get();
        $checkDuplicate = $pdo->prepare('SELECT id FROM files WHERE checksum = :checksum LIMIT 1');
        $checkDuplicate->execute([':checksum' => $checksum]);
        $existing = $checkDuplicate->fetch(PDO::FETCH_ASSOC);
        
        if ($existing) {
            // File already exists, throw exception with special code
            throw new Exception('DUPLICATE_FILE:' . $existing['id']);
        }

        // Insert into database
        $stmt = $pdo->prepare(
            'INSERT INTO files (filename, mime_type, byte_size, checksum, data) 
             VALUES (:filename, :mime_type, :byte_size, :checksum, :data)'
        );

        // Bind regular parameters
        $stmt->bindParam(':filename', $uniqueFilename, PDO::PARAM_STR);
        $stmt->bindParam(':mime_type', $mimeType, PDO::PARAM_STR);
        $stmt->bindParam(':byte_size', $fileSize, PDO::PARAM_INT);
        $stmt->bindParam(':checksum', $checksum, PDO::PARAM_STR);
        
        // Bind binary data as LOB (critical for LONGBLOB)
        $stmt->bindParam(':data', $fileContent, PDO::PARAM_LOB);
        
        // Execute
        $stmt->execute();

        return (int)$pdo->lastInsertId();
    }

    /**
     * Find a file by ID
     * 
     * @param int $id File ID
     * @return File|null
     */
    public static function find(int $id): ?File
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('SELECT * FROM files WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $file = new self();
        $file->id = (int)$row['id'];
        $file->filename = $row['filename'];
        $file->mime_type = $row['mime_type'];
        $file->byte_size = (int)$row['byte_size'];
        $file->checksum = $row['checksum'];
        $file->data = base64_encode($row['data']);
        $file->created_at = $row['created_at'];

        return $file;
    }

    /**
     * Delete a file by ID
     * 
     * @param int $id File ID
     * @return bool True if deleted successfully
     */
    public static function delete(int $id): bool
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('DELETE FROM files WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Serve file content directly (for image display)
     * 
     * @param int $id File ID
     * @return void
     */
    public static function serve(int $id): void
    {
        $file = self::find($id);
        
        if (!$file) {
            http_response_code(404);
            echo "File not found";
            exit;
        }

        header('Content-Type: ' . $file->mime_type);
        header('Content-Length: ' . $file->byte_size);
        header('Content-Disposition: inline; filename="' . $file->filename . '"');
        
        echo base64_decode($file->data);
        exit;
    }
}
