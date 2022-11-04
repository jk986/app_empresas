<?php 
    require __DIR__ . '/../config/database.php';
    // Importar conexion a base de datos 
    $db = conectarDB();

    // Consultar
    $query = "SELECT * FROM empresas" ;
    // Obtener resultado
    $result = mysqli_query($db,$query);

?>
        <?php while($empresa = mysqli_fetch_assoc($result)): ?>               
            <div>
                <h3><?php echo $empresa['nombre']; ?></h3>
                <a href="entrada.php?id=<?php echo $empresa['id_Em'] ?>">
                    <img loading="lazy" src="/imagenes/<?php echo $empresa['imgE']; ?>" alt="Anuncio">
                </a>
            </div>        
        <?php endwhile; ?>

<?php
    // Cerrar la conexión
    mysqli_close($db);
?>