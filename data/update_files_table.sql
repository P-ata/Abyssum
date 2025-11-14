-- Actualizar tabla files para usar sistema de archivos físicos
-- Ejecutar esto si ya tenías datos en la columna 'data'

-- Eliminar la columna 'data' (ya no guardamos binarios en DB)
ALTER TABLE files DROP COLUMN IF EXISTS data;

-- Eliminar constraint UNIQUE de filename (permitir mismo nombre en diferentes carpetas)
ALTER TABLE files DROP INDEX IF EXISTS ux_files_filename;

-- La tabla ahora solo guarda metadatos:
-- id, filename (con subfolder: demons/xxx.jpg), mime_type, byte_size, checksum, created_at
