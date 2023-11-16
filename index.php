<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <h1>Tarea02.1 </h1>
    <form  method="post" enctype="multipart/form-data">


        <div><label for="ficheros">Adjunte uno o varios ficheros (Solo se aceptan imágenes: jpg):</label>
            <input type="file" name="ficheros[]" id="ficheros" multiple accept=".jpg" >
        </div>  

        <div><input type="submit" value="Enviar"></div>

    </form>
</body>

</html>
<?php
require_once('funciones.php');

const DESTINATION_FOLDER = "uploaded";
const INPUT_NAME_FILES = "ficheros";
const BYTES_KB_RELATION = 1024;

const MENSAJE_MOVE_EXITO = "Se ha guardado con éxito el fichero ";
const MENSAJE_MOVE_ERROR = "Ha habido un problema y no ha podido guardarse en el servidor el fichero ";
const MENSAJE_UPLOAD_NOT_POST = "No se ha sido enviado por el método HTTP POST el fichero ";
const MENSAJE_ERROR_UPLOAD = "No se ha recibido correctamente el fichero ";

const CSS_CLASS_EXITO = "exito";
const CSS_CLASS_ERROR = "error";

if(isset($_FILES[INPUT_NAME_FILES])){
    mostrar_ol_fichero(INPUT_NAME_FILES);

    mover_ficheros();
}

