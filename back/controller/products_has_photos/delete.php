<?php
require("../../config/config.php");
require("../../config/arrays.php");
require("../../config/functions/validator.php");
require("../../config/functions/sql.php");

$data = array(
    "product" => (empty($_GET['id'])) ? null : $_GET['product_id'],
    "photo" => (empty($_GET['id'])) ? null : $_GET['id']
); 

$data["photo"] = mysqli_real_escape_string($cnx, $data["photo"]);
$data["product"] = mysqli_real_escape_string($cnx, $data["product"]);

$querySelectPhoto = <<<SELECTPHOTOS
SELECT * FROM products_photos
WHERE id='$data[photo]' AND products_id='$data[product]';
SELECTPHOTOS;

$rtaSelectPhoto = select($querySelectPhoto);

if(count($rtaSelectPhoto) == 0){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'productEdit';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Ocurrio un problema con la foto.'];

    return header('Location: ../../../index.php?section=panel&category=productEdit&id='.$data["photo"]);
}

$queryDeletePhoto = <<<DELETEPHOTOS
    DELETE FROM products_photos WHERE id = "$data[photo]";
DELETEPHOTOS;

$rtaDeletePhoto = mysqli_query($cnx, $queryDeletePhoto);

if(!$rtaDeletePhoto){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'productEdit';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Ops... Ocurrio un problema'];

    return header('Location: ../../../index.php?section=panel&category=productEdit&id='.$data["photo"]);
}

unlink('../../../site/images/products/'.$rtaSelectPhoto[0]["image"].'.jpg');

$_SESSION['status'] = true;
$_SESSION['section'] = 'productEdit';

return header('Location: ../../../index.php?section=panel&category=productEdit&id='.$data["photo"]);
