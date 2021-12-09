<?php
require("../../config/config.php");
require("../../config/arrays.php");
require("../../config/functions/validator.php");
require("../../config/functions/sql.php");

$data = array(
    "dni" => (empty($_POST['dni'])) ? null : $_POST['dni'],
    "password" => (empty($_POST['password'])) ? null : $_POST['password']
);

$rules = array(
    "dni" => ["required", "maxlen:9", "minlen:7", "numeric"],
    "password" => ["required", "minlen:8", "regex:lowerCase", "regex:upperCase", "regex:oneNumber"]
);

$validated = validator($data, $rules);

if($validated !== true){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'login';
    $_SESSION['type'] = 'validator';
    $_SESSION['errors'] = $validated;

    return header('Location: ../../../index.php?section=login');
}

$data["dni"] = mysqli_real_escape_string($cnx, $data["dni"]);

$querySelectUser = <<<SELECTUSER
    SELECT * FROM users WHERE dni = "$data[dni]";
SELECTUSER;

$rtaSelectUser = select($querySelectUser);

if(is_null($rtaSelectUser)){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'login';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Los datos ingresados son invalidos.'];

    return header('Location: ../../../index.php?section=login');
}

if($rtaSelectUser[0]['banned'] === 1){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'login';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Estas betado, no podes entrar.'];

    return header('Location: ../../../index.php?section=login');
}

if (password_verify($data['password'], $rtaSelectUser[0]['password'])) {
    $_SESSION['status'] = true;
    $_SESSION['section'] = 'login';
    $_SESSION['user']['id'] = $rtaSelectUser[0]['id'];
    $_SESSION['user']['name'] = $rtaSelectUser[0]['name'];
    $_SESSION['user']['surname'] = $rtaSelectUser[0]['surname'];
    $_SESSION['user']['email'] = $rtaSelectUser[0]['email'];
    $_SESSION['user']['role'] = $rtaSelectUser[0]['role'];
    $_SESSION['user']['created_at'] = $rtaSelectUser[0]['created_at'];
    $_SESSION['user']['updated_at'] = $rtaSelectUser[0]['updated_at'];

    return header('Location: ../../../index.php?section=home');
} else {
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'login';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Los datos ingresados son invalidos'];

    return header('Location: ../../../index.php?section=login');
}