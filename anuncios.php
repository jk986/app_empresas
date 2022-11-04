<?php 
    require 'includes/funciones.php';
    incluirTemplates("header");
?>

    <main class="contenedor seccion">
        <h2>Ofertas de Empleo</h2>
        
        <?php 
            $limite = 20;
            include 'includes/templates/anuncios.php' 
        ?>
    </main>

    <?php 
        incluirTemplates("footer");
    ?>