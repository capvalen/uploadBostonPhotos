<?php
unset($_COOKIE['ckUsuario']);
setcookie('ckUsuario', "", time() - 3600, '/');
header("location: index.html");
?>