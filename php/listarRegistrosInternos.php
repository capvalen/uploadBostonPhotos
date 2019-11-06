<?php 
include "../conexion.php";
date_default_timezone_set('America/Lima');


if (!isset($_POST['fecha'])){$fecha = date('Y-m-d');}
else{ $fecha = $_POST['fecha'];}


$i=1;
$filas = array();
$sql="SELECT hr.*, u.usuApellido, u.usuNombre, h.horaDescripcion FROM `horario_registros` hr
inner join usuarios u on hr.idUsuario = u.idUsuario
inner join horarios h on h.idHorario = hr.idHorario
where regFecha = '{$fecha}' and regActivo=1
order by regHora, u.usuApellido desc";
$resultado=$cadena->query($sql);

while($row=$resultado->fetch_assoc()){ 
   $filas[$i] = $row;
   $i++;
}

echo json_encode($filas);


?>
