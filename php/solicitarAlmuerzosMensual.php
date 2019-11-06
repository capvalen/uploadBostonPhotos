<?php 
include "../conexion.php";
date_default_timezone_set('America/Lima');




$i=1;
$filas = array();
$sql="SELECT * FROM almuerzos a
where date_format(almFecha,'%Y-%m') = '{$_POST['periodo']}' and almActivo=1 and idUsuario = {$_POST['idUser']};";
$resultado=$cadena->query($sql);

while($row=$resultado->fetch_assoc()){ 
   $filas[$i] = $row;
   $i++;
}

echo json_encode($filas);


?>
