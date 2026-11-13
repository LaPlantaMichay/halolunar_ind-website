<?php
require 'conexion.php';
include 'header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT p.*, c.nombre AS coleccion_nombre FROM productos p LEFT JOIN colecciones c ON p.coleccion_id = c.id WHERE p.id = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch();

if (!$producto) {
    echo "<p style='text-align: center;'>Producto no encontrado.</p>";
    include 'footer.php';
    exit;
}

$mensaje_consulta = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar_consulta'])) {
    $nombre  = trim($_POST['nombre']);
    $email   = trim($_POST['email']);
    $mensaje = trim($_POST['mensaje']);
    $user_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : NULL;

    $stmtInsert = $pdo->prepare("INSERT INTO consultas (usuario_id, producto_id, nombre_cliente, email_cliente, mensaje) VALUES (?, ?, ?, ?, ?)");
    if ($stmtInsert->execute([$user_id, $id, $nombre, $email, $mensaje])) {
        $mensaje_consulta = "¡Consulta enviada con éxito! Te responderemos a la brevedad.";
    } else {
        $mensaje_consulta = "Ocurrió un error al enviar la consulta.";
    }
}
?>

<div class="titulo-seccion">
    <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
</div>
<br>
<div class="contenido" style="padding: 30px; border-radius: 8px;">
    <div style="flex: 1; text-align: center;">
        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" style="max-width: 100%; max-height: 400px; border-radius: 8px;">
    </div>
    <div style="flex: 1;">
        <p><strong>Colección:</strong> <?php echo htmlspecialchars($producto['coleccion_nombre']); ?></p>
        <p style="margin-top: 10px; font-size: 24px; font-weight: bold;">Precio: $<?php echo number_format($producto['precio'], 2); ?></p>
        <p style="margin-top: 15px;"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
    </div>
</div>

<br><hr><br>

<div style="max-width: 600px; margin: 0 auto; background: #f9f9f9; padding: 25px; border-radius: 8px; border: 1px solid darkslategray; color: black;">
    <h3 style="text-align: center; margin-bottom: 15px;">Consultar sobre este producto</h3>
    <?php if ($mensaje_consulta): ?>
        <p style="color: darkslategray; font-weight: bold; text-align: center; margin-bottom: 15px;"><?php echo htmlspecialchars($mensaje_consulta); ?></p>
    <?php endif; ?>
    <form action="producto.php?id=<?php echo $id; ?>" method="POST">
        <label>Tu Nombre:</label>
        <input type="text" name="nombre" required value="<?php echo isset($_SESSION['usuario_nombre']) ? htmlspecialchars($_SESSION['usuario_nombre']) : ''; ?>">
        <br><br>
        <label>Tu Email:</label>
        <input type="email" name="email" required value="<?php echo isset($_SESSION['usuario_email']) ? htmlspecialchars($_SESSION['usuario_email']) : ''; ?>">
        <br><br>
        <label>Mensaje / Consulta:</label>
        <textarea name="mensaje" rows="4" required></textarea>
        <br><br>
        <button type="submit" name="enviar_consulta" class="btn">Enviar Consulta</button>
    </form>
</div>

<?php include 'footer.php'; ?>
