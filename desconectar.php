<?php
session_start();
unset($_COOKIE['ckidUsuario']);
unset($_COOKIE['ckAtiende']);
unset($_COOKIE['cknomCompleto']);
unset($_COOKIE['ckPower']);

$ruta = '/';
setcookie("ckidUsuario", "", time() - 3600, $ruta);
setcookie("ckAtiende", "", time() - 3600, $ruta);
setcookie("cknomCompleto", "", time() - 3600, $ruta);
setcookie("ckPower", "", time() - 3600, $ruta);
if ($_SESSION['access_token']) {
	session_destroy();
	
}
header("location: index.php");
?>