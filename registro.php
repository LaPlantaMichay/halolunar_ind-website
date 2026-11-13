<?php
require 'conexion.php';
include 'header.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        $mensaje = "El correo electrónico ya está registrado.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$nombre, $email, $password])) {
            $mensaje = "¡Registro exitoso! Ya puedes iniciar sesión.";
        } else {
            $mensaje = "Error al registrar el usuario.";
        }
    }
}
?>

<div class="titulo-seccion">
    <h2>Registro de Usuario</h2>
</div>
<br>
<div style="max-width: 500px; margin: 0 auto; background: #f2f2f2; padding: 25px; border-radius: 8px; border: 1px solid darkslategray;">
    <?php if($mensaje): ?>
        <p style="color: darkslategray; font-weight: bold; margin-bottom: 15px; text-align: center;"><?php echo htmlspecialchars($mensaje); ?></p>
    <?php endif; ?>
    <form action="registro.php" method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" required placeholder="Tu nombre">
        <br><br>
        <label>Email:</label>
        <input type="email" name="email" required placeholder="tu@email.com">
        <br><br>
        <label>Contraseña:</label>
        <input type="password" name="password" required placeholder="••••••••">
        <br><br>
        <button type="submit" class="btn" style="width: 100%;">Registrarse</button>
    </form>
    <br>
    <p style="font-size: 14px; text-align: center;">¿Ya tienes una cuenta? <a href="login.php" style="color: cadetblue;">Inicia sesión aquí</a></p>
</div>

<?php include 'footer.php'; ?>
