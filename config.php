<?php
// ============================================
// CONFIGURACIÓN DE LA BASE DE DATOS
// ============================================

// Configuración de tiempo de espera (evita errores)
ini_set('max_execution_time', 300);
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);

// Mostrar errores (para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ============================================
// DATOS DE CONEXIÓN A MySQL
// ============================================
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'adoptame';

// ============================================
// CREAR LA CONEXIÓN
// ============================================
$conexion = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("❌ Error de conexión a la base de datos: " . $conexion->connect_error . 
        "<br><br>Verifica que MySQL esté corriendo en XAMPP.");
}

// Configurar charset para caracteres especiales
$conexion->set_charset("utf8");

// ============================================
// CONFIGURACIÓN PARA SUBIDA DE IMÁGENES
// ============================================
define('UPLOAD_DIR', 'uploads/mascotas/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5 MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// ============================================
// MENSAJE DE ÉXITO (solo para pruebas)
// ============================================
// echo "✅ Conexión exitosa a la base de datos 'adoptame'";
?>