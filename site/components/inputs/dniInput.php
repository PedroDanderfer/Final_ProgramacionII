<div id="input">
    <div>
        <label for="dni">Documento</label>
        <input type="text" name="dni" id="dni" placeholder="Ingresá aquí tu dni">
    </div>
    <?php if (isset($_SESSION['status']) && isset($_SESSION['type']) && $_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['dni']) && $_SESSION['section'] === $_GET['section']): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['dni'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>