<?php
    if(isLogged()){
        $_SESSION['status'] = false;
        $_SESSION['section'] = 'home';
        $_SESSION['type'] = 'general';
        $_SESSION['errors'] = ['Ya estas logeado.'];

        return header('Location: index.php?section=home');
    }
?>
<section id="register">
    <div>
        <h2>Registrate</h2>
        <p>Rapido y sencillo</p>
    </div>
    <?php if (isset($_SESSION['status']) && isset($_SESSION['type']) && $_SESSION['status'] === false && $_SESSION['type'] === 'general' && $_SESSION['section'] === 'register' && isset($_SESSION['errors']) && $_SESSION['section'] === $_GET['section']): ?>
        <ul>
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form action="./back/controller/user/create.php" method="POST">
        <?php 
            require_once('./site/components/inputs/dniInput.php'); 
            require_once('./site/components/inputs/nameInput.php'); 
            require_once('./site/components/inputs/surnameInput.php'); 
            require_once('./site/components/inputs/emailInput.php'); 
            require_once('./site/components/inputs/passwordInput.php'); 
            require_once('./site/components/inputs/confirmPasswordInput.php'); 
        ?>
        <input type="submit" value="Registrarme">
        <a href="index.php?section=login">Ya tengo cuenta</a>
    </form>
</section>