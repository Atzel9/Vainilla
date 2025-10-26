<?php 
require_once "../../conexion.php";
$error = $_GET["error"] ?? "";
if ($error == "") {
    header("Location: /bootcamp/Vainilla/index.php");
}

$nombre_usuario = $_SESSION["usuario_nombre"] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vainilla: Lo dulce de la tradición</title>
    <!--Icono de la página-->
    <link rel="icon" type="image/x-icon" href="../../img/icono.png">
    <!--Link para ingresar a los estilos-->
    <link rel="stylesheet" href="../../css/styles.css?v=1.2">
    <link rel="stylesheet" href="../../css/styles_error.css">
    <!--Acceso a google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400..900;1,400..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <!--Link a iconos de Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!--Link iconos de Phosphor icons-->
        <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"
    />
    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css"
    />
</head>
<body>
    <?php require_once "../includes/header.php" ?>
    <main>
        <i class="ph ph-smiley-x-eyes"></i>
        <h2>ERROR</h2>
        <?php if($error === "datos"):?>
            <p>Hubo un error en los datos</p>
            <a href="../admin.php">Regresar a panel de administración</a>
        <?php elseif($error === "rol"): ?>
            <p>No tienes permiso para acceder a esta página.</p>
            <a href="../../index.php" class="regresar">Regresar a página principal</a>
        <?php endif?>
    </main>
    <?php require_once "../includes/footer.php" ?>
    <?php require_once "../includes/nav-mobil.php" ?>
</body>
</html>