<div>
    <div>
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Escribí tu contraseña secreta">
    </div>
    <?php if ($_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['password']) && $_SESSION['section'] === $_GET['section']): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['password'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>