<?php
global $cadena;
include "conexion.php";

$moneda = $_POST['txtMoneda'] == 'dólares' ? 'dólares' : 'soles';
$sql = "INSERT INTO `fichas`(`idFicha`, `fichTitulo`, `fichPrecio`, `fichDireccion`, `fichTipoPropiedad`, `fichAreaTerreno`, `fichAreaConstruccion`, `superficie_descubierta`, `superficie_semicubierta`, `superficie_cubierta`, `fichFrontis`, `fichDormitorios`, `fichBanios`, `medios_banios`, `fichCochera`, `fichDescipcion`, `antiguedad`, `resumen`, `beneficios`, `idAsesor`, `moneda`, `tipo_operacion`) VALUES
(null, '{$_POST['txtTitulo']}', '{$_POST['txtPrecio']}', '{$_POST['txtDireccion']}', '{$_POST['txtPropiedad']}', '{$_POST['txtATerreno']}', '{$_POST['txtAConstruccion']}', '{$_POST['txtSuperficieDescubierta']}', '{$_POST['txtSuperficieSemicubierta']}', '{$_POST['txtSuperficieCubierta']}', '{$_POST['txtFrontis']}', '{$_POST['txtDormitorios']}', '{$_POST['txtBanio']}', '{$_POST['txtMediosBanios']}', '{$_POST['txtCochera']}', '{$_POST['txtDescripcion']}', '{$_POST['txtAntiguedad']}', '{$_POST['txtResumen']}', '{$_POST['txtBeneficios']}', {$_POST['txtAsesor']}, '{$moneda}', '{$_POST['txtOperacion']}');";

$resultado=$cadena->query($sql);

$codigo= $cadena->insert_id;

$fotos = array();

if(!empty($_FILES['txtFoto']) && is_array($_FILES['txtFoto']['tmp_name'])){
  foreach($_FILES['txtFoto']['tmp_name'] as $i => $tmpName){
    if(is_uploaded_file($tmpName) && $_FILES['txtFoto']['error'][$i] === UPLOAD_ERR_OK){
      $ext = pathinfo($_FILES['txtFoto']['name'][$i], PATHINFO_EXTENSION);
      $fotoName = $codigo . '_foto' . $i . '.' . $ext;
      $target_path = 'images/inmuebles/' . $fotoName;
      if(move_uploaded_file($tmpName, $target_path)){
        $fotos[] = $fotoName;
      }
    }
  }
}

if(!empty($fotos)){
  $fotosJson = $cadena->real_escape_string(json_encode($fotos));
  $updateSql = "UPDATE `fichas` SET `fotos` = '{$fotosJson}' WHERE `idFicha` = {$codigo}";
  $cadena->query($updateSql);
  echo $codigo;
}else{
  echo "vacio";
}

?>
