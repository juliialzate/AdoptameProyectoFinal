<?php
include 'config.php';
include 'header.php';

// ===== OBTENER ID =====
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id == 0) {
    header('Location: mascotas.php');
    exit;
}

// ===== OBTENER DATOS DE LA MASCOTA =====
$sql = "SELECT * FROM Mascota WHERE id_mascota = $id";
$result = $conexion->query($sql);
$mascota = $result->fetch_assoc();

if (!$mascota) {
    header('Location: mascotas.php');
    exit;
}

// ===== PROCESAR FORMULARIO =====
$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar'])) {
    $nombre = trim($_POST['nombre']);
    $id_sexo = !empty($_POST['id_sexo']) ? intval($_POST['id_sexo']) : 'NULL';
    $id_raza = !empty($_POST['id_raza']) ? intval($_POST['id_raza']) : 'NULL';
    $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? "'" . $_POST['fecha_nacimiento'] . "'" : 'NULL';
    $id_estado_adopcion = !empty($_POST['id_estado_adopcion']) ? intval($_POST['id_estado_adopcion']) : 'NULL';
    
    // ===== PROCESAR NUEVA IMAGEN =====
    $nombre_imagen = $mascota['imagen']; // Mantener imagen actual por defecto
    $eliminar_imagen = isset($_POST['eliminar_imagen']) ? true : false;
    
    if ($eliminar_imagen && $mascota['imagen']) {
        // Eliminar imagen actual
        $ruta_imagen = UPLOAD_DIR . $mascota['imagen'];
        if (file_exists($ruta_imagen)) {
            unlink($ruta_imagen);
        }
        $nombre_imagen = NULL;
    }
    
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $archivo = $_FILES['imagen'];
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        
        if (in_array($extension, ALLOWED_EXTENSIONS) && $archivo['size'] <= MAX_FILE_SIZE) {
            // Eliminar imagen anterior si existe
            if ($mascota['imagen'] && file_exists(UPLOAD_DIR . $mascota['imagen'])) {
                unlink(UPLOAD_DIR . $mascota['imagen']);
            }
            
            // Subir nueva imagen
            $nombre_imagen = time() . '_' . uniqid() . '.' . $extension;
            move_uploaded_file($archivo['tmp_name'], UPLOAD_DIR . $nombre_imagen);
            $mensaje = 'Imagen actualizada. ';
            $tipo_mensaje = 'success';
        } else {
            $mensaje = 'Error con la imagen. ';
            $tipo_mensaje = 'warning';
        }
    }
    
    // ===== ACTUALIZAR EN BASE DE DATOS =====
    $imagen_sql = $nombre_imagen ? "'$nombre_imagen'" : 'NULL';
    
    $sql = "UPDATE Mascota SET 
            nombre = '$nombre',
            id_sexo = $id_sexo,
            id_raza = $id_raza,
            fecha_nacimiento = $fecha_nacimiento,
            id_estado_adopcion = $id_estado_adopcion,
            imagen = $imagen_sql
            WHERE id_mascota = $id";
    
    if ($conexion->query($sql)) {
        $mensaje .= '✅ Mascota actualizada correctamente';
        $tipo_mensaje = 'success';
        // Recargar datos
        $result = $conexion->query("SELECT * FROM Mascota WHERE id_mascota = $id");
        $mascota = $result->fetch_assoc();
    } else {
        $mensaje .= '❌ Error: ' . $conexion->error;
        $tipo_mensaje = 'danger';
    }
}
?>

<div class="container mt-4">
    <div class="table-container">
        <div class="card-header">
            <h4><i class="fas fa-edit" style="color: #E8A0A0;"></i> Editar Mascota</h4>
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
                        <input type="text" name="nombre" class="form-control" 
                               value="<?php echo $mascota['nombre']; ?>" required>
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
                            <option value="<?php echo $row['id_sexo']; ?>" 
                                    <?php echo ($mascota['id_sexo'] == $row['id_sexo']) ? 'selected' : ''; ?>>
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
                            <option value="<?php echo $row['id_raza']; ?>"
                                    <?php echo ($mascota['id_raza'] == $row['id_raza']) ? 'selected' : ''; ?>>
                                <?php echo $row['descripcion']; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <!-- Fecha Nacimiento -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fecha Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="form-control" 
                               value="<?php echo $mascota['fecha_nacimiento']; ?>">
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
                            <option value="<?php echo $row['id_estado_adopcion']; ?>"
                                    <?php echo ($mascota['id_estado_adopcion'] == $row['id_estado_adopcion']) ? 'selected' : ''; ?>>
                                <?php echo $row['descripcion']; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <!-- Imagen Actual -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Imagen Actual</label>
                        <div>
                            <?php if ($mascota['imagen'] && file_exists(UPLOAD_DIR . $mascota['imagen'])): ?>
                            <img src="<?php echo UPLOAD_DIR . $mascota['imagen']; ?>" 
                                 style="max-width: 150px; max-height: 150px; border-radius: 10px; border: 2px solid #FFD4D4;">
                            <div class="mt-2">
                                <div class="form-check">
                                    <input type="checkbox" name="eliminar_imagen" class="form-check-input" id="eliminarImagen">
                                    <label class="form-check-label text-danger" for="eliminarImagen">
                                        <i class="fas fa-trash"></i> Eliminar imagen actual
                                    </label>
                                </div>
                            </div>
                            <?php else: ?>
                            <p class="text-muted">No hay imagen</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Nueva Imagen -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cambiar Foto</label>
                        <input type="file" name="imagen" class="form-control" accept="image/*">
                        <small class="text-muted">Formatos: JPG, PNG, GIF, WEBP. Máx: 5MB</small>
                    </div>
                    
                    <!-- Botones -->
                    <div class="col-12 mt-3">
                        <button type="submit" name="actualizar" class="btn btn-pastel-success">
                            <i class="fas fa-save"></i> Actualizar Mascota
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