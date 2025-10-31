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
                <h2 class="version">v 0.1.0</h2>
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
                <h2 class="version">v 0.1.1</h2>
                <h2 class="fecha">03/10/25</h2>
                <ul class="ul">
                    <li class="li">📱El footer y header se hicieron responsivos.</li>
                </ul>
            </div>
            <div class="cambio">
                <h2 class="version">v 0.1.2</h2>
                <h2 class="fecha">04/10/25</h2>
                <ul class="ul">
                    <li class="li">🔎Se agrego la barra de busqueda en el index.</li>
                    <li class="li">🚧Se agregaron tarjetas divisoras en el index. Están en pruba y solo es para dar un vistazo de como será al final.</li>
                    <li class="li">📱La barra de navegación se cambio para las pantallas pequeñas. Ahora estarán abajo para una mejor experiencia de usuario.</li>
                    <li class="li">📝Pequeños correciones de errores ortógraficos.</li>
                </ul>
            </div>
            <div class="cambio">
                <h2 class="version">v.1.0.0</h2>
                <h2 class="fecha">05/10/25 - 15/10/25</h2>
                <ul class="ul">
                    <li class="li">🗄️Creación de base de datos.</li>
                    <li class="li">👤Gracias a la implementación de base de datos, ahora se pueden crear cuentas. Estas de manera predeterminada tendrán el rol de &quot;user&quot;, usuario en ingles. Gracias a esto en un futuro se podran crear recetas, calificar y comentar.</li>
                    <li class="li">🎛️Panel de administrador: Los usuarios con cuenta de administrador ahora tienen acceso a la sección de &quot;Panel de administración&quot;, esta podrá agregar ingredientes, ver las recetas que estan en lista de espera para que puedan ser aceptadas, y ver el esatdo de los usuarios.</li>
                    <li class="li">📝Se agrego un archivo .txt para mostrar el plan de desarrollo de la página.</li>
                </ul>
            </div>
            <div class="cambio">
                <h2 class="version">v.1.1.0</h2>
                <h2 class="fecha">16/10/25 - 24/20/25</h2>
                <ul class="ul">
                    <li class="li">🎛️CRUD para ingredientes completados. Ya se pueden agregar, leer, editar y eliminar ingredientes. Cuenta con un sistema para cuando antes de que se agregue el ingrediente verifique que no haya existido antes. Al editar el ingrediente tambien tiene una manera de verificar que el ingrediente no exista con ese mismo nombre. Todo esto para evitar errores.</li>
                    <li class="li">⚠️Ventana modal agregada para evitar que se eliminen ingredientes por accidente.</li>
                    <li class="li">🔎Esta la barra de busqueda para que el admin para verificar de manera más eficiente de que ya exista el ingrediente.</li>
                    <li class="li">🖌️Sección de registro e iniciar sesión ahora tienen estilos para que tengan una mejor aspecto.</li>
                </ul>
            </div>
            <div class="cambio">
                <h2 class="version">v1.2.0</h2>
                <h2 class="fecha">25/10/2025 - 26/10/25</h2>
                <ul class="ul">
                    <li class="li">🚀Nueva barra de navegación para los usuarios en movil:</li>
                    <li class="li">➕Se añadieron 2 botones en la barra de navegación para dispositivos moviles. Estas son &quot;Crear&quot; y &quot;Actividades&quot;.</li>
                    <li class="li">⚙️Los usuarios en movil que no hayan iniciado sesión ahora en vez de ser redirigidos a la página de registro, ahora se abrirá una ventana modal para verificar si quieren iniciar sesión/registrar o cerrar la ventana, siendo mas amigable este método.</li>
                    <li class="li">🎛️El panel de administración ahora tiene estilos y está mejor adaptado.</li>
                    <li class="li">👤Se agregaron las acciones de &quot;Editar/Eliminar&quot; en la tabla de usuarios para la tabla de administradores.</li>
                    <li class="li">⚠️La página de error ahora tiene estilos.</li>
                    <li class="li">➕Las paginas que necesiten rol de administrador ahora en vez de tener el código solo le llamara al archivo &quot;require_admin.php&quot; para menor confusión.</li>
                    <li class="li">🚧(WIP) El header tendría cambios para un aspecto mas adaptado a lo que necesitan los usuarios. Por el momento aún no se terminan estos cambios.</li>
                    <li class="li">🚧(WIP)El header no se mostrará en pantallas moviles. Será reemplazada para una más adaptada proximamente. Por el momento no se mostrará.</li>
                </ul>
            </div>
            <div class="cambio">
                <h2 class="version">v.1.3.0</h2>
                <h2 class="fecha">31/10/2025</h2>
                <ul class="ul">
                    <li class="li">🖌️Nueva barra de navegación para las pantallas moviles.</li>
                    <li class="li">🖌️Nuevo header para las pantallas de escritorio agregando y cambiando las funciones para que la experiencia de usuario sea mejor.</li>
                </ul>
            </div>
        </div>
    </section>
    <!--Inicio Footer-->
    <?php require_once "html/includes/footer.php" ?>
    <!--Fin Footer-->
    <?php require_once "html/includes/nav-mobil.php" ?>
    <script src="js/app.js"></script>
</body>
</html>