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
    $_SESSION['errors'] = ['Tenes que ser administrador para subir fotos a los productos.'];

    return header('Location: ../../../index.php?section=home');
}

$data = array(
    "id" => (empty($_POST['id'])) ? null : $_POST['id'],
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
    "photos" => ["required", "type", "size"],
);

$validated = validator($data, $rules);

if($validated !== true){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'productEdit';
    $_SESSION['type'] = 'validator';
    $_SESSION['errors'] = $validated;

    return header('Location: ../../../index.php?section=panel&category=productEdit&id='.$data["id"]);
}

$data["id"] = mysqli_real_escape_string($cnx, $data["id"]);

$queryUniqueProduct = <<<SELECTPRODUCT
    SELECT * FROM products WHERE id = "$data[id]";
SELECTPRODUCT;

$rtaUniqueProduct = select($queryUniqueProduct);

if(count($rtaUniqueProduct) == 0){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'productEdit';
    $_SESSION['type'] = 'validator';
    $_SESSION['errors']['photos'] = ['El producto no existe.'];

    return header('Location: ../../../index.php?section=panel&category=productEdit&id='.$data["id"]);
}

$queryInsertPhotos = "INSERT INTO products_photos (image, products_id) VALUES ";

for ($i=0; $i < count($data["photos"]); $i++) { 
    $photoName = md5(time().$data["photos"][$i]["name"]);
    move_uploaded_file($data["photos"][$i]["tmp_name"], "../../../site/images/products/$photoName.jpg");
    if(count($data["photos"]) === 1){
        $queryInsertPhotos = $queryInsertPhotos."('$photoName', '$data[id]')";
    }else{
        if($i !== count($data["photos"])-1){
            $queryInsertPhotos = $queryInsertPhotos."('$photoName', '$data[id]'), ";
        }else{
            $queryInsertPhotos = $queryInsertPhotos."('$photoName', '$data[id]')";
        }
    }
}   

$rtaInsertPhotos = mysqli_query($cnx, $queryInsertPhotos);

if(!$rtaInsertPhotos){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'productEdit';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ["Ocurrio un problema a la hora de subir las fotos."];

    return header('Location: ../../../index.php?section=panel&category=productEdit&id='.$data["id"]);
}else{
    $_SESSION['status'] = true;
    $_SESSION['section'] = 'productEdit';

    return header('Location: ../../../index.php?section=panel&category=productEdit&id='.$data["id"]);
}

$_SESSION['status'] = true;
$_SESSION['section'] = 'productEdit';

return header('Location: ../../../index.php?section=panel&category=productEdit&id='.$data["id"]);