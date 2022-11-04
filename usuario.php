<?php
// Importar la conexion a BD
    require 'includes/config/database.php';
    $db=conectarDB();
// Crear email y pass
    $email = 'correo@correo.com';
    $pass = '123456';
    //  ------------ hashear un password ---------------
    $passHash = password_hash($pass,PASSWORD_DEFAULT);
    
// Query para crear el usuario 
    $query = "INSERT INTO usuarios (email,pass) VALUES ('${email}','${passHash}')";
    //echo $query;
    //exit;
    
    // Agreharlo a la base de datos 
    mysqli_query($db,$query);