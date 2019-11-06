<?php 
include "../conexion.php";
date_default_timezone_set('America/Lima');


   if ($_POST['estado']=='true'){
      $sql="INSERT INTO `almuerzos`(`idAlmuerzo`, `idUsuario`, `almFecha`, `almActivo`) VALUES (null,'{$_POST['idUser']}','{$_POST['fecha']}',1);";
      $cadena->query($sql);
   }
   if ($_POST['estado']=='false'){
      $sql="UPDATE `almuerzos` SET `almActivo`=0 WHERE `idUsuario` = '{$_POST['idUser']}' and `almFecha` = '{$_POST['fecha']}';";
      $cadena->query($sql);
   }
   echo "1";
?>