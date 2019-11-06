<?php 
include "../conexion.php";
$sql="INSERT INTO `usuarios`(`idUsuario`, `usuNombre`, `usuApellido`, `usuCodigoBarras`, `usuIdEmpresa`, `usuEstadoActivo`) 
VALUES (null,'{$_POST['nombre']}','{$_POST['apellido']}','{$_POST['dni']}',1,1)";
if($cadena->query($sql)){
   echo "todo ok";
}else{
   echo "fallo algo";
}

?>