-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Nov 17, 2025 at 06:18 AM
-- Server version: 8.0.44
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abyssum`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_sections`
--

CREATE TABLE `admin_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` varchar(200) NOT NULL,
  `required_role` varchar(50) NOT NULL DEFAULT 'admin',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin_sections`
--

INSERT INTO `admin_sections` (`id`, `slug`, `title`, `required_role`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'dashboard', 'Panel de administración', 'admin', 1, '2025-11-15 21:28:56', '2025-11-15 21:28:56'),
(2, 'pacts', 'Listado de pactos', 'admin', 2, '2025-11-15 21:28:56', '2025-11-15 21:28:56'),
(3, 'users', 'Listado de usuarios', 'admin', 3, '2025-11-15 21:28:56', '2025-11-15 21:28:56'),
(4, 'orders', 'Gestión de Órdenes', 'admin', 4, '2025-11-15 21:28:56', '2025-11-15 21:28:56'),
(5, 'contacts', 'Mensajes de Contacto', 'admin', 5, '2025-11-15 21:28:56', '2025-11-15 21:28:56'),
(6, 'new-pact', 'Crear un nuevo Pact', 'admin', 6, '2025-11-15 21:28:56', '2025-11-15 21:28:56'),
(7, 'edit-pact', 'Editar Pacto', 'admin', 7, '2025-11-15 21:28:56', '2025-11-15 21:28:56'),
(8, 'new-demon', 'Crear un nuevo Demonio', 'admin', 8, '2025-11-15 21:28:56', '2025-11-15 21:28:56'),
(9, 'edit-demon', 'Editar Demonio', 'admin', 9, '2025-11-15 21:28:56', '2025-11-15 21:28:56'),
(10, '404', 'Página no encontrada', 'admin', 10, '2025-11-15 21:28:56', '2025-11-15 21:28:56'),
(11, 'demons', 'Demonios', 'admin', 11, '2025-11-16 19:26:11', '2025-11-16 19:26:22'),
(12, 'health', 'Estado del Sistema', 'admin', 12, '2025-11-16 20:10:40', '2025-11-16 20:10:40'),
(13, 'pact-detail', 'Detalle de Pacto', 'admin', 40, '2025-11-17 00:37:13', '2025-11-17 00:37:13'),
(14, 'demon-detail', 'Detalle de Demonio', 'admin', 41, '2025-11-17 00:37:13', '2025-11-17 00:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('pending','completed','cancelled','abandoned') DEFAULT 'pending',
  `total_credits` int NOT NULL DEFAULT '0',
  `currency` varchar(30) NOT NULL DEFAULT 'CREDITOS',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint UNSIGNED NOT NULL,
  `cart_id` bigint UNSIGNED NOT NULL,
  `pact_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `unit_price_credits` int NOT NULL,
  `subtotal_credits` int NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `slug` varchar(80) NOT NULL,
  `display_name` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`slug`, `display_name`, `created_at`) VALUES
