<?php
require_once "../conexion.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: iniciar_sesion.php");
    exit;
}

/* Solicitar Rol del usuario */
$id = $_SESSION['usuario_id'] ?? null;
$rol = "SELECT rol FROM usuarios WHERE id=?";
$sentencia = $conexion->prepare($rol);
$sentencia->bind_param("i", $id);
$sentencia->execute();

$resultado = $sentencia->get_result();
$usuario_rol = $resultado->fetch_assoc();

$nombre_usuario = $_SESSION["usuario_nombre"];
$correo_usuario = $_SESSION["usuario_correo"];

$consulta = $conexion->query(
    "SELECT id, nombre, correo, creado_en, rol
        FROM usuarios
        ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vainilla: Lo dulce de la tradición</title>
    <!--Icono de la página-->
    <link rel="icon" type="image/x-icon" href="../img/icono.png">
    <!--Link para ingresar a los estilos-->
    <link rel="stylesheet" href="../css/styles.css?v=1.2">
    <link rel="stylesheet" href="../css/styles_perfil.css">
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
    <!--Link a iconos Google-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=clock_loader_10" />
</head>
<body>
    <!--Inicio del header-->
    <?php require_once "includes/header.php"; ?>
    <!--Fin del header-->
    <?php require_once "includes/nav-pc.php"; ?>
    <main class="main">

    <section class="info-perfil">
        <h1>Bienvenido, <strong><?= htmlspecialchars($nombre_usuario) ?></strong></h1>
        <p>(<?= htmlspecialchars($correo_usuario) ?>)</p>
        <hr class="hr">
        <nav class="nav">
            <a href="salir.php">Cerrar sesión</a>
            <?php if($usuario_rol['rol']=='admin'):?>
                <a href="admin.php">| Panel de administrador</a>
            <?php endif;?>
        </nav>
    </section>

    </main>
    <!--Inicio Footer-->
    <?php require_once "includes/footer.php"; ?>
    <!--Fin Footer-->
    <?php require_once "includes/nav-mobil.php"; ?>
</body>
</html>