<?php
require_once "config.php";

$mensajeExito = "El archivo se subió correctamente.";
$mensajeError = "Error al subir el archivo.";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_FILES["archivo"]["error"] == UPLOAD_ERR_OK) {
        $nombreArchivoOriginal = $_FILES["archivo"]["name"];
        $tipoArchivo = $_FILES["archivo"]["type"];
        $tamañoArchivo = $_FILES["archivo"]["size"];
        $nombreTemporal = $_FILES["archivo"]["tmp_name"];
        $extensionPermitida = array("jpg", "jpeg", "png", "gif", "pdf");
        $extension = strtolower(pathinfo($nombreArchivoOriginal, PATHINFO_EXTENSION));
        if (!in_array($extension, $extensionPermitida)) {
            $mensajeError = "Error: Solo se permiten archivos de imágenes (jpg, jpeg, png, gif) y archivos PDF.";
        } else {
            $nombreDeseado = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
            if (!$nombreDeseado) {
                $nombreDeseado = pathinfo($nombreArchivoOriginal, PATHINFO_FILENAME);
            }
            $nombreDeseado .= "." . $extension;
            $directorioDestino = DIR_UPLOAD;
            $rutaDestino = $directorioDestino . DIRECTORY_SEPARATOR . $nombreDeseado;
            if (move_uploaded_file($nombreTemporal, $rutaDestino)) {
            } else {
                $mensajeError = "Error al subir el archivo.";
            }
        }
    } else {
        $mensajeError = "Error al subir el archivo.";
    }
} else {
    header("Location: index.php");
}
echo "<script>alert('" . ($rutaDestino ? $mensajeExito : $mensajeError) . "');</script>";
echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 200);</script>";
exit();
