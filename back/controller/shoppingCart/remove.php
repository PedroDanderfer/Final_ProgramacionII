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
    $_SESSION['errors'] = ['Debes estar logeado para eliminar productos del carrito de compras.'];

    return header('Location: ../../../index.php?section=login');
}

$product_id = (empty($_GET['product_id'])) ? null : $_GET['product_id'];
$section = (empty($_GET['section'])) ? 'home' : $_GET['section'];
$section_id = (empty($_GET['section_id'])) ? null : $_GET['section_id'];

if(is_null($product_id)){
    if(is_null($section_id)){
        $_SESSION['status'] = false;
        $_SESSION['section'] = $section;
        $_SESSION['type'] = 'general';
        $_SESSION['errors'] = ['El producto es invalido.'];

        return header('Location: ../../../index.php?section='.$section);
    }else{
        $_SESSION['status'] = false;
        $_SESSION['section'] = $section;
        $_SESSION['type'] = 'general';
        $_SESSION['errors'] = ['El producto es invalido.'];

        return header('Location: ../../../index.php?section='.$section.'&id='.$section_id);
    }
}

$idFromProduct = NULL;

for ($i=0; $i < count($_SESSION["shoppingCart"]); $i++) { 
    if($_SESSION["shoppingCart"][$i]["id"] == $product_id){
        $idFromProduct = $i;
    }else{
        continue;
    }
}

if(!is_null($idFromProduct)){
    array_splice($_SESSION["shoppingCart"], $idFromProduct, 1);
}

if(is_null($section_id)){
    return header('Location: ../../../index.php?section='.$section);
}else{
    return header('Location: ../../../index.php?section='.$section.'&id='.$section_id);
}