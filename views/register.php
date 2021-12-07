<section>
    <div>
        <h2>Registrate</h2>
        <p>Rapido y sencillo</p>
    </div>
    <?php if ($_SESSION['status'] === false && $_SESSION['type'] === 'general' && $_SESSION['section'] === 'register' && isset($_SESSION['errors']) && $_SESSION['section'] === $_GET['section']): ?>
        <ul>
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form action="./controller/user/create.php" method="POST">
        <?php 
            require_once('./components/inputs/dniInput.php'); 
            require_once('./components/inputs/nameInput.php'); 
            require_once('./components/inputs/surnameInput.php'); 
            require_once('./components/inputs/emailInput.php'); 
            require_once('./components/inputs/passwordInput.php'); 
            require_once('./components/inputs/confirmPasswordInput.php'); 
        ?>
        <input type="submit" value="Registrarme">
    </form>
</section>