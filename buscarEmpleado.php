<?php
 //header('Content-Type: text/html; charset=utf8');
require_once("conexion.php"); 

	$sql="CALL buscarEmpleado ('".utf8_decode($_GET['campo'])."')";
	
	//$sql="CALL buscarEmpleado ('tra')";
	//$sql="CALL proce1('dasdas')";
	if(!$result = mysqli_query($conexion, $sql)) die();
	
	$rawdata = array(); //creamos un array
 
    //guardamos en un array multidimensional todos los datos de la consulta
    $i=0;
    $idtabla="";
    $logoEmpresa="";

    while($row = mysqli_fetch_array($result))
    {
        $rawdata[$i] = $row;
        switch ($rawdata[$i]['usuIdEmpresa'])
        {
        	case 1: $logoEmpresa='feria.png';break;
        	case 2: $logoEmpresa='farmacia.png';break;
        	case 3: $logoEmpresa='consultorio.png';break;
        }
       echo '<li class="collection-item avatar">
                <img src="images/'.$logoEmpresa.'" alt="" class="circle">
                <span class="title">'.utf8_encode($rawdata[$i]['nombre']).'</span>
                <p><strong>Código de barras:</strong> '.$rawdata[$i]['usuCodigoBarras'].'</br></p>
              </li>';
        $i++;
		
	}
	if ($i==0){echo '<li class="collection-item avatar">
                <img src="images/warm.png" alt="" class="circle">
                <span class="title">No se encuentra ninguna coincidencia con el término: '.$_GET['campo'].'.</span>
              </li>';}

	mysqli_close($conexion); //desconectamos la base de datos
	 
	//llamada por fila y encabezado:
	//echo $rawdata[0]['Nombre'];
	 
	//mostrar todo:
	
	//echo json_encode($rawdata);

?>