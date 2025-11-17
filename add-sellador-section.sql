INSERT INTO public_sections (slug, title, sort_order)
SELECT 'sellador', 'El Sellador', 25
WHERE NOT EXISTS (SELECT 1 FROM public_sections WHERE slug = 'sellador');
