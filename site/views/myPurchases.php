<?php
    if(!isLogged()){
        $_SESSION['status'] = false;
        $_SESSION['section'] = 'home';
        $_SESSION['type'] = 'general';
        $_SESSION['errors'] = ['Tenes que estar logeado.'];

        return header('Location: index.php?section=home');
    }

    $purchases = [];
    $userId = $_SESSION["user"]["id"];
    $querySelectPurchases = "SELECT * FROM purchases WHERE purchases.users_id=$userId";

    $rtaSelectPurchases = select($querySelectPurchases);    

    if(!empty($rtaSelectPurchases)){

        $purchases = $rtaSelectPurchases;

        $querySelectPurchasesHasProducts = "SELECT units, products_id, purchases_id FROM purchases_has_products WHERE purchases_id IN (";

        for ($i=0; $i < count($purchases); $i++) {
            if(count($purchases) == ($i+1)){
                $querySelectPurchasesHasProducts = $querySelectPurchasesHasProducts.$purchases[$i]["id"].')';
            }else{
                $querySelectPurchasesHasProducts = $querySelectPurchasesHasProducts.$purchases[$i]["id"].', ';   
            }
        }

        $rtaSelectPurchasesHasProducts = select($querySelectPurchasesHasProducts);  

        $querySelectProducts = "SELECT id, title, price, discount FROM products WHERE id IN (";

        for ($i=0; $i < count($rtaSelectPurchasesHasProducts); $i++){
            if(count($rtaSelectPurchasesHasProducts) == ($i+1)){
                $querySelectProducts = $querySelectProducts.$rtaSelectPurchasesHasProducts[$i]["products_id"].')';
            }else{
                $querySelectProducts = $querySelectProducts.$rtaSelectPurchasesHasProducts[$i]["products_id"].', ';   
            }
        }

        $rtaSelectProducts = select($querySelectProducts);  

        for ($i=0; $i < count($rtaSelectPurchasesHasProducts); $i++) { 
            for ($j=0; $j < count($purchases); $j++) { 
                if($rtaSelectPurchasesHasProducts[$i]["purchases_id"] == $purchases[$j]["id"]){
                    if(!isset($purchases[$j]["products"])){
                        $purchases[$j]["products"] = array();
                        $purchases[$j]["products"][] = array(
                            "id" => $rtaSelectPurchasesHasProducts[$i]["products_id"],
                            "units" => $rtaSelectPurchasesHasProducts[$i]["units"]
                        );
                    }else{
                        $purchases[$j]["products"][] = array(
                            "id" => $rtaSelectPurchasesHasProducts[$i]["products_id"],
                            "units" => $rtaSelectPurchasesHasProducts[$i]["units"]
                        );
                    }
                }
            }
        }

        for ($i=0; $i < count($rtaSelectProducts); $i++) { 
            for ($j=0; $j < count($purchases); $j++) { 
                for ($l=0; $l < count($purchases[$j]["products"]); $l++) { 
                    if($purchases[$j]["products"][$l]["id"] == $rtaSelectProducts[$i]["id"]){
                        $purchases[$j]["products"][$l]["title"] = $rtaSelectProducts[$i]["title"];
                        $purchases[$j]["products"][$l]["price"] = $rtaSelectProducts[$i]["price"];
                        $purchases[$j]["products"][$l]["discount"] = $rtaSelectProducts[$i]["discount"];
                    }
                }
            }
        }

        $querySelectPhotos = "SELECT image, products_id FROM products_photos WHERE products_id IN (";

        for ($i=0; $i < count($rtaSelectProducts); $i++) { 
            if(count($rtaSelectProducts) == ($i+1)){
                $querySelectPhotos = $querySelectPhotos.$rtaSelectProducts[$i]["id"].')';
            }else{
                $querySelectPhotos = $querySelectPhotos.$rtaSelectProducts[$i]["id"].', ';   
            }
        }
        
        $rtaSelectPhotos = select($querySelectPhotos);  

        if(!empty($rtaSelectPhotos)){
            for ($i=0; $i < count($rtaSelectPhotos); $i++) { 
                for ($j=0; $j < count($purchases); $j++) { 
                    for ($l=0; $l < count($purchases[$j]["products"]); $l++) { 
                        if($rtaSelectPhotos[$i]["products_id"] == $purchases[$j]["products"][$l]["id"]){
                            $purchases[$j]["products"][$l]["image"] = $rtaSelectPhotos[$i]["image"];
                        }
                    }
                }
            }
        }
    }

    $status = array(
        "pending" => "Pendiente"
    );
?>
<section id="myPurchases">
    <div>
        <h2>Mis compras</h2>
    </div>
    <?php if(empty($purchases)): ?>
        <p>Todavia no realizaste ninguna compra.</p>
        <a href="index.php?section=products">Ir a comprar</a>
    <?php else: ?>
        <ul>
            <?php for ($i=0; $i < count($purchases); $i++): ?>
                <li>
                    <div>
                        <p><?= $purchases[$i]["created_at"] ?></p>
                        <p><?= $status[$purchases[$i]["status"]] ?></p>
                    </div>
                    <ul>
                        <?php for ($j=0; $j < count($purchases[$i]["products"]); $j++): ?>
                            <li>
                                <img src="./site/images/products/<?= $purchases[$i]["products"][$j]["image"] ?>.jpg" alt="Imagen del producto <?= $purchases[$i]["products"][$j]["title"] ?>">
                                <div>
                                    <h3><?= $purchases[$i]["products"][$j]["title"] ?></h3>
                                    <div>
                                        <p><?= $purchases[$i]["products"][$j]["units"] ?> unidades.</p>
                                        <?php if($purchases[$i]["products"][$j]["discount"] != 0): ?>
                                            <p>$<?= $purchases[$i]["products"][$j]["discount"] ?></p>
                                        <?php else: ?>
                                            <p>$<?= $purchases[$i]["products"][$j]["price"] ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php endfor; ?>
                    </ul>
                    <div>
                        <p>Total: $<?= $purchases[$i]["total"] ?></p>
                    </div>
                </li>
            <?php endfor; ?>
        </ul>
    <?php endif; ?>
</section>