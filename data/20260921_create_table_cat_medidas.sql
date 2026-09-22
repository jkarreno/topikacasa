CREATE TABLE `cat_medidas` (
	`Id` INT NOT NULL AUTO_INCREMENT,
	`Nombre` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`Abreviacion` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`Descripcion` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	PRIMARY KEY (`Id`)
)
COLLATE='utf8mb4_0900_ai_ci'
;