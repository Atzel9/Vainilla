<?php
require_once "../conexion.php"; // si la página necesita conexión/sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Título de la página</title>
    <link rel="stylesheet" href="estilo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="contenedor">
        <div class="tarjeta">
        <div class="encabezado">
            <h1>Título principal</h1>
        </div>
        <p class="sub">Subtítulo o descripción breve de la página.</p>

        <!-- Mensajes -->
        <?php if (isset($mensaje) && $mensaje !== ""): ?>
            <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

        <!-- Contenido principal -->
        <div>
            <!-- Aquí va el formulario, tabla o texto según la página -->
            <p>Contenido central...</p>
        </div>

        <hr class="hr">

        <!-- Navegación -->
        <p class="nav">
            <a href="registrar.php">Registrar</a>
            <a href="iniciar_sesion.php">Iniciar sesión</a>
            <a href="perfil.php">Privado</a>
            <a href="salir.php">Salir</a>
        </p>
        </div>
    </div>
</body>
</html>