('apex', 'apex', '2025-11-12 23:09:43'),
('apoyo', 'apoyo', '2025-11-12 23:09:43'),
('aurelia', 'aurelia', '2025-11-12 23:09:43'),
('combate', 'combate', '2025-11-12 23:09:43'),
('contratos', 'contratos', '2025-11-12 23:09:43'),
('control', 'control', '2025-11-12 23:09:43'),
('disfraz', 'disfraz', '2025-11-12 23:09:43'),
('falsificacion', 'falsificacion', '2025-11-12 23:09:43'),
('inteligencia', 'inteligencia', '2025-11-12 23:09:43'),
('movilidad', 'movilidad', '2025-11-12 23:09:43'),
('nexum', 'nexum', '2025-11-12 23:09:43'),
('sigilo', 'sigilo', '2025-11-12 23:09:43'),
('social', 'social', '2025-11-12 23:09:43'),
('sombras', 'sombras', '2025-11-12 23:09:43'),
('tumulus', 'tumulus', '2025-11-12 23:09:43'),
('utilidad', 'utilidad', '2025-11-12 23:09:43');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('new','in_progress','resolved','spam') NOT NULL DEFAULT 'new',
  `sent_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(45) DEFAULT NULL,
  `handled_by` bigint UNSIGNED DEFAULT NULL,
  `handled_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demons`
--

CREATE TABLE `demons` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(50) NOT NULL,
  `name` varchar(120) NOT NULL,
  `aliases` json DEFAULT NULL,
  `species` varchar(200) DEFAULT NULL,
  `gender` varchar(120) DEFAULT NULL,
  `age_real` varchar(200) DEFAULT NULL,
  `summary` text,
  `lore` mediumtext,
  `full_description` mediumtext,
  `appearance_tags` json DEFAULT NULL,
  `personality` json DEFAULT NULL,
  `preferred_envs` json DEFAULT NULL,
  `abilities_summary` text,
  `stat_strength` tinyint UNSIGNED DEFAULT NULL,
  `stat_dexterity` tinyint UNSIGNED DEFAULT NULL,
  `stat_intelligence` tinyint UNSIGNED DEFAULT NULL,
  `stat_health` tinyint UNSIGNED DEFAULT NULL,
  `stat_reflexes` tinyint UNSIGNED DEFAULT NULL,
  `stat_stealth` tinyint UNSIGNED DEFAULT NULL,
  `stat_mobility` tinyint UNSIGNED DEFAULT NULL,
  `weaknesses_limits` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image_file_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `demons`
--

INSERT INTO `demons` (`id`, `slug`, `name`, `aliases`, `species`, `gender`, `age_real`, `summary`, `lore`, `full_description`, `appearance_tags`, `personality`, `preferred_envs`, `abilities_summary`, `stat_strength`, `stat_dexterity`, `stat_intelligence`, `stat_health`, `stat_reflexes`, `stat_stealth`, `stat_mobility`, `weaknesses_limits`, `created_at`, `updated_at`, `image_file_id`) VALUES
(5, 'apex', 'Apex', '[\"Apex de Agujas\", \"Cronox\", \"El Coronado\"]', 'Entitad Espicular / Demonio de Engranajes', 'neutro (manifestación andrógina)', 'desconocida (se manifiesta como antiguo en simbología)', 'Apex es una entidad de combate: una corona de agujas, aristas vivas y látigos espiculares. En el mundo cyberpunk funciona como donador de técnicas combativas, movilidad extrema y manipulación de puntas/espinas energizadas.', 'Nacido en el cruce entre metal frío y neón, Apex se formó como patrón de filo y coraza en los túneles industriales donde los sistemas de defensa y los rituales de fábrica se entrelazaban. Las fábricas que olvidaron apagar sus máquinas dieron a luz a su primera corona: fragmentos de hornos y aguja fina que, con tiempo y atención, adquirieron voluntad. Cronox —como lo llaman algunos círculos— no siente amor por la violencia por sí misma; la ve como geometría aplicada: ángulo, vector, eficiencia. Suele aparecer donde la ciudad pide orden a través del filo: asaltos, escaramuzas, asedios. Los que pactan con Apex reciben prestada una porción de su mecánica: mejorar los reflejos, proyectar puntas, anclarse al entorno. Como todo pacto, la corona exige adaptación: quien usa sus dones aprende a pensar en aristas y vectores, y a pagar con disciplina corporal y riesgo táctico.', 'Figura alta y delgada, revestida de placas que recuerdan exoesqueleto y corteza ósea. Donde otros muestran carne, Apex exhibe aristas y solapas que se abren en látigos. Su rostro es un cráneo estilizado, coronado por tres o cuatro pináculos brillantes que pulsan cuando activa poderes. Sus movimientos son serpenteantes y calculados; sus \'tentáculos\' actúan con intención independiente. Aunque parece hecho de metal, hay texturas que sugieren tejido: membranas entre placas que vibran como cuerdas tensadas. Por la noche su silueta es un corte limpio en el aire neón.', '[\"corona de púas\", \"látex metálico\", \"látigos espiculares\", \"cráneo estilizado\", \"placas aciculares\", \"brillo teal/ámbar\"]', '{\"core\": \"calculador, directo, sin sentimentalismos\", \"quirks\": [\"tiende a marcar el ritmo de una pelea como si fuera metrónomo\", \"no disfruta futilidad: si algo no aporta ventaja, lo descarta\"], \"toward_vassals\": \"exigente: respeta la disciplina y la efectividad\", \"toward_opponents\": \"frío, analiza flancos y vulnerabilidades\"}', '[\"calles industriales y pasarelas\", \"azoteas con antenas\", \"galpones y fábricas abandonadas\", \"pasajes mojados con reflejos para cálculo de trayectorias\"]', 'Especialista en combate: mejora de reflejos y tiempo subjetivo, proyección de tentáculos/espinas, creación de filos fásicos, anclaje físico y movilidad acrobática. Funciona tanto ofensiva como defensivamente: corta, atrapa, ancla, recarga placas.', 8, 7, 6, 5, 10, 4, 9, '[\"requiere espacio y líneas de acción para latigazos/maniobras\", \"técnicas muy potentes tienen cooldown y exigen preparación mental\", \"ciertas aleaciones \'antipacto\' pueden bloquear la penetración del Corte Fásico\"]', '2025-11-12 23:48:00', '2025-11-17 06:15:05', 87),
(6, 'nexum', 'Nexum', '[\"Nexum Archivista\", \"El Notario\", \"Nex\"]', 'Archivista Espectral / Demonio de Contratos', 'neutro (manifestación andrógina)', 'desconocida (se percibe como antiguo y metódico)', 'Nexum es una entidad de inteligencia y orden: guarda registros, convierte acuerdos en vínculos mágicos y manipula probabilidades y coherencias. En el mundo cyberpunk actúa como broker de información y catalizador de pactos legales o semánticos.', 'Nació en los intersticios entre servidores obsoletos y sellos notariales. Donde la ciudad acumuló contratos, recibos y promesas, Nexum emergió como un archivo viviente: voces que susurran cláusulas, páginas que se reordenan solas. Lo buscan desde abogados clandestinos hasta hackers y organizaciones que necesitan transformar promesas en realidades. Nexum no se apresura: organiza, clasifica y ejecuta. Sus favores siempre vienen envueltos en condiciones; su sentido de justicia es rígido y literal, pero extraño: castiga la incoherencia y premia la precisión.', 'Figura esbelta y austera; la cabeza tiene rasgos geométricos que recuerdan a un sello, con líneas que se iluminan cuando procesa información. Su \'capa\' parece compuesta por hojas de papel oscuro o placas de datos que crujen con un sonido de página al moverse. Donde otros muestran destellos agresivos, Nexum muestra indicadores (runas, filamentos de luz) que marcan cláusulas activas. A su alrededor flotan fragmentos de texto y hologramas de contratos; su presencia ordena los pequeños detalles del entorno.', '[\"sellos luminosos\", \"hojas oscuras\", \"filamentos de neón\", \"fragmentos de texto flotante\", \"perfil geométrico\"]', '{\"core\": \"metódico, paciente, analítico\", \"quirks\": [\"responde con referencias a cláusulas imaginarias\", \"prefiere conversar en términos de contratos y condiciones\"], \"toward_vassals\": \"exige cumplimiento estricto de condiciones; recompensa la precisión\", \"toward_opponents\": \"desprecia la improvisación; actúa midiendo consecuencias\"}', '[\"bibliotecas de datos y archivos\", \"oficinas notariales y salas de juntas\", \"bóvedas de servidores y centros de procesamiento\", \"plazas legales y mercados de información\"]', 'Maestro de la información y de la legalidad mágica: copia conocimientos observados, vuelve vinculantes acuerdos, detecta incoherencias, impone reglas locales y puede inclinar probabilidades. Sus dones son tácticos y sociales; son útiles para espionaje, negociación y control de situaciones.', 3, 7, 10, 7, 8, 4, 5, '[\"no copia poderes sobrenaturales ni estados permanentes\", \"su Axioma de Verdad marca incoherencias, pero no revela contexto completo\", \"algunas culturas/rituales locales pueden bloquear sus sellos\"]', '2025-11-12 23:48:00', '2025-11-17 06:15:27', 89),
(7, 'aurelia', 'Aurelia', '[\"Aurelia Velo\", \"La Portadora\", \"Lámpara de Umbras\"]', 'Entitad Umbral / Demonio de Penumbra', 'femenino (manifestación típica)', 'desconocida (se presenta como antigua en simbolismo, atemporal en práctica)', 'Aurelia es una entidad del dominio de las sombras: domina invisibilidad, movimiento entre penumbras, creación de duplicados ilusorios, forja de objetos de sombra y la generación de una penumbra personal amplia. Sus manifestaciones sirven para sigilo, disfraz y utilidad táctica en entornos urbanos y nocturnos.', 'Aurelia nació en el cruce de faroles oxidados y callejones húmedos, donde la noche y la tecnología imperfecta se entrelazaron. Sus primeros \'susurros\' fueron linternas olvidadas que lamían oscuridad; con el tiempo su figura se estabilizó y empezó a aceptar pactos. En la ciudad, mercaderes del secreto y ladrones recurren a ella: no tanto por maldad como por la promesa de anonimato y resguardo. Sus entregas siempre exigen sutileza; quien la invoca aprende que ocultar algo exige también aprender a renunciar a exhibirlo.', 'Figura esbelta, vestida con ropajes que parecen tela y sombra fundidas; su rostro queda oculto tras un velo y una fina corona metálica que recuerda una pequeña lámpara. De su vestir cuelgan tiras que se disuelven en penumbra y, en la base, se forman púas curvas que parecen absorber luz. Sostiene una lámpara ritual —a veces la única fuente que decide iluminar— cuya luz revela u oculta según su voluntad. Su movimiento es fluido, casi sin ruido; la penumbra que genera tiene peso y textura.', '[\"velo oscuro\", \"lámpara colgante\", \"faldones de sombra\", \"bordes que absorben luz\", \"brillo tenue rojo/teal en costuras\"]', '{\"core\": \"reservada, protectora de secretos, pragmática\", \"quirks\": [\"prefiere hablar en metáforas nocturnas\", \"tiende a encender su lámpara cuando hace una observación importante\"], \"toward_vassals\": \"misericorde con aquellos que respetan la discreción; dura con los que exponen\", \"toward_opponents\": \"evasiva: evita combate directo si puede\"}', '[\"calles angostas y oscuras\", \"mercados nocturnos y puestos con toldos\", \"bibliotecas de contrabando y sótanos\", \"patios internos con poca iluminación\"]', 'Maestra del sigilo y la manipulación de oscuridad: otorga invisibilidad y desplazamiento entre sombras, crea ilusiones y objetos temporales hechos de penumbra, y puede generar un área de oscuridad controlada para ocultar a aliados o movimientos.', 3, 7, 8, 5, 8, 10, 7, '[\"sus poderes se debilitan bajo luz intensa e industrial\", \"no suprime sonidos por sí sola (los pasos y clanks siguen detectables)\", \"algunas tecnologías lumínicas avanzadas (drones, escáneres) reducen efectividad\"]', '2025-11-12 23:48:00', '2025-11-17 06:15:15', 88),
(8, 'tumulus', 'Tumulus', '[\"Tumulus el Mímico\", \"La Bolsa de Cabezas\", \"El Cambiante\"]', 'Entitad Mimética / Demonio de Rostros', 'neutro (manifestación variable)', 'desconocida (se muestra atemporal)', 'Tumulus es una entidad mimética especializada en identidades: replica voces, rostros, caligrafía y crea historias creíbles. Sus pactos son herramientas para infiltración social, falsificación y engaño controlado.', 'Nació donde la ciudad olvidó nombres: vertederos de identidades, bases de datos corruptas y morgues de archivos. Tumulus emergió como un saco vivo de máscaras: cabezas y recuerdos que se ensamblan para adoptar vidas prestadas. Lo buscan traficantes de documentos, espías y ladrones que requieren pasar como otros. No es malvado por naturaleza: su existencia gira en torno al intercambio —tú le das un fragmento de realidad, y él lo transforma en apariencia utilizable— pero sus favores siempre dejan una marca, una resonancia que puede volver.', 'Apariencia bulbosa por arriba, envuelta en capas como vendas o placas que contienen cráneos y rostros en miniatura; por debajo, una estructura humana o casi humana que sostiene el volumen. Cada \'cabeza\' parece conservar un eco: sus ojos vacíos parpadean con luz propia al activarse. Sus movimientos son a veces descoordinados, otras veces fluidos cuando adopta una identidad. Emite un murmullo continuo como si muchas voces practicaran un diálogo interno.', '[\"saco enrollado\", \"cabezas pequeñas incrustadas\", \"textura como vendas metálicas\", \"resplandores neón en fisuras\", \"postura encorvada/ambulante\"]', '{\"core\": \"adaptable, astuto, teatral\", \"quirks\": [\"cambia de entonación sin esfuerzo\", \"colecciona frases y modismos de sus víctimas\"], \"toward_vassals\": \"manifiesta curiosidad y ofrece recursos para quienes saben guardar secretos\", \"toward_opponents\": \"se burla mediante imitaciones; evita el combate directo\"}', '[\"calles de tránsito humano intenso\", \"bares y mercados donde se cruzan identidades\", \"depósitos de documentación y oficinas de registro\", \"pasillos anónimos y trastiendas\"]', 'Especialista en usurpación de identidad: replica voces, apariencia, escritura y manufactura historias inmediatas. Ideal para infiltración social, fraudes y crear cortinas de humo psicológicas.', 3, 6, 8, 5, 6, 9, 5, '[\"las biometrías avanzadas y análisis forense pueden detectar discrepancias\", \"requiere muestras o referencias para imitar con precisión (voz, rostro, escritura)\", \"no aporta conocimientos técnicos ni recuerdos verdaderos del sujeto imitado\"]', '2025-11-12 23:48:00', '2025-11-17 06:15:37', 90);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` bigint UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `byte_size` int UNSIGNED NOT NULL,
  `checksum` char(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `filename`, `mime_type`, `byte_size`, `checksum`, `created_at`) VALUES
