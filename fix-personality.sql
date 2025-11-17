-- Actualizar personality de Apex (id=5)
UPDATE demons SET personality = '{"core": "calculador, directo, sin sentimentalismos", "quirks": ["tiende a marcar el ritmo de una pelea como si fuera metrónomo", "no disfruta futilidad: si algo no aporta ventaja, lo descarta"], "toward_vassals": "exigente: respeta la disciplina y la efectividad", "toward_opponents": "frío, analiza flancos y vulnerabilidades"}' WHERE id = 5;

-- Actualizar aliases de Apex (id=5)
UPDATE demons SET aliases = '["Apex de Agujas", "Cronox", "El Coronado", "Apex Spina"]' WHERE id = 5;

-- Actualizar weaknesses_limits de Apex (id=5)
UPDATE demons SET weaknesses_limits = '["requiere espacio y líneas de acción para latigazos/maniobras", "técnicas muy potentes tienen cooldown y exigen preparación mental", "ciertas aleaciones \'antipacto\' pueden bloquear la penetración del Corte Fásico", "no otorga fuerza bruta ilimitada: optimiza técnica, no masa"]' WHERE id = 5;

-- Actualizar personality de Nexum (id=6)
UPDATE demons SET personality = '{"core": "metódico, paciente, analítico", "toward_vassals": "exige cumplimiento estricto de condiciones; recompensa la precisión", "toward_opponents": "desprecia la improvisación; actúa midiendo consecuencias", "quirks": ["responde con referencias a cláusulas imaginarias", "prefiere conversar en términos de contratos y condiciones"]}' WHERE id = 6;

-- Actualizar aliases de Nexum (id=6)
UPDATE demons SET aliases = '["Nexum Archivista", "El Notario", "Nex", "Vinculo"]' WHERE id = 6;

-- Actualizar weaknesses_limits de Nexum (id=6)
UPDATE demons SET weaknesses_limits = '["no copia poderes sobrenaturales ni estados permanentes", "su Axioma de Verdad marca incoherencias, pero no revela contexto completo", "algunas culturas/rituales locales pueden bloquear sus sellos", "funciona peor en entornos caóticos sin registros ni testigos"]' WHERE id = 6;

-- Actualizar personality de Aurelia (id=7)
UPDATE demons SET personality = '{"core": "reservada, protectora de secretos, pragmática", "toward_vassals": "misericorde con aquellos que respetan la discreción; dura con los que exponen", "toward_opponents": "evasiva: evita combate directo si puede", "quirks": ["prefiere hablar en metáforas nocturnas", "tiende a encender su lámpara cuando hace una observación importante"]}' WHERE id = 7;

-- Actualizar aliases de Aurelia (id=7)
UPDATE demons SET aliases = '["Aurelia Velo", "La Portadora", "Lámpara de Umbras"]' WHERE id = 7;

-- Actualizar weaknesses_limits de Aurelia (id=7)
UPDATE demons SET weaknesses_limits = '["sus poderes se debilitan bajo luz intensa e industrial", "no suprime sonidos por sí sola (los pasos y clanks siguen detectables)", "algunas tecnologías lumínicas avanzadas (drones, escáneres) reducen efectividad", "los objetos de sombra son frágiles frente a reflectores o campos anti-magia"]' WHERE id = 7;

-- Actualizar personality de Tumulus (id=8)
UPDATE demons SET personality = '{"core": "adaptable, astuto, teatral", "toward_vassals": "manifiesta curiosidad y ofrece recursos para quienes saben guardar secretos", "toward_opponents": "se burla mediante imitaciones; evita el combate directo", "quirks": ["cambia de entonación sin esfuerzo", "colecciona frases y modismos de sus víctimas"]}' WHERE id = 8;

-- Actualizar aliases de Tumulus (id=8)
UPDATE demons SET aliases = '["Tumulus el Mímico", "La Bolsa de Cabezas", "El Cambiante"]' WHERE id = 8;

-- Actualizar weaknesses_limits de Tumulus (id=8)
UPDATE demons SET weaknesses_limits = '["las biometrias avanzadas y análisis forense pueden detectar discrepancias", "requiere muestras o referencias para imitar con precisión (voz, rostro, escritura)", "no aporta conocimientos técnicos ni recuerdos verdaderos del sujeto imitado", "activaciones largas o múltiples identidades dejan residuos perceptibles (microgestos, tics)"]' WHERE id = 8;
