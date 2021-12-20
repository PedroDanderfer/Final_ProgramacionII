<?php if(isset($product["images"]) && !empty($product["images"])): ?>
    <div id="input" class="editPhotosInput">
        <div>
            <ul>
                <?php for ($i=0; $i < count($product["images"]); $i++): ?>
                    <li>
                        <img src="./site/images/products/<?= $product["images"][$i]["image"] ?>.jpg" alt="Foto n° <?= ($i+1) ?> del producto <?= $product["title"] ?>">
                        <a href="./back/controller/products_has_photos/delete.php?id=<?= $product["images"][$i]["id"] ?>&product_id=<?= $product["id"] ?>">Borrar imagen</a>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>