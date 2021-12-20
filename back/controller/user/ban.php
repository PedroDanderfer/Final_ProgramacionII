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
    $_SESSION['errors'] = ['No podes bloquearte a vos mismo.'];

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

if($rtaSelectUser[0]['banned'] == 1){
    $queryBanUser = <<<BANUSER
        UPDATE users SET banned = NULL WHERE id = "$data[user]";
    BANUSER;
}else{
    $queryBanUser = <<<BANUSER
        UPDATE users SET banned = 1 WHERE id = "$data[user]";
    BANUSER;
}

$rtaBanUser = mysqli_query($cnx, $queryBanUser);

if(!$rtaBanUser){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'users';
    $_SESSION['type'] = 'general';
    $_SESSION['errors']['category'] = ['Ops... Ocurrio un problema'];

    return header('Location: ../../../index.php?section=panel&category=users');
}

$_SESSION['status'] = true;
$_SESSION['section'] = 'users';

return header('Location: ../../../index.php?section=panel&category=users');
