<?php
    if(!isLoggedAdmin()){
        return header('Location: index.php?section=home');
    }

    $category = $_GET["category"] ?? "products";
    $titleCategory = [];
    $titleCategory['products'] = 'Productos';
    $titleCategory['productCreate'] = 'Crear producto';
    $titleCategory['productEdit'] = 'Editar producto';
    $titleCategory['users'] = 'Usuarios';
    $titleCategory['categories'] = 'Categorías';
?>
<section id="panel">
    <div>
        <div>   
            <h2>Panel - <?= $titleCategory[$category] ?></h2>
            <?php if($category === 'products'): ?>
                <a href="index.php?section=panel&category=productCreate">Crear producto</a>
            <?php endif; ?>
        </div>
        <nav>
            <ul>
                <li><a href="index.php?section=panel&category=products">Productos</a></li>
                <li><a href="index.php?section=panel&category=users">Usuarios</a></li>
                <li><a href="index.php?section=panel&category=categories">Categorias</a></li>
            </ul>
        </nav>
    </div>
    <?php if (isset($_SESSION['status']) && $_SESSION['status'] === false && $_SESSION['type'] === 'general' && $_SESSION['section'] === $_GET['category']): ?>
        <ul>
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php 
    if (in_array($category, $panelCategories) && $category !== 'panel'){
        require_once("./site/views/panel/$category.php");
    }else{
        require_once("./site/views/error.php");
    }
    ?>
</section>