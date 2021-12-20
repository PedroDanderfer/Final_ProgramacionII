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

    for ($i=0; $i < count($rtaSelectProduct); $i++) { 
        $product["images"][$i]["id"] = $rtaSelectProduct[$i]["photos_id"];
        $product["images"][$i]["image"] = $rtaSelectProduct[$i]["image"];
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
}

print_r($product);
?>
<section id="product">
    <p>Product</p>
</section>