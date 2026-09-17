ALTER TABLE `usuarios`
	ADD COLUMN `Telefono` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `Perfil`,
	ADD COLUMN `CorreoE` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `Telefono`;