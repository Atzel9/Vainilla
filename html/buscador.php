<?php
require_once "../conexion.php";

$nombre_usuario = $_SESSION["usuario_nombre"] ?? null;
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
    <link rel="stylesheet" href="../css/styles_buscador.css">
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
    <main class="main">
        <div class="div-buscador">
            <form action="">
                <input class="buscador" type="text" name="buscar" placeholder="Buscar recetas...">
                <input class="input-buscar" type="submit" value="Buscar">
            </form>
            <button class="filtros"><i class="bi bi-sliders"></i></button>
            <div class="fondo">
                    <div class="ventana-filtro">
                    <div class="cerrar"><i class="ph ph-x"></i></div>
                    <ul class="lista-filtros">
                        <li class="li-postre">
                            <button id="boton-tipo-postre">Elige el postre</button>
                            <ul class="tipo-postre">
                                <li class="postre">Postres horneados</li>
                                <li class="postre">Postres fríos</li>
                                <li class="postre">Postres helados</li>
                                <li class="postre">Postres de cuchara</li>
                                <li class="postre">Postres fritos</li>
                                <li class="postre">Repostería con frutas</li>
                                <li class="postre">Respotería con masa hojaldre</li>
                                <li class="postre">Dulces y confitería</li>
                            </ul>
                        </li>
                        <li class="li-tiempo">
                            <button id="boton-tiempo">Tiempo en específico</button>
                            <ul class="lista-tiempo">
                                <li class="tiempo">0-30min</li>
                                <li class="tiempo">15-30min</li>
                                <li class="tiempo">30-60min</li>
                                <li class="tiempo">1-2h</li>
                                <li class="tiempo">2h+</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    <!--Inicio Footer-->
    <!--Inicio Footer-->
    <?php require_once "includes/footer.php" ?>
    <!--Fin Footer-->
    <?php require_once "includes/nav-mobil.php"; ?>
    <!--Acceder al Javascript-->
    <script type="text/Javascript"></script>
</body>
</html>