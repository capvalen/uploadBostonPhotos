<?php

include "conexion.php";

$codigo=$_POST['ficha'];

$sql = "UPDATE `fichas` SET
 `fichPrecio` = '{$_POST['precio']}',
 `fichTitulo`='{$_POST['titulo']}',
 `fichDireccion`='{$_POST['direccion']}',
 `fichTipoPropiedad`='{$_POST['tipoPropiedad']}',
 `fichAreaTerreno`='{$_POST['area']}',
 `fichAreaConstruccion`='{$_POST['areaConstruida']}',
 `fichFrontis`='{$_POST['frontis']}',
 `fichDormitorios`='{$_POST['dormitorios']}',
 `fichBanios`='{$_POST['banios']}',
 `fichCochera`='{$_POST['cochera']}',
 `fichDescipcion`='{$_POST['descripcion']}'
 WHERE `fichas`.`idFicha` = {$_POST['ficha']}; ";

if($resultado=$cadena->query($sql)){
	echo "todo ok";
}


?>
