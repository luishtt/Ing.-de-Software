<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca Virtual</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenido a la Biblioteca Virtual</h1>
        </div>
        <div class="content">
            <p>Accede a nuestra colección de libros o gestiona tu cuenta.</p>
            <a href="login.php" class="button primary">Iniciar Sesión</a>
            <a href="registro.php" class="button primary">Registrarse</a>
        </div>
        <div class="footer">
            <p>&copy; 2025 Biblioteca Virtual</p>
        </div>
    </div>
</body>
</html>
