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
    $_SESSION['errors'] = ['Tenes que ser administrador para crear categorías.'];

    return header('Location: ../../../index.php?section=home');
}

$data = array(
    "category" => (empty($_POST['category'])) ? null : $_POST['category']
);

$rules = array(
    "category" => ["required", "maxlen:30"]
);

$validated = validator($data, $rules);

if($validated !== true){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'categories';
    $_SESSION['type'] = 'validator';
    $_SESSION['errors'] = $validated;

    return header('Location: ../../../index.php?section=panel&category=categories');
}

$data["category"] = mysqli_real_escape_string($cnx, $data["category"]);

$queryUniqueCategory = <<<SELECTCATEGORY
    SELECT * FROM categories WHERE name = "$data[category]";
SELECTCATEGORY;

$rtaUniqueCategory = select($queryUniqueCategory);

if(count($rtaUniqueCategory) > 0){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'categories';
    $_SESSION['type'] = 'validator';
    $_SESSION['errors']['category'] = ['Ya existe una categoría con este nombre'];

    return header('Location: ../../../index.php?section=panel&category=categories');
}

$queryInsertCategory = <<<INSERTCATEGORY
    INSERT INTO categories (name) 
    VALUES ("$data[category]");
INSERTCATEGORY;

$rtaInsertCategory = mysqli_query($cnx, $queryInsertCategory);

if(!$rtaInsertCategory){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'categories';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ["Ocurrio un problema a la hora de crear la categoría."];

    return header('Location: ../../../index.php?section=panel&category=categories');
}

$_SESSION['status'] = true;
$_SESSION['section'] = 'categories';

return header('Location: ../../../index.php?section=panel&category=categories');
