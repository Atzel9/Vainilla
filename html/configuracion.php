<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <!--Icono de la página-->
    <link rel="icon" type="image/x-icon" href="../img/icono.png">
    <!--Link para ingresar a los estilos-->
    <link rel="stylesheet" href="../css/styles.css?v=1.2">
    <link rel="stylesheet" href="../css/styles_configuracion.css">
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
    <?php require_once "includes/header.php"; ?>
    <?php require_once "includes/nav-pc.php"; ?>
    <main class="main main-conf">
        <section class="opciones">
            <ul class="lista-opciones">
                <li class="li-opc"><p>Editar perfil</p></li>
                <hr>
                <li class="li-opc btn-sesion"><a href="acciones/cerrar-sesion.php">Cerrar Sesión</a></li>
            </ul>
        </section>
        <section class="informacion">
            <div class="div-config div-cuenta">
                
            </div>
        </section>
    </main>
    <?php require_once "includes/footer.php"; ?>
    <?php require_once "includes/nav-mobil.php"; ?>
</body>
</html>