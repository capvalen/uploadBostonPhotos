<?php 
// ini_set("session.cookie_lifetime","7200");
// ini_set("session.gc_maxlifetime","7200");
//session_start();
//header('Content-Type: text/html; charset=utf8');


$local='/';

$expira=time()+60*60*3; //cookie para 3 horas


if( $_POST['user'] == 'administrador' && $_POST['pws']=="boston2019" ){
    setcookie('ckAtiende', 'Administrador', $expira, $local);
	setcookie('cknomCompleto', 'Administrador', $expira, $local);
	setcookie('ckPower', 1, $expira, $local);
	setcookie('ckidUsuario', 1, $expira, $local);
	echo 'concedido';
}

else if( $_POST['user'] == 'boston' && $_POST['pws']=="abregu" ){
    setcookie('ckAtiende', 'Asesor', $expira, $local);
	setcookie('cknomCompleto', 'Asesor', $expira, $local);
	setcookie('ckPower', 2, $expira, $local);
	setcookie('ckidUsuario', 2, $expira, $local);
	echo 'concedido';
}else{
    echo "denegado";
}


?>