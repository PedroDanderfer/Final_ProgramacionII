<div id="input">
    <div>
        <label for="name">Categoría</label>
        <input type="text" name="category" id="category" placeholder="Nombre de la categoría">
    </div>
    <?php if (isset($_SESSION['status']) && $_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['category'])): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['category'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>