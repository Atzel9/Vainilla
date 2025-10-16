<?php $usuario_nombre = $_SESSION['usuario_nombre'] ?? null; ?>
<nav id="nav-movil">
    <ul class="ul-nav-movil">
        <li class="li-nav-movil inicio-movil nav-movil-activo"><a href="index.html"><i class="ph ph-house"></i></a></li>
        <li class="li-nav-movil"><a href="html/buscador.html" class="buscar-movil"><i class="ph ph-magnifying-glass"></i></a></li>
        <?php if(isset($_SESSION["usuario_id"])) : ?>
            <li class="li-nav-movil"><a href="/bootcamp/Vainilla/html/perfil.php" class="perfil-movil"><i class="ph ph-user"></i></a></li>
        <?php else: ?>
            <li class="li-nav-movil"><a href="/bootcamp/Vainilla/html/registrar.php" class="perfil-movil"><i class="ph ph-user"></i></a></li>
        <?php endif; ?>
    </ul>
</nav>