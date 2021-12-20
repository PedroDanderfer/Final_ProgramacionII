<?php 
    if(!isLoggedAdmin()){
        return header('Location: index.php?section=home');
    }
    
    $products = [];

    $querySelectProducts = <<<SELECTPRODUCTS
    SELECT * FROM products;
    SELECTPRODUCTS;

    $rtaSelectProducts = select($querySelectProducts);

    if(count($rtaSelectProducts) > 0){
        $products = $rtaSelectProducts;
    }
?>
<section id="products">
    <ul>
        <?php for ($i=0; $i < count($products); $i++): ?>
            <li>
                <a href="index.php?section=product&id=<?= $products[$i]['id'] ?>">
                    <div>
                        <h3><?= $products[$i]['title'] ?></h3>
                        <div>
                            <p>Precio: <?= $products[$i]['price'] ?></p>
                            <?php if(isset($products[$i]['discount'])): ?>
                                <p>Descuento: <?= $products[$i]['discount'] ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <p><?= $products[$i]['stock'] ?></p>
                    </div>
                </a>
                <div>
                    <div>
                        <a href="index.php?section=panel&category=productEdit&id=<?= $products[$i]['id'] ?>">Editar producto</a>
                    </div>
                    <form action="./back/controller/product/delete.php" method="POST">
                        <input type="hidden" name="product" value="<?= $products[$i]['id'] ?>">
                        <input type="submit" value="Borrar producto">
                    </form>
                </div>
            </li>
        <?php endfor; ?>
    </ul>
</section>