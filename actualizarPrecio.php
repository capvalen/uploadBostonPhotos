<?php

include "conexion.php";

$codigo=$_POST['ficha'];

$sql = "UPDATE `fichas` SET `fichPrecio` = '{$_POST['precio']}' WHERE `fichas`.`idFicha` = {$_POST['ficha']}; ";

if($resultado=$cadena->query($sql)){
	echo "todo ok";
}


?>
