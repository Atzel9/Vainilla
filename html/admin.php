<?php
require_once "../conexion.php";

$mensaje = "";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: iniciar_sesion.php");
    exit;
} else {
    $id = $_SESSION['usuario_id'] ?? null;
    $nombre_usuario = $_SESSION['usuario_nombre'];
    $sql = "SELECT nombre, rol FROM usuarios WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if($usuario['rol'] != 'admin') {
        header("Location: includes/error.php?error=rol");
        exit;
    }
    $stmt->close();

    /* Metodo para agregar ingrediente a la DB*/
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        function cambiarTexto($texto) {
            /* Convertir el string a minúscula */
            $texto = mb_strtolower($texto, 'UTF-8');

            /* Quitar tíldes */
            $texto = strtr($texto, [
                'á' => 'a', 'é' => 'e', 'í' => 'i',
                'ó' => 'o', 'ú' => 'u', 'ü' => 'u',
                'Á' => 'a', 'É' => 'e', 'Í' => 'i',
                'Ó' => 'o', 'Ú' => 'u', 'Ü' => 'u'
            ]);

            /* Quitar cualquier espacio extra */
            $texto = trim($texto);

            return $texto;
        }
        $ingrediente = $_POST["ingrediente"];
        $ingrediente_normalizado = cambiarTexto($_POST["ingrediente"]) ;

        if($ingrediente === "") {
            $mensaje = "Campo vacío";
        }
        else {
            /*  Verificar que no exista otro ingrediente con el mismo nombre */
            $sql_verificar = "SELECT id FROM ingredientes WHERE nombre=?";
            $sentencia = $conexion->prepare($sql_verificar);
            $sentencia->bind_param("s", $ingrediente_normalizado);
            $sentencia->execute();

            $resultado_ing = $sentencia->get_result();

            /* SI cumple condicional entonces no se agrega a la BD */
            if($resultado_ing->num_rows > 0) {
                $mensaje = "Este ingrediente ya existe";
            } else if ($resultado_ing->num_rows === 0) {
                $sql_agregar_ing = "INSERT INTO ingredientes (nombre) VALUES (?)";
                $sentencia = $conexion->prepare($sql_agregar_ing);
                if($sentencia){
                    $sentencia->bind_param("s", $ingrediente);
                    if($sentencia->execute()) {
                        $mensaje = "Ingrediente añadido!";
                    } else {
                        $mensaje = "Ocurrio un error al registrar";
                    }
                    $sentencia->close();
                } else {
                    $mensaje = "Error al preparar la sentencia " . $conexion->error;
                }
            }
        }
    }

    /* Pedir los datos en las 3 tablas. INGREDIENTES. RECETAS. USUARIOS */
    /* Seleccionar datos de la tabla ingredientes */
    $sql_ingredientes = $conexion->query(
        "SELECT id, nombre 
            FROM ingredientes 
            ORDER BY id DESC"
        );
    /* Seleccionar datos de la tabla recetas pendientes */
    $sql_recetas = $conexion->query(
        "SELECT id, nombre, imagen, id_usuario, estado
            FROM recetas 
            ORDER BY id DESC"
    );
    /* Seleccionar datos de la tabla usuarios */
    $sql_usuarios = $conexion->query(
        "SELECT id, nombre, correo, creado_en, rol
            FROM usuarios
            ORDER BY id DESC"
    );
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vainilla: Lo dulce de la tradición</title>
    <!--Icono de la página-->
    <link rel="icon" type="image/x-icon" href="/bootcamp/Vainilla/img/icono.png">
    <!--Link para ingresar a los estilos-->
    <link rel="stylesheet" href="../css/styles.css?v=1.2">
    <link rel="stylesheet" href="../css/styles_admin.css">
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
        <main class="main">
            <h2><?=htmlspecialchars($nombre_usuario);?></h2>
            <div class="btns-accion">
                <button id="btnIng" class="btn btn-activo">Ingredientes</button>
                <button id="btnRec" class="btn">Recetas</button>
                <button id="btnUsu" class="btn">Usuarios</button>
            </div>
            <div id="ingrediente" class="div div-activo">
                <h3>Lista de ingrediente</h3>
                <div class="div-crear">
                    <form method="POST" class="form">
                        <p>Crear ingrediente</p>
                        <input id="form-ingrediente" type="text" name="ingrediente" required>
                        <input type="submit" id="form-subir-ingrediente">
                    </form>
                    <?php if($mensaje !== ""): ?>
                        <p><?=htmlspecialchars($mensaje)?></p>
                    <?php endif; ?>
                </div>
                <div class="div-datos">
                    <?php if($sql_ingredientes && $sql_ingredientes->num_rows > 0):?>
                        <table class="table">
                        <thead class="thead">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th colspan="2" >Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php while ($fila_ing = $sql_ingredientes->fetch_assoc()):?>
                                <tr>
                                <td><?= (int)$fila_ing["id"]?></td>
                                <td><?= htmlspecialchars($fila_ing["nombre"])?></td>
                                <td><a href="acciones/ingredientes.php?id=<?=(int)$fila_ing["id"]?>">Editar</a></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                        </table>
                    <?php else:?>
                        <p>No hay ingredientes</p>
                    <?php endif;?>
                </div>
            </div>
            <div id="recetas" class="div">
                <h3>Recetas pendientes</h3>
            </div>
            <div id="usuarios" class="div">
                <h3>Lista de usuarios</h3>
                <div class="div-datos">
                    <?php if($sql_usuarios && $sql_usuarios->num_rows > 0):?>
                        <table class="table">
                        <thead class="thead">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Creado en:</th>
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php while ($fila_usu = $sql_usuarios->fetch_assoc()):?>
                                <tr>
                                <td><?= (int)$fila_usu["id"]?></td>
                                <td><?= htmlspecialchars($fila_usu["nombre"])?></td>
                                <td><?= htmlspecialchars($fila_usu["correo"])?></td>
                                <td><?= htmlspecialchars($fila_usu["creado_en"])?></td>
                                <td><?= htmlspecialchars($fila_usu["rol"])?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                        </table>
                    <?php else:?>
                        <p>No se encontraron usuarios</p>
                    <?php endif;?>
                </div>
            </div>
        </main>
    <?php require_once "includes/footer.php"; ?>
    <?php require_once "includes/nav-mobil.php"; ?>
    <script src="../js/admin.js"></script>
</body>
</html>