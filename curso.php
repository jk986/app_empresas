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
    $query = "SELECT * FROM cursos WHERE id_Cu = ${id}" ;
    $result = mysqli_query($db,$query);

    if($result->num_rows === 0){
        header('location: /');
    }
    /* echo '<pre>';
    var_dump($result->num_rows); // Para acceder a la propiedad de un objeto en php
    echo '</pre>'; */
    $curso = mysqli_fetch_assoc($result);

    // Inludes
    require 'includes/funciones.php';
    incluirTemplates("header");

?>

<main class="contenedor seccion contenido-centrado">
        <h1><?php echo $curso['titulo']; ?></h1>
        <picture>
            <img loading="lazy" src="imagenes/<?php echo $curso['imgC'] ?>" alt="imagen curso">
        </picture>
        
        <p class="informacion-meta">Escrito el: <span><?php echo $curso['fecha']; ?></span> por: <span>Anónimo</span></p>
        
        <div class="resumen-propiedad">
            <p>
                <?php echo $curso['descrip'] ?>
            </p>
        </div>
    </main>
    <?php 

        // Cerrar la conexión
        mysqli_close($db);
        incluirTemplates("footer");
    ?>