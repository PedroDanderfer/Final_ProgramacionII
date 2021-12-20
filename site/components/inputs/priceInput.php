<div id="input">
    <div>
        <label for="price">Precio</label>
        <input type="number" name="price" id="price" <?php if(!isset($product["price"])): ?> placeholder="0" <?php else: ?> value="<?= $product['price'] ?>" <?php endif; ?> step="any" />
    </div>
    <?php if (isset($_SESSION['status']) && $_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['price'])): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['price'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>