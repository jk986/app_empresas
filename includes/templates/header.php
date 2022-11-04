<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $aut = $_SESSION['login'] ?? false;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VaJobs</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?> ">
    <div class="fondo">

    
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <!-- <img class="enlace" src="/build/img/logo.svg" alt="Logotipo de bienes raices"> -->
                    <h1>Va<span>Jobs</span></h1>
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">

                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="dark mode option">
                    <nav class="navegacion">
                        <!-- <a href="nosotros.php">Nosotros</a> -->
                        <a href="anuncios.php">Empleos</a>
                        <a href="blog.php">Cursos</a>
                        <a href="contacto.php">Empresas</a>
                        <?php if($aut): ?>
                            <a href="/admin">Publicaciones</a>
                        <?php endif; ?>
                        <?php if($aut): ?>
                            <a href="cerrar-session.php">Cerrar Sesión</a>
                        <?php endif; ?>
                        <?php if(!$aut): ?>
                            <a href="login.php">Iniciar Sesión</a>
                        <?php endif; ?>
                    </nav>
                </div>

            </div><!--Cierre de la barra-->
            <?php
                if($inicio){
                    echo '<h1>Empleos y cursos publicados por multiples empresas</h1>';
                }
            ?>
        </div>
    </div>
    </header>