<?php $usuario_nombre = $_SESSION['usuario_nombre'] ?? null; ?>
<?php if(!isset($_SESSION["usuario_id"])) : ?>
    <div id="nav-modal" class="nav-modal">
        <div class="contenedor-modal">
            <button id="cerrar" class="nav-btn-cerrar"><i class="ph ph-x"></i></button>
            <div class="modal-txt">
                <h2>Inicia sesión o Registrate</h2>
                <p>Al ser usuario registrado tienes acceso a poder crear recetas, añadir favoritos y calificar</p>
            </div>
            <div class="modal-btns">
                <a href="/bootcamp/Vainilla/html/registrar.php">Registrarse</a>
                <a href="/bootcamp/Vainilla/html/iniciar_sesion.php">Iniciar sesión</a>
            </div>
        </div>
    </div>
<?php endif;?>
<nav id="nav-movil">
    <ul class="ul-nav-movil">
        <li class="li-nav-movil"><a href="/bootcamp/Vainilla/index.php" class="inicio-movil"><i class="ph ph-house"></i></a></li>
        <li class="li-nav-movil"><a href="/bootcamp/Vainilla/html/buscador.php" class="buscar-movil"><i class="ph ph-magnifying-glass"></i></a></li>
        <?php if(isset($_SESSION["usuario_id"])) : ?>
            <li class="li-nav-movil"><a href="/bootcamp/Vainilla/html/crear.php" class="crear-movil"><i class="ph ph-plus"></i></a></li>
            <li class="li-nav-movil"><a href="/bootcamp/Vainilla/html/notificaciones.php" class="notifi-movil"><i class="ph ph-envelope"></i></a></li>
            <li class="li-nav-movil"><a href="/bootcamp/Vainilla/html/perfil.php" class="perfil-movil"><i class="ph ph-user"></i></a></li>
        <?php else: ?>
            <li class="li-nav-movil"><button class="nav-btn crear-movil"><i class="ph ph-plus"></i></button></li>
            <li class="li-nav-movil"><button class="nav-btn notifi-movil"><i class="ph ph-envelope"></i></button></li>
            <li class="li-nav-movil"><button class="nav-btn perfil-movil"><i class="ph ph-user"></i></button></li>
        <?php endif; ?>
    </ul>
</nav>