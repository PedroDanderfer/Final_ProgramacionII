<div id="input">
    <div>
        <label for="photos">Fotos</label>
        <input type="file" name="photos[]" id="photos" multiple>
    </div>
    <?php if (isset($_SESSION['status']) && $_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['photos'])): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['photos'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>