<?php
require_once "conexion.php";

$nombre_usuario = $_SESSION["usuario_nombre"] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora</title>
    <!--Icono de la página-->
    <link rel="icon" type="image/x-icon" href="img/icono.png">
    <!--Link para ingresar a los estilos-->
    <link rel="stylesheet" href="css/styles.css?v=1.1">
    <link rel="stylesheet" href="css/styles_bitacora.css">
    <!--Acceso a google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400..900;1,400..900&family=Google+Sans+Code:ital,wght@0,300..800;1,300..800&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
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
    <!--Inicio del header-->
    <?php require_once "html/includes/header.php" ?>
    <!--Fin del header-->
    <section class="section">
        <div id="bitacora">
            <div class="cambio">
                <h2 class="version">v 1.0.0</h2>
                <h2 class="fecha">02/10/25</h2>
                <ul class="ul">
                    <li class="li">📄Se creo la página index.</li>
                    <li class="li">🖌️Se creo el header.</li>
                    <li class="li">🖌️Se creo el footer.</li>
                    <li class="li">📝Creación de la bitácora.</li>
                    <li class="li">🖼️El icono es temporal.</li>
                </ul>
            </div>
            <div class="cambio">
                <h2 class="version">v 1.0.1</h2>
                <h2 class="fecha">03/10/25</h2>
                <ul class="ul">
                    <li class="li">📱El footer y header se hicieron responsivos.</li>
                </ul>
            </div>
            <div class="cambio">
                <h2 class="version">v 1.1.0</h2>
                <h2 class="fecha">04/10/25</h2>
                <ul class="ul">
                    <li class="li">🔎Se agrego la barra de busqueda en el index.</li>
                    <li class="li">🚧Se agregaron tarjetas divisoras en el index. Están en pruba y solo es para dar un vistazo de como será al final.</li>
                    <li class="li">📱La barra de navegación se cambio para las pantallas pequeñas. Ahora estarán abajo para una mejor experiencia de usuario.</li>
                    <li class="li">📝Pequeños correciones de errores ortógraficos.</li>
                </ul>
            </div>
        </div>
    </section>
    <!--Inicio Footer-->
    <?php require_once "html/includes/footer.php" ?>
    <!--Fin Footer-->
    <?php require_once "html/includes/nav-mobil.php" ?>
</body>
</html>