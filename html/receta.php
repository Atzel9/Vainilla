<?php
require_once "../conexion.php";

$id_receta = $_GET["id"] ?? 0;

if ($id_receta !== 0) {
    //Tomar todos los datos de la receta
    $sql_receta =   
    "SELECT r.* , u.nombre AS nombre_usuario
    FROM recetas r
    INNER JOIN usuarios u ON r.id_usuario = u.id
    WHERE r.id = ?";
    $sentencia_rec = $conexion->prepare($sql_receta);
    $sentencia_rec->bind_param("i", $id_receta);

    //Verificar que se haya ejecutado
    if ($sentencia_rec->execute()) {
        $resultado = $sentencia_rec->get_result();
        $receta = $resultado->fetch_assoc();


        //Seleccionar pasos
        $sql_pasos = "SELECT id, texto FROM receta_pasos WHERE id_receta = ?";
        $sentencia_pasos = $conexion->prepare($sql_pasos);
        $sentencia_pasos->bind_param("i", $id_receta);
        if ($sentencia_pasos->execute()) {
            $resultado_pasos = $sentencia_pasos->get_result();
        } else {
            header("Location: acciones/error?error=datos");
        }
        //Seleccionar ingredientes
        $sql_ing = 
        "SELECT ri.unidad, ri.cantidad, ri.id_ingrediente,
        i.nombre AS nombre_ingrediente
        FROM recetas_ingredientes ri
        INNER JOIN ingredientes i ON ri.id_ingrediente = i.id
        WHERE id_receta = ?";
        $sentencia_ing = $conexion->prepare($sql_ing);
        $sentencia_ing->bind_param("i", $id_receta);
        if ($sentencia_ing->execute()) {
            $resultado_ing = $sentencia_ing->get_result();
        } else {
            header("Location: acciones/error?error=datos");
        }
        //Saber el estado de la receta para poner de uso público o solo admins y autor de la receta
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if($id_usuario !== $receta["id_usuario"] && $receta["estado"] === 'pendiente') {
            require_once "acciones/require_admin.php";
        } /* PRELIMINAR EN PRUEBA */ else if ($id_usuario === $receta["id_usuario"]) {
            if($receta["estado"] === 'pendiente') {
                $autor = 'pendiendte';
            } else {
                $autor = 'aprobado';
            }
        }
    } else {
        header("Location: acciones/error.php?error=receta&tipo=ejecutar");
    }
    $sentencia_rec->close();
} else {
    header("Location: acciones/error.php?error=receta&tipo=null");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=htmlspecialchars($receta["nombre"])?></title>
    <!--Icono de la página-->
    <link rel="icon" type="image/x-icon" href="/bootcamp/Vainilla/img/icono.png">
    <!--Link para ingresar a los estilos-->
    <link rel="stylesheet" href="../css/styles.css?v=1.3">
    <link rel="stylesheet" href="../css/styles_recetas.css">
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
    <?php require_once "includes/header.php";?> 
    <?php require_once "includes/nav-pc.php"; ?>
    <main class="main-receta">
        <div id="sentinela"></div>
        <div class="opciones">
            <a href="#"><i class="ph ph-caret-left"></i></a>
            <button><i class="ph ph-heart"></i></button>
            <button><i class="ph ph-bookmark-simple"></i></button>
            <button><i class="ph ph-star"></i></button>
            <button><i class="ph ph-user-plus"></i></button>
            <button><i class="ph ph-share-fat"></i></button>
            <?php if($is_admin): ?>
                <button id="btn-rec-admin"><i class="ph ph-sliders-horizontal"></i></button>
            <?php endif; ?>
            <?php if($id_usuario === $receta["id_usuario"]): ?>
                <button><i class="ph ph-pencil-simple-line"></i></button>
            <?php endif; ?>
        </div>
        <section class="info-receta">
            <?php if($receta["estado"] === 'pendiente' && $id_usuario === $receta["id_usuario"]): ?>
                <div class="modal-pendiente">
                    <i class="ph ph-warning"></i><p>Tu receta aún necesita ser aprobada.</p>
                </div>
            <?php endif; ?>
            <div class="div-img">
                <img src="../<?=htmlspecialchars($receta["imagen"])?>" alt="imagen de la receta">
            </div>
            <div class="texto-receta">
                <div class="texto-info">
                    <p>Por:<a href="usuario.php?id=<?=htmlspecialchars($receta["id_usuario"])?>">@<?=htmlspecialchars($receta["nombre_usuario"])?></a></p>
                    <p>Tiempo: <?php if($receta["tiempo"] > 60):?>
                        <!--Separar la horas de los minutos-->
                        <?php 
                        $horas = intval($receta["tiempo"] / 60);  
                        $minutos = $receta["tiempo"] % 60;
                        ?>
                        <p><i class="ph ph-hourglass-simple"></i><?=htmlspecialchars($horas)?>h <?=htmlspecialchars($minutos)?>min</p>
                        <?php else: ?>
                        <p><i class="ph ph-hourglass-simple"></i><?=htmlspecialchars($receta["tiempo"])?> min</p>
                        <?php endif;?>
                    </p>
                    <p> <i class="ph ph-star"></i>5.0 </p>
                </div>
                <div class="ingredientes">
                    <h2 class="titulo-ing">Lista de ingredientes</h2>
                    <ul class="lista-ingredientes">
                        <?php while($ingrediente = $resultado_ing->fetch_assoc()): ?>
                            <li class="info ingrediente">
                                <p>
                                    <span><?=htmlspecialchars($ingrediente["nombre_ingrediente"])?></span>
                                    <span><?=htmlspecialchars($ingrediente["cantidad"])?></span>
                                    <span><?=htmlspecialchars($ingrediente["unidad"])?></span>
                                </p>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <div class="pasos">
                    <h2 class="titulo-ing">¡Hora de cocinar!</h2>
                    <ul class="lista-pasos">
                        <?php while($pasos = $resultado_pasos->fetch_assoc()): ?>
                            <li class="paso-receta">
                                <h3>Paso:</h3>
                                <p><?=htmlspecialchars($pasos["texto"])?></p>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </section>
    </main>
    
    <div id="modal-receta" class="modal-receta">
        <div class="ventana-modal">
            <div id="modal-calificar" class="modal-calificar">
                <p>PRUEBA</p>
            </div>
            <?php if($is_admin): ?>
                <div id="modal-admin" class="texto modal-admin">
                    <button id="admin-cerrar"><i class="ph ph-x"></i></button>
                    <p>Opciones de aministrador</p>
                    <p>Información:</p>
                    <p>No.<?=htmlspecialchars($receta["id"])?></p>
                    <p>Nombre: <?=htmlspecialchars($receta["nombre"])?></p>
                    <p>Por: <?=htmlspecialchars($receta["nombre_usuario"])?></p>
                    <p>Estado: <?=htmlspecialchars($receta["estado"])?></p>

                    <?php if($receta["estado"] === "pendiente"): ?>
                        <div class="btns-admin">
                            <form action="receta-admin.php">
                                <input type="hidden">
                                <button type="submit">Aceptar</button>
                                <button type="submit">Rechazar</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <button>Eliminar receta</button>
                    <?php endif;?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php require_once "includes/footer.php"; ?> 
    <?php require_once "includes/nav-mobil.php"; ?>
    <script src="../js/recetas.js"></script>
</body>
</html>
