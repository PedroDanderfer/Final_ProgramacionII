<?php
    if(!isLogged()){
        $_SESSION['status'] = false;
        $_SESSION['section'] = 'home';
        $_SESSION['type'] = 'general';
        $_SESSION['errors'] = ['Tenes que estar logeado.'];
    
        return header('Location: index.php?section=home');
    }

    $products = [];
    $total = 0;

    $querySelectProductsFromCart = "SELECT products.id, products.title, products.price, products.discount, products.stock FROM products WHERE id IN ("; 

    if(isset($_SESSION["shoppingCart"])){
        for ($i=0; $i < count($_SESSION["shoppingCart"]); $i++) { 
            if(count($_SESSION["shoppingCart"]) == ($i+1)){
                $querySelectProductsFromCart = $querySelectProductsFromCart.$_SESSION["shoppingCart"][$i]["id"].')';
            }else{
                $querySelectProductsFromCart = $querySelectProductsFromCart.$_SESSION["shoppingCart"][$i]["id"].', ';   
            }
        }

        $rtaSelectProductsFromCart = select($querySelectProductsFromCart);

        if(!empty($rtaSelectProductsFromCart)){
            $products = $rtaSelectProductsFromCart;

            $querySelectPhotosFromProducts = "SELECT * FROM products_photos WHERE products_id IN ("; 

            for ($i=0; $i < count($products); $i++) { 
                if(count($products) == ($i+1)){
                    $querySelectPhotosFromProducts = $querySelectPhotosFromProducts.$products[$i]["id"].');';
                }else{
                    $querySelectPhotosFromProducts = $querySelectPhotosFromProducts.$products[$i]["id"].', ';   
                }

                if($products[$i]["discount"] == 0){
                    $total = $total + $products[$i]["price"];
                }else{
                    $total = $total + $products[$i]["discount"];
                }
                for ($j=0; $j < count($_SESSION["shoppingCart"]); $j++) { 
                    if($products[$i]["id"] == $_SESSION["shoppingCart"][$j]["id"]){
                        $products[$i]["quantity"] = $_SESSION["shoppingCart"][$j]["quantity"];
                    }
                }
            }
        }

        $rtaSelectPhotosFromProducts = select($querySelectPhotosFromProducts);

        for ($i=0; $i < count($rtaSelectPhotosFromProducts); $i++) { 
            for ($j=0; $j < count($products); $j++) { 
                if($rtaSelectPhotosFromProducts[$i]["products_id"] == $products[$j]["id"]){
                    if(isset($products[$j]["image"]) && !empty($products[$j]["image"])){
                        continue;
                    }else{
                        $products[$j]["image"] = $rtaSelectPhotosFromProducts[$i]["image"];
                    }
                }else{
                    continue;
                }
            }
        }
    }else{
        return header('Location: index.php?section=products');
    }
?>
<section id="purchase">
    <h2>Carrito</h2>
    <?php if (isset($_SESSION['status']) && isset($_SESSION['type']) && $_SESSION['status'] === false && $_SESSION['type'] === 'general' && $_SESSION['section'] === 'purchase' && isset($_SESSION['errors']) && $_SESSION['section'] === $_GET['section']): ?>
        <ul>
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form action="./back/controller/purchases/create.php" method="post">
        <h3>Productos</h3>
        <ul>
            <?php for ($i=0; $i < count($products); $i++): ?>
                <li>
                    <input type="hidden" name="product_id<?= $i ?>" value="<?= $products[$i]["id"] ?>">
                    <img src="./site/images/products/<?= $products[$i]["image"] ?>.jpg" alt="Foto del producto '<?= $products[$i]["title"] ?>'">
                    <div>
                        <div>
                            <h4><?= $products[$i]["title"] ?></h4>
                            <a href="./back/controller/shoppingCart/remove.php?product_id=<?= $_SESSION["shoppingCart"][$i]["id"] ?>&section=<?= $section ?><?php if (!is_null($section_id)) echo '&section_id='.$section_id; ?>">Eliminar producto</a>
                        </div>
                        <div>
                            <div>
                                <input type="number" name="quantity<?= $i ?>" value="<?= $products[$i]["quantity"] ?>" min="1" max="<?= $products[$i]["stock"] ?>">
                                <p><?= $products[$i]["stock"] ?> disponibles</p>
                            </div>
                            <div>
                                <?php if($products[$i]["discount"] == 0): ?>
                                    <p>$<?= $products[$i]["price"] ?></p>
                                <?php else: ?>
                                    <p>¡Oferta: $<?= $products[$i]["discount"] ?>!</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endfor; ?>
        </ul>
        <div>
            <h3>Metodo de pago</h3>
            <div>
                <label for="paymentFiat">Efectivo</label>
                <input type="radio" name="payment" id="paymentFiat" value="fiat" checked>
            </div>
        </div>
        <div>
            <p>Total: <?= $total ?></p>
            <input type="submit" value="Comprar">
        </div>
    </form>
</section>