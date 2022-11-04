<?php 
    require '../../includes/funciones.php';
    $aut=autenticado();
        if(!$aut){
            header('location: /');
        }
    // Base de datos
    require '../../includes/config/database.php';
    $db = conectarDB();// --> Conexion a la base de datos
    //var_dump($db);


    //Areglo con mensajes de errores y variables
    $errores = [];

    $nombre = '';
    $descrip = '';
    $imgC = '';

    // Ejecutar el codigo desoues de que el usuario envia el formualrio 
    if($_SERVER['REQUEST_METHOD']==='POST'){
        
        /* $num = "1Hola";
        $num2 = 1;

        $res = filter_var($num,FILTER_SANITIZE_NUMBER_INT);// Este filtro elimina lo que no son numeros, quedando asi : $num=1
        $res = filter_var($num2,FILTER_VALIDATE_INT);// Este filtro valida que se este insertando el tipo de datos que corresponde
        
        var_dump($res);
        exit; */
        
   /*      echo '<pre>';
        var_dump($_POST);
        echo '</pre>';

        echo '<pre>';
        var_dump($_FILES);
        echo '</pre>'; */
        
        $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
        $descrip = mysqli_real_escape_string($db, $_POST['descrip']);
        $imagen = $_FILES['imagen'];
        $fecha = date('Y/m/d');


        if(!$nombre){
            $errores[]="Debes añadir un nombre";
        }
        if(strlen($descrip)<50){
            $errores[]="Debes añadir una descripcion con al menos 50 caracteres";
        }
        if(!$imagen['name']){
            $errores[] ="La imagen es obligatoria";
        }

        // Validar por tamaño (1Mb)
        $medida = 1000 *1000;
        if($imagen['size']>$medida /* || $imagen['error'] */){
            $errores[]="La imagen es muy pesada el tamaño maáximo son 100kb";// php no acepta imagenes de mas de 2mb
        }
        

        // Revisar que el arreglo de errores este vacío
        if(empty($errores)){

            // Subida de archivos

            // Crear carpeta
            $carpetaImag = '../../imagenes/';
            
            if(!is_dir($carpetaImag)){
                mkdir($carpetaImag);
            }

            // Generar un nombr unico
            $nombreImag = md5(uniqid(rand(),true)) . ".jpg";

            // Subir la imagen
            move_uploaded_file($imagen['tmp_name'],$carpetaImag . $nombreImag);

            //insertar en la base de datos
            $query = "INSERT INTO cursos (titulo,fecha,descrip,imgC) 
            VALUES ('$nombre','$fecha','$descrip','$nombreImag')";
            //echo $query;

            $result = mysqli_query($db,$query);//Con esto se hace la insercion,(conexion a la base de datos,consulta)

            if($result){
                //echo 'Insert succesful!!';
                // Redireccionar 
                header('location: /admin/cursos?resultado=1');

            }
        }
    }


    //require '../../includes/funciones.php';
    incluirTemplates("header");

?>

    <main class="contenedor seccion">
        <h1>Registrar Curso</h1>

        <a href="/admin/cursos" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>
        
        <form class="formulario" method="POST" actions="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Información General</legend>

                <label for="nombre">Título</label>
                <input type="text" id="nombre" name="nombre" placeholder="Título"  value="<?php echo $nombre; ?>" />
                
                <label for="descrip">Descripción</label>
                <textarea id="descrip" name="descrip"><?php echo $descrip; ?></textarea>

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png" />
                
            </fieldset>

            <input type="submit" value="Registrar" class="boton-verde">
        </form>
    </main>

    <?php 
        incluirTemplates("footer");
    ?>