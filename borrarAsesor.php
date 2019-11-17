<?php

include "conexion.php";

$codigo=$_POST['ficha'];

$sql = "UPDATE `asesor` SET `aseActivo` = '0' WHERE `idAsesor` = {$_POST['idAsesor']};";

$resultado=$cadena->query($sql);

echo "todo ok";
?>
