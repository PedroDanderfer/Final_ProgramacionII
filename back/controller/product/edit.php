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
    $_SESSION['errors'] = ['Tenes que ser administrador para editar productos.'];

    return header('Location: ../../../index.php?section=home');
}

$data = array(
    "title" => (empty($_POST['title'])) ? null : $_POST['title'],
    "description" => (empty($_POST['description'])) ? null : $_POST['description'],
    "price" => (empty($_POST['price'])) ? null : $_POST['price'],
    "discount" => (empty($_POST['discount'])) ? null : $_POST['discount'],
    "stock" => (empty($_POST['stock'])) ? null : $_POST['stock'],
);

$rules = array(
    "title" => ["required", "maxlen:100"],
    "description" => ["maxlen:1000"],
    "price" => ["required", "numeric"],
    "discount" => ["numeric"],
    "stock" => ["numeric"],
);

$validated = validator($data, $rules);

if($validated !== true){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'editProduct';
    $_SESSION['type'] = 'validator';
    $_SESSION['errors'] = $validated;

    return header('Location: ../../../index.php?section=panel&category=productEdit&id='.$_POST['id']);
}

$data["title"] = mysqli_real_escape_string($cnx, $data["title"]);
$data["description"] = mysqli_real_escape_string($cnx, $data["description"]);
$data["price"] = mysqli_real_escape_string($cnx, $data["price"]);
$data["discount"] = mysqli_real_escape_string($cnx, $data["discount"]);
$data["stock"] = mysqli_real_escape_string($cnx, $data["stock"]);

$queryUniqueProduct = <<<SELECTPRODUCT
    SELECT * FROM products WHERE id = "$_POST[id]";
SELECTPRODUCT;

$rtaUniqueProduct = select($queryUniqueProduct);

if(count($rtaUniqueProduct) == 0){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'editProduct';
    $_SESSION['type'] = 'general';
    $_SESSION['errors']['title'] = ['No existe el producto'];

    return header('Location: ../../../index.php?section=panel&category=productEdit&id='.$_POST['id']);
}

$queryEditProduct = "UPDATE products SET ";
$updateData = false;
$countUpdate = 0;

if($data["title"] !== $rtaUniqueProduct[0]['title']){
    $updateData = true;
    $queryEditProduct = $queryEditProduct."title='$data[title]'";
    $countUpdate++;
}

if($data["description"] !== $rtaUniqueProduct[0]['description']){
    $updateData = true;
    if($countUpdate > 0){
        $queryEditProduct = $queryEditProduct.", description='$data[description]'";
    }else{
        $queryEditProduct = $queryEditProduct."description='$data[description]'";
    }
    $countUpdate++;
}

if($data["price"] !== $rtaUniqueProduct[0]['price']){
    $updateData = true;
    if($countUpdate > 0){
        $queryEditProduct = $queryEditProduct.", price='$data[price]'";
    }else{
        $queryEditProduct = $queryEditProduct."price='$data[price]'";
    }
    $countUpdate++;
}

if($data["discount"] !== $rtaUniqueProduct[0]['discount']){
    $updateData = true;
    if($countUpdate > 0){
        $queryEditProduct = $queryEditProduct.", discount='$data[discount]'";
    }else{
        $queryEditProduct = $queryEditProduct."discount='$data[discount]'";
    }
    $countUpdate++;
}

if($data["stock"] !== $rtaUniqueProduct[0]['stock']){
    $updateData = true;
    if($countUpdate > 0){
        $queryEditProduct = $queryEditProduct.", stock='$data[stock]'";
    }else{
        $queryEditProduct = $queryEditProduct."stock='$data[stock]'";
    }
    $countUpdate++;
}

$queryEditProduct = $queryEditProduct." WHERE id='$_POST[id]'";

if(!$updateData){
    return header('Location: ../../../index.php?section=panel&category=productEdit&id='.$_POST['id']);
}

$rtaEditProduct = mysqli_query($cnx, $queryEditProduct);

if(!$rtaEditProduct){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'editProduct';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ["Ocurrio un problema a la hora de editar el producto."];

    return header('Location: ../../../index.php?section=panel&category=productEdit&asd=wew');
}

$_SESSION['status'] = true;
$_SESSION['section'] = 'editProduct';

return header('Location: ../../../index.php?section=panel&category=productEdit&jeje=wew');
