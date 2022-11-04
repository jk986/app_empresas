<?php
    require 'includes/funciones.php';
    incluirTemplates("header",$inicio = true);
?>


    <section class="seccion contenedor"><!--Anuncios-->
        <h2>Ofertas de empleo</h2>
        <?php 
            $limite = 3;
            include_once 'includes/templates/anuncios.php'
        ?>
        <div class="alinear-derecha">
            <a href="anuncios.php" class="boton-verde">Ver Todas</a>
        </div>
    </section><!--Fin Anuncios-->
    
    
    <section class="imagen-buscarEm diseño-imagen-buscarEm"><!--Contacto-->
        <div class="fondo imagen-contacto">
            <h2>¿Buscas una empresa en específico?</h2>
            <a href="contacto.php" class="boton-amarillo">Ver Empresas</a>
        </div>    
    </section><!--Fin Contacto-->

    <div class="contenedor seccion seccion-inferior"><!--Blog-->
        <section class="blog">
            <h3>Cursos</h3>
            <?php 
                $limite = 2;
                include_once 'includes/templates/cursos.php' 
            ?>
        </section>
        
        <section class="testimoniales"><!--Testimoniales-->
            <h3>Testimoniales</h3>
            <div class="testimonial">
                <blockquote>
                    Los cursos ofrecidos por las empresas cumplen con lo prometido. Además,
                    la información esta siempre actualizada.
                </blockquote>
                <p>- J17</p>
            </div>
        </section><!--Fin Testimoniales-->
    </div><!--Fin-Blog-->
    
    <?php 
        incluirTemplates("footer");
    ?>