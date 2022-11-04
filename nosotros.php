<?php 
    require 'includes/funciones.php';
    incluirTemplates("header");
?>

    <main class="contenedor seccion">   
        <h1>Conce Sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/nosotros.jpg" alt="Sobre nosotros">
                </picture>
            </div>
            <div class="texto-nosotros">
                <blockquote>
                    25 años de experiencia
                </blockquote>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum et, odit at delectus dolores iste magnam dolor 
                    doloribus aut, omnis quis reiciendis, quaerat voluptates veritatis ipsam possimus. Odio, minima consequatur?
                    Culpa nobis in iusto dolor delectus reiciendis, ipsam, animi doloribus, eum et accusantium quia. 
                    Esse minima rem repellendus fugiat, voluptatum quam error nesciunt exercitationem enim quod delectus 
                    hic tempora cum! Repellendus, harum fugiat aperiam velit vel dolores inventore nemo, earum, accusamus 
                    sapiente dolorum odit cum architecto. Aliquam, earum officia possimus, qui, repellat dolorem amet minima 
                    aperiam autem exercitationem molestiae iure!
                </p>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum et, odit at delectus dolores iste magnam dolor 
                    doloribus aut, omnis quis reiciendis, quaerat voluptates veritatis ipsam possimus. Odio, minima consequatur?
                    Culpa nobis in iusto dolor delectus reiciendis, ipsam, animi doloribus, eum et accusantium quia. 
                    Esse minima rem repellendus fugiat, voluptatum quam error nesciunt exercitationem enim quod delectus 
                    hic tempora cum! Repellendus, harum fugiat aperiam velit vel dolores inventore nemo, earum, accusamus 
                    sapiente dolorum odit cum architecto. Aliquam, earum officia possimus, qui, repellat dolorem amet minima 
                    aperiam autem exercitationem molestiae iure!
                </p>
            </div>
        </div>
    </main>
    <section class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>
        <div class="iconos-nosotros">
            
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    Rerum ratione ipsum aspernatur eos harum sequi vitae quis debitis dolore tempore, 
                    incidunt error ab animi corporis aliquam laboriosam repellendus odio voluptatibus!
                </p>
            </div>
            
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono Precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    Rerum ratione ipsum aspernatur eos harum sequi vitae quis debitis dolore tempore, 
                    incidunt error ab animi corporis aliquam laboriosam repellendus odio voluptatibus!
                </p>
            </div>
            
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
                <h3>A Tiempo</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    Rerum ratione ipsum aspernatur eos harum sequi vitae quis debitis dolore tempore, 
                    incidunt error ab animi corporis aliquam laboriosam repellendus odio voluptatibus!
                </p>
            </div>

        </div>
    </section>

    <?php 
        incluirTemplates("footer");
    ?>