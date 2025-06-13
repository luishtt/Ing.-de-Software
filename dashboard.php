<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$nombre = $_SESSION['nombre'];
$tipo_usuario = $_SESSION['tipo_usuario']; // 'admin' o 'usuario'
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
            <h1>Biblioteca Virtual</h1>
            <p>Bienvenido, <?php echo htmlspecialchars($nombre); ?>.</p>
        </div>
        <div class="content">
            <?php if ($tipo_usuario === 'admin'): ?>
                <a href="admin/gestion_usuarios.php" class="button primary">Gestión de Usuarios</a>
                <a href="admin/gestion_libros.php" class="button primary">Gestión de Libros</a>
                <a href="admin/gestion_prestamos.php" class="button primary">Gestión de Préstamos</a>
                <a href="admin/añadir.php" class="button primary">añadir libro</a>
            <?php else: ?>
                <a href="users/catalogo.php" class="button primary">Catálogo de Libros</a>
                <a href="users/mis_prestamos.php" class="button primary">Mis Préstamos</a>
                <a href="admin/añadir.php" class="button primary">añadir libro</a>
            <?php endif; ?>
            <a href="logout.php" class="button danger">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>
