<?php
require_once "../conexion.php";

if(!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit;
}

//Pedir lista de ingredientes
$sql_ing = $conexion->query("SELECT * FROM ingredientes ORDER BY nombre ASC"); //Ordenar la lista de manera alfabetica de "a" a "z"
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
    <link rel="stylesheet" href="../css/styles_crear.css">
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
    <main class="main">
        <form action="crear-receta.php" class="form-rec">
            <div class="form-rec-datos">
                <label for="imagen">
                    <input type="file" accept="image/jpg, image/jpg, image/png, image/webp">
                </label>
                <label for="titulo">
                    <input type="text" name="titulo" placeholder="Nombre de la receta" required>
                </label>
            </div>
            <div class="form-rec-txt">
                <div class="for-rec-ing">
                    <!--Lista de contenedor que contiene los ingredientes agregados-->
                    <div id="ingredientes-seleccionados">

                    </div>
                    <h2>Selecciona los ingredientes:</h2>
                    <button id="btn-lista-ing" class="form-rec-ing" type="button">Lista de ingredientes <i class="ph ph-caret-down"></i></button>
                    <!--Lista de contenedor que contiene la lista de ingredientes y el buscador-->
                    <div id="lis-rec" class="lis-rec lista-desactiva">
                        <div class="div-rec-buscador">
                            <input id="buscador-ingrediente" type="text" placeholder="Buscar ingrediente...">
                        </div>
                        <div class="contenedor-lista-ing">
                            <?php while($fila_ing = $sql_ing->fetch_assoc()):?>
                                <div class="lista-ing" data-id="<?=htmlspecialchars($fila_ing['id'])?>" data-nombre=" <?=htmlspecialchars($fila_ing['nombre'])?> ">
                                    <span class="nombre-ingrediente"><?=htmlspecialchars($fila_ing['nombre'])?></span>
                                    <button class="agregar-ingrediente" type="button"><i class="ph ph-plus"></i></button>
                                </div>
                            <?php endwhile;?>
                        </div>
                    </div>
                </div>
                <div id="form-texto" class="form-rec-txt">
                    <h2>Indica los pasos para hacer esta receta:</h2>
                    <button id="crear-bloquetxt" class="crear-paso" type="button">Crear paso</button>
                    <div class="div-paso" data-paso="1">
                        <h2 class="paso-h2">Paso 1</h2>
                        <textarea class="textarea" name="paso[]" placeholder="Escribir instrucciones..."></textarea>
                    </div>
                </div>
            </div>
            <button class="form-rec-btn" type="submit">Subir receta</button>
        </form>
    </main>
    <?php require_once "includes/footer.php"; ?> 
    <?php require_once "includes/nav-mobil.php"; ?>
    <!-- Acceso a javascript-->
    <script src="../js/app.js"></script>
    <!-- Script para las recetas-->
    <script src="../js/receta.js"></script>
</body>
</html>