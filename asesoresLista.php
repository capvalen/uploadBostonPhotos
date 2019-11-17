<h4 class='py-3'>Asesores ya registrados</h4>
<table class="table table-hover">
<thead>
  <tr>
    <th>N°</th>
    <th>Nombre</th>
    <th>Celular</th>
    <th>Correo</th>
    <th>@</th>
  </tr>
</thead>
<tbody>
<?php 
include "conexion.php";

$sql="SELECT `idAsesor`, lower(`aseNombre`) as aseNombre, lower(`aseCelular`) as aseCelular, lower(`aseCorreo`) as aseCorreo FROM `asesor` where aseActivo =1";
$resultado=$cadena->query($sql); $i=1;
while($row=$resultado->fetch_assoc()){ ?>
  <tr>
    <td><?= $i; ?></td>
    <td class="text-capitalize"><?= $row['aseNombre']; ?></td>
    <td><?= $row['aseCelular']; ?></td>
    <td><?= $row['aseCorreo']; ?></td>
    <td>
      <button class="btn btn-outline-danger btn-sm"  onClick="eliminarAsesor(<?= $row['idAsesor']; ?>)"> <i class="icofont-close"></i> </button>
    </td>
  </tr>
<?php
$i++; }

?>

 </tbody>
</table>