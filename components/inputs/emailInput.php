<div>
    <div>
        <label for="email">Correo electronico</label>
        <input type="email" name="email" id="email" placeholder="Aquí va tu correo electronico">
    </div>
    <?php if ($_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['email']) ): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['email'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>