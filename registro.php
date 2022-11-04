<?php
    // Conexion a DB
    require 'includes/config/database.php';
    $db=conectarDB();

    // Autenticar el usuario
    $errores=[];
    if($_SERVER['REQUEST_METHOD']==='POST'){
        /* echo '<pre>';
        var_dump($_POST);
        echo '</pre>'; */
        // Sanitizacion y validacion del formulario
        $email= mysqli_real_escape_string($db,filter_var($_POST['email'],FILTER_VALIDATE_EMAIL));
        $pass= mysqli_real_escape_string($db,$_POST['pass']);
        if(!$email){
            $errores[]= "El email es obligatorio o no es válido";
        }

        if(!$pass){
            $errores[] = "La contraseña es obligatorio";
        }

        if(empty($errores)){
            // Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email='{$email}'" ;
            $result = mysqli_query($db,$query);
            if($result){
                $errores[]="El correo que ingreso ya existe";
            }else{
            


            $passHash = password_hash($pass,PASSWORD_DEFAULT);
            $query = "INSERT INTO usuarios (email,pass) VALUES ('${email}','${passHash}')";
            //echo $query;
            //exit;
    
            // Agreharlo a la base de datos 
            $result = mysqli_query($db,$query);

            if($result){
                //echo 'Insert succesful!!';
                // Redireccionar 
                header('location: /login.php?r=1');

            }
            
            
        }
    }
    }

    // Incluye el header
    require 'includes/funciones.php';
    incluirTemplates("header");
?>

    <main class="contenedor seccion">
        <h1>Registrar</h1>
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        
            <?php endforeach; ?>
        <form method="POST" class="formulario contenido-centrado">
        <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-mail</label>
                <input name="email" type="email" id="email" placeholder="forexample@email.com" required />
                
                <label for="pass">Password</label>
                <input name="pass" type="password" id="pass" placeholder="Password" required />

                <p>¿Ya tienes una cuenta? <span><a href="login.php" >Iniciar Sesion</a></span></p>

            </fieldset>
            <input type="submit" value="Crear Cuenta" class="boton boton-verde" />
        </form>
    </main>

    <?php 
        incluirTemplates("footer");
    ?>