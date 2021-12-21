<?php

function addToCart(){
    if(!isset($_SESSION['shoppingCart'])){
        $_SESSION['shoppingCart'] = ['shopping'];
        print_r($_SESSION["shoppingCart"]);
    }else{
        print_r($_SESSION["shoppingCart"]);
    }
} 

addToCart();