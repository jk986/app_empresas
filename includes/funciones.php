<?php

require 'app.php';

function incluirTemplates(String $nombre, bool $inicio = false){
    include TEMPLATES_URL . "/${nombre}.php";
}

function autenticado() : bool {
    session_start();
    $aut=$_SESSION['login'];
    if($aut){
        return true;
    } else {
        return false;
    }
}