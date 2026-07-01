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