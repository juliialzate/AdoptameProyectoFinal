<?php
// config.php - CONEXIÓN A LA BASE DE DATOS
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'adoptame';

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");

// ===== CONFIGURACIÓN PARA SUBIDA DE IMÁGENES =====
define('UPLOAD_DIR', 'uploads/mascotas/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5 MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
?>