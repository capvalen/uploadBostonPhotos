<?php 
include "../conexion.php";
date_default_timezone_set('America/Lima');

$i=1;
$filas = array();

$sql="SELECT `idRegistroHora`, `idUsuario`, hr.`idHorario`, `regFecha`, date_format(`regHora`, '%H:%i') as regHora, `regActivo`, h.horaDescripcion,
case hr.idHorario when 1 then '09:00:00' when 2 then '13:00:00' when 3 then '15:00:00' when 4 then '19:00:00' end as horas
FROM `horario_registros` hr
inner join horarios h on h.idHorario = hr.idHorario
where date_format(regFecha,'%Y-%m') = '{$_POST['fecha']}' and regActivo=1 and hr.idUsuario = {$_POST['idUsuario']}
order by regFecha, regHora desc;";
$resultado=$cadena->query($sql);
while($row=$resultado->fetch_assoc()){ 
   $filas[$i] = $row;
   $i++;
}
echo json_encode($filas);
?>