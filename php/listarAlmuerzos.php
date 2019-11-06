<?php 
include "../conexion.php";
date_default_timezone_set('America/Lima');


if (!isset($_POST['fecha'])){$fecha = date('Y-m-d');}
else{ $fecha = $_POST['fecha'];}


$i=1;
$filas = array();
$sql="SELECT * FROM almuerzos a
where almFecha = '{$fecha}' and almActivo=1;";
$resultado=$cadena->query($sql);

while($row=$resultado->fetch_assoc()){ 
   $filas[$i] = $row;
   $i++;
}

echo json_encode($filas);


?>
