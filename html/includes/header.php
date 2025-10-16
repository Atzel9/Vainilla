
<?php $usuario_nombre = $_SESSION['usuario_nombre'] ?? null; ?>
<header id="header">
    <a href="/bootcamp/Vainilla/index.php" class="inicio">
        <div class="div-inicio">
            <div class="icon"><img src="/bootcamp/Vainilla/img/icono.png" alt="Icono de Vainilla"></div>
            <div class="div-titulo"><p class="titulo">Vainilla <br> "Lo dulce de la tradición"</p></div>
            </div>
        <div class="navegacion">
            <nav class="nav">
                <ul>
                    <li><a href="/html/buscador.php" class="buscar"><i class="bi bi-search"></i></a></li>
                    <?php if(isset($_SESSION["usuario_id"])) : ?>
                    <li><a href="/bootcamp/Vainilla/html/perfil.php" class="usuario"><i class="ph ph-user"></i><p><?=htmlspecialchars($nombre_usuario)?></p></a></li>
                    <?php else: ?>
                    <li><a href="/bootcamp/Vainilla/html/registrar.php" class="iniciar-sesion">Registrarse</a></li>
                    <?php endif;?>
                </ul>
            </nav>
        </div>
    </a>
</header>