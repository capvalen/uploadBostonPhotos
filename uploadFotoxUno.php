<?php

$codigo = $_POST['llave'];

if(!empty($_FILES)){
 if(is_uploaded_file($_FILES['txtFoto1']['tmp_name'])){
  //sleep(1);
  $source_path = $_FILES['txtFoto1']['tmp_name'];
  $target_path = 'images/inmuebles/' . $codigo.'_foto1.'. strtolower(end(explode(".", $_FILES['txtFoto1']['name'])));
  if(move_uploaded_file($source_path, $target_path)){
   //echo '<img src="'.$target_path.'" class="img-thumbnail" width="300" height="250" />';
  }
 }
  if(is_uploaded_file($_FILES['txtFoto2']['tmp_name'])){
  //sleep(1);
  $source_path = $_FILES['txtFoto2']['tmp_name'];
  $target_path = 'images/inmuebles/' . $codigo.'_foto2.'. strtolower(end(explode(".", $_FILES['txtFoto2']['name'])));
  if(move_uploaded_file($source_path, $target_path)){
   //echo '<img src="'.$target_path.'" class="img-thumbnail" width="300" height="250" />';
  }
 }
  if(is_uploaded_file($_FILES['txtFoto3']['tmp_name'])){
  //sleep(1);
  $source_path = $_FILES['txtFoto3']['tmp_name'];
  $target_path = 'images/inmuebles/' . $codigo.'_foto3.'. strtolower(end(explode(".", $_FILES['txtFoto3']['name'])));
  if(move_uploaded_file($source_path, $target_path)){
   //echo '<img src="'.$target_path.'" class="img-thumbnail" width="300" height="250" />';
  }
 }
echo 'ok';
}else{
  echo "vacio";
}

?>