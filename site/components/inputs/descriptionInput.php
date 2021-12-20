<div id="input">
    <div>
        <label for="description">Descripción</label>
        <textarea name="description" id="description" <?php if(!isset($product["description"])): ?> placeholder="Descripción del producto" ><?php else: ?>><?= $product["description"] ?><?php endif; ?></textarea>
    </div>
    <?php if (isset($_SESSION['status']) && $_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['description'])): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['description'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>