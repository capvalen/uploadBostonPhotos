--1.6
ALTER TABLE `fichas` ADD `mantenimiento` VARCHAR(250) NULL AFTER `anticipo`;

--1.5
ALTER TABLE `fichas` ADD `pisos` TEXT NULL AFTER `beneficios`;
ALTER TABLE `fichas` ADD `azoteas` TEXT NULL AFTER `pisos`;
ALTER TABLE `fichas` ADD `area_contruccion` TEXT NULL AFTER `azoteas`;
ALTER TABLE `fichas` ADD `area_cochera` TEXT NULL AFTER `area_contruccion`;
ALTER TABLE `fichas` ADD `servicio_agua` VARCHAR(250) NULL AFTER `area_cochera`;
ALTER TABLE `fichas` ADD `servicio_luz` VARCHAR(250) NULL AFTER `servicio_agua`;
ALTER TABLE `fichas` ADD `servicio_desague` VARCHAR(250) NULL AFTER `servicio_luz`;
ALTER TABLE `fichas` ADD `garantia` VARCHAR(250) NULL AFTER `servicio_desague`;
ALTER TABLE `fichas` ADD `anticipo` VARCHAR(250) NULL AFTER `garantia`;
ALTER TABLE `fichas` CHANGE `tipo_operacion` `tipo_operacion` ENUM('venta','alquiler','anticresis') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT 'venta'; 

--1.4.2
ALTER TABLE `fichas` ADD `resumen` TEXT NULL AFTER `fichTitulo`;
ALTER TABLE `fichas` ADD `tipo_operacion` ENUM('venta', 'alquiler', 'traspaso', 'permuta') NULL DEFAULT 'venta' AFTER `moneda`;

--1.36
ALTER TABLE `fichas` ADD `beneficios` TEXT NULL AFTER `antiguedad`;

ALTER TABLE `fichas` ADD `superficie_descubierta` VARCHAR(250) NULL AFTER `fichAreaConstruccion`,
ADD `superficie_semicubierta` VARCHAR(250) NULL AFTER `superficie_descubierta`,
ADD `superficie_cubierta` VARCHAR(250) NULL AFTER `superficie_semicubierta`;

--1.35


--1.34
ALTER TABLE `fichas` ADD `medios_banios` VARCHAR(250) NULL AFTER `fichCochera`, ADD `antiguedad` VARCHAR(250) NULL AFTER `medios_banios`; 
ALTER TABLE `fichas` ADD `fotos` TEXT NOT NULL DEFAULT '[]' AFTER `fichActivo`; 
ALTER TABLE `fichas` ADD `moneda` ENUM('soles', 'dólares') NULL DEFAULT 'soles' AFTER `fichTitulo`; 

UPDATE `fichas`
SET
  `fichPrecio` = TRIM(REPLACE(`fichPrecio`, 'S/', '')),
  `moneda` = 'soles'
WHERE `fichPrecio` REGEXP '^S/[ ]?';

UPDATE `fichas`
SET
  `fichPrecio` = TRIM(REPLACE(`fichPrecio`, '$', '')),
  `moneda` = 'dólares'
WHERE `fichPrecio` REGEXP '^\\$[ ]?';