<?php
require_once "../conexion.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: iniciar_sesion.php");
    exit;
}

/* Solicitar datos del usuario */
$id = $_SESSION['usuario_id'] ?? null;
$datos = "SELECT rol, creado_en FROM usuarios WHERE id=?";
$sentencia = $conexion->prepare($datos);
$sentencia->bind_param("i", $id);
$sentencia->execute();

$resultado = $sentencia->get_result();
$usuario = $resultado->fetch_assoc();

/* Convertir fecha a una mas simple */
//Primero se crea el array
$meses = [
    "January" => "Enero",
    "February" => "Febrero",
    "March" => "Marzo",
    "April" => "Abril",
    "May" => "Mayo",
    "June" => "Junio",
    "July" => "Julio",
    "August" => "Agosto",
    "September" => "Septiembre",
    "October" => "Octubre",
    "November" => "Noviembre",
    "December" => "Diciembre",
];

//Crear el formato
$fecha = $usuario["creado_en"]; //Declarar fecha
$mesIngles = date("F", strtotime($fecha));
$anio = date("Y", strtotime($fecha));

$sentencia->close();

/* Solicitar recetas del usuario */
$sql_rec = 
    "SELECT r.* , u.nombre AS nombre_usuario
    FROM recetas r
    INNER JOIN usuarios u ON r.id_usuario = u.id
    WHERE r.id = ?";
$sentencia_rec = $conexion->prepare($sql_rec);
$sentencia_rec->bind_param("i", $id);
if($sentencia_rec->execute()) {
    $resultado_rec = $sentencia_rec->get_result();
}
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
    <main class="main main-perfil">

    <section class="info-perfil">
        <h1>Hola, <strong><?= htmlspecialchars($usuario_nombre) ?></strong>!</h1>
        <hr class="hr">
        <div class="datos-perfil">
            <p>Recetas creadas: 0</p>
            <p>Calificación promedio: 0</p>
            <p>Favoritos en en total: 0</p>
        </div>
        <hr class="hr">
        <div>
            <p>Miembro desde <?=htmlspecialchars($meses[$mesIngles])?> <?= htmlspecialchars($anio) ?> </p>
        </div>
        <nav class="nav">
        </nav>
    </section>
    <section class="seccion-recetas">
        <nav class="btns-nav">
            <button class="btn-perfil"><i class="ph ph-notepad"></i>Tus recetas</button>
            <button class="btn-perfil"><i class="ph ph-heart"></i>Favoritos</button>
            <button class="btn-perfil"><i class="ph ph-bookmark-simple"></i>Guardados</button>
        </nav>
        <section class="recetas">
            <?php while($receta = $resultado_rec->fetch_assoc()): ?>
                <p>A</p>
                <p><?=htmlspecialchars($receta["nombre_usuario"])?></p>
                <p><?=htmlspecialchars($receta["nombre"])?></p>
            <?php endwhile; ?>
        </section>
    </section>

    </main>
    <!--Inicio Footer-->
    <?php require_once "includes/footer.php"; ?>
    <!--Fin Footer-->
    <?php require_once "includes/nav-mobil.php"; ?>
</body>
</html>