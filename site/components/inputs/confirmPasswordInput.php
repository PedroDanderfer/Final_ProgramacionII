<div id="input">
    <div>
        <label for="confirmPassword">Confirmar contraseña</label>
        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirma tu contraseña secreta">
    </div>
    <?php if (isset($_SESSION['status']) && isset($_SESSION['type']) && $_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['confirmPassword'])): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['confirmPassword'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>