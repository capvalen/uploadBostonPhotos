--1.34
ALTER TABLE `fichas` ADD `medios_banios` VARCHAR(250) NULL AFTER `fichCochera`, ADD `antiguedad` VARCHAR(250) NULL AFTER `medios_banios`; 
ALTER TABLE `fichas` ADD `fotos` TEXT NOT NULL DEFAULT '[]' AFTER `fichActivo`; 
ALTER TABLE `fichas` ADD `moneda` ENUM('soles', 'dólares') NULL DEFAULT 'soles' AFTER `fichTitulo`; 