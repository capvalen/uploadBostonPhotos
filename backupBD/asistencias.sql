-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2019 a las 15:51:45
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asistencias`
--
CREATE DATABASE IF NOT EXISTS `asistencias` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `asistencias`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `buscarEmpleado`$$
CREATE PROCEDURE `buscarEmpleado` (IN `campo` VARCHAR(20))  NO SQL
SELECT concat(usu.usuNombre,' ',usu.usuApellido) as nombre, usuCodigoBarras, usuIdEmpresa
FROM `usuarios` usu inner join empresa empr
on usu.usuIdEmpresa = empr.IdEmpresa
WHERE `usuNombre` LIKE concat(campo,'%') or
`usuApellido` LIKE concat(campo,'%') or
usuCodigoBarras like campo$$

DROP PROCEDURE IF EXISTS `empleados_pormes`$$
CREATE PROCEDURE `empleados_pormes` (IN `ano` INT, IN `mes` INT, IN `empresa` INT)  NO SQL
select DISTINCT usu.idusuario, concat(usu.usuNombre,' ', usuApellido) as Nombre from usuarios usu inner join registro_asistencias reg on usu.idUsuario=reg.IdUsuario where month(reg.regFecha)=mes and year(reg.regFecha)=ano and usuIdEmpresa =empresa order by usunombre$$

DROP PROCEDURE IF EXISTS `existe_usuario`$$
CREATE PROCEDURE `existe_usuario` (IN `codBarras` VARCHAR(8))  NO SQL
SELECT IF( EXISTS( select * FROM usuarios WHERE usucodigoBarras =  codBarras), 'si', 'no') as existe$$

DROP PROCEDURE IF EXISTS `insertar_NuevoEmpleado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_NuevoEmpleado` (IN `nombre` VARCHAR(50), IN `apellido` VARCHAR(50), IN `codigo` VARCHAR(8), IN `idempresa` VARCHAR(1))  NO SQL
begin INSERT INTO `usuarios` (`usuNombre`, `usuApellido`, `usuCodigoBarras`, `usuIdEmpresa`, `usuFoto` ) VALUES (nombre, apellido, codigo, idempresa, 'ok.png'); SELECT `usuCodigoBarras` FROM `usuarios`; end$$

DROP PROCEDURE IF EXISTS `proce1`$$
CREATE PROCEDURE `proce1` (IN `codBarra` VARCHAR(8))  BEGIN

set @id= (select idusuario from usuarios
where usuCodigoBarras=codBarra);
/*select @id;*/

INSERT INTO `registro_asistencias` (`IdUsuario`, `regFecha`) SELECT @id,DATE_FORMAT(NOW(),'%Y-%m-%d')
from dual
WHERE NOT EXISTS (select IdRegistro from `registro_asistencias`
WHERE `regFecha`=DATE_FORMAT(NOW(),'%Y-%m-%d') and IdUsuario =@id ) LIMIT 1;

set @turno=
(SELECT 
case when hour(now())+ (minute(now()))/100 between 06 and 11 then 'Entrada de manana'
when hour(now())+ (minute(now()))/100 between 11.01 and 16 then 'Salida de manana'
when hour(now())+ (minute(now()))/100 between 16.01 and 18.30 then 'Entrada de tarde'
when hour(now())+ (minute(now()))/100 between 18.31 and 23.59 then 'Salida de tarde'
when hour(now())+ (minute(now()))/100 between 0.0 and 2 then 'Salida de tarde'
end as Turno
from dual);

set @horainst:=DATE_FORMAT(NOW(),'%T');
/*select @horainst;*/

UPDATE `registro_asistencias` reg
SET `regEntrada01`=DATE_FORMAT(NOW(),'%T'),
reg.`regTardanzaDia`= (select TIMEDIFF(@horainst,hora.horaentrada1) from `horarioempleados` hora where hora.IdUsuario=@id)
WHERE reg.IdUsuario=@id and @turno='Entrada de manana' and `regEntrada01`='00:00:00'
and `regFecha`=DATE_FORMAT(NOW(),'%Y-%m-%d');

UPDATE `registro_asistencias`
SET `regSalida01`=DATE_FORMAT(NOW(),'%T')
WHERE IdUsuario=@id and @turno='Salida de manana' and `regSalida01`='00:00:00'
and `regFecha`=DATE_FORMAT(NOW(),'%Y-%m-%d');

UPDATE `registro_asistencias` reg
SET `regEntrada02`=DATE_FORMAT(NOW(),'%T'),
reg.`regTardanzaTarde`= (select TIMEDIFF(@horainst,hora.horaentrada2) from `horarioempleados` hora where hora.IdUsuario=@id)
WHERE reg.IdUsuario=@id and @turno='Entrada de tarde' and reg.`regEntrada02`='00:00:00'
and reg.`regFecha`=DATE_FORMAT(NOW(),'%Y-%m-%d');

UPDATE `registro_asistencias`
SET `regSalida02`=DATE_FORMAT(NOW(),'%T')
WHERE IdUsuario=@id and @turno='Salida de tarde' and `regSalida02`='00:00:00'
and `regFecha`=DATE_FORMAT(NOW(),'%Y-%m-%d');

select reg.idUsuario, concat(usu.usuNombre,' ', usu.usuApellido) as Nombre, @turno as turno, regEntrada01,regSalida01,regEntrada02,regSalida02,regtardanzadia, regtardanzatarde,usuIdEmpresa,usufoto
from `usuarios` usu inner join `registro_asistencias` reg 
on reg.idusuario=usu.idusuario
where reg.IdUsuario=@id and reg.`regFecha`=DATE_FORMAT(NOW(),'%Y-%m-%d');

END$$

DROP PROCEDURE IF EXISTS `proce2`$$
CREATE PROCEDURE `proce2` ()  NO SQL
select * from usuarios where idUsuario=1$$

DROP PROCEDURE IF EXISTS `registro`$$
CREATE PROCEDURE `registro` (IN `id` INT)  NO SQL
UPDATE `registro_asistencias` 
SET
`regEntrada02`=DATE_FORMAT(NOW(),'%T')
WHERE IdUsuario=id$$

DROP PROCEDURE IF EXISTS `registro_detallepormes`$$
CREATE PROCEDURE `registro_detallepormes` (IN `ano` INT, IN `mes` INT, IN `empresa` INT, IN `id` INT)  NO SQL
SELECT concat(usu.usuNombre,' ', usu.usuApellido) As Nombre, cast(Date_format(reg.regFecha,'%d') as UNSIGNED) as Dia
, case reg.regEntrada01 when '00:00:00' then '' else reg.regEntrada01 end as Entrada01, case reg.regsalida01 when '00:00:00' then '' else reg.regsalida01 end as Salida01, case reg.regEntrada02 when '00:00:00' then '' else reg.regEntrada02 end as Entrada02, case reg.regsalida02 when '00:00:00' then '' else reg.regsalida02 end as Salida02, case when reg.regTardanzaDia < 0 then @min1:=0 when reg.regTardanzaDia="00:00:00" then @min1:=0 else @min1:=TIME_TO_SEC(reg.regTardanzaDia) end as TardanzaDia, case when reg.regTardanzaTarde < 0 then @min2:=0 when reg.regTardanzaTarde="00:00:00" then @min2:=0 else @min2:=TIME_TO_SEC(reg.regTardanzaTarde) end as TardanzaTarde, @min1 + @min2 as Parcial, SUBSTRING(SEC_TO_TIME(@min1 + @min2),1,8) as Suma from usuarios usu inner join registro_asistencias reg on usu.idUsuario=reg.IdUsuario where month(reg.regFecha)=mes and year(reg.regFecha)=ano and usuIdEmpresa =empresa and reg.idUsuario=id order by regFecha$$

DROP PROCEDURE IF EXISTS `reporte`$$
CREATE PROCEDURE `reporte` (IN `mesFecha` INT, IN `anoFecha` INT)  NO SQL
SELECT concat(usu.usuNombre,' ', usu.usuApellido) As Nombre, reg.regFecha,
case reg.regEntrada01 when '00:00:00' then '' else reg.regEntrada01 end as Entrada01,
case reg.regsalida01 when '00:00:00' then '' else reg.regsalida01 end as Salida01,
case reg.regEntrada02 when '00:00:00' then '' else reg.regEntrada02 end as Entrada02,
case reg.regsalida02 when '00:00:00' then '' else reg.regsalida02 end as Salida02,
case when reg.regTardanzaDia < 0 then @min1:=0 when reg.regTardanzaDia="00:00:00" then @min1:=0 else @min1:=TIME_TO_SEC(reg.regTardanzaDia) end as TardanzaDia,
case when reg.regTardanzaTarde < 0 then @min2:=0 when reg.regTardanzaTarde="00:00:00" then @min2:=0 else @min2:=TIME_TO_SEC(reg.regTardanzaTarde) end as TardanzaTarde,
SEC_TO_TIME(@min1 + @min2) as Suma
FROM registro_asistencias reg inner join usuarios usu
on usu.idUsuario=reg.IdUsuario
where usu.usuEstadoActivo=1 and month(reg.regFecha)= mesFecha and year(reg.regFecha)=anoFecha
order by reg.regFecha, Nombre$$

DROP PROCEDURE IF EXISTS `sp_ingresos`$$
CREATE PROCEDURE `sp_ingresos` ()  NO SQL
begin
select @id:=idusuario from usuarios
where usuCodigoBarras='85462415';
select @id;


INSERT INTO `registro_asistencias` (`IdUsuario`, `regFecha`) SELECT @id,DATE_FORMAT(NOW(),'%Y-%m-%d')
from dual
WHERE NOT EXISTS (select IdRegistro from `registro_asistencias`
                  WHERE `regFecha`=DATE_FORMAT(NOW(),'%Y-%m-%d') and IdUsuario =@id ) LIMIT 1 ;

end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almuerzos`
--

