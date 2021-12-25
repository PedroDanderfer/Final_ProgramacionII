<?php 
require("../../config/config.php");
require("../../config/arrays.php");
require("../../config/functions/validator.php");
require("../../config/functions/sql.php");
require("../../config/functions/session.php");

if(!isLogged()){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'login';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Debes estar logeado para agregar productos al carrito de compras.'];

    return header('Location: ../../../index.php?section=login');
}

$productId = (empty($_POST['product_id'])) ? null : $_POST['product_id'];
$quantity = (empty($_POST['quantity'])) ? null : $_POST['quantity'];
$title = (empty($_POST['title'])) ? null : $_POST['title'];
$stock = (empty($_POST['stock'])) ? null : $_POST['stock'];

$obj = array();
$obj["id"] = $productId;
$obj["quantity"] = $quantity;
$obj["title"] = $title;
$obj["stock"] = $stock;

$exist = false;

if(!isset($_SESSION["shoppingCart"])){
    $_SESSION["shoppingCart"] = array();
}

for ($i=0; $i < count($_SESSION["shoppingCart"]); $i++) { 
    if($_SESSION["shoppingCart"][$i]["id"] == $productId){
        $exist = true;
    }else{
        continue;
    }
}

if($exist){
    if(is_null($productId)){
        $_SESSION['status'] = false;
        $_SESSION['section'] = 'products';
        $_SESSION['type'] = 'general';
        $_SESSION['errors'] = ['El producto ya se encuentra en el carrito de compras.'];

        return header('Location: ../../../index.php?section=products');
    }else{
        $_SESSION['status'] = false;
        $_SESSION['section'] = 'product';
        $_SESSION['type'] = 'general';
        $_SESSION['errors'] = ['El producto ya se encuentra en el carrito de compras.'];

        return header('Location: ../../../index.php?section=product&id='.$productId);
    }
}

if(is_null($productId)){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'products';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['El producto es invalido.'];
    
    return header('Location: ../../../index.php?section=products');
}else{
    $_SESSION["shoppingCart"][] = $obj;
    
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'product';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Producto agregado al carrito de compras.'];
    return header('Location: ../../../index.php?section=product&id='.$productId);
}