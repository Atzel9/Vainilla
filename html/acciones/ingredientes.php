<?php
require_once "../../conexion.php";
$mensaje = '';

/* Primero verificar el estado de la cuenta del usuario */
if (!isset($_SESSION["usuario_id"])) {
    /* Si no ha iniciado sesion lo lleva a la pagina para que inicie sesion */
    header("Location: ../iniciar_sesion.php");
    exit;
} else {
    /* Seleccionar el rol del usuario para ver si tiene permitido acceder a la página */
    $id = $_SESSION['usuario_id'] ?? null;
    $nombre_usuario = $_SESSION['usuario_nombre'];
    $sql = "SELECT nombre, rol FROM usuarios WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if($usuario['rol'] != 'admin') {
        /* Si no tiene permiso lo redirige a la página de error */
        header("Location: /bootcamp/Vainilla/html/includes/error.php?error=datos");
        exit;
    }
    $stmt->close();
}

$id = $_GET["id"] ?? 0;

/* Si no tiene datos la página redirecciona a la página error */
if ($id == 0) {
    header("Location: ../includes/error.php?error=datos");
}
/* Metodo para actualizar/eliminar el ingrediente */
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_ing = $_POST["nombre"];

    /* Metodo para editar el ingrediente */
    if (isset($_POST['Editar'])) {
        /* Primero se verifica que el nombre no sea igual a otro ingrediente ya existente pero con otra id */
        $sql_ver = "SELECT nombre FROM ingredientes WHERE nombre=? AND id!=?";
        /* $sentencia_ver = sentencia verificar */
        $sentencia_ver = $conexion->prepare($sql_ver);
        $sentencia_ver->bind_param("si", $nom_ing, $id);
        $sentencia_ver->execute();
        $resultado_ver = $sentencia_ver->get_result();

        if($resultado_ver->num_rows > 0) {
            $mensaje = "Este ingrediente ya existe";
        } else {
            /* Si no existe dicho ingrediente con diferente id, entonces se actualiza el nombre del ingrediente */
            $sql_edit = "UPDATE ingredientes SET nombre=? WHERE id=?";
            /* $sentencia_up = sentencia update(actualizar) */
            $sentencia_up = $conexion->prepare($sql_edit);
            if (!$sentencia_up) {
                $mensaje = "Error al preparar la actualización " . $conexion->error;
            } else {
                $sentencia_up->bind_param("si", $nom_ing, $id);
                if ($sentencia_up->execute()) {
                    $mensaje = "Ingrediente editado con exito!";
                } else {
                    $mensaje = "Error al actualizar los datos" . $conexion->error;
                }
                $sentencia_up->close();
            }
        }
        $sentencia_ver->close();
    } elseif (isset($_POST['Eliminar'])) {
        /* Metodo para eliminar el ingrediente */

        $id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
        if ($id <= 0) {
            die("ID inválido.");
        }
        //Primero se verifica que exista el ingrediente.
        $sql_sel = "SELECT id FROM ingredientes WHERE id = ?";
        $sentencia_sel = $conexion->prepare($sql_sel);
        if(!$sentencia_sel) {die("Error al preparar la consulta." . $conexion->error);}
        $sentencia_sel->bind_param("i", $id);
        $sentencia_sel->execute();
        $resultado_sel = $sentencia_sel->get_result();
        if(!$resultado_sel || $resultado_sel->num_rows != 1) {die("Ingrediente no encontrado.");}
        $sentencia_sel->close();
        //Si se encuentra el ingrediente se ejecuta ahora el método de eliminar
        $sql_del = "DELETE FROM ingredientes WHERE id=?";
        $sentencia_del = $conexion->prepare($sql_del);
        if(!$sentencia_del) {die("Error al preparar la eliminación: " . $conexion->error);}
        $sentencia_del->bind_param("i", $id);

        if ($sentencia_del->execute()) {
            //Si se ejecuta se elimina
            $sentencia_del->close();
            header("Location: ../admin.php");
            exit;
        } else {
            //Si no muestra el error
            $sentencia_del->close();
            die("Error al eliminar: " . $conexion->error);
        }
    }
}
/* Seleccionar datos del ingrediente seleccionado */
$ingrediente = "SELECT nombre, id FROM ingredientes WHERE id=?";
$sentencia = $conexion->prepare($ingrediente);
$sentencia->bind_param("i", $id);
$sentencia->execute();

$resultado = $sentencia->get_result();
if($resultado->num_rows != 1) {
    header("Location: ../includes/error.php?error=datos");
} else {
    $nom_ing = $resultado->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vainilla: Lo dulce de la tradición</title>
    <!--Icono de la página-->
    <link rel="icon" type="image/x-icon" href="/bootcamp/Vainilla/img/icono.png">
    <!--Link para ingresar a los estilos-->
    <link rel="stylesheet" href="/bootcamp/Vainilla/css/styles.css">
    <link rel="stylesheet" href="/bootcamp/Vainilla/css/styles_admin.css">
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
    <?php require_once "../includes/header.php"; ?>
    <main class="main">
        <h2><?=htmlspecialchars($nom_ing['nombre'])?></h2>
        <h3 class="h3_ing">Número de identificación: #<?=htmlspecialchars($nom_ing['id'])?></h3>
        <a href="../admin.php">Regresar a la página de administración</a>

        <?php if($mensaje != ''): ?>
            <p><?=htmlspecialchars($mensaje)?></p>
        <?php endif; ?>
        <form method="post">
            <input type="text" value="<?=htmlspecialchars($nom_ing['nombre'])?>" required name="nombre">
            <input type="submit" name="Editar" value="Editar">
            <input type="submit" name="Eliminar" value="Eliminar">
        </form>
    </main>
    <?php require_once "../includes/footer.php"; ?>
    <?php require_once "../includes/nav-mobil.php"; ?>
</body>
</html>