<?php
// Incluye la conexión a la base de datos
include 'includes/db.php';

// Inicia la sesion para manejar los usuarios
session_start();

// Verifica si se envio del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos del formulario con seguridad
    $nombre = $_POST['nombre'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    // Valida que todos los campos estén completos
    if (!empty($nombre) && !empty($email) && !empty($password)) {
        try {
            // Genera el hash de la contraseña
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Consulta SQL para insertar el usuario
            $sql = "INSERT INTO usuarios (nombre, email, password, tipo_usuario) 
                    VALUES (:nombre, :email, :password, 'usuario')";
            $stmt = $conn->prepare($sql);

            // Ejecuta la consulta con los parametros
            $stmt->execute([
                ':nombre' => $nombre,
                ':email' => $email,
                ':password' => $passwordHash
            ]);

            // Redirige al usuario al inicio de sesión o muestra un mensaje de exito
            echo "Registro exitoso. <a href='login.php'>Inicia sesión aquí</a>";
        } catch (PDOException $e) {
            // Maneja errores de la base de datos
            echo "Error en el registro: " . $e->getMessage();
        }
    } else {
        // Muestra un mensaje si faltan campos
        echo "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Registro de Usuario</h1>
        </div>
        <div class="content">
            <form action="registro.php" method="POST">
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="email" name="email" placeholder="Correo Electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit" class="button primary">Registrarse</button>
            </form>
            <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a>.</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 Biblioteca Virtual</p>
        </div>
    </div>
</body>
</html>
