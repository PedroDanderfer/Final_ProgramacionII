<?php

function select($query){
global $cnx;

$matchs = [];
$rta = mysqli_query($cnx, $query);

if(mysqli_error($cnx)){
    $_SESSION['status'] = false;
    $_SESSION['section'] = 'global';
    $_SESSION['errors'] = ['Ops... Ocurrio un problema'];
}

if(mysqli_num_rows($rta) > 0){
    while($match = mysqli_fetch_assoc($rta)):
        $matchs[] = $match;
    endwhile;    
}

mysqli_free_result($rta);

return $matchs;
}
