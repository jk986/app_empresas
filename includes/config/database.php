<?php

function conectarDB(){
    $db = mysqli_connect('localhost','jdavs','linus0*','appempresas_db');

    if(!$db){
        echo "No se pudo conectar";
        exit;
    }
    return $db;
};

