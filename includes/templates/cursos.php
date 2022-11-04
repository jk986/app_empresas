<?php 
    // Importar conexion a base de datos 
    $db = conectarDB();

    // Consultar
    $query = "SELECT * FROM cursos LIMIT ${limite}";
    // Obtener resultado
    $result = mysqli_query($db,$query);

?>
    
        <?php while($curso = mysqli_fetch_assoc($result)): ?>
            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <img loading="lazy" src="/imagenes/<?php echo $curso['imgC']; ?>" alt="Texto entrada Blog">
                    </picture>
                </div>

                <div class="texto-entrada">
                    <a href="/curso.php?id=<?php echo $curso['id_Cu'] ?>">
                        <h4><?php echo $curso['titulo']; ?></h4>
                        <p class="informacion-meta">Publicado el: <span><?php echo $curso['fecha']; ?></span> por: <span>Anónimo</span></p>
                        <p class="descrip-curso">
                            <?php echo $curso['descrip']; ?>
                        </p>
                    </a>
                </div>
            </article>
        <?php endwhile; ?>

<?php
    // Cerrar la conexión
    mysqli_close($db);
?>