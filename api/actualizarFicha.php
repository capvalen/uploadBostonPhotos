<?php
global $cadena;
include "../conexion.php";

$idFicha = (int)$_POST['idFicha'];

$titulo = $cadena->real_escape_string($_POST['txtTitulo']);
$precio = $cadena->real_escape_string($_POST['txtPrecio']);
$moneda = $_POST['txtMoneda'] == 'dólares' ? 'dólares' : 'soles';
$direccion = $cadena->real_escape_string($_POST['txtDireccion']);
$propiedad = $cadena->real_escape_string($_POST['txtPropiedad']);
$aTerreno = $cadena->real_escape_string($_POST['txtATerreno']);
$aConstruccion = $cadena->real_escape_string($_POST['txtAConstruccion']);
$frontis = $cadena->real_escape_string($_POST['txtFrontis']);
$dormitorios = $cadena->real_escape_string($_POST['txtDormitorios']);
$banios = $cadena->real_escape_string($_POST['txtBanio']);
$mediosBanios = $cadena->real_escape_string($_POST['txtMediosBanios']);
$cochera = $cadena->real_escape_string($_POST['txtCochera']);
$descripcion = $cadena->real_escape_string($_POST['txtDescripcion']);
$antiguedad = $cadena->real_escape_string($_POST['txtAntiguedad']);
$idAsesor = (int)$_POST['txtAsesor'];

$sql = "UPDATE `fichas` SET
  `fichTitulo` = '{$titulo}',
  `fichPrecio` = '{$precio}',
  `fichDireccion` = '{$direccion}',
  `fichTipoPropiedad` = '{$propiedad}',
  `fichAreaTerreno` = '{$aTerreno}',
  `fichAreaConstruccion` = '{$aConstruccion}',
  `fichFrontis` = '{$frontis}',
  `fichDormitorios` = '{$dormitorios}',
  `fichBanios` = '{$banios}',
  `medios_banios` = '{$mediosBanios}',
  `fichCochera` = '{$cochera}',
  `fichDescipcion` = '{$descripcion}',
  `antiguedad` = '{$antiguedad}',
  `idAsesor` = {$idAsesor},
  `moneda` = '{$moneda}'
WHERE `idFicha` = {$idFicha}";

$cadena->query($sql);

// --- Manejo de fotos ---
$fotosGuardadas = array();

// 1. Obtener fotos existentes que NO fueron eliminadas
$fotosAEliminar = isset($_POST['fotosEliminar']) ? json_decode($_POST['fotosEliminar'], true) : array();
if (!is_array($fotosAEliminar)) $fotosAEliminar = array();

// Leer las fotos actuales de la BD
$rsFotos = $cadena->query("SELECT `fotos` FROM `fichas` WHERE `idFicha` = {$idFicha}");
$rowFotos = $rsFotos->fetch_assoc();
$fotosActuales = json_decode($rowFotos['fotos'], true);
if (!is_array($fotosActuales)) $fotosActuales = array();

// Conservar las que no se eliminaron
foreach ($fotosActuales as $f) {
    if (!in_array($f, $fotosAEliminar)) {
        $fotosGuardadas[] = $f;
    } else {
        // Borrar el archivo físico
        $archivoPath = __DIR__ . '/../images/inmuebles/' . basename($f);
        if (file_exists($archivoPath)) unlink($archivoPath);
    }
}

// 2. Subir fotos nuevas
if (!empty($_FILES['txtFoto']) && is_array($_FILES['txtFoto']['tmp_name'])) {
    foreach ($_FILES['txtFoto']['tmp_name'] as $i => $tmpName) {
        if (is_uploaded_file($tmpName) && $_FILES['txtFoto']['error'][$i] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['txtFoto']['name'][$i], PATHINFO_EXTENSION);
            $idx = count($fotosGuardadas);
            $fotoName = $idFicha . '_foto' . $idx . '.' . $ext;
            $target_path = __DIR__ . '/../images/inmuebles/' . $fotoName;
            // Evitar colisión: si ya existe, incrementar índice
            while (file_exists($target_path)) {
                $idx++;
                $fotoName = $idFicha . '_foto' . $idx . '.' . $ext;
                $target_path = __DIR__ . '/../images/inmuebles/' . $fotoName;
            }
            if (move_uploaded_file($tmpName, $target_path)) {
                $fotosGuardadas[] = $fotoName;
            }
        }
    }
}

// 3. Actualizar columna fotos en BD
// Aplicar reorden si el usuario movió las fotos
if (isset($_POST['ordenFotos'])) {
    $orden = json_decode($_POST['ordenFotos'], true);
    if (is_array($orden) && count($orden) > 0) {
        $fotosReordenadas = array();
        // Primero las existentes en el nuevo orden
        foreach ($orden as $f) {
            if (in_array($f, $fotosGuardadas)) {
                $fotosReordenadas[] = $f;
            }
        }
        // Luego las nuevas fotos que no estaban en el orden
        foreach ($fotosGuardadas as $f) {
            if (!in_array($f, $fotosReordenadas)) {
                $fotosReordenadas[] = $f;
            }
        }
        $fotosGuardadas = $fotosReordenadas;
    }
}
$fotosJson = $cadena->real_escape_string(json_encode($fotosGuardadas));
$cadena->query("UPDATE `fichas` SET `fotos` = '{$fotosJson}' WHERE `idFicha` = {$idFicha}");

echo $idFicha;
