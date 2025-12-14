<?php 
$usuario_nombre = $_SESSION['usuario_nombre'] ?? null;
$id_perfil = $_SESSION['usuario_id'] ?? null;
$is_admin = false;

if(isset($_SESSION['usuario_id'])) {
    $consultaRol = $conexion->prepare("SELECT rol FROM usuarios WHERE id = ?");
    $consultaRol->bind_param("i", $id_perfil);
    $consultaRol->execute();
    $resultadoRol = $consultaRol->get_result();
    $pefil_rol = $resultadoRol->fetch_assoc();

    if($pefil_rol['rol'] === 'admin') {
        $is_admin = true;
    }
}

?>
<header id="header">
    <div class="div-inicio">
        <a class="icon" href="/bootcamp/Vainilla/index.php">
            <img src="/bootcamp/Vainilla/img/icono.png" alt="Icono de Vainilla">
            <img id="texto-logo" src="/bootcamp/Vainilla/img/texto_logo_png.png" alt="Vainilla">
        </a>
    </div>
    <div class="div-buscador-header">
        <a href="/bootcamp/Vainilla/html/buscador.php" class="a-buscador"><i class="ph ph-magnifying-glass"></i>Buscar recetas...</a>
    </div>
    <div class="div-perfil">
        <?php if(isset($_SESSION['usuario_id'])):?>
            <div class="index-perfil">
                <a href="/bootcamp/Vainilla/html/perfil.php" class="usuario"><i class="ph ph-user"></i><p><?=htmlspecialchars($usuario_nombre)?></p></a>
                <a href="/bootcamp/Vainilla/html/configuracion.php" class="configuracion"><i class="ph ph-gear"></i></a>
                <?php if($is_admin): ?>
                    <a href="/bootcamp/Vainilla/html/admin.php" class="admin"><i class="ph ph-sliders-horizontal"></i></a>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="login">
                <a href="/bootcamp/Vainilla/html/iniciar_sesion.php" class="iniciar-sesion">Iniciar Sesión</a>
                <a href="/bootcamp/Vainilla/html/registrar.php" class="registrarse" >Registrarse</a>
            </div>
        <?php endif; ?>
    </div>
</header>