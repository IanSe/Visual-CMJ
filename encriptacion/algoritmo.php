<?php
    
    require('./encriptacion/datos.php');

    //Metodo de encriptación
    $method = 'aes-128-cbc';

    $iv = base64_decode("K8JrTYuwaDRmO4a/SirLbg==");

    //Funcion para encriptar
    $encriptar = function ($valor) use ($method, $clave, $iv) {
        return openssl_encrypt ($valor, $method, $clave, false, $iv);
    };

    //Funcion para descencriptar
    $desencriptar = function ($valor) use ($method, $clave, $iv) {
        $encrypted_data = base64_decode($valor);
        return openssl_decrypt($valor, $method, $clave, false, $iv);
    };

    /*
    Genera un valor para IV
    */
    $getIV = function () use ($method) {
        return base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length($method)));
    };

 ?>