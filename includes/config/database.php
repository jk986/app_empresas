<?php

function conectarDB(){
    $db = mysqli_connect('us-cdbr-east-06.cleardb.net','bd45478afdce1a','18b3b133','heroku_6c8aeda6b41d475');

    if(!$db){
        echo "No se pudo conectar";
        exit;
    }
    return $db;
};

