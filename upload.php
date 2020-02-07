<?php

include "conexion.php";

$sql = "INSERT INTO `fichas`(`idFicha`, `fichTitulo`, `fichPrecio`, `fichDireccion`, `fichTipoPropiedad`, `fichAreaTerreno`, `fichAreaConstruccion`, `fichFrontis`, `fichDormitorios`, `fichBanios`, `fichCochera`, `fichDescipcion`, `idAsesor`) VALUES
(null, '{$_POST['txtTitulo']}', '{$_POST['txtPrecio']}', '{$_POST['txtDireccion']}', '{$_POST['txtPropiedad']}', '{$_POST['txtATerreno']}', '{$_POST['txtAConstruccion']}', '{$_POST['txtFrontis']}', '{$_POST['txtDormitorios']}', '{$_POST['txtBanio']}', '{$_POST['txtCochera']}', '{$_POST['txtDescripcion']}', {$_POST['txtAsesor']});";

$resultado=$cadena->query($sql);

$codigo= $cadena->insert_id;

if(!empty($_FILES)){
 if(is_uploaded_file($_FILES['txtFoto1']['tmp_name'])){
  //sleep(1);
  $source_path = $_FILES['txtFoto1']['tmp_name'];
  $target_path = 'images/inmuebles/' . $codigo.'_foto1.'.end(explode(".", $_FILES['txtFoto1']['name']));;
  if(move_uploaded_file($source_path, $target_path)){
   //echo '<img src="'.$target_path.'" class="img-thumbnail" width="300" height="250" />';
  }
 }
  if(is_uploaded_file($_FILES['txtFoto2']['tmp_name'])){
  //sleep(1);
  $source_path = $_FILES['txtFoto2']['tmp_name'];
  $target_path = 'images/inmuebles/' . $codigo.'_foto2.'.end(explode(".", $_FILES['txtFoto2']['name']));;
  if(move_uploaded_file($source_path, $target_path)){
   //echo '<img src="'.$target_path.'" class="img-thumbnail" width="300" height="250" />';
  }
 }
  if(is_uploaded_file($_FILES['txtFoto3']['tmp_name'])){
  //sleep(1);
  $source_path = $_FILES['txtFoto3']['tmp_name'];
  $target_path = 'images/inmuebles/' . $codigo.'_foto3.'.end(explode(".", $_FILES['txtFoto3']['name']));;
  if(move_uploaded_file($source_path, $target_path)){
   //echo '<img src="'.$target_path.'" class="img-thumbnail" width="300" height="250" />';
  }
 }
echo $codigo;
}else{
  echo "vacio";
}

?>
