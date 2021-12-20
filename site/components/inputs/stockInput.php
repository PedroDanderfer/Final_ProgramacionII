<div id="input">
    <div>
        <label for="stock">Stock</label>
        <input type="number" name="stock" id="stock" <?php if(!isset($product["stock"])): ?> placeholder="0" <?php else: ?> value="<?= $product['stock'] ?>" <?php endif; ?>/>
    </div>
    <?php if (isset($_SESSION['status']) && $_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['stock'])): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['stock'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>