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

    // Consultar para obtener los empresa en la base de datos
    $query_V = "SELECT * FROM empresas";
    $result_V= mysqli_query($db,$query_V);

    //Areglo con mensajes de errores y variables
    $errores = [];

    $titulo = '';
    $sueldo = ''; //Sueldo
    //$imagen = '';
    $descripcion = '';
    $vacantes = '';
    $xp = '';
    //$parking = '';
    $empresa = '';

    // Ejecutar el codigo desoues de que el usuario envia el formualrio 
    if($_SERVER['REQUEST_METHOD']==='POST'){
        
        /* $num = "1Hola";
        $num2 = 1;

        $res = filter_var($num,FILTER_SANITIZE_NUMBER_INT);// Este filtro elimina lo que no son numeros, quedando asi : $num=1
        $res = filter_var($num2,FILTER_VALIDATE_INT);// Este filtro valida que se este insertando el tipo de datos que corresponde
        
        var_dump($res);
        exit; */
        
        /* echo '<pre>';
        var_dump($_POST);
        echo '</pre>';

        echo '<pre>';
        var_dump($_FILES);
        echo '</pre>'; */
        
        $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
        $sueldo = mysqli_real_escape_string($db, $_POST['sueldo']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $vacantes = mysqli_real_escape_string($db, $_POST['vacantes']);
        $xp = mysqli_real_escape_string($db, $_POST['xp']);
        //$parking = mysqli_real_escape_string($db, $_POST['parking']);
        $empresa = mysqli_real_escape_string($db, $_POST['empresa']);
        $creado = date('Y/m/d');
        // Asignar files a una variable
        $imagen = $_FILES['imagen'];
        //var_dump($imagen);
        //exit;


        if(!$titulo){
            $errores[]="Debes añadir un titulo";
        }
        if(!$sueldo){
            $errores[]="Debes añadir un precio";
        }
        if(strlen($descripcion)<50){
            $errores[]="Debes añadir una descripcion con al menos 50 caracteres";
        }
        if(!$vacantes){
            $errores[]="Debes añadir un numero de vacantes";
        }
        if(!$xp){
            $errores[]="Debes añadir un numero de baños";
        }
        /* if(!$parking){
            $errores[]="Debes añadir un numero de espacios disponibles para autos";
        } */
        if(!$empresa){
            $errores[]="Elige una empresa";
        }
        if(!$imagen['name']){
            $errores[] ="La imagen es obligatoria";
        }

        // Validar por tamaño (1Mb)
        $medida = 1000 *1000;
        if($imagen['size']>$medida /* || $imagen['error'] */){
            $errores[]="La imagen es muy pesada el tamaño maáximo son 100kb";// php no acepta imagenes de mas de 2mb
        }

        /* echo '<pre>';
        var_dump($errores);
        echo '</pre>';
        */

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
            $query = "INSERT INTO vacantes (titulo,sueldo,imagen,descripcion,vacantes,xp,creado,empresa_id_Em) 
            VALUES ('$titulo','$sueldo','$nombreImag','$descripcion','$vacantes','$xp','$creado','$empresa')";
            // echo $query;

            $result = mysqli_query($db,$query);//Con esto se hace la insercion,(conexion a la base de datos,consulta)

            if($result){
                //echo 'Insert succesful!!';
                // Redireccionar 
                header('location: /admin?resultado=1');
            }
        }
    }


    //require '../../includes/funciones.php';
    incluirTemplates("header");
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>
        
        <form class="formulario" method="POST" actions="/admin/propiedades/crear.php" enctype="multipart/form-data">
            
            <fieldset>
                <legend>Empresa</legend>

                <select name="empresa">
                    <option value="">-- SELECCIONAR --</option>
                    <?php while($row = mysqli_fetch_assoc($result_V)): ?>
                        <option <?php echo $empresa == $row['id_Em'] ? 'selected' : ''; ?> 
                        value="<?php echo $row['id_Em']; ?>"><?php echo $row['nombre'];  ?></option>
                    <?php endwhile; ?>
                </select>
                <a class="boton-amarillo" href="/admin/empresas/crear.php">¿No encuentras tu empresa?</a>
                
            </fieldset>
        
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" placeholder="Título"  value="<?php echo $titulo; ?>" />
                
                <label for="sueldo">Sueldo</label>
                <input type="number" id="sueldo" name="sueldo" placeholder="Sueldo" value="<?php echo $sueldo; ?>" />
                
                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png" />
                
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

            </fieldset>

            <fieldset>
                <legend>Información Vacante</legend>

                <label for="vacantes">Vacantes</label>
                <input type="number" id="vacantes" name="vacantes" placeholder="Ej: 3" min="1" max="9" value="<?php echo $vacantes; ?>" />
                
                <label for="xp">Experiencia Mínima</label>
                <input type="number" id="xp" name="xp" placeholder="Ej: 3" min="1" max="9" value="<?php echo $xp; ?>" />
                
            </fieldset>

            <input type="submit" value="Crear Publicación" class="boton-verde">
        </form>
    </main>

    <?php 
        incluirTemplates("footer");
    ?>