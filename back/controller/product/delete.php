<?php
require("../../config/config.php");
require("../../config/arrays.php");
require("../../config/functions/validator.php");
require("../../config/functions/sql.php");

$data = array(
    "product" => (empty($_POST['product'])) ? null : $_POST['product']
);

$rules = array(
    "product" => ["required", "numeric"]
);

$validated = validator($data, $rules);

if($validated !== true){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'products';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Ops... Ocurrio un problema'];

    return header('Location: ../../../index.php?section=panel&category=products');
}

$data["product"] = mysqli_real_escape_string($cnx, $data["product"]);

$queryDeleteProduct = <<<SELECTPRODUCT
    DELETE FROM products WHERE id = "$data[product]";
SELECTPRODUCT;

$rtaDeleteProduct = mysqli_query($cnx, $queryDeleteProduct);

if(!$rtaDeleteProduct){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'products';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Ops... Ocurrio un problema'];

    return header('Location: ../../../index.php?section=panel&category=products');
}

$_SESSION['status'] = true;
$_SESSION['section'] = 'products';

return header('Location: ../../../index.php?section=panel&category=products');
