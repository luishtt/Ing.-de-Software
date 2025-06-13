<?php
// Inicia la sesión
session_start();

// Incluye la conexión a la base de datos
include 'includes/db.php';

// Verifica si el formulario se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene y valida los datos del formulario
    $email = $_POST['email'] ?? null;
    $contraseña = $_POST['contraseña'] ?? null;

    // Valida que los campos no estén vacíos
    if (!empty($email) && !empty($contraseña)) {
        try {
            // Consulta para buscar al usuario por email
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica si el usuario existe y la contraseña es correcta
            if ($usuario && password_verify($contraseña, $usuario['password'])) {
                // Inicia sesión guardando datos del usuario
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

                // Redirige según el tipo de usuario
                if ($usuario['tipo_usuario'] === 'admin') {
                    header("Location: dashboard.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit;
            } else {
                $error = "Credenciales inválidas. Por favor, verifica tu correo y contraseña.";
            }
        } catch (PDOException $e) {
            $error = "Error en la conexión a la base de datos: " . $e->getMessage();
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Iniciar Sesión</h1>
        </div>
        <div class="content">
            <?php if (!empty($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" placeholder="Correo Electrónico" required>
                
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
                
                <button type="submit" class="button primary">Iniciar Sesión</button>
            </form>
            <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>.</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 Biblioteca Virtual</p>
        </div>
    </div>
</body>
</html>
