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
    $query = "SELECT * FROM vacantes WHERE id_pro = ${id}" ;
    $result = mysqli_query($db,$query);

    if($result->num_rows === 0){
        header('location: /');
    }
    /* echo '<pre>';
    var_dump($result->num_rows); // Para acceder a la propiedad de un objeto en php
    echo '</pre>'; */
    $vacan = mysqli_fetch_assoc($result);

    // Inludes
    require 'includes/funciones.php';
    incluirTemplates("header");

?>

    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $vacan['titulo']; ?></h1>

            <img loading="lazy" src="/imagenes/<?php echo $vacan['imagen']; ?>" alt="imagen de la Propiedad">

        <div class="resumen-propiedad">
            <p class="details">Sueldo:</p>
            <p class="details precio">$<?php echo $vacan['sueldo']; ?></p>
            <p class="details">Años de experiencia:</p>
            <p class="details"><?php echo $vacan['xp']; ?></p>
            <p class="details">Vacantes:</p>
            <p class="details"><?php echo $vacan['vacantes']; ?></p>
            <p><?php echo $vacan['descripcion']; ?></p>
        </div>
    </main>

    <?php 

        // Cerrar la conexión
        mysqli_close($db);
        incluirTemplates("footer");
    ?>