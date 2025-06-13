<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php';

// Obtener información del usuario
try {
    $sql = "SELECT nombre, tipo_usuario FROM usuarios WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['usuario_id'], PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch();
    
    if (!$usuario) {
        session_destroy();
        header("Location: login.php");
        exit();
    }
    
    $nombre = $usuario['nombre'];
    $tipo_usuario = $usuario['tipo_usuario'];
} catch (PDOException $e) {
    die("Error al cargar datos del usuario: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Biblioteca Virtual</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Biblioteca Virtual</h1>
        <p>Bienvenido, <?= htmlspecialchars($nombre) ?></p>
    </header>
    
    <main>
        <?php if ($tipo_usuario === 'admin'): ?>
            <section class="admin-actions">
                <h2>Panel de Administración</h2>
                <div class="action-grid">
                    <a href="admin/gestion_usuarios.php" class="action-card">
                        <h3>Gestión de Usuarios</h3>
                    </a>
                    <a href="admin/gestion_libros.php" class="action-card">
                        <h3>Gestión de Libros</h3>
                    </a>
                    <a href="admin/gestion_prestamos.php" class="action-card">
                        <h3>Gestión de Préstamos</h3>
                    </a>
                </div>
            </section>
        <?php else: ?>
            <section class="user-actions">
                <h2>Acciones Disponibles</h2>
                <div class="action-grid">
                    <a href="catalogo.php" class="action-card">
                        <h3>Catálogo de Libros</h3>
                    </a>
                    <a href="mis_prestamos.php" class="action-card">
                        <h3>Mis Préstamos</h3>
                    </a>
                </div>
            </section>
        <?php endif; ?>
    </main>
    
    <footer>
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </footer>
</body>
</html>