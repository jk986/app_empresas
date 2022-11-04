<?php 

require '../../includes/funciones.php';
    $aut=autenticado();
        if(!$aut){
            header('location: /');
        }
    // ----------Validar la URL por id válido
    $id = $_GET['id'];
    $id = filter_var($id,FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /admin');
    }

    // Base de datos
    require '../../includes/config/database.php';
    $db = conectarDB();// --> Conexion a la base de datos
    //var_dump($db);

    // Consulta para obtener lod datos de la propiedad
    $consulta = "SELECT * FROM cursos WHERE id_Cu = ${id}";
    $resultado = mysqli_query($db,$consulta);
    $curso=mysqli_fetch_assoc($resultado);

    /* echo '<pre>';
    var_dump($curso);
    echo '</pre>'; */

    //Areglo con mensajes de errores y variables
    $errores = [];

        $titulo = $curso['titulo'] ;
        $descripcion = $curso['descrip'] ;
        $imagenP = $curso['imgC'] ;

    // Ejecutar el codigo despues de que el usuario envia el formualrio 
    
    if($_SERVER['REQUEST_METHOD']==='POST'){
        
        
        /* echo '<pre>';
        var_dump($_POST);
        echo '</pre>'; */

        //exit;
        /* echo '<pre>';
        var_dump($_FILES);
        echo '</pre>'; */

        $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $fecha = date('Y/m/d');
       
        // Asignar files a una variable
        $imagen = $_FILES['imagen'];
        //exit;

        if(!$titulo){
            $errores[]="Debes añadir un titulo";
        }
        if(strlen($descripcion)<50){
            $errores[]="Debes añadir una descripcion con al menos 50 caracteres";
        }

        /* echo '<pre>';
        var_dump($errores);
        echo '</pre>';
        */

        // Revisar que el arreglo de errores este vacío
        if(empty($errores)){

            // Crear carpeta para gusrdar las imagenes que se suben
            $carpetaImag = '../../imagenes/';
            
            if(!is_dir($carpetaImag)){
                mkdir($carpetaImag);
            }
            $nombreImag = '';
            // ----------Subida de archivos--------------

            // Validar por tamaño (1Mb)
            $medida = 1000 *1000;
            if($imagen['size']>$medida || $imagen['error']){
                $errores[]="La imagen es muy pesada el tamaño maáximo son 100kb";// php no acepta imagenes de mas de 2mb
            }
            //var_dump($imagen);
            
            if($imagen['name']){
                // Eliminar imagen previa 
                unlink($carpetaImag . $vacante['imgC']); // Sirve para eliminar archivos
                // Generar un nombr unico
                $nombreImag = md5(uniqid(rand(),true)) . ".jpg";

                // Subir la imagen
                move_uploaded_file($imagen['tmp_name'],$carpetaImag . $nombreImag);
            } else {
                $nombreImag = $vacante['imgC'];
            }

            // Insertar en la base de datos
            $query = "UPDATE cursos SET 
                    titulo='${titulo}', fecha='${fecha}', descrip='${descripcion}',imagen='${nombreImag}'
                    WHERE id_Cu=${id}" ;
            /* echo 'Aqui abajo deberia esta mu puta consulta *.*';
            echo $query;
            exit; */

            $result = mysqli_query($db,$query);//Con esto se hace la insercion,(conexion a la base de datos,consulta)

            if($result){
                //echo 'Insert succesful!!';
                // Redireccionar 
                header('Location: /admin/cursos?resultado=2');
            }
        }
    }


    
    incluirTemplates("header");
?>

    <main class="contenedor seccion">
        <h1>Actualizar Curso</h1>
        
        <a href="/admin/cursos" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>
        
        <form class="formulario" method="POST" enctype="multipart/form-data">
            
        
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" placeholder="Título"  value="<?php echo $titulo; ?>" />
                
                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png" />
                <img src="/imagenes/<?php echo $imagenP; ?>" alt="" class="imagen-small" />
                
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

            </fieldset>

            <input type="submit" value="Actualizar Publicación" class="boton-verde">
        </form>
    </main>

    <?php 
        incluirTemplates("footer");
    ?>