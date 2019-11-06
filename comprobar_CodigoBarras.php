<?php
require_once("conexion.php"); 

	$sql="SELECT idusuario FROM `usuarios` where `usuCodigoBarras`= ".$_POST["codigo"];
	//$sql="CALL empleados_pormesF13 ('2014', '12')";
	//$sql="CALL proce1('dasdas')";
	if(!$result = mysqli_query($conexion, $sql)) die();
	
	$rawdata = array(); //creamos un array
 
    //guardamos en un array multidimensional todos los datos de la consulta
    $i=0;
 
    while($row = mysqli_fetch_array($result))
    {
        $rawdata[$i] = $row;
        $i++;
		//echo $rawdata[0][0];
	}
	mysqli_close($conexion); //desconectamos la base de datos
	 
	echo $i;//0 = Codigo Libre && 1=Codigo usado
	
?>