DROP TABLE IF EXISTS `almuerzos`;
CREATE TABLE `almuerzos` (
  `idAlmuerzo` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `almFecha` date NOT NULL,
  `almActivo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE `empresa` (
  `IdEmpresa` int(11) NOT NULL,
  `NombreEmpresa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`IdEmpresa`, `NombreEmpresa`) VALUES
(1, 'Perucash');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE `horarios` (
  `idHorario` int(11) NOT NULL,
  `horaDescripcion` varchar(250) NOT NULL,
  `horaInicio` time NOT NULL,
  `horaFin` time NOT NULL,
  `horaActivo` int(11) NOT NULL DEFAULT 1 COMMENT '1 activo/ 0 inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`idHorario`, `horaDescripcion`, `horaInicio`, `horaFin`, `horaActivo`) VALUES
(1, 'Entrada día', '07:00:00', '11:30:00', 1),
(2, 'Salida día', '11:30:59', '13:30:59', 1),
(3, 'Entrada tarde', '13:31:00', '17:00:00', 1),
(4, 'Salida noche', '17:00:59', '21:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_registros`
--

DROP TABLE IF EXISTS `horario_registros`;
CREATE TABLE `horario_registros` (
  `idRegistroHora` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idHorario` int(11) NOT NULL,
  `regFecha` date NOT NULL,
  `regHora` time NOT NULL,
  `regActivo` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `usuNombre` varchar(255) NOT NULL,
  `usuApellido` varchar(255) NOT NULL,
  `usuCodigoBarras` varchar(255) NOT NULL,
  `usuIdEmpresa` int(11) NOT NULL DEFAULT 1,
  `usuEstadoActivo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usuNombre`, `usuApellido`, `usuCodigoBarras`, `usuIdEmpresa`, `usuEstadoActivo`) VALUES
(1, 'Carlos', 'Pariona Valencia', '44475064', 1, 1)


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almuerzos`
--
ALTER TABLE `almuerzos`
  ADD PRIMARY KEY (`idAlmuerzo`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`IdEmpresa`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`idHorario`);

--
-- Indices de la tabla `horario_registros`
--
ALTER TABLE `horario_registros`
  ADD PRIMARY KEY (`idRegistroHora`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almuerzos`
--
ALTER TABLE `almuerzos`
  MODIFY `idAlmuerzo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `IdEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `idHorario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `horario_registros`
--
ALTER TABLE `horario_registros`
  MODIFY `idRegistroHora` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
