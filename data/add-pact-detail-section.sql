-- Agregar sección pact-detail a la base de datos
-- Ejecutar esto en la base de datos para que no tire 404

-- Verificar si ya existe
SELECT * FROM public_sections WHERE slug = 'pact-detail';

-- Si no existe, insertarla
INSERT INTO public_sections (slug, title, sort_order) 
VALUES ('pact-detail', 'Detalle de Pacto', 3)
ON CONFLICT (slug) DO NOTHING;

-- Reordenar las secciones posteriores (opcional)
UPDATE public_sections SET sort_order = 4 WHERE slug = 'contact';
UPDATE public_sections SET sort_order = 5 WHERE slug = 'cart';
UPDATE public_sections SET sort_order = 6 WHERE slug = 'profile';
UPDATE public_sections SET sort_order = 7 WHERE slug = 'orders';
UPDATE public_sections SET sort_order = 8 WHERE slug = 'register';
UPDATE public_sections SET sort_order = 9 WHERE slug = 'login';
UPDATE public_sections SET sort_order = 10 WHERE slug = '404';

-- Verificar resultado
SELECT slug, title, sort_order FROM public_sections ORDER BY sort_order;
