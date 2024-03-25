<?php
require_once "login_helper.php";
require  "config.php";
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
$usuario = $_SESSION['usuario'];
$esAdmin = $usuario['esAdmin'];
function listarArchivos($esAdmin) {
    $archivos = scandir(DIR_UPLOAD);
    $archivos = array_diff($archivos, array('.', '..'));
    echo '<table>';
    echo '<tr><th>Nombre del Archivo</th><th>Tamaño del Archivo (KB)</th>';
    if ($esAdmin) {
        echo '<th>Borrar</th>';
    }
    echo '</tr>';
    foreach ($archivos as $archivo) {
        $rutaArchivo = DIR_UPLOAD .  DIRECTORY_SEPARATOR . $archivo;
        $tamaño = filesize($rutaArchivo) / 1024; 
        echo '<tr id="' . $archivo . '">';
        echo '<td><a href="archivo.php?nombre=' . urlencode($archivo) . '" target="_blank">' . $archivo . '</a></td>';
        echo '<td>' . round($tamaño, 2) . ' KB</td>';
        if ($esAdmin) {
            echo '<td><button onclick="borrarArchivo(\'' . $archivo . '\')">Borrar</button></td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Archivos</title>
    <link rel="stylesheet" href="estilosAdmin.css">
    <script>
    function borrarArchivo(nombreArchivo) {
        if (confirm("¿Está seguro que desea borrar " + nombreArchivo + "?")) {
            // Realizar petición AJAX para borrar archivo
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "borrar.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Eliminar fila de la tabla
                    var fila = document.getElementById(nombreArchivo);
                    fila.parentNode.removeChild(fila);
                    // Mostrar mensaje de éxito
                    alert("El archivo " + nombreArchivo + " ha sido eliminado correctamente.");
                }
            };
            xhr.send("archivo=" + nombreArchivo);
        }
    }
</script>
</head>
<body>
    <div class="menu">
        <p>Bienvenido, <?php echo $usuario['nombre']; ?></p>
        <a href="logout.php">Cerrar Sesión<ion-icon name="log-out-outline" class="icono"></ion-icon></a>
    </div><br>
    <?php listarArchivos($esAdmin); ?>
    <?php if ($esAdmin): ?>
    <div class="form">
        <h2>Subir Archivo</h2>
        <form action="subir.php" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre del Archivo (opcional):</label>
            <input type="text" name="nombre" id="nombre"><br>
            <label for="archivo">Seleccionar Archivo:</label>
            <input type="file" name="archivo" id="archivo"><br>
            <input type="submit" value="Subir Archivo" class="submit">
        </form>
    </div>
    <?php endif; ?>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
|   <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
