<?php
session_start();

$_SESSION = [];
session_unset();
session_destroy();

header("Location: iniciar_sesion.php");
exit;
?>