<?php 
$productId = (empty($_GET['id'])) ? null : $_GET['id'];
$product = [];
$querySelectProduct = 
    <<<SELECTPRODUCTS
    SELECT products_photos.id AS photos_id, products_photos.image, products.id, products.title, products.description, products.price, products.discount, products.stock, products.created_at, products.updated_at 
    FROM products_photos
    JOIN products
    ON products_photos.products_id=products.id AND products_photos.products_id=
    SELECTPRODUCTS;

$querySelectProduct = $querySelectProduct.$productId.";";

$rtaSelectProduct = select($querySelectProduct);

if(empty($rtaSelectProduct)){
    $querySelectProduct = 
    <<<SELECTPRODUCTS
    SELECT * 
    FROM products
    WHERE id=
    SELECTPRODUCTS;

    $querySelectProduct = $querySelectProduct.$productId.";";

    $rtaSelectProduct = select($querySelectProduct);

    if(empty($rtaSelectProduct)){
        return header('Location: ./index.php?section=products');
    }else{
        $product["id"] = $rtaSelectProduct[0]["id"];
        $product["title"] = $rtaSelectProduct[0]["title"];
        $product["description"] = $rtaSelectProduct[0]["description"];
        $product["price"] = $rtaSelectProduct[0]["price"];
        $product["discount"] = $rtaSelectProduct[0]["discount"];
        $product["stock"] = $rtaSelectProduct[0]["stock"];
        $product["created_at"] = $rtaSelectProduct[0]["created_at"];
        $product["updated_at"] = $rtaSelectProduct[0]["updated_at"];
    }
}else{
    $product["id"] = $rtaSelectProduct[0]["id"];
    $product["title"] = $rtaSelectProduct[0]["title"];
    $product["description"] = $rtaSelectProduct[0]["description"];
    $product["price"] = $rtaSelectProduct[0]["price"];
    $product["discount"] = $rtaSelectProduct[0]["discount"];
    $product["stock"] = $rtaSelectProduct[0]["stock"];
    $product["created_at"] = $rtaSelectProduct[0]["created_at"];
    $product["updated_at"] = $rtaSelectProduct[0]["updated_at"];

    for ($i=0; $i < count($rtaSelectProduct); $i++) { 
        $product["images"][$i]["id"] = $rtaSelectProduct[$i]["photos_id"];
        $product["images"][$i]["image"] = $rtaSelectProduct[$i]["image"];
    }
}

$querySelectCategories = 
<<<SELECTCATEGORIES
SELECT categories.id AS categories_id, categories.name, products_has_categories.products_id 
FROM categories
JOIN products_has_categories
ON categories.id=products_has_categories.categories_id AND products_has_categories.products_id=
SELECTCATEGORIES;

$querySelectCategories = $querySelectCategories.$productId.";";

$rtaSelectCategories = select($querySelectCategories);

if(!empty($rtaSelectCategories)){
    for ($i=0; $i < count($rtaSelectCategories); $i++) { 
        $product["categories"][$i]["id"] = $rtaSelectCategories[$i]["categories_id"];
        $product["categories"][$i]["name"] = $rtaSelectCategories[$i]["name"];
    }
}
?>
<section id="product">
    <div class="container">
        <div class="row">
            <?php if(isset($product["images"])): ?>
                <div class="col-sm">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="./site/images/products/<?= $product["images"][0]["image"] ?>.jpg" alt="First slide" />
                            </div>
                            <?php if(count($product["images"]) > 1): ?>
                                <?php for ($i=1; $i < count($product["images"]); $i++): ?>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="./site/images/products/<?= $product["images"][$i]["image"] ?>.jpg" alt="First slide" &>
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-sm">
                <div>
                    <h3><?= $product["title"] ?></h3>
                    <?php if(!empty($product["description"])): ?>
                        <p><?= $product["description"] ?></p>
                    <?php else: ?>
                        <p>El articulo no posee descripción.</p>
                    <?php endif; ?>
                    <?php if($product["stock"] > 0): ?>
                        <p>Stock: <?= $product["stock"] ?>.</p>
                    <?php else: ?>
                        <p>Sin stock.</p>
                    <?php endif; ?>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <p>$<?= $product["price"] ?>.</p>
                        </div>
                        <?php if($product["discount"] > 0): ?>
                            <div class="col-6">
                                <p>¡Precio final: $<?= $product["discount"] ?>!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if(isset($product["categories"])): ?>
                    <ul>
                        <?php for ($i=0; $i < count($product["categories"]); $i++): ?>
                            <li><a href="./index.php?section=products&category=<?= $product["categories"][$i]["name"] ?>"><?= $product["categories"][$i]["name"] ?></a></li>
                        <?php endfor; ?>
                    </ul>
                <?php endif; ?>
                <div>
                    <a href="#">Agregar al carrito</a>
                    <a href="#">Comprar ahora</a>
                </div>
            </div>
        </div>
    </div>
</section>