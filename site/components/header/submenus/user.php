<li id="user-submenu">
    <?php if(!isset($_SESSION['user']['id'])): ?>
        <div>
            <ul>
                <li><a href="index.php?section=login">Iniciar sesión</a></li>
                <li><a href="index.php?section=register">Registrarme</a></li>
            </ul>
        </div>
    <?php else: ?>
        <div>
            <button id="DisplayUserSubMenuBtn"><span><?= $_SESSION['user']['name'].' '.$_SESSION['user']['surname'] ?></span><span id="UserSubMenuArrowSpan"></span></button>
        </div>
        <ul id="UserSubmenu">
            <li><a href="index.php?section=profile">Mi perfil</a></li>
            <li><a href="index.php?section=profile">Mis compras</a></li>
            <?php if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                <li><a href="index.php?section=panel">Panel de administrador</a></li>
            <?php endif; ?>
            <li><a href="./back/controller/session/logout.php">Cerrar sesión</a></li>
        </ul>
    <?php endif; ?>
</li>