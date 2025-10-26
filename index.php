<?php
require_once "conexion.php";

$nombre_usuario = $_SESSION["usuario_nombre"] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vainilla: Lo dulce de la tradición</title>
    <!--Icono de la página-->
    <link rel="icon" type="image/x-icon" href="img/icono.png">
    <!--Link para ingresar a los estilos-->
    <link rel="stylesheet" href="css/styles.css?v=1.3">
    <link rel="stylesheet" href="css/styles_index.css">
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
</head>
<body>
    <!--Inicio del header-->
    <?php require_once "html/includes/header.php";?> 
    <!--Fin del header-->
    <main id="main">
        <!--Inicio donde se muestran las recetas-->
        <section id="recetario" class="section">
            <h2>En tu recetario</h2>
            <ul class="ul-recetas">
                <li class="card">
                    <a href="#">
                        <div class="img">
                            <img src="img/chessecake.jpg" alt="chessecake" class="img">
                        </div>
                        <div class="texto">
                            <div><h3>Chessecake</h3></div>
                            <div>
                                <div><i class="bi bi-hourglass"></i>1hr</div>
                                <div><i class="bi bi-star-fill star"></i>67</div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="card">
                    <a href="#">
                        <div class="img">
                            <img src="img/cookies.jpg" alt="chessecake" class="img">
                        </div>
                        <div class="texto">
                            <div><h3>Galletas</h3></div>
                            <div>
                                <div><i class="bi bi-hourglass"></i>1hr 30min</div>
                                <div><i class="bi bi-star-fill star"></i>4.2</div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="card">
                    <a href="#">
                        <div class="img">
                            <img src="img/donut.jpg" alt="chessecake" class="img">
                        </div>
                        <div class="texto">
                            <div><h3>Dona glaseada</h3></div>
                            <div>
                                <div><i class="bi bi-hourglass"></i>2hr</div>
                                <div><i class="bi bi-star-fill star"></i>4.3</div>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </section>
        <section id="Destacadas" class="section">
            <h2>Destacadas</h2>
            <ul class="ul-recetas">
                <li class="card">
                    <a href="#">
                        <div class="img">
                            <img src="img/chessecake.jpg" alt="chessecake" class="img">
                        </div>
                        <div class="texto">
                            <div><h3>Chessecake</h3></div>
                            <div>
                                <div><i class="bi bi-hourglass"></i>1hr</div>
                                <div><i class="bi bi-star-fill star"></i>4.6</div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="card">
                    <a href="#">
                        <div class="img">
                            <img src="img/cookies.jpg" alt="chessecake" class="img">
                        </div>
                        <div class="texto">
                            <div><h3>Galletas</h3></div>
                            <div>
                                <div><i class="bi bi-hourglass"></i>1hr 30min</div>
                                <div><i class="bi bi-star-fill star"></i>4.2</div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="card">
                    <a href="#">
                        <div class="img">
                            <img src="img/donut.jpg" alt="chessecake" class="img">
                        </div>
                        <div class="texto">
                            <div><h3>Dona glaseada</h3></div>
                            <div>
                                <div><i class="bi bi-hourglass"></i>2hr</div>
                                <div><i class="bi bi-star-fill star"></i>4.3</div>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </section>
        <section id="Valoradas" class="section">
            <h2>Mas valoradas</h2>
            <ul class="ul-recetas">
                <li class="card">
                    <a href="#">
                        <div class="img">
                            <img src="img/chessecake.jpg" alt="chessecake" class="img">
                        </div>
                        <div class="texto">
                            <div><h3>Chessecake</h3></div>
                            <div>
                                <div><i class="bi bi-hourglass"></i>1hr</div>
                                <div><i class="bi bi-star-fill star"></i>4.6</div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="card">
                    <a href="#">
                        <div class="img">
                            <img src="img/cookies.jpg" alt="chessecake" class="img">
                        </div>
                        <div class="texto">
                            <div><h3>Galletas</h3></div>
                            <div>
                                <div><i class="bi bi-hourglass"></i>1hr 30min</div>
                                <div><i class="bi bi-star-fill star"></i>4.2</div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="card">
                    <a href="#">
                        <div class="img">
                            <img src="img/donut.jpg" alt="chessecake" class="img">
                        </div>
                        <div class="texto">
                            <div><h3>Dona glaseada</h3></div>
                            <div>
                                <div><i class="bi bi-hourglass"></i>2hr</div>
                                <div><i class="bi bi-star-fill star"></i>4.3</div>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </section>
        <section id="Recientes" class="section">
            <h2>Recien agregadas</h2>
            <ul class="ul-recetas">
                <li class="card">
                    <a href="#">
                        <div class="img">
                            <img src="img/chessecake.jpg" alt="chessecake" class="img">
                        </div>
                        <div class="texto">
                            <div><h3>Chessecake</h3></div>
                            <div>
                                <div><i class="bi bi-hourglass"></i>1hr</div>
                                <div><i class="bi bi-star-fill star"></i>4.6</div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="card">
                    <a href="#">
                        <div class="img">
                            <img src="img/cookies.jpg" alt="chessecake" class="img">
                        </div>
                        <div class="texto">
                            <div><h3>Galletas</h3></div>
                            <div>
                                <div><i class="bi bi-hourglass"></i>1hr 30min</div>
                                <div><i class="bi bi-star-fill star"></i>4.2</div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="card">
                    <a href="#">
                        <div class="img">
                            <img src="img/donut.jpg" alt="chessecake" class="img">
                        </div>
                        <div class="texto">
                            <div><h3>Dona glaseada</h3></div>
                            <div>
                                <div><i class="bi bi-hourglass"></i>2hr</div>
                                <div><i class="bi bi-star-fill star"></i>4.3</div>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </section>
    </main>
    <!--Inicio Footer-->
    <?php require_once "html/includes/footer.php"; ?> 
    <!--Fin Footer-->
    <?php require_once "html/includes/nav-mobil.php"; ?>
    <!-- Acceso a javascript-->
    <script src="js/app.js"></script>
</body>
</html>