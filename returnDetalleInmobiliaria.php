<?php 
include "conexion.php";


$filas=array();
$log = mysqli_query($cadena,"SELECT `idFicha`, `fichTitulo`, `fichPrecio`, `fichDireccion`, `fichTipoPropiedad`, `fichAreaTerreno`, `fichAreaConstruccion`, `fichFrontis`, `fichDormitorios`, `fichBanios`, `fichCochera`, `fichDescipcion`, `idAsesor`, `fichFechaAuto`, `fichActivo` FROM `fichas` WHERE `idFicha`= '{$_POST['idFicha']}'; ");
$i=0;
while($row = mysqli_fetch_array($log, MYSQLI_ASSOC))
{
	$filas[$i]= $row;
	
}


$i++;
$foto1= './images/inmuebles/'.$_POST['idFicha']."_foto1";
if(file_exists($foto1.".jpg")){ $filas[$i] = array('foto' => $foto1.".jpg");  } 
else if(file_exists($foto1.".png")){ $filas[$i] = array('foto' => $foto1.".png");  } 
else if(file_exists($foto1.".jpeg")){ $filas[$i] = array('foto' => $foto1.".jpeg");  }
else{ $filas[$i] = array('foto' => '' ); }

$i++;
$foto2= './images/inmuebles/'.$_POST['idFicha']."_foto2";

if(file_exists($foto2.".jpg")){ $filas[$i] = array('foto' => $foto2.".jpg");  } 
else if(file_exists($foto2.".png")){ $filas[$i] = array('foto' => $foto2.".png");  } 
else if(file_exists($foto2.".jpeg")){ $filas[$i] = array('foto' => $foto2.".jpeg");  }
else{ $filas[$i] = array('foto' => '' ); }

$i++;
$foto3= './images/inmuebles/'.$_POST['idFicha']."_foto3";

if(file_exists($foto3.".jpg")){ $filas[$i] = array('foto' => $foto3.".jpg");  } 
else if(file_exists($foto3.".png")){ $filas[$i] = array('foto' => $foto3.".png");  } 
else if(file_exists($foto3.".jpeg")){ $filas[$i] = array('foto' => $foto3.".jpeg");  }
else{ $filas[$i] = array('foto' => '' ); }


mysqli_close($cadena);
echo json_encode($filas);
//var_dump($filas);

/* liberar la serie de resultados */
mysqli_free_result($log);

?>