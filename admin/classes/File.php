<?php
declare(strict_types=1);

require_once __DIR__ . '/../../classes/DbConnection.php';

class File
{
    private int $id;
    private string $filename;
    private string $mimeType;
    private int $byteSize;
    private string $checksum;
    private ?string $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getByteSize(): int
    {
        return $this->byteSize;
    }

    public function getChecksum(): string
    {
        return $this->checksum;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getFullPath(): string
    {
        return __DIR__ . '/../../public/assets/img/' . $this->filename;
    }

    public function getUrl(): string
    {
        return '/assets/img/' . $this->filename;
    }

    /**
     * buscar por id
    */
    public static function find(int $id): ?self
    {
        $pdo = DbConnection::get();
        $stmt = $pdo->prepare('SELECT * FROM files WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$data) {
            return null;
        }

        $file = new self();
        $file->id = (int)$data['id'];
        $file->filename = $data['filename'];
        $file->mimeType = $data['mime_type'];
        $file->byteSize = (int)$data['byte_size'];
        $file->checksum = $data['checksum'];
        $file->createdAt = $data['created_at'] ?? null;

        return $file;
    }

    /**
     * subir el archivo con su tipo
     */
    public static function upload(array $fileData, string $type = 'other'): int
    {
        // validar tipo de archivo
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $fileData['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes, true)) {
            throw new Exception("Tipo de archivo inválido. Solo se permiten JPG, PNG, GIF y WebP");
        }

        // maximo 5MB
        if ($fileData['size'] > 5 * 1024 * 1024) {
            throw new Exception("El tamaño del archivo excede el límite de 5MB");
        }

        // verificar duplicados por checksum
        $fileContent = file_get_contents($fileData['tmp_name']);
        $checksum = hash('sha256', $fileContent);
        
        $pdo = DbConnection::get();
        $checkDuplicate = $pdo->prepare('SELECT id FROM files WHERE checksum = :checksum LIMIT 1');
        $checkDuplicate->execute([':checksum' => $checksum]);
        $existing = $checkDuplicate->fetch(PDO::FETCH_ASSOC);
        
        if ($existing) {
            throw new Exception('ARCHIVO_DUPLICADO:' . $existing['id']);
        }

        // generar nombre de archivo único
        $originalName = explode(".", $fileData['name']);
        $extension = strtolower(end($originalName));
        $uniqueFilename = rand(10000000, 99999999) . ".$extension";

        // determinar directorio de subida basado en el tipo de imagen
        $subFolder = ($type === 'demon') ? 'demons' : (($type === 'pact') ? 'pacts' : 'other');
        $uploadsDir = __DIR__ . "/../../public/assets/img/$subFolder";
        
        if (!file_exists($uploadsDir)) {
            mkdir($uploadsDir, 0755, true);
        }
        
        // mover archivo subido
        $filePath = $uploadsDir . '/' . $uniqueFilename;
        $fileUploaded = move_uploaded_file($fileData['tmp_name'], $filePath);
        
        if (!$fileUploaded) {
            throw new Exception("Error al subir el archivo al servidor");
        }
        
        // guardar metadata en la base de datos
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
     * borrar archivo (elimina el archivo físico y el registro de la base de datos)
     */
    public function delete(): bool
    {
        $pdo = DbConnection::get();
        
        // borrar archivo físico
        $filePath = $this->getFullPath();
        if (file_exists($filePath)) {
            $fileDeleted = unlink($filePath);
            if (!$fileDeleted) {
                throw new Exception("Error al borrar el archivo físico");
            }
        }

        // borrar de la base de datos
        $stmt = $pdo->prepare('DELETE FROM files WHERE id = :id');
        return $stmt->execute([':id' => $this->id]);
    }

    /**
     * borrar archivo por ID (elimina el archivo físico y el registro de la base de datos)
     */
    public static function deleteById(int $id): bool
    {
        $file = self::find($id);
        
        if (!$file) {
            return false;
        }

        return $file->delete();
    }



    /**
     * servir el contenido del archivo directamente (para mostrar imágenes)
     */
    public function serve(): void
    {
        $filePath = $this->getFullPath();

        if (!file_exists($filePath)) {
            http_response_code(404);
            echo "Archivo físico no encontrado";
            exit;
        }

        header('Content-Type: ' . $this->mimeType);
        header('Content-Disposition: inline; filename="' . basename($this->filename) . '"');
        
        readfile($filePath);
        exit;
    }

    /**
     * servir el contenido del archivo directamente por ID (para mostrar imágenes)
     */
    public static function serveById(int $id): void
    {
        $file = self::find($id);
        
        if (!$file) {
            http_response_code(404);
            echo "File not found";
            exit;
        }

        $file->serve();
    }
}
