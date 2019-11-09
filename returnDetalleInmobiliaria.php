<?php 
include "conexion.php";


$filas=array();
$log = mysqli_query($cadena,"SELECT `idFicha`, `fichTitulo`, `fichPrecio`, `fichDireccion`, `fichTipoPropiedad`, `fichAreaTerreno`, `fichAreaConstruccion`, `fichFrontis`, `fichDormitorios`, `fichBanios`, `fichCochera`, `fichDescipcion`, `idAsesor`, `fichFechaAuto`, `fichActivo` FROM `fichas` WHERE `idFicha`= '{$_POST['idFicha']}'; ");
$i=0;
while($row = mysqli_fetch_array($log, MYSQLI_ASSOC))
{
	$filas[$i]= $row;
		
}
/* liberar la serie de resultados */
mysqli_free_result($log);

mysqli_close($cadena);
echo json_encode($filas);

?>