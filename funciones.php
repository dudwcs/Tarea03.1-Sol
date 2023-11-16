<?php



/**
 * mostrar_ol_ficheros
 * Crea marcado HTML para generar una lista ordenada con todos los datos que provee PHP en $_FILES para el parámetro de entrada $input
 * @param  string $input Clave del array superglobal $_FILES 
 * @return void
 */
function mostrar_ol_fichero(string $input): void
{

    $infoArr = $_FILES[$input];
    $total_archivos = count(array_values($infoArr[array_key_first($infoArr)]));

    $i = 0;
    do {
        printf("<p> Fichero %d</p><ol> ", $i + 1);
        foreach ($infoArr as $key => $value) {
            echo "<li> $key: $value[$i] </li>";
        }
        echo "</ol>";
        $i++;
    } while ($i < $total_archivos);
}
/**
 * Summary of mover_ficheros Comprueba si se han llegado correctamente al servidor ficheros mediante POST y los mueve a la carpeta de destino destination_folder o DESTINATION_FOLDER si no se provee el argumento. Muestra mensajes de error/éxito según el éxito de la subida/movimiento
 * @param string $destination_folder Carpeta de destino o la constante DESTINATION_FOLDER en su defecto
 * @return void
 */
function mover_ficheros(string $destination_folder =DESTINATION_FOLDER): void
{

    foreach ($_FILES as $input => $infoArr) {
        foreach ($infoArr["error"] as $i => $error) {
            $exito = false;
            $msg = MENSAJE_ERROR_UPLOAD;

            if ($error == UPLOAD_ERR_OK) {
                //Según la documentación, move_uploaded_file lleva a cabo la comprobación de is_uploaded_file, así que no es estrictamente necesaria
                //La añado porque la pedía en el enunciado, pero si se ha obviado también se consideró correcto
                if (is_uploaded_file($infoArr["tmp_name"][$i])) {
                    $destination_name = $destination_folder . DIRECTORY_SEPARATOR . $infoArr["name"][$i];
                    $exito = move_uploaded_file($infoArr["tmp_name"][$i], $destination_name);
                    $msg = $exito ? MENSAJE_MOVE_EXITO : MENSAJE_MOVE_ERROR;
                } else {
                    $msg = MENSAJE_UPLOAD_NOT_POST;
                }
            }
            formatear_msg($exito, $msg, $infoArr["name"][$i], $infoArr["size"][$i], $infoArr["error"][$i]);
        }
    }
}
/**
 * Summary of formatear_msg Muestra un mensaje formateado
 * @param bool $exito Indicador de éxito (true) o false en caso contrario
 * @param string $msg Mensaje a mostrar
 * @param string $name Nombre del fichero enviado
 * @param int $size_bytes Tamaño en bytes del fichero
 * @param int $error_code Código de error del proceso de envío al servidor
 * @return void
 */
function formatear_msg(bool $exito, string $msg, string $name, int $size_bytes, int $error_code):void
{
    $class_css = $exito ? CSS_CLASS_EXITO : CSS_CLASS_ERROR;
    printf("<p class=\"$class_css\"> %s %s</p>", $msg, $name);

    printf("<ul><li>Tamaño: %.2fKB </li>
   <li> Código de error: %d </li></ul>", $size_bytes / BYTES_KB_RELATION, $error_code);
}
