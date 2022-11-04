<?php
    require __DIR__ . '/includes/config/database.php';
    require 'includes/funciones.php';
    incluirTemplates("header");
    $aut=autenticado();

?>

    <main class="contenedor seccion">
        <h1>Todos los Cursos</h1>
        <?php 
            $limite = 20;
            include 'includes/templates/cursos.php' 
        ?>
        <?php if($aut): ?>
            <a href="/admin/cursos" class="boton-amarillo">Administrar Cursos</a>
        <?php endif; ?>
    </main>

    <?php 
        incluirTemplates("footer");
    ?>