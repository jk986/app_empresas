<?php 
    // Importar conexion a base de datos 
    require __DIR__ . '/../config/database.php';
    $db = conectarDB();

    // Consultar
    $query = "SELECT * FROM vacantes LIMIT ${limite}";
    // Obtener resultado
    $result = mysqli_query($db,$query);

?>
    <div class="contenedor-anuncios">
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
    // Cerrar la conexión
    mysqli_close($db);
?>