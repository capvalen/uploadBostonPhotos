<?php

include "conexion.php";

$codigo=$_POST['ficha'];

$sql = "UPDATE `fichas` SET `fichActivo` = '0' WHERE `fichas`.`idFicha` = {$_POST['ficha']};";

$resultado=$cadena->query($sql);


unlink('images/inmuebles/' . $codigo.'_foto1.jpg');
unlink('images/inmuebles/' . $codigo.'_foto1.png');
unlink('images/inmuebles/' . $codigo.'_foto1.jpeg');

unlink('images/inmuebles/' . $codigo.'_foto2.jpg');
unlink('images/inmuebles/' . $codigo.'_foto2.png');
unlink('images/inmuebles/' . $codigo.'_foto2.jpeg');

unlink('images/inmuebles/' . $codigo.'_foto3.jpg');
unlink('images/inmuebles/' . $codigo.'_foto3.png');
unlink('images/inmuebles/' . $codigo.'_foto3.jpeg');

?>
