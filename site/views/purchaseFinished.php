<?php
if(!isLogged()){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'home';
    $_SESSION['type'] = 'general';
    $_SESSION['errors'] = ['Tenes que estar logeado.'];

    return header('Location: index.php?section=home');
}
?>
<section id="purchaseFinished">
    <div>
        <h2>Gracias por tu compra <?= $_SESSION["user"]["name"].' '.$_SESSION["user"]["surname"]?></h2>
        <a href="index.php?section=myPurchases">Ver mis compras</a>
    </div>
</section>