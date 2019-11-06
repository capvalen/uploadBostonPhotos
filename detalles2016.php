<?php
require_once("conexion.php"); 

	$sql="CALL registro_detallepormes ('".$_GET['ano']."', '".$_GET['mes']."', '".$_GET['empresa']."', '".$_GET['id']."')";
	//$sql="CALL registro_detallepormes ('2015', '5','1','22')";
	//$sql="CALL proce1('dasdas')";
	if(!$result = mysqli_query($conexion, $sql)) die();
	
	$rawdata = array(); //creamos un array

    //guardamos en un array multidimensional todos los datos de la consulta
    $i=0;
    $dias = array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sabado');
    $diasDeMes="" ;
    $diasDeMes= getMonthDays($_GET['mes'], $_GET['ano']);
    $diaslistado=1;
    //echo $diasDeMes;

    //DIA -- MAÑANAS -- TARDES -- TARDANZAS
    while($row = mysqli_fetch_array($result))
    {
        $rawdata[$i] = $row;
		$fecha = $dias[date('w', strtotime($_GET['ano'].'-'.$_GET['mes'].'-'.$rawdata[$i]['Dia']))];//Formato de hora es yyyy-mm-dd
		
        echo "<tr><td> ".$fecha." ".$rawdata[$i]['Dia']."</td>
        	<td>".$rawdata[$i]['Entrada01']."</br>
        		".$rawdata[$i]['Salida01']."</td>
        	<td>".$rawdata[$i]['Entrada02']."</br>
        		".$rawdata[$i]['Salida02']."</td>
        	<td>".$rawdata[$i]['Suma']."</br></td>
        	</tr>";
        	/*if($diaslistado<=intval($diasDeMes) and $diaslistado!=$rawdata[$i]['Dia'])
	        {
	        	while($diaslistado!=$rawdata[$i]['Dia']){
	        		echo "falta el dia ".$diaslistado."</br>"; $diaslistado++;
	        	}
	        	
	        }
	        else {echo $fecha." ".$rawdata[$i]['Dia'].' continuo '."</br>";
	        	$i++;$diaslistado++;}*/
        
		
	}

	mysqli_close($conexion); //desconectamos la base de datos
	 
	//llamada por fila y encabezado:
	//echo $rawdata[0]['regSalida02'];
	 
	//mostrar todo:
	
	//echo json_encode($rawdata);

function getMonthDays($Month, $Year)
{
   //Si la extensión que mencioné está instalada, usamos esa.
   if( is_callable("cal_days_in_month"))
   {
      return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
   }
   else
   {
      //Lo hacemos a mi manera.
      return date("d",mktime(0,0,0,$Month+1,0,$Year));
   }
}
?>