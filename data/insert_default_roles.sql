-- Insert default roles if they don't exist
INSERT IGNORE INTO roles (id, name, description) VALUES 
(1, 'admin', 'Administrador con acceso completo al sistema'),
(2, 'customer', 'Cliente con acceso al catálogo y funciones de compra');
