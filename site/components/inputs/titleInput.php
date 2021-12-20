<div id="input">
    <div>
        <label for="title">Titulo</label>
        <input type="text" name="title" id="title" <?php if(!isset($product["title"])): ?> placeholder="Titulo del producto" <?php else: ?> value="<?= $product['title'] ?>" <?php endif; ?>>
    </div>
    <?php if (isset($_SESSION['status']) && $_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['title'])): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['title'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>