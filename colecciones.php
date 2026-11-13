<?php
require 'conexion.php';
include 'header.php';

$colecciones = $pdo->query("SELECT * FROM colecciones")->fetchAll();
?>

<div class="titulo-seccion">
    <h2>Colecciones Disponibles</h2>
</div>
<br>

<div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center;">
    <?php foreach ($colecciones as $col): ?>
        <div style="border: 1px solid darkslategray; padding: 20px; border-radius: 8px; width: 300px; background: white; color: black; text-align: center;">
            <?php if (!empty($col['imagen'])): ?>
                <img src="<?php echo htmlspecialchars($col['imagen']); ?>" alt="<?php echo htmlspecialchars($col['nombre']); ?>" style="max-width: 100%; height: 180px; object-fit: cover; border-radius: 4px; margin-bottom: 15px;">
            <?php endif; ?>
            <h3 style="margin-bottom: 10px;"><?php echo htmlspecialchars($col['nombre']); ?></h3>
            <p style="font-size: 15px; color: #555; margin-bottom: 15px;"><?php echo htmlspecialchars($col['descripcion']); ?></p>
            <a href="coleccion.php?id=<?php echo $col['id']; ?>" class="btn">Ver Productos</a>
        </div>
    <?php endforeach; ?>
    <?php if (empty($colecciones)): ?>
        <p style="text-align: center; width: 100%;">No hay colecciones disponibles en este momento.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
