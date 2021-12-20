<?php

function validator($data, $rules){
    $errors = [];

    foreach ($rules as $key => $rules) {
        
        $res = validate($key, $data[$key], $rules, $data);

        if($res !== true){
            $errors[$key] = $res;
        }else{
            continue;
        }
    }

    if(empty($errors)){
        return true;
    }else{
        return $errors;
    }
}

function validate($key, $data, $rules, $allData){
    $errors = [];

    for ($i=0; $i < count($rules); $i++) { 
        
        if(str_contains($rules[$i], ':')){
            $rule = explode(':', $rules[$i]);

            if($rule[0] === 'compare'){
                $res = $rule[0]($key, $data, $rule[1], $allData);
            }else{
                $res = $rule[0]($key, $data, $rule[1]);
            }
            
            if($res !== true){
                if(is_array($res)){
                    for ($i=0; $i < count($res); $i++) { 
                        $errors[] = $res[$i];
                    }
                }else{
                    $errors[] = $res;
                }
            }else{
                continue;
            }
        }else{
            $res = $rules[$i]($key, $data);

            if($res !== true){
                if(is_array($res)){
                    for ($i=0; $i < count($res); $i++) { 
                        $errors[] = $res[$i];
                    }
                }else{
                    $errors[] = $res;
                }
            }else{
                continue;
            }
        }

    }

    if(empty($errors)){
        return true;
    }else{
        return $errors;
    }
}

function type($key, $data){
    if(!is_null($data)){
        $errors = [];
        $hasError = false;
        for ($i=0; $i < count($data); $i++) { 
            if($data[$i]["type"] !== "image/png" && $data[$i]["type"] !== "image/jpeg"){
                $errors[] = 'La imagen n° '.($i+1).' debe ser png o jpeg.';
                $hasError = true;
            }else{
                continue;
            }
        }

        if($hasError){
            return $errors;
        }else{
            return true;
        }
    }else{
        return true;
    }
}

function exists($key, $data, $table){
    global $validatorKeys;
    if(!is_null($data)){
        if(is_array($data)){
            $errors = [];
            $hasError = false;
            $querySelect = "SELECT * FROM $table WHERE id in (";

            for ($i=0; $i < count($data); $i++) { 
                if(count($data) == 0){
                    $querySelect = $querySelect."$data[$i]";
                }else{
                    if($i == count($data)-1){
                        $querySelect = $querySelect."$data[$i]";
                    }else{
                        $querySelect = $querySelect."$data[$i], ";
                    }
                }
            }

            $querySelect = $querySelect.");";

            $rtaSelect = select($querySelect);

            $idExist = false;

            for ($i=0; $i < count($data); $i++) { 
                $idExist = false;
                for ($j=0; $j < count($rtaSelect); $j++) { 
                    if($data[$i] === $rtaSelect[$j]["id"]){
                        $idExist = true;
                    }
                }
                if(!$idExist){
                    return ["El campo ".$validatorKeys[$key]." no existe."];
                }
            }
            return true;
        }else{
            $querySelect = <<<SELECTEXIST
            SELECT * FROM $table
            WHERE id='$data[id]';
            SELECTEXIST;

            $rtaSelect = select($querySelect);
            if(count($rtaSelect) == 0){
                return ['El campo '.$validatorKeys[$key].' no existe.'];
            }else{
                return true;
            }
        }
    }

    return true;
}

function size($key, $data){
    if(!is_null($data)){
        $errors = [];
        $hasError = false;
        for ($i=0; $i < count($data); $i++) { 
            if($data[$i]["size"] > 524288){
                $errors[] = 'La imagen n° '.($i+1).' no puede pesar mas de 524Kbs.';
                $hasError = true;
            }else{
                continue;
            }
        }

        if($hasError){
            return $errors;
        }else{
            return true;
        }
    }else{
        return true;
    }
}

function required($key, $data){
    global $validatorKeys;

    if(empty($data)){
        return 'El campo '.$validatorKeys[$key].' es obligatorio.';
    }else{
        return true;
    }
}

function maxlen($key, $data, $n){
    global $validatorKeys;

    if(strlen($data) > $n){
        return 'El campo '.$validatorKeys[$key].' no puede contener mas de '.$n.' caracteres.';
    }else{
        return true;
    }
}

function minlen($key, $data, $n){
    global $validatorKeys;

    if(strlen($data) > 0 && strlen($data) < $n){
        return 'El campo '.$validatorKeys[$key].' no puede contener menos de '.$n.' caracteres.';
    }else{
        return true;
    }
}

function numeric($key, $data){
    global $validatorKeys;

    if(is_null($data)){
        return true;
    }else{
        if(!is_numeric($data)){
            return 'El campo '.$validatorKeys[$key].' solo puede contener números.';
        }else{
            return true;
        }
    }
}

function alphabetic($key, $data){
    global $validatorKeys;
    $regex = "/^[a-zA-Z]{1,}$/";

    if (!preg_match($regex, $data)){
        return 'El campo '.$validatorKeys[$key].' solo puede contener letras.';
    }else{
        return true;
    }
}

function email($key, $data){
    global $validatorKeys;

    if (!filter_var($data, FILTER_VALIDATE_EMAIL)){
        return 'El campo '.$validatorKeys[$key].' no es valido.';
    }else{
        return true;
    }
}

function regex($key, $data, $type){
    global $validatorKeys;

    $regex = [];

    $regex['lowerCase'] = "/^(?=.*[a-z]).+$/";
    $regex['upperCase'] = "/^(?=.*[A-Z]).+$/";
    $regex['oneNumber'] = "/^(?=.*[\d]).+$/";

    if (!preg_match($regex[$type], $data)){
        switch ($type) {
            case 'lowerCase':
                return 'El campo '.$validatorKeys[$key].' debe tener al menos una minuscula.';
                break;
            
            case 'upperCase':
                return 'El campo '.$validatorKeys[$key].' debe tener al menos una mayuscula.';
                break;

            case 'oneNumber':
                return 'El campo '.$validatorKeys[$key].' debe tener al menos un numero.';
                break;    
        }
    }else{
        return true;
    }
}

function compare($key, $data, $compare, $allData){
    global $validatorKeys;

    if($data !== $allData[$compare]){
        return 'El campo '.$validatorKeys[$key].' debe ser igual al campo '.$validatorKeys[$compare].'.';
    }else{
        return true;
    }
}