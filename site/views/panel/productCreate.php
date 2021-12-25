<?php 
    if(!isLoggedAdmin()){
        $_SESSION['status'] = false;
        $_SESSION['section'] = 'home';
        $_SESSION['type'] = 'general';
        $_SESSION['errors'] = ['Tenes que estar logeado y ser administrador.'];
    
        return header('Location: index.php?section=home');
    }
?>
<section id="productCreate">
    <form action="./back/controller/product/create.php" method="POST" enctype="multipart/form-data">
        <?php
            require_once('./site/components/inputs/photoInput.php');
            require_once('./site/components/inputs/titleInput.php'); 
            require_once('./site/components/inputs/descriptionInput.php'); 
        ?>
        <div>
        <?php
            require_once('./site/components/inputs/priceInput.php'); 
            require_once('./site/components/inputs/discountInput.php'); 
        ?>
        </div>
        <?php
            require_once('./site/components/inputs/stockInput.php'); 
            require_once('./site/components/inputs/categoriesInput.php'); 
        ?>
        <input type="submit" value="Crear producto">
    </form>
</section>