<?php
include __DIR__ . '/../conexion.php';

header('Content-Type: application/json');

$sql = "SELECT `idAsesor`, UPPER(`aseNombre`) as aseNombre FROM `asesor` WHERE aseActivo = 1 order by aseNombre asc";
$resultado = $cadena->query($sql);
$asesores = [];
while ($row = $resultado->fetch_assoc()) {
	$asesores[] = $row;
}
echo json_encode($asesores);
