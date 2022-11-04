<?php
    // Conexion a DB
    require 'includes/config/database.php';
    $db=conectarDB();
    $resultadoR = $_GET['r'] ?? null;
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
            $query = "SELECT * FROM usuarios WHERE email='${email}' ";
            $resultado = mysqli_query($db,$query);
            
            if($resultado->num_rows){
                // Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                //Verificar si el password es correcto o no 
                $aut = password_verify($pass,$usuario['pass']);
                //var_dump($aut);
                if($aut){
                    // El usuario esta autenticado
                    session_start();
                    // Llenar el arreglo de la session 
                    $_SESSION['usuario']=$usuario['email'];
                    $_SESSION['login']=true;

                    header('location: /admin');

                } else {
                    $errores[]='El password es incorrecto';
                }
                
            } else {
                $errores[]='El usuario no existe';
            }
        }
    }

    // Incluye el header
    require 'includes/funciones.php';
    incluirTemplates("header");
?>

    <main class="contenedor seccion">
        <h1>Iniciar Sesión</h1>
        <?php if(intval($resultadoR)===1):  ?>
            <p class="alerta exito">Usuario creado correctamente</p>
            <?php endif; ?>
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

                <p>¿Todavía no tienes una cuenta? <span><a href="registro.php" >Registrate</a></span></p>

            </fieldset>
            <input type="submit" value="Iniciar Sesión" class="boton boton-verde" />
        </form>
    </main>

    <?php 
        incluirTemplates("footer");
    ?>