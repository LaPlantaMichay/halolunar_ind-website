<?php
require 'conexion.php';
include 'header.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    echo "<div class='titulo-seccion'><h2>Acceso Denegado</h2></div>";
    echo "<p style='text-align:center; margin-top:20px;'>No tienes permisos para acceder a este panel.</p>";
    include 'footer.php';
    exit;
}

$msg_col = "";
$msg_prod = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_coleccion'])) {
    $nombre = trim($_POST['nombre_col']);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nombre)));
    $descripcion = trim($_POST['desc_col']);

    $stmt = $pdo->prepare("INSERT INTO colecciones (nombre, slug, descripcion) VALUES (?, ?, ?)");
    if ($stmt->execute([$nombre, $slug, $descripcion])) {
        $msg_col = "Colección creada con éxito.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_producto'])) {
    $coleccion_id = (int)$_POST['coleccion_id'];
    $nombre = trim($_POST['nombre_prod']);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nombre)));
    $precio = (float)$_POST['precio_prod'];
    $descripcion = trim($_POST['desc_prod']);

    $ruta_imagen = "img/default.jpg";
    if (isset($_FILES['imagen_prod']) && $_FILES['imagen_prod']['error'] === UPLOAD_ERR_OK) {
        if (!file_exists('img')) {
            mkdir('img', 0777, true);
        }
        $nombre_img = time() . '_' . basename($_FILES['imagen_prod']['name']);
        $destino = "img/" . $nombre_img;
        if (move_uploaded_file($_FILES['imagen_prod']['tmp_name'], $destino)) {
            $ruta_imagen = $destino;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO productos (coleccion_id, nombre, slug, precio, descripcion, imagen) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$coleccion_id, $nombre, $slug, $precio, $descripcion, $ruta_imagen])) {
        $msg_prod = "Producto añadido con éxito.";
    }
}

$colecciones = $pdo->query("SELECT * FROM colecciones")->fetchAll();
?>

<div class="titulo-seccion">
    <h2>Panel de Administración - Catálogo</h2>
</div>
<br>

<div style="display: flex; flex-wrap: wrap; gap: 40px; justify-content: center;">
    <div style="flex: 1; min-width: 300px; background: #f2f2f2; padding: 25px; border-radius: 8px; border: 1px solid darkslategray; color: black;">
        <h3>Añadir Colección</h3>
        <?php if($msg_col): ?><p style="color: darkslategray; font-weight: bold; margin: 10px 0;"><?php echo htmlspecialchars($msg_col); ?></p><?php endif; ?>
        <form action="admin_catalogo.php" method="POST">
            <label>Nombre:</label>
            <input type="text" name="nombre_col" required>
            <br><br>
            <label>Descripción:</label>
            <textarea name="desc_col" rows="3"></textarea>
            <br><br>
            <button type="submit" name="crear_coleccion" class="btn">Guardar Colección</button>
        </form>
    </div>

    <div style="flex: 1; min-width: 300px; background: #f2f2f2; padding: 25px; border-radius: 8px; border: 1px solid darkslategray; color: black;">
        <h3>Añadir Producto</h3>
        <?php if($msg_prod): ?><p style="color: darkslategray; font-weight: bold; margin: 10px 0;"><?php echo htmlspecialchars($msg_prod); ?></p><?php endif; ?>
        <form action="admin_catalogo.php" method="POST" enctype="multipart/form-data">
            <label>Colección:</label>
            <select name="coleccion_id" required>
                <option value="">Seleccione...</option>
                <?php foreach ($colecciones as $col): ?>
                    <option value="<?php echo $col['id']; ?>"><?php echo htmlspecialchars($col['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <label>Nombre:</label>
            <input type="text" name="nombre_prod" required>
            <br><br>
            <label>Precio:</label>
            <input type="number" step="0.01" name="precio_prod" required>
            <br><br>
            <label>Imagen:</label>
            <input type="file" name="imagen_prod" accept="image/*">
            <br><br>
            <label>Descripción:</label>
            <textarea name="desc_prod" rows="3"></textarea>
            <br><br>
            <button type="submit" name="crear_producto" class="btn">Guardar Producto</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
