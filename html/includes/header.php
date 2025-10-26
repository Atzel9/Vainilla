
<?php $usuario_nombre = $_SESSION['usuario_nombre'] ?? null; ?>
<header id="header">
    <a href="/bootcamp/Vainilla/index.php" class="inicio">
        <div class="div-inicio">
            <div class="icon"><img src="/bootcamp/Vainilla/img/icono.png" alt="Icono de Vainilla"></div>
        </div>
        <div class="div-buscar">
            <a href="/bootcamp/Vainilla/html/buscador.php" class="a-buscador"><i class="ph ph-magnifying-glass"></i>Buscar recetas...</a>
        </div>
        <div class="div-perfil">
            <?php if(isset($_SESSION['usuario_id'])):?>
                <a href="/bootcamp/Vainilla/html/perfil.php" class="usuario"><i class="ph ph-user"></i><p><?=htmlspecialchars($usuario_nombre)?></p></a>
                <a href="/bootcamp/Vainilla/html/configuracion.php" class="configuracion"><i class="ph ph-gear"></i></a>
            <?php else : ?>
                <div class="sesion">
                    <a href="/bootcamp/Vainilla/html/iniciar_sesion.php" class="iniciar-sesion">Iniciar Sesión</a>
                    <a href="/bootcamp/Vainilla/html/registrar.php">Registrarse</a>
                </div>
            <?php endif; ?>
        </div>
    </a>
</header>