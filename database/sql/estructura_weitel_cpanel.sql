-- Estructura de la base de Contratos Weitel (mismas tablas que Fibercom, sin datos).
-- Importar en phpMyAdmin: seleccionar la base de Weitel > pestaña Importar > este archivo.
-- Incluye todas las tablas y los datos base (tipos de conexión, duraciones, dominios de correo, planes Weitel).
-- El usuario administrador se crea aparte con crear_admin_weitel.sql

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `anexo2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `anexo2` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_contrato` bigint(20) unsigned NOT NULL,
  `equipos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`equipos`)),
  `compra_credito` tinyint(1) NOT NULL DEFAULT 0,
  `arrendamiento` tinyint(1) NOT NULL DEFAULT 0,
  `compra_contado` tinyint(1) NOT NULL DEFAULT 0,
  `valor_mensual_arrendamiento` decimal(8,2) DEFAULT NULL,
  `valor_mensual_compra_credito` decimal(8,2) DEFAULT NULL,
  `cantidad_meses` int(11) DEFAULT NULL,
  `firma_cliente` longtext DEFAULT NULL,
  `datos_anexo3` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_anexo3`)),
  `completado_en` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `anexo2_id_contrato_foreign` (`id_contrato`),
  CONSTRAINT `anexo2_id_contrato_foreign` FOREIGN KEY (`id_contrato`) REFERENCES `contracts` (`id_contrato`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `audit_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `id_cliente` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `cedula` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `canton` varchar(255) DEFAULT NULL,
  `parroquia` varchar(100) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `n_telefono` varchar(255) DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'activo',
  `fecha_baja` timestamp NULL DEFAULT NULL,
  `motivo_baja` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `clients_cedula_unique` (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `contract_durations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `contract_durations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `meses` smallint(5) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contract_durations_meses_unique` (`meses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `contracts` (
  `id_contrato` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `base` varchar(255) DEFAULT NULL,
  `id_tecnico` bigint(20) unsigned DEFAULT NULL,
  `id_cliente` bigint(20) unsigned NOT NULL,
  `id_plan` bigint(20) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `hora_creacion` time NOT NULL,
  `direccion_servicio` varchar(255) DEFAULT NULL,
  `metodo_pago` varchar(255) DEFAULT NULL,
  `datos_pago` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_pago`)),
  `equipos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`equipos`)),
  `duracion` varchar(255) NOT NULL DEFAULT '24',
  `beneficio_ley` tinyint(1) NOT NULL DEFAULT 0,
  `pdf_ruta` varchar(255) DEFAULT NULL,
  `estado_anexo2` enum('pendiente','completado') NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_contrato`),
  KEY `contracts_id_usuario_foreign` (`id_usuario`),
  KEY `contracts_id_cliente_foreign` (`id_cliente`),
  KEY `contracts_id_plan_foreign` (`id_plan`),
  KEY `contracts_id_tecnico_foreign` (`id_tecnico`),
  KEY `contracts_base_index` (`base`),
  CONSTRAINT `contracts_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `clients` (`id_cliente`) ON DELETE CASCADE,
  CONSTRAINT `contracts_id_plan_foreign` FOREIGN KEY (`id_plan`) REFERENCES `internet_plans` (`id_plan`) ON DELETE CASCADE,
  CONSTRAINT `contracts_id_tecnico_foreign` FOREIGN KEY (`id_tecnico`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `contracts_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `equipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 5,
  `unidad` varchar(255) NOT NULL DEFAULT 'unidad',
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `internet_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `internet_plans` (
  `id_plan` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_tipo` bigint(20) unsigned NOT NULL,
  `nombre_plan` varchar(255) NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `precio_regular` decimal(8,2) DEFAULT NULL,
  `es_promocional` tinyint(1) NOT NULL DEFAULT 0,
  `velocidad` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_plan`),
  KEY `internet_plans_id_tipo_foreign` (`id_tipo`),
  CONSTRAINT `internet_plans_id_tipo_foreign` FOREIGN KEY (`id_tipo`) REFERENCES `internet_types` (`id_tipo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `internet_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `internet_types` (
  `id_tipo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `cedula` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `base` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_cedula_unique` (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_03_24_220948_create_clients_table',1),
(5,'2026_03_24_220949_create_internet_types_table',1),
(6,'2026_03_24_220950_create_internet_plans_table',1),
(7,'2026_03_24_220951_create_contracts_table',1),
(8,'2026_03_26_184539_create_audit_logs_table',1),
(9,'2026_04_06_000002_create_equipment_table',1),
(10,'2026_04_06_000003_add_estado_to_clients_table',1),
(11,'2026_04_06_000004_add_tecnico_to_contracts_table',1),
(12,'2026_04_06_000005_create_anexo2_table',1),
(13,'2026_04_10_015941_add_missing_fields_to_contracts_table',1),
(14,'2026_04_23_013513_add_firma_cliente_to_anexo2_table',1),
(15,'2026_04_26_002002_add_datos_anexo3_to_anexo2_table',1),
(16,'2026_04_27_000001_add_datos_pago_to_contracts_table',1),
(17,'2026_04_27_000002_add_equipos_to_contracts_table',1),
(18,'2026_04_11_000001_add_promocion_fields_to_internet_plans_table',2),
(19,'2026_10_13_000001_add_base_to_users_and_contracts',3),
(20,'2026_10_13_000002_add_parroquia_to_clients_table',4),
(21,'2026_10_16_000001_create_contract_durations_table',5),
(22,'2026_11_04_000001_create_email_domains_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- ------------------------------------------------------------
-- Tabla email_domains (migración 2026_11_04)
-- ------------------------------------------------------------
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `email_domains`;
CREATE TABLE `email_domains` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dominio` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_domains_dominio_unique` (`dominio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Datos base de Weitel
-- ------------------------------------------------------------
-- El sistema identifica "Radio Enlace" por id_tipo = 2 (marca "Inalámbrico" en el Anexo 1)
INSERT INTO `internet_types` (`id_tipo`, `nombre_tipo`, `created_at`, `updated_at`) VALUES
(1, 'Fibra Óptica', NOW(), NOW()),
(2, 'Radio Enlace', NOW(), NOW());

INSERT INTO `contract_durations` (`meses`, `created_at`, `updated_at`) VALUES
(24, NOW(), NOW()),
(36, NOW(), NOW());

INSERT INTO `email_domains` (`dominio`, `created_at`, `updated_at`) VALUES
('gmail.com', NOW(), NOW()), ('hotmail.com', NOW(), NOW()), ('outlook.com', NOW(), NOW()),
('yahoo.com', NOW(), NOW()), ('yahoo.es', NOW(), NOW()), ('live.com', NOW(), NOW()), ('icloud.com', NOW(), NOW());

-- Planes Weitel (precio con IVA; el contrato muestra la tarifa sin IVA: 13.04 y 17.39)
INSERT INTO `internet_plans` (`id_tipo`, `nombre_plan`, `precio`, `precio_regular`, `es_promocional`, `velocidad`, `created_at`, `updated_at`) VALUES
(2, 'WEITEL PLAN DE TERCERA EDAD', 15.00, NULL, 0, '8 MEGAS', NOW(), NOW()),
(2, 'WEITEL HOME ESTUDIANTIL', 20.00, NULL, 0, '12 MEGAS', NOW(), NOW());
SET FOREIGN_KEY_CHECKS=1;