(67, 'pacts/20630853.webp', 'image/webp', 1369400, '657fc19867ed2052ced2afefe708488391c14e123a8251644313714d9fb2eaa6', '2025-11-17 06:11:14'),
(68, 'pacts/39605356.webp', 'image/webp', 1247168, 'a6e43149a4cfa663f34bf010f286dfc2ab4780f0bfcae58952045026ef4bf5a0', '2025-11-17 06:11:25'),
(69, 'pacts/28628998.webp', 'image/webp', 1196910, '90b316801f9586dca653a7aa3b2828819d35112318f9f176771da5f98f1f32b7', '2025-11-17 06:11:34'),
(70, 'pacts/61851764.webp', 'image/webp', 1320948, '32a957d4d6b9dd51976296a02d393895cb90cf42bfdd5155f3319aac561f57b3', '2025-11-17 06:11:41'),
(71, 'pacts/41298689.webp', 'image/webp', 1370570, 'a2bf4288ec2f0afc77690344775d6909ca279e969b92304a1f6c7afa9ff40703', '2025-11-17 06:11:49'),
(72, 'pacts/42000006.webp', 'image/webp', 1505740, 'a8ca5d7b717df08428afd26c988811aa3c08b33cdfcfb0c00000d2f1ca7922fc', '2025-11-17 06:11:55'),
(73, 'pacts/50642490.webp', 'image/webp', 1113996, '3ef91b37906d27e44c156b8f1440899905fb7bcb360cc564d257d2f57d6d7b47', '2025-11-17 06:12:08'),
(74, 'pacts/93820368.webp', 'image/webp', 1012466, '2e5c2fd56f17f09086c77ac9dbb4c441580abb9d0b37198da9c0b0313c66b14f', '2025-11-17 06:12:23'),
(75, 'pacts/95307533.webp', 'image/webp', 1402516, 'd40498c75a63397fee1bfdc569e2b69b3d80f7b4f1cdc0ccd4629bacc90f9b6d', '2025-11-17 06:12:31'),
(76, 'pacts/19755546.webp', 'image/webp', 1403780, 'bc61e39da32cecfa9d310f5245082a428727eaee54870802bac52f9d8bce703e', '2025-11-17 06:12:38'),
(77, 'pacts/63643386.webp', 'image/webp', 1348426, '1e378ae265d4120cb55951e0c99683af748c946d142e6ce4d5e82628adeae582', '2025-11-17 06:12:48'),
(78, 'pacts/77926192.webp', 'image/webp', 1068288, '1f346ef43f77d07029fe367697b8f2ca7def3d56cf606d9b7f04d8c48a0505fd', '2025-11-17 06:13:01'),
(79, 'pacts/54867355.webp', 'image/webp', 1507794, 'f5c04f78fb561e553d73c4426c57f779e7dc5f14f4914f3f29689c487f8473c9', '2025-11-17 06:13:11'),
(80, 'pacts/19747377.webp', 'image/webp', 1416282, '0e136473c53e2ac79adf9a25f9bc0cfff2aa9b8c3be598bd499700e544699f51', '2025-11-17 06:13:22'),
(81, 'pacts/29972832.webp', 'image/webp', 1454942, '728f6239e49fa50570ec9c34558dbaaea112152600be81583897e5ef5a893fd7', '2025-11-17 06:13:30'),
(82, 'pacts/85835002.webp', 'image/webp', 1114380, '062fa6d2d151fd6cd7ac21e29a338e13b9af21d927171c95e13b157d3415934d', '2025-11-17 06:13:56'),
(83, 'pacts/17447286.webp', 'image/webp', 1550110, '1f213f685853580cd6ec94029dd5932117a18f2af8bf9a1e54c68a19a0d533cd', '2025-11-17 06:14:16'),
(84, 'pacts/58022811.webp', 'image/webp', 1010584, '01b95a22409128a6830dc2fbbc3708aa543c58435d8b672af36bd3bde9ff00d9', '2025-11-17 06:14:26'),
(85, 'pacts/84819920.webp', 'image/webp', 1342216, '758d03ca1880849b2f0402f63762bdda56115fd82733b5380c04dbb0d1ee403e', '2025-11-17 06:14:37'),
(86, 'pacts/19762471.webp', 'image/webp', 1453748, 'a6a57fca1ea455589e42fb5cee6aff420af2fa7430b311d900fadc91db681008', '2025-11-17 06:14:48'),
(87, 'demons/78020608.webp', 'image/webp', 1044052, 'a01e7820c50571d8939f5adaf9db014addbdc85c6d7d0f759956f42dfab9eb5b', '2025-11-17 06:15:05'),
(88, 'demons/91959870.webp', 'image/webp', 874418, '1791b8ad7aca77d45c895d63aa032b13586f3cb71c2a913e1b03c4fa27efe822', '2025-11-17 06:15:15'),
(89, 'demons/45423737.webp', 'image/webp', 739040, 'bfc45aaefcc2b062876c70af26716223164d1fd0ee45734d7f18d078c110e73b', '2025-11-17 06:15:27'),
(90, 'demons/77535071.webp', 'image/webp', 1012620, 'ee04dc1f77add5d6e12d49bd153f5a8b3d04fd562c4e2d3bce697d8d37e6d3a0', '2025-11-17 06:15:37');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `cart_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('placed','paid','fulfilled','refunded','cancelled') NOT NULL DEFAULT 'placed',
  `total_credits` int NOT NULL,
  `currency` varchar(30) NOT NULL DEFAULT 'CREDITOS',
  `placed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `paid_at` datetime DEFAULT NULL,
  `fulfilled_at` datetime DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `pact_id` bigint UNSIGNED NOT NULL,
  `unit_price_credits` int NOT NULL,
  `subtotal_credits` int NOT NULL,
  `snapshot` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Table structure for table `pacts`
