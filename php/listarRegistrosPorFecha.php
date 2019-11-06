<?php 
include "../conexion.php";
date_default_timezone_set('America/Lima');


if (!isset($_POST['fecha'])){$fecha = date('Y-m-d');}
else{ $fecha = $_POST['fecha'];}


$i=1;
$sql="SELECT u.idUsuario, u.usuApellido, u.usuNombre FROM `horario_registros` hr
inner join usuarios u on hr.idUsuario = u.idUsuario
where /* regFecha = '{$fecha}' and */ regActivo=1 and usuEstadoActivo =1
group by u.idUsuario
order by u.usuNombre asc;";
$resultado=$cadena->query($sql);
if( $resultado->num_rows==0){ ?>
<tr>
	<td>No hay registros encontrados en ésta fecha</td>
</tr>
<?php
}else{
	while($row=$resultado->fetch_assoc()){ ?>
		<tr data-user="<?= $row['idUsuario']; ?>">
			<td><?= $i; ?></td>
			<td><?= $row['usuNombre'] . " ". $row['usuApellido'] ; ?></td>
			<td data-reg="1">-</td>
			<td data-reg="2">-</td>
			<td data-reg="3">-</td>
			<td data-reg="4">-</td>	
			<td class="text-center" data-reg="alm">
				<input class="form-check-input" type="checkbox" value="" id="">
			</td>	
	  </tr>
	  <?php $i++;
	}
}


?>
