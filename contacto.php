<?php 
    require 'includes/funciones.php';
    incluirTemplates("header");
?>

    <main class="contenedor seccion">
        <h1>Todas las Empresas</h1>
        <div class="contenedor-anuncios">
            <?php 
                include 'includes/templates/empresas.php' 
            ?>
        </div>
    </main>

    <?php 
        incluirTemplates("footer");
    ?>