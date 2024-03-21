<?php
include "../conexion.php";

switch ($_POST['pedir']) {
	case 'listar': listar($dbase); break;
	case 'crear': crear($dbase); break;
	case 'eliminar': eliminar($dbase); break;
	default:
		# code...
		break;
}

function listar($db){
	$filas = [];
	$sql=$db->prepare("SELECT c.*, a.aseNombre FROM `comentarios` c
	inner join asesor a on a.idAsesor = c.idAsesor
	where c.idFicha =? and c.activo=1 order by id desc;");
	if($sql->execute([ $_POST['idFicha'] ]))
		while($row = $sql->fetch(PDO::FETCH_ASSOC))
			$filas[] = $row;
	echo json_encode($filas);
}

function crear($db){	
	$sql = $db->prepare("INSERT INTO `comentarios` (`comentario`, `idFicha`, `idAsesor`) VALUES (?,?,?);");
	if($sql->execute([ $_POST['comentario'], $_POST['idFicha'], $_POST['idAsesor'] ])){
		$id = $db->lastInsertId();
		echo json_encode( array('id' => $id, 'mensaje' => 'ok'));
	}
}

function eliminar($db){
	$sql = $db->prepare("UPDATE `comentarios` SET `activo`=0 WHERE id= ?;");
	if($sql->execute([ $_POST['id'] ]))
		echo json_encode( array('mensaje' => 'ok'));


}