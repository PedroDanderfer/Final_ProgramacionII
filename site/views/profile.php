<?php 

if(!isLogged()){
    return header('Location: index.php?section=home');
}

$user = [];
$querySelectUser = 
    <<<SELECTUSER
    SELECT users.dni, users.name, users.surname, users.email, users.role, users.created_at
    FROM users
    WHERE users.id=
    SELECTUSER;

$querySelectUser = $querySelectUser.$_SESSION["user"]["id"].";";

$user = select($querySelectUser);

?>

<section id="login">
    <div>
        <h3>Mi perfil</h3>
    </div>
    <div>
        <ul>
            <li><?= $user[0]["name"].' '.$user[0]["surname"] ?></li>
            <li><?= $user[0]["dni"] ?></li>
            <li><?= $user[0]["email"] ?></li>
            <?php if($user[0]["role"] == 'user'): ?>
                <li>Usuario</li>
            <?php else: ?>
                <li>Administrador</li>
            <?php endif; ?>
            <li>Te uniste el: <?= $user[0]["created_at"] ?></li>
        </ul>
    </div>
</section>