--

CREATE TABLE `pacts` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(120) DEFAULT NULL,
  `demon_id` bigint UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `summary` text,
  `duration` varchar(120) DEFAULT NULL,
  `cooldown` varchar(120) DEFAULT NULL,
  `limitations` json DEFAULT NULL,
  `price_credits` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image_file_id` bigint UNSIGNED DEFAULT NULL
) ;

--
-- Dumping data for table `pacts`
--

INSERT INTO `pacts` (`id`, `slug`, `demon_id`, `name`, `summary`, `duration`, `cooldown`, `limitations`, `price_credits`, `created_at`, `updated_at`, `image_file_id`) VALUES
(1, 'overclock-de-corona', 5, 'Overclock de Corona', 'Percibís el entorno más lento y actuás con reflejos optimizados.', '1 minuto', '5 minutos', '[\"No aumenta fuerza física.\", \"Requiere concentración para no sobrerreaccionar.\"]', 2400, '2025-11-12 23:48:00', '2025-11-17 06:12:48', 77),
(2, 'latigos-aciculares', 5, 'Látigos Aciculares', 'Invocás tentáculos armados para alcance, agarre y movilidad.', '2 minutos', '3 minutos', '[\"Visibles para todos; difícil de ocultar.\", \"Requiere espacio libre para maniobrar.\"]', 2600, '2025-11-12 23:48:00', '2025-11-17 06:14:48', 86),
(3, 'corte-fasico', 5, 'Corte Fásico', 'Formás un filo extremo capaz de cortar metal y blindaje localizado.', '15 segundos', '2 minutos', '[\"Necesita contacto directo.\", \"No atraviesa materiales especializados antipacto.\"]', 2700, '2025-11-12 23:48:00', '2025-11-17 06:14:37', 85),
(4, 'garra-ancla', 5, 'Garra Ancla', 'Transformás una mano en garra para atacar, bloquear, trepar o anclarte.', '5 minutos', '10 minutos', '[\"Solo una mano por activación.\", \"Reduce precisión en tareas finas.\"]', 1600, '2025-11-12 23:48:00', '2025-11-17 06:14:26', 84),
(5, 'latencia-cero', 5, 'Latencia Cero', 'Casi eliminás el delay entre intención y movimiento.', '30 segundos', '3 minutos', '[\"No corrige malas decisiones.\", \"Coordinar con otros puede ser más difícil.\"]', 3000, '2025-11-12 23:48:00', '2025-11-17 06:14:16', 83),
(6, 'archivo-mnemotico', 6, 'Archivo Mnemótico', 'Copiás temporalmente una habilidad o conocimiento técnico que acabás de ver.', '2 horas', '1 hora', '[\"Solo habilidades humanas o tecnológicas observables.\", \"No copia poderes sobrenaturales ni estados permanentes.\"]', 1800, '2025-11-12 23:48:00', '2025-11-17 06:13:56', 82),
(7, 'sello-notarial', 6, 'Sello Notarial', 'Convertís un acuerdo hablado o escrito en un pacto obligado para todas las partes.', 'ilimitado (hasta que se cumpla o rompa)', NULL, '[\"Requiere consentimiento explícito de todas las partes.\", \"No puede forzar autodaño directo ni romper leyes físicas.\"]', 2600, '2025-11-12 23:48:00', '2025-11-17 06:13:30', 81),
(8, 'axioma-de-verdad', 6, 'Axioma de Verdad', 'Detectás al instante cuando alguien oculta o distorsiona información clave.', '20 minutos', '1 hora', '[\"No muestra la verdad completa; solo marca incoherencias.\", \"En grupos grandes se vuelve menos preciso.\"]', 1550, '2025-11-12 23:48:00', '2025-11-17 06:13:22', 80),
(9, 'clausula-local', 6, 'Cláusula Local', 'Imponés una única regla simple en una zona limitada.', '90 segundos', '10 minutos', '[\"La regla debe ser concreta (ej: \'nadie dispara\', \'nadie cruza la puerta\').\", \"No obliga acciones complejas ni tortura.\"]', 2100, '2025-11-12 23:48:00', '2025-11-17 06:13:11', 79),
(10, 'pivote-de-probabilidad', 6, 'Pivote de Probabilidad', 'Inclinás levemente a tu favor el resultado de un evento posible.', NULL, NULL, '[\"Solo sobre eventos posibles en curso.\", \"No afecta sorteos masivos ni sucesos globales.\"]', 3200, '2025-11-12 23:48:00', '2025-11-17 06:13:01', 78),
(11, 'velo-umbral', 7, 'Velo Umbral', 'Te volvés casi invisible si permanecés en sombras o penumbra cercana.', 'hasta 60 segundos por activación', '1 minuto', '[\"La invisibilidad se reduce en luz directa intensa.\", \"No silencia pasos ni ruido metálico.\"]', 950, '2025-11-12 23:48:00', '2025-11-17 06:11:14', 67),
(12, 'paso-entre-sombras', 7, 'Paso Entre Sombras', 'Te desplazás instantáneamente entre dos sombras dentro de tu campo visual.', NULL, '15 segundos', '[\"Requiere línea de visión entre origen y destino.\", \"No transporta objetos individuales mayores a 40 kg fuera de tu cuerpo.\"]', 1100, '2025-11-12 23:48:00', '2025-11-17 06:12:38', 76),
(13, 'clones-velados', 7, 'Clones Velados', 'Proyectás hasta 3 ilusiones que imitan tus movimientos para confundir.', '45 segundos', '2 minutos', '[\"No infligen daño.\", \"Se desvanecen al contacto directo o bajo reflectores fuertes.\"]', 980, '2025-11-12 23:48:00', '2025-11-17 06:12:31', 75),
(14, 'forja-sombria', 7, 'Forja Sombría', 'Condensás sombras en herramientas simples y armas cuerpo a cuerpo.', '1 hora', NULL, '[\"Solo formas simples (cuchillos, cuerdas, ganzúas, escudos pequeños).\", \"Se debilitan en zonas excesivamente iluminadas.\"]', 1020, '2025-11-12 23:48:00', '2025-11-17 06:12:23', 74),
(15, 'noche-personal', 7, 'Noche Personal', 'Creás una penumbra controlada a tu alrededor para ocultar movimiento.', '60 segundos', '5 minutos', '[\"No apaga luces industriales pesadas.\", \"Aliados dentro del área también ven menos.\"]', 1300, '2025-11-12 23:48:00', '2025-11-17 06:12:08', 73),
(16, 'eco-vocal', 8, 'Eco Vocal', 'Reproducís con precisión la voz y acento de alguien.', '60 minutos', '1 hora', '[\"Necesitás al menos 20 segundos de muestra clara.\", \"No copia conocimientos ni pensamientos.\"]', 700, '2025-11-12 23:48:00', '2025-11-17 06:11:55', 72),
(17, 'rostro-prestado', 8, 'Rostro Prestado', 'Tomás la apariencia física general de alguien que viste.', '90 minutos', '3 horas', '[\"Solo una identidad activa a la vez.\", \"Biometrías avanzadas pueden detectar diferencias.\"]', 1450, '2025-11-12 23:48:00', '2025-11-17 06:11:49', 71),
(18, 'caligrafia-espejo', 8, 'Caligrafía Espejo', 'Imitás escritura, estilo de chat y tono de mensajes de un objetivo.', '8 horas', NULL, '[\"Requiere muestras previas suficientes.\", \"Sistemas forenses avanzados pueden rastrear patrones.\"]', 620, '2025-11-12 23:48:00', '2025-11-17 06:11:41', 70),
(19, 'amistosa-historia', 8, 'Amistosa Historia', 'Generás la impresión inmediata de tener un pasado creíble en común.', '30 minutos', NULL, '[\"Funciona mejor en primeros encuentros.\", \"Preguntas muy específicas pueden romper la ilusión.\"]', 900, '2025-11-12 23:48:00', '2025-11-17 06:11:34', 69),
(20, 'cuerpo-inerte', 8, 'Cuerpo Inerte', 'Simulás inconsciencia total o muerte aparente ante inspección rápida.', 'hasta 15 minutos', '1 hora', '[\"Seguís consciente internamente.\", \"Pruebas médicas profundas pueden notar anomalías.\"]', 1250, '2025-11-12 23:48:00', '2025-11-17 06:11:25', 68);

-- --------------------------------------------------------

--
-- Table structure for table `pact_categories`
--

CREATE TABLE `pact_categories` (
  `pact_id` bigint UNSIGNED NOT NULL,
  `category_slug` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pact_categories`
