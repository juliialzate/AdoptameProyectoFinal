<?php
include 'config.php';
include 'header.php';

// ===== ELIMINAR MASCOTA (desde aquí) =====
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    
    // Obtener nombre de la imagen para eliminarla del servidor
    $result = $conexion->query("SELECT imagen FROM Mascota WHERE id_mascota = $id");
    $row = $result->fetch_assoc();
    
    if ($row && $row['imagen']) {
        $ruta_imagen = UPLOAD_DIR . $row['imagen'];
        if (file_exists($ruta_imagen)) {
            unlink($ruta_imagen); // Eliminar archivo físico
        }
    }
    
    // Eliminar de la base de datos
    $conexion->query("DELETE FROM Mascota WHERE id_mascota = $id");
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> Mascota eliminada correctamente
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>';
}
?>

<div class="container mt-4">
    <div class="table-container">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4><i class="fas fa-dog" style="color: #E8A0A0;"></i> Lista de Mascotas</h4>
            <a href="mascota_agregar.php" class="btn btn-pastel-success">
                <i class="fas fa-plus"></i> Agregar Mascota
            </a>
        </div>
        <div class="p-3">
            <!-- Filtro por estado -->
            <div class="mb-3">
                <label class="form-label">Filtrar por estado:</label>
                <select class="form-select w-auto d-inline-block" onchange="window.location.href='mascotas.php?estado='+this.value">
                    <option value="">Todos</option>
                    <?php
                    $result = $conexion->query("SELECT * FROM EstadoAdopcion");
                    while($row = $result->fetch_assoc()):
                    ?>
                    <option value="<?php echo $row['id_estado_adopcion']; ?>" <?php echo (isset($_GET['estado']) && $_GET['estado'] == $row['id_estado_adopcion']) ? 'selected' : ''; ?>>
                        <?php echo $row['descripcion']; ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th style="width: 80px;">Foto</th>
                            <th>Nombre</th>
                            <th>Sexo</th>
                            <th>Raza</th>
                            <th>Fecha Nac.</th>
                            <th>Estado</th>
                            <th style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $where = '';
                        if (isset($_GET['estado']) && $_GET['estado'] != '') {
                            $where = "WHERE m.id_estado_adopcion = " . intval($_GET['estado']);
                        }
                        
                        $sql = "SELECT m.id_mascota, m.nombre, m.fecha_nacimiento, m.imagen,
                                       s.descripcion as sexo, r.descripcion as raza, e.descripcion as estado
                                FROM Mascota m
                                LEFT JOIN Sexo s ON m.id_sexo = s.id_sexo
                                LEFT JOIN Raza r ON m.id_raza = r.id_raza
                                LEFT JOIN EstadoAdopcion e ON m.id_estado_adopcion = e.id_estado_adopcion
                                $where
                                ORDER BY m.id_mascota DESC";
                        
                        $result = $conexion->query($sql);
                        
                        if ($result->num_rows == 0) {
                            echo '<tr><td colspan="8" class="text-center py-4">
                                    <i class="fas fa-dog fa-2x" style="color: #E8A0A0;"></i>
                                    <p class="mt-2">No hay mascotas registradas</p>
                                  </td></tr>';
                        }
                        
                        while($row = $result->fetch_assoc()):
                            $badge_class = $row['estado'] == 'Disponible' ? 'badge-pastel-success' : 
                                          ($row['estado'] == 'En proceso' ? 'badge-pastel-warning' : 'badge-pastel-secondary');
                            
                            // Ruta de imagen
                            $imagen = ($row['imagen'] && file_exists(UPLOAD_DIR . $row['imagen'])) 
                                    ? UPLOAD_DIR . $row['imagen'] 
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($row['nombre']) . '&background=FFD4D4&color=8B5A6B&size=60';
                        ?>
                        <tr>
                            <td><?php echo $row['id_mascota']; ?></td>
                            <td>
                                <img src="<?php echo $imagen; ?>" 
                                     alt="<?php echo $row['nombre']; ?>" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #FFD4D4;">
                            </td>
                            <td><strong><?php echo $row['nombre']; ?></strong></td>
                            <td><?php echo $row['sexo'] ?: '—'; ?></td>
                            <td><?php echo $row['raza'] ?: '—'; ?></td>
                            <td><?php echo $row['fecha_nacimiento'] ? date('d/m/Y', strtotime($row['fecha_nacimiento'])) : '—'; ?></td>
                            <td>
                                <span class="badge <?php echo $badge_class; ?>">
                                    <?php echo $row['estado'] ?: 'Sin estado'; ?>
                                </span>
                            </td>
                            <td>
                                <a href="mascota_editar.php?id=<?php echo $row['id_mascota']; ?>" 
                                   class="btn btn-sm btn-pastel-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="mascotas.php?eliminar=<?php echo $row['id_mascota']; ?>" 
                                   class="btn btn-sm btn-pastel-danger" title="Eliminar"
                                   onclick="return confirm('¿Estás seguro de eliminar esta mascota?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.btn-pastel-danger {
    background: #FFD9D9;
    color: #8B4A4A;
    border: none;
    border-radius: 20px;
    padding: 5px 15px;
    transition: all 0.3s;
}
.btn-pastel-danger:hover {
    background: #FFC8C8;
    color: #6B3A3A;
    transform: scale(1.05);
}
</style>

<?php include 'footer.php'; ?>