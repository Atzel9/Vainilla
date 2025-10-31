<nav class="nav-pc">
    <ul class="ul-nav-pc">
        <li class="li-nav-pc"><a href="/bootcamp/Vainilla/index.php" class="inicio-movil"><i class="ph ph-house"></i></a></li>
        <?php if(isset($_SESSION["usuario_id"])) : ?>
            <li class="li-nav-pc"><a href="/bootcamp/Vainilla/html/crear.php" class="crear-movil"><i class="ph ph-plus"></i></a></li>
            <li class="li-nav-pc"><a href="/bootcamp/Vainilla/html/notificaciones.php" class="notifi-movil"><i class="ph ph-envelope"></i></a></li>
            <li class="li-nav-pc"><a href="/bootcamp/Vainilla/html/notificaciones.php?seccion=fav" class="notifi-movil"><i class="ph ph-heart"></i></a></li>
            <li class="li-nav-pc"><a href="/bootcamp/Vainilla/html/notificaciones.php?seccion=esp" class="notifi-movil"><i class="ph ph-bookmark-simple"></i></a>
        <?php else: ?>
            <li class="li-nav-pc"><button class="nav-btn crear-movil"><i class="ph ph-plus"></i></button></li>
            <li class="li-nav-pc"><button class="nav-btn notifi-movil"><i class="ph ph-envelope"></i></button></li>
            <li class="li-nav-pc"><button class="nav-btn notifi-movil"><i class="ph ph-heart"></i></button></li>
            <li class="li-nav-pc"><button class="nav-btn notifi-movil"><i class="ph ph-bookmark-simple"></i></button></li>
        <?php endif; ?>
    </ul>
</nav>