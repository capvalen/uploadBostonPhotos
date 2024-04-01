<?php
include "../conexion.php";

switch ($_POST['pedir']) {
	case 'listar': listar($dbase); break;
	case 'subir': subir($dbase); break;
	case 'eliminar': eliminar($dbase); break;
	default: break;
}

function listar($db){
	$filas = [];
	if($_POST['nivel'] == '1')
		$sql=$db->prepare("SELECT * from archivos where activo = 1 order by nombre asc");
	else if($_POST['nivel'] == '2')
		$sql=$db->prepare("SELECT * from archivos where activo = 1 and publico = 1 order by nombre asc");
	if($sql->execute())
		while($row = $sql->fetch(PDO::FETCH_ASSOC))
			$filas[] = $row;
	echo json_encode($filas);
}

function subir($db){
	$meta = json_decode($_POST['metadata'], true);
	
	$directorioActual = __DIR__;
	$directorio = dirname($directorioActual) . "/multimedia/";
//	var_dump($meta); die();

	$tipoArchivo = strtolower(pathinfo( $directorio . basename($_FILES["multimedia"]["name"]) ,PATHINFO_EXTENSION));
	$queArchivo = uniqid() . "." . $tipoArchivo;
	$archivoFinal = $directorio . $queArchivo; //basename($_FILES["archivo"]["name"]);

	if (move_uploaded_file($_FILES["multimedia"]["tmp_name"], $archivoFinal)) {
		$sql = $db->prepare("INSERT INTO `archivos`(`nombre`, `ruta`, `comentario`, `publico`) VALUES (?, ?, ?, ?)");
		$serv = $sql->execute([
			$meta['nombre'], $queArchivo, $meta['comentario'], $meta['publico']
		]);
		if($serv){
			echo json_encode(array( 'ruta' => $queArchivo ));
		} else echo 'Hubo un error';
	} else {
		echo "Error subida".$_FILES["multimedia"]["error"];
	}
}
function eliminar($db){
	$directorioActual = __DIR__;
	$ruta = dirname($directorioActual) . "/multimedia/";
	$archivoAnterior =$ruta.$_POST['archivo'];
	$nuevoNombre = uniqid() . "." . pathinfo($archivoAnterior)['extension'];
	rename($archivoAnterior, $ruta. $nuevoNombre) ;
	//unlink($archivo);

	$sql = $db->prepare("UPDATE `archivos` set `ruta` = ?, `activo` = 0 where id= ?;");
	$serv = $sql->execute([
		$nuevoNombre, $_POST['id']
	]);
	//var_dump( $sql->debugDumpParams());

	if($serv) echo 'ok';
	else echo 'error';
}