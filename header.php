<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halo Lunar - Indumentaria Musiquera</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        Halo Lunar
    </header>
    <div id="navbar">
        <div id="navbarList">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="colecciones.php">Colecciones</a></li>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                    <li><a href="admin_catalogo.php">Admin Catálogo</a></li>
                    <li><a href="admin_consultas.php">Consultas / Tickets</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['usuario_nombre'])): ?>
                    <li><a href="#">Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></a></li>
                    <li class="nav-right"><a href="logout.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li class="nav-right"><a href="login.php">Iniciar Sesión</a></li>
                    <li><a href="registro.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <main style="padding: 30px; width: 100%; max-width: 1200px; margin: 0 auto;">
