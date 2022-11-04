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
    $consulta = "SELECT * FROM vacantes WHERE id_pro = ${id}";
    $resultado = mysqli_query($db,$consulta);
    $vacante=mysqli_fetch_assoc($resultado);

    /* echo '<pre>';
    var_dump($vacante);
    echo '</pre>'; */



    // Consultar para obtener los vendedores en la base de datos
    $query_V = "SELECT * FROM empresas";
    $result_V= mysqli_query($db,$query_V);

    //Areglo con mensajes de errores y variables
    $errores = [];

        $titulo = $vacante['titulo'] ;
        $sueldo = $vacante['sueldo'] ;
        $descripcion = $vacante['descripcion'] ;
        $vacantes = $vacante['vacantes'] ;
        $xp = $vacante['xp'] ;
        //$parking = $vacante['estacionamiento'] ;
        $empresa = $vacante['empresa_id_Em'] ;
        $imagenP = $vacante['imagen'] ;

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
        $sueldo = mysqli_real_escape_string($db, $_POST['sueldo']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $vacantes = mysqli_real_escape_string($db, $_POST['vacantes']);
        $xp = mysqli_real_escape_string($db, $_POST['xp']);
        //$parking = mysqli_real_escape_string($db, $_POST['parking']);
        $empresa = mysqli_real_escape_string($db, $_POST['empresa']);
        $creado = date('Y/m/d');
       
        // Asignar files a una variable
        $imagen = $_FILES['imagen'];
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
                unlink($carpetaImag . $vacante['imagen']); // Sirve para eliminar archivos
                // Generar un nombr unico
                $nombreImag = md5(uniqid(rand(),true)) . ".jpg";

                // Subir la imagen
                move_uploaded_file($imagen['tmp_name'],$carpetaImag . $nombreImag);
            } else {
                $nombreImag = $vacante['imagen'];
            }

            // Insertar en la base de datos
            $query = "UPDATE vacantes SET titulo='${titulo}', sueldo='${sueldo}', imagen='${nombreImag}', descripcion='${descripcion}',
            vacantes=${vacantes}, xp=${xp},empresa_id_Em=${empresa} WHERE id_pro=${id}" ;
            /* echo 'Aqui abajo deberia esta mu puta consulta *.*';
            echo $query;
            exit; */

            $result = mysqli_query($db,$query);//Con esto se hace la insercion,(conexion a la base de datos,consulta)

            if($result){
                //echo 'Insert succesful!!';
                // Redireccionar 
                header('Location: /admin?resultado=2');
            }
        }
    }


    
    incluirTemplates("header");
?>

    <main class="contenedor seccion">
        <h1>Actualizar Publicación</h1>
        
        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>
        
        <form class="formulario" method="POST" enctype="multipart/form-data">
            
            <fieldset>
                <legend>Empresa</legend>

                <select name="empresa">
                    <option value="">-- SELECCIONAR --</option>
                    <?php while($row = mysqli_fetch_assoc($result_V)): ?>
                    <option <?php echo $empresa == $row['id_Em'] ? 'selected' : ''; ?> 
                        value="<?php echo $row['id_Em']; ?>"><?php echo $row['nombre'];  ?></option>
                    <?php endwhile; ?>
                </select>
            </fieldset>
        
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" placeholder="Título"  value="<?php echo $titulo; ?>" />
                
                <label for="sueldo">sueldo</label>
                <input type="number" id="sueldo" name="sueldo" placeholder="Sueldo" value="<?php echo $sueldo; ?>" />
                
                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png" />
                <img src="/imagenes/<?php echo $imagenP; ?>" alt="" class="imagen-small" />
                
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

            </fieldset>

            <fieldset>
                <legend>Información Vacante</legend>

                <label for="vacantes">Vacantes</label>
                <input type="number" id="vacantes" name="vacantes" placeholder="Ej: 3" min="1" max="9" value="<?php echo $vacantes; ?>" />
                
                <label for="xp">Emperiencia Mínima</label>
                <input type="number" id="xp" name="xp" placeholder="Ej: 3" min="1" max="9" value="<?php echo $xp; ?>" />
                
                

            </fieldset>

            <input type="submit" value="Actualizar Publicación" class="boton-verde">
        </form>
    </main>

    <?php 
        incluirTemplates("footer");
    ?>