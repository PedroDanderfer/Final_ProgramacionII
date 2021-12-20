<?php
    if(isLogged()){
        return header('Location: index.php?section=home');
    }
?>
<section id="login">
    <div>
        <h2>Ingresa</h2>
    </div>
    <?php if (isset($_SESSION['status']) && isset($_SESSION['type']) && $_SESSION['status'] === false && $_SESSION['type'] === 'general' && $_SESSION['section'] === 'login' && isset($_SESSION['errors']) && $_SESSION['section'] === $_GET['section']): ?>
        <ul>
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form action="./back/controller/session/login.php" method="POST">
        <?php 
            require_once('./site/components/inputs/dniInput.php'); 
            require_once('./site/components/inputs/passwordInput.php'); 
        ?>
        <input type="submit" value="Ingresar">
        <a href="index.php?section=register">No tengo cuenta</a>
    </form>
</section>