<?php

function generateCode($prefix, $table, $field){

    $number = 1;
    $length = 5;    
    
    $code = $prefix . "-" . substr(str_repeat(0, $length).$number, - $length);
    
    // * Obtener el último código insertado
    $db = \Config\Database::connect();
    $getLastCode = $db
        ->table($table)
        ->select($field)
        ->orderBy($field, 'DESC')
        ->limit(1)
        ->get()->getResultArray();

    // * Si ya hay registros generar el código que sigue, en caso contrario será 00001 (el primer registro)
    if($getLastCode){

        $id = explode('-', $getLastCode[0][$field]);
        $id = floatval($id[1]);
        $number = $id + 1;

        $code = $prefix . "-" . substr(str_repeat(0, $length).$number, - $length);

        if( strlen($number) > $length ){
            $code = $prefix . "-" . $number;
        }

    }    

    // * Verificar que el código no exista, no debería entrar aquí pero por si acaso
    $verifyCode = $db
        ->table($table)
        ->select($field)
        ->where($field, $code)
        ->get()->getResult();

    if( $verifyCode ){
        return generateCode($prefix, $table, $field);
    }
    
    return $code;

}