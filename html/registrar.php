<?php
require_once "../conexion.php";
if(isset($_SESSION['usuario_id'])) {
    header("Location: perfil.php");
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre     = trim($_POST["nombre"] ?? "");
    $correo     = trim($_POST["correo"] ?? "");
    $contrasena = $_POST["contrasena"] ?? "";

    if ($nombre === "" || $correo === "" || $contrasena === "") {
        $mensaje = "Completa todos los campos.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo no es válido.";
    } else {
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $rol = 'user';
        $sql = "INSERT INTO usuarios (nombre, correo, contrasena_hash, rol) VALUES (?, ?, ?, ?)";
        $sentencia = $conexion->prepare($sql);
        if ($sentencia) {
            $sentencia->bind_param("ssss", $nombre, $correo, $contrasena_hash, $rol);
            if ($sentencia->execute()) {
                $mensaje = "Registro exitoso. Ahora puedes iniciar sesión.";
            } else {
                if ($conexion->errno === 1062) {
                    $mensaje = "El correo ya está registrado.";
                } else {
                    $mensaje = "Error al registrar: " . $conexion->error;
                }
            }
            $sentencia->close();
        } else {
            $mensaje = "Error al preparar la sentencia: " . $conexion->error;
        }
    }
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
    <link rel="stylesheet" href="../css/styles_sesion.css">
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
    <main>
        <section class="div-form">
            <div class="div-form-text">
                <h1>Registro de usuario</h1>
                <h2>¡Adentrate a la cocina!</h2>
            </div>

            <?php if ($mensaje !== ""): ?>
                <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
            <?php endif; ?>

            <form method="post" action="registrar.php" novalidate class="formulario">
                <div class="div-frame">
                    <label for="nombre">Nombre</label>
                    <input id="nombre" name="nombre" type="text" required maxlength="100" autocomplete="name">
                </div>

                <div class="div-frame">
                    <label for="correo">Correo</label>
                    <input id="correo" name="correo" type="email" required maxlength="120" autocomplete="email">
                </div>

                <div class="div-frame">
                    <label for="contrasena">Contraseña</label>
                    <input id="contrasena" name="contrasena" type="password" required minlength="6" autocomplete="new-password">
                </div>

                <button type="submit" class="submit">Crear cuenta</button>
            </form>

            <p>¿Ya tienes cuenta? <a href="iniciar_sesion.php">Inicia sesión</a></p>
        </section>
    </main>
    <!--Inicio Footer-->
    <?php require_once "includes/footer.php" ?>
    <!--Fin Footer-->
    <?php require_once "includes/nav-mobil.php"; ?>
    <!--Acceder al Javascript-->
    <script type="text/Javascript"></script>
</body>
</html>