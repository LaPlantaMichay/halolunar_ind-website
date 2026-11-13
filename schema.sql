-- Schema de Base de Datos para Halo Lunar
USE u283509122_halolunar;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('cliente', 'admin') DEFAULT 'cliente',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS colecciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    imagen VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    coleccion_id INT,
    nombre VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255),
    FOREIGN KEY (coleccion_id) REFERENCES colecciones(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NULL,
    producto_id INT NULL,
    nombre_cliente VARCHAR(100) NOT NULL,
    email_cliente VARCHAR(150) NOT NULL,
    mensaje TEXT NOT NULL,
    respuesta TEXT NULL,
    estado ENUM('pendiente', 'respondido') DEFAULT 'pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_respuesta TIMESTAMP NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE SET NULL
);
