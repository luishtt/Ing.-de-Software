<?php
session_start();
include 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    
    if (!empty($nombre) && !empty($email) && !empty($password)) {
        if (strlen($password) < 8) {
            $error = "La contraseña debe tener al menos 8 caracteres";
        } else {
            try {
                // Verificar si el email ya existe
                $sql = "SELECT id FROM usuarios WHERE email = :email";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    $error = "El correo electrónico ya está registrado";
                } else {
                    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                    
                    $sql = "INSERT INTO usuarios (nombre, email, password) 
                            VALUES (:nombre, :email, :password)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
                    
                    if ($stmt->execute()) {
                        $_SESSION['registro_exitoso'] = true;
                        header("Location: login.php");
                        exit();
                    }
                }
            } catch (PDOException $e) {
                $error = "Error en el registro: " . $e->getMessage();
            }
        }
    } else {
        $error = "Todos los campos son obligatorios";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Biblioteca Virtual</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="register-container">
        <h1>Registro de Usuario</h1>
        
        <?php if (!empty($error)): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña (mínimo 8 caracteres)</label>
                <input type="password" id="password" name="password" minlength="8" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
        
        <p class="text-center">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
</body>
</html>