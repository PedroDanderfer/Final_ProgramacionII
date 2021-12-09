<?php 

    $categories = [];

    $querySelectCategories = <<<SELECTCATEGORIES
    SELECT * FROM categories;
    SELECTCATEGORIES;

    $rtaSelectCategories = select($querySelectCategories);

    if(count($rtaSelectCategories) > 0){
        $categories = $rtaSelectCategories;
    }
?>
<li id="products-submenu">
    <div>
        <a href="index.php?section=products"><span>Productos</span></a>
        <?php if(count($categories) > 0): ?>
        <button id="DisplayProductSubMenuBtn">Abrir menú</button>
        <?php endif; ?>
    </div>
    <?php if(count($categories) > 0): ?>
    <ul id="ProductsSubmenu">
        <?php for ($i=0; $i < count($categories); $i++): ?>
        <li><a href="index.php?section=products&category=<?= $categories[$i]['name']; ?>"><?= $categories[$i]['name']; ?></a></li>
        <?php endfor; ?>
    </ul>
    <?php endif; ?>
</li>