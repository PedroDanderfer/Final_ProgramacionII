<?php
function isLogged(){
    if(isset($_SESSION['user']['id'])){
        return true;
    }else{
        return false;
    }
}

function isLoggedAdmin(){
    if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'){
        return true;
    }else{
        return false;
    }
}