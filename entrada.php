<?php 

    // Validar ID

    $id = $_GET['id'];
    $id = filter_var($id,FILTER_VALIDATE_INT);
    if(!$id){
        header('location: /');
    }

    // importar la base de datos 
    require __DIR__ . '/includes/config/database.php';
    $db = conectarDB();

    // Consulta 
    $query = "SELECT * FROM vacantes WHERE empresa_id_Em = ${id}" ;
    $result = mysqli_query($db,$query);

    if($result->num_rows === 0){
        //Añadir algo que indique que no hay registros
        header('location: /');

    }
    /* echo '<pre>';
    var_dump($result->num_rows); // Para acceder a la propiedad de un objeto en php
    echo '</pre>'; */
    
    $qeryEmpresa = "SELECT nombre FROM empresas WHERE id_Em = ${id}" ;
    $empresa = mysqli_query($db,$qeryEmpresa) ;
    $nameE = mysqli_fetch_assoc($empresa);
    // Inludes
    require 'includes/funciones.php';
    incluirTemplates("header");

?>
<h2>Empleos <?php echo $nameE['nombre']; ?></h2>
<div class="contenedor-anuncios contenedor">
        <?php while($vacan = mysqli_fetch_assoc($result)): ?>
            <div class="anuncio">
                
                <img loading="lazy" src="/imagenes/<?php echo $vacan['imagen']; ?>" alt="Anuncio">
                
                <div class="contenido-anuncio">
                    <h3><?php echo $vacan['titulo']; ?></h3>
                    <p><?php echo $vacan['descripcion']; ?></p>
                    <p class="precio">$<?php echo $vacan['sueldo'] ?></p>
                    <a href="anuncio.php?id=<?php echo $vacan['id_pro'] ?>" class="boton-amarillo-block">Ver Detalles</a>
                </div><!--Contenido_Anuncio-->
            </div><!--Anuncio-->
        <?php endwhile; ?>
    </div><!--Contenedor de Anuncios-->

    <?php 
        incluirTemplates("footer");
    ?>