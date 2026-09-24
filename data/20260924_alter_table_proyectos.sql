ALTER TABLE `proyectos`
	ADD COLUMN `FechaEntrega` INT NULL DEFAULT NULL AFTER `FechaFIn`;

ALTER TABLE `proyectos`
	ADD COLUMN `Descripcion` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `NombreProyecto`;

ALTER TABLE `proyectos`
	ADD COLUMN `UbicacionMontaje` LONGTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `Descripcion`;