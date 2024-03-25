<?php
require_once "login_helper.php";
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $usuario = autentificar($username, $password);

    if ($usuario !== false) {
        $_SESSION['usuario'] = $usuario;
        header("Location: index.php");
        exit();
    } else {
        $error = "Nombre de usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilosInicio.css">
    <title>Iniciar Sesión</title>
</head>
<body>
    <div class="form">
        <h1>Iniciar Sesión</h1>
        <?php if (isset($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="username">Usuario:</label>
            <input type="text" name="username" id="username"><br>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password"><br>
            <input type="submit" class="submit" value="Iniciar Sesión">
        </form>
    </div>
</body>
</html>
