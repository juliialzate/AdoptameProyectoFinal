<?php
include 'config.php';
include 'header.php';

// ===== PROCESAR FORMULARIO =====
$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['guardar'])) {
    $nombre = trim($_POST['nombre']);
    $id_sexo = !empty($_POST['id_sexo']) ? intval($_POST['id_sexo']) : 'NULL';
    $id_raza = !empty($_POST['id_raza']) ? intval($_POST['id_raza']) : 'NULL';
    $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? "'" . $_POST['fecha_nacimiento'] . "'" : 'NULL';
    $id_estado_adopcion = !empty($_POST['id_estado_adopcion']) ? intval($_POST['id_estado_adopcion']) : 'NULL';
    
    // ===== PROCESAR IMAGEN =====
    $nombre_imagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $archivo = $_FILES['imagen'];
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        
        // Validar extensión
        if (in_array($extension, ALLOWED_EXTENSIONS)) {
            // Validar tamaño
            if ($archivo['size'] <= MAX_FILE_SIZE) {
                // Generar nombre único
                $nombre_imagen = time() . '_' . uniqid() . '.' . $extension;
                $ruta_destino = UPLOAD_DIR . $nombre_imagen;
                
                // Mover archivo
                if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
                    $mensaje = 'Imagen subida correctamente. ';
                    $tipo_mensaje = 'success';
                } else {
                    $mensaje = 'Error al subir la imagen. ';
                    $tipo_mensaje = 'danger';
                }
            } else {
                $mensaje = 'La imagen excede el tamaño máximo (5MB). ';
                $tipo_mensaje = 'warning';
            }
        } else {
            $mensaje = 'Formato de imagen no permitido. Use: JPG, PNG, GIF, WEBP. ';
            $tipo_mensaje = 'warning';
        }
    }
    
    // ===== GUARDAR EN BASE DE DATOS =====
    $imagen_sql = $nombre_imagen ? "'$nombre_imagen'" : 'NULL';
    
    $sql = "INSERT INTO Mascota (nombre, id_sexo, id_raza, fecha_nacimiento, id_estado_adopcion, imagen) 
            VALUES ('$nombre', $id_sexo, $id_raza, $fecha_nacimiento, $id_estado_adopcion, $imagen_sql)";
    
    if ($conexion->query($sql)) {
        $mensaje .= '✅ Mascota agregada correctamente';
        $tipo_mensaje = 'success';
    } else {
        $mensaje .= '❌ Error: ' . $conexion->error;
        $tipo_mensaje = 'danger';
    }
}
?>

<div class="container mt-4">
    <div class="table-container">
        <div class="card-header">
            <h4><i class="fas fa-plus-circle" style="color: #E8A0A0;"></i> Agregar Nueva Mascota</h4>
        </div>
        <div class="p-4">
            <?php if ($mensaje): ?>
            <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Nombre -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    
                    <!-- Sexo -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sexo</label>
                        <select name="id_sexo" class="form-select">
                            <option value="">Seleccione...</option>
                            <?php
                            $result = $conexion->query("SELECT * FROM Sexo");
                            while($row = $result->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['id_sexo']; ?>">
                                <?php echo $row['descripcion']; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <!-- Raza -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Raza</label>
                        <select name="id_raza" class="form-select">
                            <option value="">Seleccione...</option>
                            <?php
                            $result = $conexion->query("SELECT * FROM Raza");
                            while($row = $result->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['id_raza']; ?>">
                                <?php echo $row['descripcion']; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <!-- Fecha Nacimiento -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fecha Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="form-control">
                    </div>
                    
                    <!-- Estado Adopción -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado Adopción</label>
                        <select name="id_estado_adopcion" class="form-select">
                            <option value="">Seleccione...</option>
                            <?php
                            $result = $conexion->query("SELECT * FROM EstadoAdopcion");
                            while($row = $result->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['id_estado_adopcion']; ?>">
                                <?php echo $row['descripcion']; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <!-- Imagen -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Foto de la Mascota</label>
                        <input type="file" name="imagen" class="form-control" accept="image/*">
                        <small class="text-muted">Formatos: JPG, PNG, GIF, WEBP. Máx: 5MB</small>
                    </div>
                    
                    <!-- Botones -->
                    <div class="col-12 mt-3">
                        <button type="submit" name="guardar" class="btn btn-pastel-success">
                            <i class="fas fa-save"></i> Guardar Mascota
                        </button>
                        <a href="mascotas.php" class="btn btn-pastel-primary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>