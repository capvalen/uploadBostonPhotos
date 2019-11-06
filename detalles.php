<?php
require_once("conexion.php"); 

	$sql="CALL registro_detallepormes ('".$_POST['ano']."', '".$_POST['mes']."', '".$_POST['empresa']."', '".$_POST['id']."')";
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
	 
	//llamada por fila y encabezado:
	//echo $rawdata[0]['regSalida02'];
	 
	//mostrar todo:
	
	echo json_encode($rawdata);

?>