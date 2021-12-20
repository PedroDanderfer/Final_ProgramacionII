<?php 
    if(!isLoggedAdmin()){
        return header('Location: index.php?section=home');
    }

    $product = [];

    $querySelectProduct = <<<SELECTPRODUCTS
    SELECT * FROM products
    WHERE id='$_GET[id]';
    SELECTPRODUCTS;

    $rtaSelectProduct = select($querySelectProduct);

    if(count($rtaSelectProduct) > 0){
        $product["id"] = $rtaSelectProduct[0]["id"];
        $product["title"] = $rtaSelectProduct[0]["title"];
        $product["description"] = $rtaSelectProduct[0]["description"];
        $product["price"] = $rtaSelectProduct[0]["price"];
        $product["discount"] = $rtaSelectProduct[0]["discount"];
        $product["stock"] = $rtaSelectProduct[0]["stock"];

        $querySelectPhotos = <<<SELECTPHOTOS
        SELECT * FROM products_photos
        WHERE products_id='$product[id]';
        SELECTPHOTOS;
    
        $rtaSelectPhotos = select($querySelectPhotos);
    
        if(count($rtaSelectPhotos) > 0){
            for ($i=0; $i < count($rtaSelectPhotos); $i++) { 
                $product["images"][$i]["id"] = $rtaSelectPhotos[$i]["id"];
                $product["images"][$i]["image"] = $rtaSelectPhotos[$i]["image"];
            }
        }

    }else{
        return header('Location: index.php?section=panel&category=products');
    }
?>
<section id="productEdit">
    <form action="./back/controller/products_has_photos/create.php" method="POST" enctype="multipart/form-data">
        <?php
            require_once('./site/components/inputs/photoInput.php'); 
        ?>
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <input type="submit" value="Subir foto">
    </form>
    <form action="./back/controller/product/edit.php" method="POST">
        <?php
            require_once('./site/components/inputs/editPhotos.php'); 
            require_once('./site/components/inputs/titleInput.php'); 
            require_once('./site/components/inputs/descriptionInput.php'); 
        ?>
        <div>
        <?php
            require_once('./site/components/inputs/priceInput.php'); 
            require_once('./site/components/inputs/discountInput.php'); 
        ?>
        </div>
        <?php
            require_once('./site/components/inputs/stockInput.php'); 
        ?>
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <input type="submit" value="Editar producto">
    </form>
</section>