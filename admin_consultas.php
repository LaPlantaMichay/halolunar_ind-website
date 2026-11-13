<?php
require 'conexion.php';
include 'header.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    echo "<div class='titulo-seccion'><h2>Acceso Denegado</h2></div>";
    echo "<p style='text-align:center; margin-top:20px;'>No tienes permisos para acceder a este panel de consultas.</p>";
    include 'footer.php';
    exit;
}

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['responder_consulta'])) {
    $consulta_id = (int)$_POST['consulta_id'];
    $respuesta   = trim($_POST['respuesta']);
    $email_to    = trim($_POST['email_cliente']);
    $nombre_to   = trim($_POST['nombre_cliente']);

    $stmt = $pdo->prepare("UPDATE consultas SET respuesta = ?, estado = 'respondido', fecha_respuesta = CURRENT_TIMESTAMP WHERE id = ?");
    if ($stmt->execute([$respuesta, $consulta_id])) {
        $asunto = "Respuesta a tu consulta - Halo Lunar";
        $cuerpo = "Hola " . htmlspecialchars($nombre_to) . ",\n\nGracias por consultarnos. Aquí tienes la respuesta:\n\n" . $respuesta;
        $headers = "From: no-reply@halolunar.com";
        
        @mail($email_to, $asunto, $cuerpo, $headers);
        $msg = "Respuesta guardada y enviada correctamente.";
    }
}

$consultas = $pdo->query("SELECT c.*, p.nombre AS producto_nombre FROM consultas c LEFT JOIN productos p ON c.producto_id = p.id ORDER BY c.fecha_creacion DESC")->fetchAll();
?>

<div class="titulo-seccion">
    <h2>Gestión de Consultas y Presupuestos</h2>
</div>
<br>

<?php if($msg): ?>
    <p style="text-align: center; font-weight: bold; color: darkslategray; margin-bottom: 20px;"><?php echo htmlspecialchars($msg); ?></p>
<?php endif; ?>

<div style="overflow-x: auto;">
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; background: white; color: black;">
        <thead>
            <tr style="background: darkslategray; color: white;">
                <th>ID</th>
                <th>Cliente</th>
                <th>Email</th>
                <th>Producto</th>
                <th>Mensaje</th>
                <th>Estado</th>
                <th>Acción / Respuesta</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consultas as $c): ?>
                <tr>
                    <td>#<?php echo $c['id']; ?></td>
                    <td><strong><?php echo htmlspecialchars($c['nombre_cliente']); ?></strong></td>
                    <td><?php echo htmlspecialchars($c['email_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($c['producto_nombre'] ?? 'General'); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($c['mensaje'])); ?></td>
                    <td><strong><?php echo strtoupper($c['estado']); ?></strong></td>
                    <td>
                        <?php if ($c['estado'] === 'pendiente'): ?>
                            <form action="admin_consultas.php" method="POST">
                                <input type="hidden" name="consulta_id" value="<?php echo $c['id']; ?>">
                                <input type="hidden" name="email_cliente" value="<?php echo htmlspecialchars($c['email_cliente']); ?>">
                                <input type="hidden" name="nombre_cliente" value="<?php echo htmlspecialchars($c['nombre_cliente']); ?>">
                                <textarea name="respuesta" rows="3" required placeholder="Escribe tu respuesta..."></textarea>
                                <br>
                                <button type="submit" name="responder_consulta" class="btn" style="padding: 5px 10px; font-size: 14px; margin-top: 5px;">Enviar</button>
                            </form>
                        <?php else: ?>
                            <em>Respondido:</em><br><?php echo nl2br(htmlspecialchars($c['respuesta'])); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($consultas)): ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No hay consultas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
