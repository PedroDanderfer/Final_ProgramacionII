<?php

require("../../config/config.php");
require("../../config/arrays.php");
require("../../config/functions/validator.php");
require("../../config/functions/sql.php");
require("../../config/functions/session.php");

$data = array(
    "dni" => (empty($_POST['dni'])) ? null : $_POST['dni'],
    "name" => (empty($_POST['name'])) ? null : $_POST['name'],
    "surname" => (empty($_POST['surname'])) ? null : $_POST['surname'],
    "email" => (empty($_POST['email'])) ? null : $_POST['email'],
    "password" => (empty($_POST['password'])) ? null : $_POST['password'],
    "confirmPassword" => (empty($_POST['confirmPassword'])) ? null : $_POST['confirmPassword'],
);

$rules = array(
    "dni" => ["required", "maxlen:9", "minlen:7", "numeric"],
    "name" => ["required", "maxlen:100", "minlen:2", "alphabetic"],
    "surname" => ["required", "maxlen:100", "minlen:2", "alphabetic"],
    "email" => ["required", "maxlen:100", "email"],
    "password" => ["required", "minlen:8", "regex:lowerCase", "regex:upperCase", "regex:oneNumber"],
    "confirmPassword" => ["required", "compare:password"],
);

$validated = validator($data, $rules);

if($validated !== true){
    session(array(
        "status" => false,
        "section" => 'register',
        "type" => 'validator',
        "errors" => $validated,
    ));

    return header('Location: ../../index.php?section=register');
}

$data["dni"] = mysqli_real_escape_string($cnx, $data["dni"]);
$data["name"] = mysqli_real_escape_string($cnx, $data["name"]);
$data["surname"] = mysqli_real_escape_string($cnx, $data["surname"]);
$data["email"] = mysqli_real_escape_string($cnx, $data["email"]);
$data["password"] = mysqli_real_escape_string($cnx, password_hash($data['password'], PASSWORD_DEFAULT));

$queryUniqueDniAndEmail = <<<SELECTUSER
    SELECT * FROM users WHERE email = "$data[email]" OR dni = "$data[dni]";
SELECTUSER;

$rtaUniqueDniAndEmail = select($queryUniqueDniAndEmail);

if(count($rtaUniqueDniAndEmail) > 0){
    $errors = [];
    $dniExists = false;
    $emailExists = false;
    
    for ($i=0; $i < count($rta); $i++) { 
        if($rta[$i]['dni'] === $data['dni']){
            $dniExists = true;
        }
        if($rta[$i]['email'] === $data['email']){
            $emailExists = true;
        }
    }

    if($dniExists){
        $errors['dni'] = ['El documento ya se encuentra en uso.']; 
    }
    if($emailExists){
        $errors['email'] = ['El correo electronico ya se encuentra en uso.'];
    }

    session(array(
        "status" => false,
        "section" => 'register',
        "type" => 'validator',
        "errors" => $errors,
    ));

    return header('Location: ../../index.php?section=register');
}

$queryInsertUser = <<<INSERTUSER
    INSERT INTO users (dni, name, surname, email, password) 
    VALUES ("$data[dni]","$data[name]","$data[surname]","$data[email]","$data[password]");
INSERTUSER;

$rtaInsertUser = mysqli_query($cnx, $queryInsertUser);

if(!$rtaInsertUser){
    session(array(
        "status" => false,
        "section" => 'register',
        "type" => 'general',
        "errors" => ["Ocurrio un problema a la hora de crear el usuario."],
    ));
}

session(array(
    "status" => true,
    "section" => 'register',
));

return header('Location: ../../index.php?section=login');



