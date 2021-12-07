<div>
    <div>
        <label for="surname">Apellido</label>
        <input type="text" name="surname" id="surname" placeholder="Tu apellido completo">
    </div>
    <?php if ($_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['surname'])): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['surname'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>