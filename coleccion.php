<?php
require 'conexion.php';
include 'header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: colecciones.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM colecciones WHERE id = ?");
$stmt->execute([$id]);
$coleccion = $stmt->fetch();

if (!$coleccion) {
    echo "<p style='text-align: center;'>Colección no encontrada.</p>";
    include 'footer.php';
    exit;
}

$stmtProd = $pdo->prepare("SELECT * FROM productos WHERE coleccion_id = ?");
$stmtProd->execute([$id]);
$productos = $stmtProd->fetchAll();
?>

<div class="titulo-seccion">
    <h2>Colección: <?php echo htmlspecialchars($coleccion['nombre']); ?></h2>
</div>
<p style="text-align: center; margin-top: 15px;"><?php echo htmlspecialchars($coleccion['descripcion']); ?></p>
<br><hr><br>

<div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center;">
    <?php foreach ($productos as $prod): ?>
        <div style="border: 1px solid darkslategray; border-radius: 8px; width: 260px; padding: 15px; background: white; text-align: center;">
            <div class="divImagen">
                <img src="<?php echo htmlspecialchars($prod['imagen']); ?>" alt="<?php echo htmlspecialchars($prod['nombre']); ?>" class="imagenCarrusel" style="max-width: 100%; height: auto;">
            </div>
            <h3 style="margin-top: 10px;"><?php echo htmlspecialchars($prod['nombre']); ?></h3>
            <p style="margin: 10px 0; font-weight: bold;">Precio: $<?php echo number_format($prod['precio'], 2); ?></p>
            <a href="producto.php?id=<?php echo $prod['id']; ?>" class="btn">Ver Detalle</a>
        </div>
    <?php endforeach; ?>
    <?php if (empty($productos)): ?>
        <p style="text-align: center; width: 100%;">No hay productos en esta colección.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