--

INSERT INTO `pact_categories` (`pact_id`, `category_slug`) VALUES
(1, 'apoyo'),
(5, 'apoyo'),
(6, 'apoyo'),
(7, 'apoyo'),
(8, 'apoyo'),
(10, 'apoyo'),
(18, 'apoyo'),
(20, 'apoyo'),
(1, 'combate'),
(2, 'combate'),
(3, 'combate'),
(4, 'combate'),
(5, 'combate'),
(14, 'combate'),
(7, 'contratos'),
(9, 'contratos'),
(9, 'control'),
(15, 'control'),
(13, 'disfraz'),
(16, 'disfraz'),
(17, 'disfraz'),
(19, 'disfraz'),
(16, 'falsificacion'),
(18, 'falsificacion'),
(6, 'inteligencia'),
(8, 'inteligencia'),
(10, 'inteligencia'),
(1, 'movilidad'),
(2, 'movilidad'),
(4, 'movilidad'),
(12, 'movilidad'),
(11, 'sigilo'),
(13, 'sigilo'),
(15, 'sigilo'),
(20, 'sigilo'),
(8, 'social'),
(16, 'social'),
(17, 'social'),
(19, 'social'),
(11, 'sombras'),
(12, 'sombras'),
(14, 'sombras'),
(15, 'sombras'),
(3, 'utilidad'),
(4, 'utilidad'),
(14, 'utilidad');

