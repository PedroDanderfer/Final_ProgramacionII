<section>
    <div>
        <h2>Ingresa</h2>
    </div>
    <form action="./controller/session/login.php" method="POST">
        <?php 
            require_once('./components/inputs/dniInput.php'); 
            require_once('./components/inputs/passwordInput.php'); 
        ?>
        <input type="submit" value="Ingresar">
    </form>
</section>