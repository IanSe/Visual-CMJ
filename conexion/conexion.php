<?php
    $server = 'Localhost';
    $user = 'root';
    $pass = '';
    $database = 'prebuild';

    $mysqli = new mysqli($server, $user, $pass, $database);    
    if ($mysqli->connect_errno) {
        $Error = "Fallo al conectar con la BD";
    }
?>