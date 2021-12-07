<?php

function session($session){
    $_SESSION['status'] = $session['status'];
    if(isset($session['section'])){
        $_SESSION['section'] = $session['section'];
    }else{
        unset($_SESSION['section']); 
    }
    if(isset($session['type'])){
        $_SESSION['type'] = $session['type'];
    }else{
        unset($_SESSION['type']); 
    }
    if(isset($session['errors'])){
        $_SESSION['errors'] = $session['errors'];
    }else{
        unset($_SESSION['errors']); 
    }
}