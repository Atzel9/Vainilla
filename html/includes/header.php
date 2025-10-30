<?php 
$usuario_nombre = $_SESSION['usuario_nombre'] ?? null;
?>
<header id="header">
    <div class="div-inicio">
        <a class="icon" href="/bootcamp/Vainilla/index.php"><img src="/bootcamp/Vainilla/img/icono.png" alt="Icono de Vainilla"></a>
    </div>
    <div class="div-buscador-header">
        <a href="/bootcamp/Vainilla/html/buscador.php" class="a-buscador"><i class="ph ph-magnifying-glass"></i>Buscar recetas...</a>
    </div>
    <div class="div-perfil">
        <?php if(isset($_SESSION['usuario_id'])):?>
            <div class="index-perfil">
                <a href="/bootcamp/Vainilla/html/perfil.php" class="usuario"><i class="ph ph-user"></i><p><?=htmlspecialchars($usuario_nombre)?></p></a>
                <a href="/bootcamp/Vainilla/html/configuracion.php" class="configuracion"><i class="ph ph-gear"></i></a>
            </div>
        <?php else : ?>
            <div class="login">
                <a href="/bootcamp/Vainilla/html/iniciar_sesion.php" class="iniciar-sesion">Iniciar Sesión</a>
                <a href="/bootcamp/Vainilla/html/registrar.php" class="registrarse" >Registrarse</a>
            </div>
        <?php endif; ?>
    </div>
</header>