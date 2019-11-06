<?php 
include "conexion.php";

$sql="SELECT `idUsuario`, `usuNombre`, `usuApellido`, `usuCodigoBarras`FROM `usuarios` WHERE usuEstadoActivo =1";
$resultado=$cadena->query($sql);
$i=1;
while($row=$resultado->fetch_assoc()){ ?>
<tr>
   <td><?= $i; ?></td>
   <td data-id="<?= $row['idUsuario'];?>"><?= $row['usuApellido'] ." ".$row['usuNombre']; ?></td>
   <td><?= $row['usuCodigoBarras']; ?></td>
   <td><button class="btn btn-outline-danger btn-sm" onclick="removerPersonal(<?= $row['idUsuario'];?>)"><i class="icofont-trash"></i></button></td>
</tr>
   <?php $i++;
}
 ?>