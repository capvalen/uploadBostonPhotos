<?php 
include "conexion.php";
date_default_timezone_set('America/Lima');

?><option value="-1">Seleccione</option> <?php
$sql="SELECT * FROM `usuarios` where usuEstadoActivo=1 order by usuNombre;";
$resultado=$cadena->query($sql);
while($row=$resultado->fetch_assoc()){ ?>
   <option value="<?= $row['idUsuario'];?>"><?= $row['usuNombre']." ".$row['usuApellido']; ?></option>
<?php }
?>