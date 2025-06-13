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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="landing-container">
        <header>
            <h1>Bienvenido a la Biblioteca Virtual</h1>
            <p>Accede a nuestra extensa colección de libros digitales</p>
        </header>
        
        <main>
            <div class="action-buttons">
                <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
                <a href="registro.php" class="btn btn-secondary">Registrarse</a>
            </div>
        </main>
        
        <footer>
            <p>&copy; <?= date('Y') ?> Biblioteca Virtual. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>
</html>