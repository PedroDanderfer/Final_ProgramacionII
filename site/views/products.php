<?php 
    $products = [];
    $category = (empty($_GET['category'])) ? null : $_GET['category'];

    if(is_null($category)){
        $querySelectProducts = <<<SELECTPRODUCTS
        SELECT * FROM products
        SELECTPRODUCTS;
    }else{
        $querySelectCategory = <<<SELECTCATEGORY
        SELECT * FROM categories
        WHERE name='$category'
        SELECTCATEGORY;

        $rtaSelectCategory = select($querySelectCategory);

        if(empty($rtaSelectCategory)){
            return header('Location: ./index.php?section=products');
        }else{
            $querySelectProducts = <<<SELECTPRODUCTS
            SELECT products_has_categories.id AS category_id, products.id, products.title, products.price, products.discount
            FROM products_has_categories
            JOIN products ON products_has_categories.products_id=products.id AND products_has_categories.categories_id=
            SELECTPRODUCTS;

            $querySelectProducts = $querySelectProducts.$rtaSelectCategory[0]["id"]."";

            $rtaSelectProducts = select($querySelectProducts);
        }
    }

    $rtaSelectProducts = select($querySelectProducts);

    if(count($rtaSelectProducts) > 0){    
        $querySelectPhotos = <<<SELECTPHOTOS
        SELECT * FROM products_photos
        SELECTPHOTOS;

        $rtaSelectPhotos = select($querySelectPhotos);

        for ($i=0; $i < count($rtaSelectProducts); $i++) { 
            $products[$i]["id"] = $rtaSelectProducts[$i]["id"];
            $products[$i]["title"] = $rtaSelectProducts[$i]["title"];
            $products[$i]["price"] = $rtaSelectProducts[$i]["price"];
            $products[$i]["discount"] = $rtaSelectProducts[$i]["discount"];

            if(count($rtaSelectPhotos) > 0){
                for ($j=0; $j < count($rtaSelectPhotos); $j++) { 
                    if($rtaSelectPhotos[$j]["products_id"] == $rtaSelectProducts[$i]["id"]){
                        $products[$i]["images"][$j]["id"] = $rtaSelectPhotos[$j]["id"];
                        $products[$i]["images"][$j]["image"] = $rtaSelectPhotos[$j]["image"];
                        $products[$i]["images"][$j]["products_id"] = $rtaSelectPhotos[$j]["products_id"];
                    }
                }
            }
        }
    }else{
        $products = NULL;
    }
?>
<section id="products">
    <?php if(!is_null($products)): ?>
        <div>
            <h2>Productos<?= (!is_null($category)) ? ' - '.$category : '' ?></h2>
        </div>
        <ul>
            <?php for ($i=0; $i < count($products); $i++): ?>
                <li>
                    <a href="index.php?section=product&id=<?= $products[$i]["id"] ?>"]>
                        <div>
                            <h3><?= $products[$i]["title"] ?></h3>
                            <div>
                                <p>$<?= $products[$i]["price"] ?></p>
                                <?php if(isset($products[$i]["discount"]) && $products[$i]["discount"] > 0): ?>
                                    <p><?= $products[$i]["discount"] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    <?php else: ?>
        <div>
            <p>Sin productos</p>
        </div>
    <?php endif; ?>
</section>