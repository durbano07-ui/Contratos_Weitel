-- Crea el primer usuario administrador de Weitel (el ingreso al sistema es con la cédula).
-- ANTES de importar: reemplaza NOMBRE COMPLETO y 0000000000 por los datos reales.
-- Importar en phpMyAdmin DESPUÉS de estructura_weitel_cpanel.sql.
INSERT INTO `users` (`name`, `cedula`, `role`, `base`, `created_at`, `updated_at`)
VALUES ('NOMBRE COMPLETO', '0000000000', 'administrador', 'San Miguel', NOW(), NOW());
