<?php
require("../../config/config.php");
require("../../config/arrays.php");
require("../../config/functions/validator.php");
require("../../config/functions/sql.php");
require("../../config/functions/session.php");

if(!isLoggedAdmin()){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'home';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Tenes que ser administrador para crear productos.'];

    return header('Location: ../../../index.php?section=home');
}

$data = array(
    "title" => (empty($_POST['title'])) ? null : $_POST['title'],
    "description" => (empty($_POST['description'])) ? null : $_POST['description'],
    "price" => (empty($_POST['price'])) ? null : $_POST['price'],
    "discount" => (empty($_POST['discount'])) ? null : $_POST['discount'],
    "stock" => (empty($_POST['stock'])) ? null : $_POST['stock'],
    "categories" => (empty($_POST['categories'])) ? null : $_POST['categories'],
);

if(!empty($_FILES['photos']["name"][0])){
    $photos = [];

    for ($i=0; $i < count($_FILES["photos"]["name"]); $i++) { 
        $photos[$i]["name"] = $_FILES["photos"]["name"][$i];
        $photos[$i]["type"] = $_FILES["photos"]["type"][$i];
        $photos[$i]["tmp_name"] = $_FILES["photos"]["tmp_name"][$i];
        $photos[$i]["size"] = $_FILES["photos"]["size"][$i];
    }
    
    $data["photos"] = $photos;
}else{
    $data["photos"] = null;
}

$rules = array(
    "photos" => ["type"],
    "title" => ["required", "maxlen:100"],
    "description" => ["maxlen:1000"],
    "price" => ["required", "numeric"],
    "discount" => ["numeric"],
    "stock" => ["numeric"],
    "categories" => ["exists:categories"]
);

$validated = validator($data, $rules);

if($validated !== true){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'productCreate';
    $_SESSION['type'] = 'validator';
    $_SESSION['errors'] = $validated;

    return header('Location: ../../../index.php?section=panel&category=productCreate');
}

$data["title"] = mysqli_real_escape_string($cnx, $data["title"]);
$data["description"] = mysqli_real_escape_string($cnx, $data["description"]);
$data["price"] = mysqli_real_escape_string($cnx, $data["price"]);
$data["discount"] = mysqli_real_escape_string($cnx, $data["discount"]);
$data["stock"] = mysqli_real_escape_string($cnx, $data["stock"]);

$queryUniqueProduct = <<<SELECTPRODUCT
    SELECT * FROM products WHERE title = "$data[title]";
SELECTPRODUCT;

$rtaUniqueProduct = select($queryUniqueProduct);

if(count($rtaUniqueProduct) > 0){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'productCreate';
    $_SESSION['type'] = 'validator';
    $_SESSION['errors']['title'] = ['Ya existe un producto con este titulo'];

    return header('Location: ../../../index.php?section=panel&category=productCreate');
}

$queryInsertProduct = <<<INSERTPRODUCT
    INSERT INTO products (title,description,price,discount,stock) 
    VALUES ("$data[title]","$data[description]","$data[price]","$data[discount]","$data[stock]");
INSERTPRODUCT;

$rtaInsertProduct = mysqli_query($cnx, $queryInsertProduct);

if(!$rtaInsertProduct){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'productCreate';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ["Ocurrio un problema a la hora de crear el producto."];

    return header('Location: ../../../index.php?section=panel&category=productCreate');
}

$productId = mysqli_insert_id($cnx);

if(!is_null($data["photos"])){
    $queryInsertPhotos = "INSERT INTO products_photos (image, products_id) VALUES ";

    for ($i=0; $i < count($data["photos"]); $i++) { 
        $photoName = md5(time().$data["photos"][$i]["name"]);
        move_uploaded_file($data["photos"][$i]["tmp_name"], "../../../site/images/products/$photoName.jpg");
        if(count($data["photos"]) === 1){
            $queryInsertPhotos = $queryInsertPhotos."('$photoName', '$productId')";
        }else{
            if($i !== count($data["photos"])-1){
                $queryInsertPhotos = $queryInsertPhotos."('$photoName', '$productId'), ";
            }else{
                $queryInsertPhotos = $queryInsertPhotos."('$photoName', '$productId')";
            }
        }
    }

    $rtaInsertPhotos = mysqli_query($cnx, $queryInsertPhotos);

    if(!$rtaInsertPhotos){
        $_SESSION['status'] = false;
        $_SESSION['section'] = 'productCreate';
        $_SESSION['type'] = 'general';
        $_SESSION['errors'] = ["Ocurrio un problema a la hora de subir las fotos."];

        return header('Location: ../../../index.php?section=panel&category=productCreate');
    }
}

if(!is_null($data["categories"])){
    $queryInsertCategories = "INSERT INTO products_has_categories (products_id, categories_id) VALUES ";

    if(count($data["categories"]) > 0){
        for ($i=0; $i < count($data["categories"]); $i++) { 
            if($i == count($data["categories"])-1){
                $queryInsertCategories = $queryInsertCategories."(".$productId.", ".$data["categories"][$i].");";
            }else{
                $queryInsertCategories = $queryInsertCategories."(".$productId.", ".$data["categories"][$i]."), ";
            }
        }
    }else{
        $queryInsertCategories = $queryInsertCategories."(".$productId.", ".$data["categories"][$i].");";
    }

    $rtaInsertCategories = mysqli_query($cnx, $queryInsertCategories);

    if(!$rtaInsertCategories){
        $_SESSION['status'] = false;
        $_SESSION['section'] = 'productCreate';
        $_SESSION['type'] = 'general';
        $_SESSION['errors'] = ["Ocurrio un problema a la hora de guardar las categorías."];

        return header('Location: ../../../index.php?section=panel&category=productCreate');
    }
}

$_SESSION['status'] = true;
$_SESSION['section'] = 'productCreate';

return header('Location: ../../../index.php?section=panel&category=products');