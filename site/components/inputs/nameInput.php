<div id="input">
    <div>
        <label for="name">Nombre</label>
        <input type="text" name="name" id="name" placeholder="Tu nombre completo">
    </div>
    <?php if (isset($_SESSION['status']) && $_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['name'])): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['name'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>