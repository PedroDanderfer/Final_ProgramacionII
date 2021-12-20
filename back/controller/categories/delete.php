<?php
require("../../config/config.php");
require("../../config/arrays.php");
require("../../config/functions/validator.php");
require("../../config/functions/sql.php");

$data = array(
    "category" => (empty($_POST['category'])) ? null : $_POST['category']
);

$rules = array(
    "category" => ["required", "numeric"]
);

$validated = validator($data, $rules);

if($validated !== true){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'categories';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Ops... Ocurrio un problema'];

    return header('Location: ../../../index.php?section=panel&category=categories');
}

$data["category"] = mysqli_real_escape_string($cnx, $data["category"]);

$queryDeleteCategory = <<<SELECTCATEGORY
    DELETE FROM categories WHERE id = "$data[category]";
SELECTCATEGORY;

$rtaDeleteCategory = mysqli_query($cnx, $queryDeleteCategory);

if(!$rtaDeleteCategory){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'categories';
    $_SESSION['type'] = 'general';
    $_SESSION['errors']['category'] = ['Ops... Ocurrio un problema'];

    return header('Location: ../../../index.php?section=panel&category=categories');
}

$_SESSION['status'] = true;
$_SESSION['section'] = 'categories';

return header('Location: ../../../index.php?section=panel&category=categories');
