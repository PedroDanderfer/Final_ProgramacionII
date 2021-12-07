<div>
    <div>
        <label for="confirmPassword">Confirmar contraseña</label>
        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirma tu contraseña secreta">
    </div>
    <?php if ($_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['confirmPassword'])): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['confirmPassword'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>