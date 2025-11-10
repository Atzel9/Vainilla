<?php
require_once "../conexion.php";

require_once "acciones/require_admin.php";

$mensaje = "";

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
                    header("Location: admin.php?seccion=ingrediente");
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
/* Seleccionar datos de la tabla recetas aprobadas */
$sql_recetas = $conexion->query(
    "SELECT 
    r.id, r.nombre, r.imagen, r.id_usuario, r.tiempo, r.creado_en,
    u.nombre AS nombre_usuario
    FROM recetas r
    INNER JOIN  usuarios u ON r.id_usuario = u.id
    ORDER BY r.id DESC"
);
/* Seleccionar datos de la tabla recetas pendientes */
$sql_recetas_aprobada = $conexion->query(
    "SELECT 
    r.id, r.nombre, r.imagen, r.id_usuario, r.tiempo, r.creado_en,
    u.nombre AS nombre_usuario
    FROM recetas r
    INNER JOIN  usuarios u ON r.id_usuario = u.id
    WHERE estado = 'aprobada'
    ORDER BY id DESC"
);
/* Seleccionar datos de la tabla usuarios */
$sql_usuarios = $conexion->query(
    "SELECT id, nombre, correo, creado_en, rol
        FROM usuarios
        ORDER BY id DESC"
);

//Metodo para activar botón
$seccion = $_GET['seccion'] ?? "";
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
            <h2>Panel de administración</h2>
            <div class="btns-accion">
                <p>Admin: <?=htmlspecialchars($nombre_usuario)?> </p>
                <button id="btnIng" class="btn <?= ($seccion === 'ingrediente') ? 'btn-activo' : '' ?>">Ingredientes</button>
                <button id="btnRec" class="btn <?= ($seccion === 'recetas') ? 'btn-activo' : '' ?>" ">Recetas</button>
                <button id="btnUsu" class="btn <?= ($seccion === 'usuarios') ? 'btn-activo' : '' ?>">Usuarios</button>
            </div>
            <!--Mensaje de Bienvenida cuando se entra al panel-->
            <div id="vacio" class="div <?= ($seccion === '') ? 'div-activo' : '' ?>  ">
                <h2>Bienvenido <?=htmlspecialchars($nombre_usuario)?> al panel de administración</h2>
                <p>Elige una opción para continuar</p>
            </div>
            <!--Mostrar tabla de ingredientes. Y sección para crear ingredientes-->
            <div id="ingrediente" class="div <?= ($seccion === 'ingrediente') ? 'div-activo' : '' ?>">
                <h3>Lista de ingrediente</h3>
                <div class="div-crear">
                    <form method="POST" class="form">
                        <p>Crear ingrediente</p>
                        <input id="form-ingrediente" type="text" name="ingrediente" required>
                        <button type="submit" id="form-subir-ingrediente">Subir ingrediente</button>
                    </form>
                    <div class="div-admin-bus">
                            <input type="text" id="admin-buscar" placeholder="Buscar ingrediente...">
                    </div>
                    <?php if($mensaje !== ""): ?>
                        <p><?=htmlspecialchars($mensaje)?></p>
                    <?php endif; ?>
                </div>
                <div class="div-datos">
                    <?php if($sql_ingredientes && $sql_ingredientes->num_rows > 0):?>
                        <table id="tabla-ingrediente" class="table">
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
                                <td class="nombre"><?= htmlspecialchars($fila_ing["nombre"])?></td>
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
            <!--Mostrar tabla de recetas que los usuarios han subido-->
            <div id="recetas" class="div <?= ($seccion === 'recetas') ? 'div-activo' : '' ?>">
                <div class="btns-recetas">
                    <button id="btn-recTodas" class="btn">Todas</button>
                    <button id="btn-recAprob" class="btn">Aprobadas</button>
                    <button id="btn-recPend" class="btn">Pendientes</button>
                </div>
                <div id="todas-recetas" class="div-recetas">
                        <?php while($cont_rec = $sql_recetas->fetch_assoc()):?>
                            <div class="card">
                                <a href="receta.php?<?=(int)$cont_rec["id"]?>">
                                    <div class="img">
                                        <img src="../<?=htmlspecialchars($cont_rec["imagen"])?>" class="img">
                                    </div>
                                    <div class="texto">
                                        <div><h3><?=htmlspecialchars($cont_rec["nombre"])?></h3></div>
                                        <div class="otros">
                                            <div class="usuario"><h2><?=htmlspecialchars($cont_rec["nombre_usuario"])?></h2></div>
                                            <div class="detalles">
                                                <div class="tiempo">
                                                    <?php if($cont_rec["tiempo"] > 60):?>
                                                        <!--Separar la horas de los minutos-->
                                                        <?php 
                                                        $horas = intval($cont_rec["tiempo"] / 60);  
                                                        $minutos = $cont_rec["tiempo"] % 60;
                                                        ?>
                                                        <p><i class="ph ph-hourglass-simple"></i><?=htmlspecialchars($horas)?>h <?=htmlspecialchars($minutos)?>min</p>
                                                    <?php else: ?>
                                                        <p><i class="ph ph-hourglass-simple"></i><?=htmlspecialchars($cont_rec["tiempo"])?> min</p>
                                                    <?php endif;?>
                                                </div>
                                                <div class="calificacion">
                                                    <p><i class="ph ph-star"></i>5.0</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                </div>
                <div id="aceptadas-recetas" class="div-recetas">
                        <?php while($cont_rec_aprob = $sql_recetas_aprobada->fetch_assoc()):?>
                            <div class="card">
                                <a href="receta.php?<?=(int)$cont_rec_aprob["id"]?>">
                                    <div class="img">
                                        <img src="../<?=htmlspecialchars($cont_rec_aprob["imagen"])?>" class="img">
                                    </div>
                                    <div class="texto">
                                        <div><h3><?=htmlspecialchars($cont_rec_aprob["nombre"])?></h3></div>
                                        <div class="otros">
                                            <div class="usuario"><h2><?=htmlspecialchars($cont_rec_aprob["nombre_usuario"])?></h2></div>
                                            <div class="detalles">
                                                <div class="tiempo">
                                                    <?php if($cont_rec_aprob["tiempo"] > 60):?>
                                                        <!--Separar la horas de los minutos-->
                                                        <?php 
                                                        $horas = intval($cont_rec_aprob["tiempo"] / 60);  
                                                        $minutos = $cont_rec_aprob["tiempo"] % 60;
                                                        ?>
                                                        <p><i class="ph ph-hourglass-simple"></i><?=htmlspecialchars($horas)?>h <?=htmlspecialchars($minutos)?>min</p>
                                                    <?php else: ?>
                                                        <p><i class="ph ph-hourglass-simple"></i><?=htmlspecialchars($cont_rec_aprob["tiempo"])?> min</p>
                                                    <?php endif;?>
                                                </div>
                                                <div class="calificacion">
                                                    <p><i class="ph ph-star"></i>5.0</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                </div>
                <div id="pendientes-recetas" class="div-recetas">
                </div>
                <div id="mensaje">
                    <p>Elige que estado de la receta quieres ver</p>
                </div>
            </div>
            <!--Mostrar lista de usuarios-->
            <div id="usuarios" class="div <?= ($seccion === 'usuarios') ? 'div-activo' : '' ?>">
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
                                <th>Acciones</th>
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
                                <td><a href="acciones/usuario.php?id=<?=(int)$fila_usu["id"]?>">Editar</a></td>
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