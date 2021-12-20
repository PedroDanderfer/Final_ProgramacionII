<div id="input">
    <div>
        <label for="discount">Precio con descuento</label>
        <input type="number" name="discount" id="discount" <?php if(!isset($product["discount"])): ?> placeholder="0" <?php else: ?> value="<?= $product['discount'] ?>" <?php endif; ?> step="any" />
    </div>
    <?php if (isset($_SESSION['status']) && $_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['discount'])): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['discount'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>