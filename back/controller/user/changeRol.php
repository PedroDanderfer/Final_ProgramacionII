<?php
require("../../config/config.php");
require("../../config/arrays.php");
require("../../config/functions/validator.php");
require("../../config/functions/sql.php");

$data = array(
    "user" => (empty($_POST['user'])) ? null : $_POST['user']
);

$rules = array(
    "user" => ["required", "numeric"]
);

$validated = validator($data, $rules);

if($validated !== true){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'users';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Ops... Ocurrio un problema'];

    return header('Location: ../../../index.php?section=panel&category=users');
}

if($_SESSION['user']['id'] === $data['user']){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'users';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['No podes modificarte a vos mismo.'];

    return header('Location: ../../../index.php?section=panel&category=users');
}

$data["user"] = mysqli_real_escape_string($cnx, $data["user"]);

$querySelectUser = <<<SELECTUSER
    SELECT * FROM users WHERE id = "$data[user]";
SELECTUSER;

$rtaSelectUser = select($querySelectUser);

if(is_null($rtaSelectUser)){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'users';
    $_SESSION['type'] = 'general';
    $_SESSION['errors']['category'] = ['No se encontro al usuario.'];

    return header('Location: ../../../index.php?section=panel&category=users');
}

if($rtaSelectUser[0]['role'] == 'admin'){
    $queryChangeRoleUser = <<<CHANGEROLEUSER
        UPDATE users SET role = 'user' WHERE id = "$data[user]";
        CHANGEROLEUSER;
}else{
    $queryChangeRoleUser = <<<CHANGEROLEUSER
        UPDATE users SET role = 'admin' WHERE id = "$data[user]";
    CHANGEROLEUSER;
}

$rtaChangeRoleUser = mysqli_query($cnx, $queryChangeRoleUser);

if(!$rtaChangeRoleUser){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'users';
    $_SESSION['type'] = 'general';
    $_SESSION['errors']['category'] = ['Ops... Ocurrio un problema'];

    return header('Location: ../../../index.php?section=panel&category=users');
}

$_SESSION['status'] = true;
$_SESSION['section'] = 'users';

return header('Location: ../../../index.php?section=panel&category=users');