-- --------------------------------------------------------

--
-- Table structure for table `public_sections`
--

CREATE TABLE `public_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(120) NOT NULL,
  `title` varchar(200) NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `public_sections`
--

INSERT INTO `public_sections` (`id`, `slug`, `title`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'abyssum', 'Abyssum: Pactos de Demonios', 1, '2025-11-15 21:28:56', '2025-11-15 21:28:56'),
(2, 'pacts', 'Pacts', 2, '2025-11-15 21:28:56', '2025-11-15 21:28:56'),
(3, 'contact', 'Contacto', 4, '2025-11-15 21:28:56', '2025-11-16 07:18:47'),
(4, 'cart', 'Tu Carrito', 5, '2025-11-15 21:28:56', '2025-11-16 07:18:52'),
(5, 'profile', 'Mi Perfil', 6, '2025-11-15 21:28:56', '2025-11-16 07:18:55'),
(6, 'orders', 'Mis Órdenes', 7, '2025-11-15 21:28:56', '2025-11-16 07:18:56'),
(7, 'register', 'Registro de Usuario', 8, '2025-11-15 21:28:56', '2025-11-16 07:18:58'),
(8, 'login', 'Iniciar Sesión', 9, '2025-11-15 21:28:56', '2025-11-16 07:19:00'),
(9, '404', 'Página no encontrada', 10, '2025-11-15 21:28:56', '2025-11-16 07:19:02'),
(10, 'pact-detail', 'Detalle de Pacto', 3, '2025-11-16 07:18:18', '2025-11-16 07:19:05'),
(11, 'demons', 'Demonios', 3, '2025-11-16 21:01:43', '2025-11-16 21:01:43'),
(12, 'demon-detail', 'Detalle de Demonio', 99, '2025-11-16 21:19:41', '2025-11-16 21:19:41'),
(13, 'sellador', 'El Sellador', 25, '2025-11-16 22:42:54', '2025-11-16 22:42:54');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrador con acceso completo al sistema', '2025-11-14 22:25:47', '2025-11-14 22:25:47'),
(2, 'customer', 'Cliente con acceso al catálogo y funciones de compra', '2025-11-14 22:25:47', '2025-11-14 22:25:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(190) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `display_name` varchar(120) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `display_name`, `is_active`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'mateogarcia1660@gmail.com', '$2y$10$hoqkYoyuJN.FoPy46egd1OUA9pT23oTBtnxELIh1mshv22Nv445om', 'Mateo', 1, '2025-11-17 02:57:56', '2025-11-14 22:31:55', '2025-11-17 05:57:56'),
(2, 'admin@demons.test', '$2y$10$iT83YZt7edcOUB666fEpCOeEcS4pY15UNWAQdS1z6mVjgvpHtjdeO', 'Jorge', 1, '2025-11-17 02:59:03', '2025-11-14 22:39:15', '2025-11-17 05:59:03'),
(3, 'juan@gmail.com', '$2y$10$UaD2/LHuYHzzw2Bfgic1buYm6z12HwS.zSCoYQfRZiEV0bppXX43W', 'Juan', 1, '2025-11-17 02:56:04', '2025-11-17 05:06:00', '2025-11-17 05:56:04');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`, `assigned_at`) VALUES
(1, 2, '2025-11-14 22:31:55'),
(2, 1, '2025-11-14 23:21:42'),
(2, 2, '2025-11-14 22:39:15'),
(3, 2, '2025-11-17 05:06:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_sections`
--
ALTER TABLE `admin_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `route` (`slug`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_carts_user` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_items_cart` (`cart_id`),
  ADD KEY `fk_cart_items_pact` (`pact_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`slug`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contacts_user` (`handled_by`);

--
-- Indexes for table `demons`
--
ALTER TABLE `demons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_demons_name` (`name`),
  ADD KEY `fk_demons_image_file` (`image_file_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `fk_orders_cart` (`cart_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_items_order` (`order_id`),
  ADD KEY `fk_order_items_pact` (`pact_id`);

--
-- Indexes for table `pacts`
--
ALTER TABLE `pacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_pacts_demon` (`demon_id`),
  ADD KEY `fk_pacts_image_file` (`image_file_id`);
ALTER TABLE `pacts` ADD FULLTEXT KEY `ftx_pacts_text` (`name`,`summary`);

--
-- Indexes for table `pact_categories`
--
ALTER TABLE `pact_categories`
  ADD PRIMARY KEY (`pact_id`,`category_slug`),
  ADD KEY `fk_pc_category` (`category_slug`);

--
-- Indexes for table `public_sections`
--
ALTER TABLE `public_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `fk_user_roles_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_sections`
--
ALTER TABLE `admin_sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `demons`
--
ALTER TABLE `demons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pacts`
--
ALTER TABLE `pacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `public_sections`
--
ALTER TABLE `public_sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `fk_carts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `fk_cart_items_cart` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_items_pact` FOREIGN KEY (`pact_id`) REFERENCES `pacts` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `fk_contacts_user` FOREIGN KEY (`handled_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `demons`
--
ALTER TABLE `demons`
  ADD CONSTRAINT `fk_demons_image_file` FOREIGN KEY (`image_file_id`) REFERENCES `files` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_cart` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_items_pact` FOREIGN KEY (`pact_id`) REFERENCES `pacts` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `pacts`
--
ALTER TABLE `pacts`
  ADD CONSTRAINT `fk_pacts_demon` FOREIGN KEY (`demon_id`) REFERENCES `demons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pacts_image_file` FOREIGN KEY (`image_file_id`) REFERENCES `files` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pact_categories`
--
ALTER TABLE `pact_categories`
  ADD CONSTRAINT `fk_pc_category` FOREIGN KEY (`category_slug`) REFERENCES `categories` (`slug`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pc_pact` FOREIGN KEY (`pact_id`) REFERENCES `pacts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `fk_user_roles_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_roles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
