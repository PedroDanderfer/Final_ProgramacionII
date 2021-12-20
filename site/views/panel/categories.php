<?php 
    if(!isLoggedAdmin()){
        return header('Location: index.php?section=home');
    }
    
    $categories = [];

    $querySelectCategories = <<<SELECTCATEGORIES
    SELECT * FROM categories;
    SELECTCATEGORIES;

    $rtaSelectCategories = select($querySelectCategories);

    if(count($rtaSelectCategories) > 0){
        $categories = $rtaSelectCategories;
    }
?>
<section id="categories">
    <form action="./back/controller/categories/create.php" method="POST">
        <?php require_once("./site/components/inputs/category.php"); ?>
        <input type="submit" value="Crear categoría">
    </form>
    <ul>
        <?php for ($i=0; $i < count($categories); $i++): ?>
            <li>
                <p><?= $categories[$i]['name'] ?></p>
                <form action="./back/controller/categories/delete.php" method="post">
                    <input type="hidden" name="category" value="<?= $categories[$i]['id'] ?>">
                    <input type="submit" value="Borrar categoría">
                </form>
            </li>
        <?php endfor; ?>
    </ul>
</section>