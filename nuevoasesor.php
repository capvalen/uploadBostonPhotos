<?php

include "conexion.php";

$sql = "INSERT INTO `asesor`(`idAsesor`, `aseNombre`, `aseCelular`, `aseCorreo`) VALUES (null, '{$_POST['txtNombre']}', '{$_POST['txtCelular']}', '{$_POST['txtCorreo']}');";

$resultado=$cadena->query($sql);

$codigo= $cadena->insert_id;

if(!empty($_FILES)){
 if(is_uploaded_file($_FILES['txtFoto1']['tmp_name'])){
  //sleep(1);
  $source_path = $_FILES['txtFoto1']['tmp_name'];
  $target_path = 'images/empleado/' . $codigo.'_foto1.'.end(explode(".", $_FILES['txtFoto1']['name']));;
  if(move_uploaded_file($source_path, $target_path)){
   //echo '<img src="'.$target_path.'" class="img-thumbnail" width="300" height="250" />';
  }
 }
 
echo $codigo;
}else{
  echo "vacio";
}

?>
