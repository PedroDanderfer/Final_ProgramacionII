<?php 
    $section_id = (empty($_GET['id'])) ? null : $_GET['id'];
?>
<li id="shoppingCart-submenu">
    <div>
        <button id="DisplayShoppingCartSubMenuBtn"><span>Carrito de compras</span><span id="ShoppingCartSubMenuIconSpan"></span></button>
    </div>
    <?php if(isset($_SESSION['shoppingCart'][0])): ?>
        <div id="ShoppingCartSubMenu">
            <ul>
                <?php for($i=0; $i < count($_SESSION['shoppingCart']); $i++): ?>
                        <li>
                            <div>
                                <p><?= $_SESSION['shoppingCart'][$i]['title'] ?></p>
                                <p>Cantidad: <?= $_SESSION['shoppingCart'][$i]['quantity'] ?></p>
                            </div>
                            <a href="./back/controller/shoppingCart/remove.php?product_id=<?= $_SESSION["shoppingCart"][$i]["id"] ?>&section=<?= $section ?><?php if (!is_null($section_id)) echo '&section_id='.$section_id; ?>">Eliminar producto</a>
                        </li>
                <?php endfor; ?>
            </ul>
            <?php if(!isLogged()): ?>
                <a href="index.php?section=login">Inicia sesión</a>
            <?php else: ?>
                <a href="index.php?section=purchase">Continuar con la compra</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div id="ShoppingCartSubMenu">
            <ul>
                <li>No agregaste productos a tu carrito.</li>
            </ul>
            <?php if(!isLogged()): ?>
                <a href="index.php?section=login">Inicia sesión</a>
            <?php else: ?>
                <?php if(isset($_SESSION["shoppingCart"]) && !empty($_SESSION["shoppingCart"])): ?>
                    <a href="index.php?section=purchase">Continuar con la compra</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</li>