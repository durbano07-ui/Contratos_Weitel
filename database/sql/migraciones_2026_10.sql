-- Migraciones pendientes (octubre 2026) para el servidor
-- Seguro de ejecutar varias veces: solo crea lo que falte.

-- 2026_10_13_000001_add_base_to_users_and_contracts
SET @sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'base') = 0,
    'ALTER TABLE `users` ADD COLUMN `base` VARCHAR(255) NULL AFTER `role`',
    'SELECT ''users.base ya existe'''
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'contracts' AND COLUMN_NAME = 'base') = 0,
    'ALTER TABLE `contracts` ADD COLUMN `base` VARCHAR(255) NULL AFTER `id_usuario`',
    'SELECT ''contracts.base ya existe'''
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql = IF(
    (SELECT COUNT(*) FROM information_schema.STATISTICS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'contracts' AND INDEX_NAME = 'contracts_base_index') = 0,
    'ALTER TABLE `contracts` ADD INDEX `contracts_base_index` (`base`)',
    'SELECT ''contracts_base_index ya existe'''
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- 2026_10_13_000002_add_parroquia_to_clients_table
SET @sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'clients' AND COLUMN_NAME = 'parroquia') = 0,
    'ALTER TABLE `clients` ADD COLUMN `parroquia` VARCHAR(100) NULL AFTER `canton`',
    'SELECT ''clients.parroquia ya existe'''
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- 2026_10_16_000001_create_contract_durations_table
CREATE TABLE IF NOT EXISTS `contract_durations` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `meses` SMALLINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `contract_durations_meses_unique` (`meses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `contract_durations` (`meses`, `created_at`, `updated_at`) VALUES
    (24, NOW(), NOW()),
    (36, NOW(), NOW());

-- 2026_11_04_000001_create_email_domains_table
CREATE TABLE IF NOT EXISTS `email_domains` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `dominio` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email_domains_dominio_unique` (`dominio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `email_domains` (`dominio`, `created_at`, `updated_at`) VALUES
    ('gmail.com', NOW(), NOW()),
    ('hotmail.com', NOW(), NOW()),
    ('outlook.com', NOW(), NOW()),
    ('yahoo.com', NOW(), NOW()),
    ('yahoo.es', NOW(), NOW()),
    ('live.com', NOW(), NOW()),
    ('icloud.com', NOW(), NOW());

-- Registrar las migraciones para que `php artisan migrate` no intente correrlas otra vez
SET @batch = (SELECT COALESCE(MAX(`batch`), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`migration`, `batch`)
SELECT m.migration, @batch FROM (
    SELECT '2026_10_13_000001_add_base_to_users_and_contracts' AS migration
    UNION ALL SELECT '2026_10_13_000002_add_parroquia_to_clients_table'
    UNION ALL SELECT '2026_10_16_000001_create_contract_durations_table'
    UNION ALL SELECT '2026_11_04_000001_create_email_domains_table'
) m
WHERE NOT EXISTS (SELECT 1 FROM `migrations` x WHERE x.migration = m.migration);
