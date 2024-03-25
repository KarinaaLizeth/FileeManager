<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreArchivo = isset($_POST["archivo"]) ? $_POST["archivo"] : null;

    if ($nombreArchivo) {
        $rutaArchivo = DIR_UPLOAD . DIRECTORY_SEPARATOR . $nombreArchivo;

        if (file_exists($rutaArchivo)) {
            if (unlink($rutaArchivo)) {
                echo "success";
            } else {
                echo "error";
            }
        } else {
            echo "not_found";
        }
    } else {
        echo "invalid_file";
    }
} else {
    echo "invalid_request";
}
?>
