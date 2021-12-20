<?php
    $categories = [];

    $querySelectCategories = <<<SELECTPRODUCTS
    SELECT * FROM categories;
    SELECTPRODUCTS;

    $rtaSelectCategories = select($querySelectCategories);

    if(count($rtaSelectCategories) > 0){
        $categories = $rtaSelectCategories;
    }
?>
<?php if(count($categories) > 0): ?>
<div id="input">
    <label for="categories">Seleccioná categorías (CTRL + Click):</label>
    <select name="categories[]" id="categories" multiple>
        <?php for ($i=0; $i < count($categories); $i++): ?>
            <option value="<?= $categories[$i]["id"] ?>"><?= $categories[$i]["name"] ?></option>
        <?php endfor; ?>
    </select>
    <?php if (isset($_SESSION['status']) && $_SESSION['status'] === false && $_SESSION['type'] === 'validator' && isset($_SESSION['errors']['categories'])): ?>
        <ul>
            <?php foreach ($_SESSION['errors']['categories'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
<?php endif; ?>