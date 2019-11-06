<?php
require_once("conexion.php"); 

//if(isset($_POST["codigo"])){

	$sql="CALL insertar_NuevoEmpleado('".$_POST["nombre"]."','".$_POST["apellido"]."','".$_POST["codigoBarra"]."',".$_POST["empresa"].")";
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
   //return json_encode($rawdata,true); //devolvemos el array
   
//}
?>