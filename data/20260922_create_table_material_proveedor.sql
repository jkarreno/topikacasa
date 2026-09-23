CREATE TABLE `material_proveedor` (
	`Id` INT NOT NULL AUTO_INCREMENT,
	`IdMaterial` INT NULL DEFAULT NULL,
	`IdProveedor` INT NULL DEFAULT NULL,
	PRIMARY KEY (`Id`)
)
COLLATE='utf8mb4_0900_ai_ci'
;