<?php
require_once "../../conexion.php";

/* 1) Validar parámetro id */
$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) {
    die("ID inválido.");
}

/* 2) Obtener datos actuales del usuario */
$usuario = null;
$sql_sel = "SELECT id, nombre, correo FROM usuarios WHERE id = ?";
$sentencia_sel = $conexion->prepare($sql_sel);
if (!$sentencia_sel) { die("Error al preparar la consulta: " . $conexion->error); }
$sentencia_sel->bind_param("i", $id);
$sentencia_sel->execute();
$resultado_sel = $sentencia_sel->get_result();
if ($resultado_sel && $resultado_sel->num_rows === 1) {
    $usuario = $resultado_sel->fetch_assoc();
} else {
    die("Usuario no encontrado.");
}
$sentencia_sel->close();

/* 3) Procesar envío de formulario (POST) */
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre            = trim($_POST["nombre"] ?? "");
    $correo            = trim($_POST["correo"] ?? "");
    $contrasena_nueva  = $_POST["contrasena_nueva"] ?? ""; // opcional

    if ($nombre === "" || $correo === "") {
        $mensaje = "Nombre y correo son obligatorios.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo no es válido.";
    } else {
        if ($contrasena_nueva !== "") {
            $contrasena_hash = password_hash($contrasena_nueva, PASSWORD_DEFAULT);
            $sql_up = "UPDATE usuarios
                        SET nombre = ?, correo = ?, contrasena_hash = ?
                        WHERE id = ?";
            $sentencia_up = $conexion->prepare($sql_up);
            if (!$sentencia_up) {
                $mensaje = "Error al preparar actualización: " . $conexion->error;
            } else {
                $sentencia_up->bind_param("sssi", $nombre, $correo, $contrasena_hash, $id);
                if ($sentencia_up->execute()) {
                    $mensaje = "Usuario actualizado (incluye nueva contraseña).";
                    $usuario["nombre"] = $nombre;
                    $usuario["correo"] = $correo;
                } else {
                    if ($conexion->errno === 1062) {
                        $mensaje = "El correo ya está registrado en otro usuario.";
                    } else {
                        $mensaje = "Error al actualizar: " . $conexion->error;
                    }
                }
                $sentencia_up->close();
            }
        } else {
            $sql_up = "UPDATE usuarios
                        SET nombre = ?, correo = ?
                        WHERE id = ?";
            $sentencia_up = $conexion->prepare($sql_up);
            if (!$sentencia_up) {
                $mensaje = "Error al preparar actualización: " . $conexion->error;
            } else {
                $sentencia_up->bind_param("ssi", $nombre, $correo, $id);
                if ($sentencia_up->execute()) {
                    $mensaje = "Usuario actualizado.";
                    $usuario["nombre"] = $nombre;
                    $usuario["correo"] = $correo;
                } else {
                    if ($conexion->errno === 1062) {
                        $mensaje = "El correo ya está registrado en otro usuario.";
                    } else {
                        $mensaje = "Error al actualizar: " . $conexion->error;
                    }
                }
                $sentencia_up->close();
            }
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
    <?php require_once "includes/header.php" ?>
    <!--Fin del header-->
    <main>
        <h1>Editar usuario</h1>

        <?php if ($mensaje !== ""): ?>
            <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

        <form method="post" action="editar_usuario.php?id=<?= (int)$usuario['id'] ?>" novalidate>
            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" type="text" required maxlength="100"
                value="<?= htmlspecialchars($usuario['nombre']) ?>">

            <label for="correo">Correo</label>
            <input id="correo" name="correo" type="email" required maxlength="120"
                value="<?= htmlspecialchars($usuario['correo']) ?>">

            <label for="contrasena_nueva">Contraseña nueva (opcional)</label>
            <input id="contrasena_nueva" name="contrasena_nueva" type="password" minlength="6"
                placeholder="Déjalo vacío para no cambiarla">

            <button type="submit">Guardar cambios</button>
            <a href="perfil.php">Volver</a>
        </form>
    </main>
    <!--Inicio Footer-->
    <?php require_once "includes/footer.php" ?>
    <!--Fin Footer-->
    <?php require_once "includes/nav-mobil.php"; ?>
    <!--Acceder al Javascript-->
    <script type="text/Javascript"></script>
</body>
</html>