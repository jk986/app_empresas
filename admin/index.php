<?php

    require '../includes/funciones.php';
    $aut=autenticado();
    if(!$aut){
        header('location: /');
    }

// Importar la base de datos 
    require '../includes/config/database.php';
    $db=conectarDB();

// Escribir el Query
    $query = "SELECT * FROM vacantes";

// Consultar la base de datos
    $result = mysqli_query($db,$query);


/* echo '<pre>';
var_dump($_GET);
echo '</pre>';
exit; */
// Muestra mensaje condicional 
$resultadoR = $_GET['resultado'] ?? null;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id'];
    $id = filter_var($id,FILTER_VALIDATE_INT);

    if($id){
        // Eliminar archivo
        $query_SE = "SELECT imagen FROM vacantes WHERE id_pro=${id}";
        $resultado_D = mysqli_query($db,$query_SE);
        $row = mysqli_fetch_assoc($resultado_D);
        unlink('../imagenes/' . $row['imagen']);

        // Eliminar Propiedad
        $query_D = "DELETE FROM vacantes WHERE id_pro = ${id}";
        $resultado_D = mysqli_query($db,$query_D);
        if($resultado_D){
            header('location: /admin?resultado=3');
        }
    }
}


// Incluye un template 
    //require '../includes/funciones.php';
    incluirTemplates("header");
?>

    <main class="contenedor seccion">
        <h1>Administrador de Empleos</h1>
        <?php if(intval($resultadoR)===1):  ?>
            <p class="alerta exito">Publicación creada correctamente</p>
            <?php elseif(intval($resultadoR)===2): ?>
            <p class="alerta exito">Publicación actualizada correctamente</p>
            <?php elseif(intval($resultadoR)===3): ?>
            <p class="alerta exito">Publicación eliminada correctamente</p>
            <?php endif; ?>
            <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Publicación</a>
        </main>
        
        
        <table class="contenedor propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Sueldo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody><!--Mostrar los resultados-->
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id_pro']; ?></td>
                    <td><?php echo $row['titulo']; ?></td>
                    <td><img src="/imagenes/<?php echo $row['imagen']; ?>" alt="imagen casa" class="imagen-tabla"></td>
                    <td>$<?php echo $row['sueldo']; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $row['id_pro']; ?>" />
                            <input type="submit" class="boton-rojo-block" value="Eliminar" />
                        </form>
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $row['id_pro']; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    <?php

        //Cerrar la conexión 
        mysqli_close($db);

        // Footer
        incluirTemplates("footer");
    ?>