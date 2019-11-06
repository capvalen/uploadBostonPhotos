<?php 
include "../conexion.php";

$sql="SELECT idHorario, u.idUsuario
FROM `horarios` h inner join usuarios u 
where curtime() between horaInicio and horaFin and horaActivo=1 and u.usuCodigoBarras = '{$_POST['codigo']}';";
$resultado=$cadena->query($sql);
$numRows = $resultado->num_rows;
$row=$resultado->fetch_assoc();
if($numRows==0){
   echo "Revise su DNI";
}else{
   //Verificar que si ya se registró
   $horario= $row['idHorario'];
   $usuario= $row['idUsuario'];
   
   if( in_array($horario, array(2, 4)) ){
      $sqlConsultar="SELECT idRegistroHora FROM `horario_registros`
      where idUsuario ={$usuario} and idHorario = {$horario} and regFecha = curdate();";
      $resultadoConsultar=$cadena->query($sqlConsultar);
      $filasYaexiste=$resultadoConsultar->num_rows;
      //echo $sqlConsultar;
      if($filasYaexiste>=1){
         $sqlInsert="UPDATE `horario_registros` SET `regHora`=curtime()
         WHERE idUsuario ={$usuario} and idHorario = {$horario} and regFecha = curdate();";
         $cadena->query($sqlInsert);
         echo "Horario actualizado";
      }else{
         $sqlInsert="INSERT INTO `horario_registros`(`idRegistroHora`, `idUsuario`, `idHorario`, `regFecha`, `regHora`, `regActivo`)
         VALUES (null, {$usuario}, {$horario}, curdate(), curtime(), 1)";
         $cadena->query($sqlInsert);
         echo "Horario registrado";
      }
   }else{
      $sqlConsultar="SELECT idRegistroHora FROM `horario_registros`
      where idUsuario ={$usuario} and idHorario = {$horario} and regFecha = curdate();";
      $resultadoConsultar=$cadena->query($sqlConsultar);
      $filasYaexiste=$resultadoConsultar->num_rows;
      if($filasYaexiste>=1){
         echo "Ya registraste tu horario";
      }else{
         $sqlInsert="INSERT INTO `horario_registros`(`idRegistroHora`, `idUsuario`, `idHorario`, `regFecha`, `regHora`, `regActivo`)
         VALUES (null, {$usuario}, {$horario}, curdate(), curtime(), 1)";
         $cadena->query($sqlInsert);
         echo "Horario registrado";
      }
   }
}

?>