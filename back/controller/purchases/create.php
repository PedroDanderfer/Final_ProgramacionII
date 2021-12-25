<?php 
require("../../config/config.php");
require("../../config/functions/sql.php");
require("../../config/functions/session.php");

if(!isLogged()){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'login';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Debes estar logeado para realizar una compra.'];

    return header('Location: ../../../index.php?section=login');
}

$payment = (!isset($_POST['payment'])) ? null : $_POST['payment'];

$count = (count($_POST) - 1) / 2;

$products = [];
$productsFromDB = [];
$total = 0;
$user_id = $_SESSION["user"]["id"];

for ($i=0; $i < $count; $i++) { 
    $products[$i]["id"] = $_POST["product_id".$i];
    $products[$i]["quantity"] = $_POST["quantity".$i];
}

if(empty($products)){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'purchase';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['No seleccionaste ningun producto.'];

    return header('Location: ../../../index.php?section=purchase');
}

$querySelectProductsFromCart = "SELECT products.id, products.price, products.discount, products.stock FROM products WHERE id IN ("; 

for ($i=0; $i < count($products); $i++) { 
    if(count($products) == ($i+1)){
        $querySelectProductsFromCart = $querySelectProductsFromCart.$products[$i]["id"].')';
    }else{
        $querySelectProductsFromCart = $querySelectProductsFromCart.$products[$i]["id"].', ';   
    }
}

$rtaSelectProductsFromCart = select($querySelectProductsFromCart);

if(!empty($rtaSelectProductsFromCart)){
    $productsFromDB = $rtaSelectProductsFromCart;
}else{
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'purchase';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Los productos ingresados son invalidos.'];

    return header('Location: ../../../index.php?section=purchase');
}

for ($i=0; $i < count($productsFromDB); $i++) { 
    if($productsFromDB[$i]["discount"] != 0){
        $total = $total + $productsFromDB[$i]["discount"];
    }else{
        $total = $total + $productsFromDB[$i]["price"];
    }
}

for ($i=0; $i < count($productsFromDB); $i++) { 
    for ($j=0; $j < count($products); $j++) { 
        if($productsFromDB[$i]["id"] == $products[$j]["id"]){
            $productsFromDB[$i]["quantity"] = $products[$j]["quantity"];
        }else{
            continue;
        }
    }
}

$queryInsertPurchases = "INSERT INTO purchases (total, status, payment, users_id) VALUES ($total, 'pending', '$payment', $user_id)";

$rtaInsertPurchases = mysqli_query($cnx, $queryInsertPurchases);

$purchaseId = mysqli_insert_id($cnx);

if(!$rtaInsertPurchases){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'purchase';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ["Ocurrio un problema a la hora de generar la compra."];

    return header('Location: ../../../index.php?section=purchase');
}

$queryInsertPurchasesHasProducts = "INSERT INTO purchases_has_products (units, products_id, purchases_id) VALUES ";

for ($i=0; $i < count($productsFromDB); $i++) { 
    if(count($productsFromDB) == ($i+1)){
        $queryInsertPurchasesHasProducts = $queryInsertPurchasesHasProducts.'('.$productsFromDB[$i]["quantity"].', '.$productsFromDB[$i]["id"].', '.$purchaseId.')';
    }else{
        $queryInsertPurchasesHasProducts = $queryInsertPurchasesHasProducts.'('.$productsFromDB[$i]["quantity"].', '.$productsFromDB[$i]["id"].', '.$purchaseId.'), ';   
    }
}

$rtaInsertPurchasesHasProducts = mysqli_query($cnx, $queryInsertPurchasesHasProducts);

if(!$rtaInsertPurchasesHasProducts){
    $queryDeletePurchase = "DELETE FROM purchases WHERE id=$purchaseId";
    mysqli_query($cnx, $queryDeletePurchase);

    $_SESSION['status'] = false;
    $_SESSION['section'] = 'purchase';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ["Ocurrio un problema a la hora de generar la compra."];

    return header('Location: ../../../index.php?section=purchase');
}

$queryUpdateProductsStock = "UPDATE products SET stock = (case ";

for ($i=0; $i < count($products); $i++) { 
    if(count($products) == ($i+1)){
        $queryUpdateProductsStock = $queryUpdateProductsStock.' when id = '.$products[$i]["id"].' then stock - '.$products[$i]["quantity"].' end)';
    }else{
        $queryUpdateProductsStock = $queryUpdateProductsStock.' when id = '.$products[$i]["id"].' then stock - '.$products[$i]["quantity"];   
    }
}

$queryUpdateProductsStock = $queryUpdateProductsStock.' WHERE id in (';

for ($i=0; $i < count($products); $i++) { 
    if(count($products) == ($i+1)){
        $queryUpdateProductsStock = $queryUpdateProductsStock.$products[$i]["id"].')';
    }else{
        $queryUpdateProductsStock = $queryUpdateProductsStock.$products[$i]["id"].', ';   
    }
}

$rtaUpdateProductsStock = mysqli_query($cnx, $queryUpdateProductsStock);

$_SESSION['status'] = true;
$_SESSION['section'] = 'purchase';
$_SESSION['shoppingCart'] = array();

return header('Location: ../../../index.php?section=purchaseFinished');