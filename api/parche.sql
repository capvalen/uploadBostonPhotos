--1.37
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