-- =====================================================
-- MIGRACIÓN DE SECCIONES DE JSON A BASE DE DATOS
-- =====================================================

-- Insertar secciones públicas desde sections.json
INSERT INTO public_sections (slug, title, sort_order) VALUES
('abyssum', 'Abyssum: Pactos de Demonios', 1),
('pacts', 'Pacts', 2),
('contact', 'Contacto', 3),
('cart', 'Tu Carrito', 4),
('profile', 'Mi Perfil', 5),
('orders', 'Mis Órdenes', 6),
('register', 'Registro de Usuario', 7),
('login', 'Iniciar Sesión', 8),
('404', 'Página no encontrada', 9);

-- Insertar secciones de admin desde admin_sections.json
INSERT INTO admin_sections (slug, title, icon, required_role, sort_order) VALUES
('dashboard', 'Panel de administración', '📊', 'admin', 1),
('pacts', 'Listado de pactos', '📜', 'admin', 2),
('users', 'Listado de usuarios', '👥', 'admin', 3),
('orders', 'Gestión de Órdenes', '🛒', 'admin', 4),
('contacts', 'Mensajes de Contacto', '📧', 'admin', 5),
('new-pact', 'Crear un nuevo Pact', '➕', 'admin', 6),
('edit-pact', 'Editar Pacto', '✏️', 'admin', 7),
('new-demon', 'Crear un nuevo Demonio', '➕', 'admin', 8),
('edit-demon', 'Editar Demonio', '✏️', 'admin', 9),
('404', 'Página no encontrada', '❌', 'admin', 10);

-- Verificar inserciones
SELECT 'PUBLIC SECTIONS:' as table_name, COUNT(*) as total FROM public_sections
UNION ALL
SELECT 'ADMIN SECTIONS:', COUNT(*) FROM admin_sections;
