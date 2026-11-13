<?php
require 'conexion.php';
include 'header.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario_id']     = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_email']  = $usuario['email'];
        $_SESSION['rol']            = $usuario['rol'];

        header("Location: colecciones.php");
        exit;
    } else {
        $mensaje = "Correo electrónico o contraseña incorrectos.";
    }
}
?>

<div class="titulo-seccion">
    <h2>Iniciar Sesión</h2>
</div>
<br>
<div style="max-width: 450px; margin: 0 auto; background: #f2f2f2; padding: 25px; border-radius: 8px; border: 1px solid darkslategray;">
    <?php if($mensaje): ?>
        <p style="color: red; font-weight: bold; margin-bottom: 15px; text-align: center;"><?php echo htmlspecialchars($mensaje); ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label>Correo Electrónico:</label>
        <input type="email" name="email" required placeholder="tu@email.com">
        <br><br>
        <label>Contraseña:</label>
        <input type="password" name="password" required placeholder="••••••••">
        <br><br>
        <button type="submit" class="btn" style="width: 100%;">Ingresar</button>
    </form>
    <br>
    <p style="font-size: 14px; text-align: center;">¿No tienes una cuenta? <a href="registro.php" style="color: cadetblue;">Regístrate aquí</a></p>
</div>

<?php include 'footer.php'; ?>
