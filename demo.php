<html>
<header>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
</header>
<?php
require_once("conexion.php"); 

if(isset($_POST["codigo"])){
	//echo $_POST["codigo"]."</br>";
	$sql="select * from usuarios where usuCodigoBarras like '".$_POST["codigo"]."'";
	$result=mysql_db_query($nombreBaseDatos,$sql,$conexion)  or die(mysql_error())."</br>";

	if($registro=mysql_fetch_array($result)){
		echo "Código: ".$registro["usuCodigoBarras"]."</br>";
		echo "Ud. es el usuario ".$registro["usuNombre"].' '.$registro["usuApellido"]."</br>";
	}
	else{echo "Vuelva a pasar su tarjeta"."</br>";
	}
}
else {echo "no existe parametro"."</br>";}


//Establecemos zona horaria por defecto
    date_default_timezone_set('America/Lima');
    //preguntamos la zona horaria
    $zonahoraria = date_default_timezone_get();
    echo 'Zona horaria predeterminada: ' . $zonahoraria;
?>
</html>
