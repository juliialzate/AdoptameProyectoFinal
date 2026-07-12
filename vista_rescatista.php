<?php
include 'config.php';
include 'header.php';

$sql = "SELECT * FROM vista_rescatista";
$result = $conexion->query($sql);
?>

<div class="container mt-4">
    <div class="table-container">
        <div class="card-header" style="background: linear-gradient(135deg, #FFF5D6, #FFE8B8);">
            <h4><i class="fas fa-user-nurse" style="color: #8B7A3D;"></i> Rescatistas</h4>
            <p class="mb-0" style="font-size: 0.9rem; color: #8B7A3D;">
                <i class="fas fa-info-circle"></i> Mascotas asignadas, datos básicos y seguimiento de recuperación
            </p>
        </div>
        <div class="p-3">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Sexo</th>
                            <th>Raza</th>
                            <th>Edad</th>
                            <th>Estado</th>
                            <th>Fecha Rescate</th>
                            <th>Ubicación</th>
                            <th>Rescatista</th>
                            <th>Revisiones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): 
                            $badge_color = $row['estado_adopcion'] == 'Disponible' ? 'success' : 'warning';
                        ?>
                        <tr>
                            <td><?php echo $row['id_mascota']; ?></td>
                            <td><strong><?php echo $row['nombre']; ?></strong></td>
                            <td><?php echo $row['sexo'] ?? '—'; ?></td>
                            <td><?php echo $row['raza'] ?? '—'; ?></td>
                            <td><?php echo $row['edad'] ?? '—'; ?> años</td>
                            <td>
                                <span class="badge bg-<?php echo $badge_color; ?>">
                                    <?php echo $row['estado_adopcion']; ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($row['fecha_rescate'])); ?></td>
                            <td><?php echo $row['ubicacion_rescate'] ?? '—'; ?></td>
                            <td><?php echo $row['rescatista_asignado']; ?></td>
                            <td>
                                <span class="badge bg-info"><?php echo $row['total_revisiones'] ?? 0; ?></span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <i class="fas fa-info-circle fa-2x" style="color: #E8A0A0;"></i>
                                <p class="mt-2">No hay mascotas asignadas a rescatistas</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Mostrar SQL -->
            <div class="mt-4">
                <div class="card bg-light">
                    <div class="card-header bg-light">
                        <small class="text-muted">
                            <i class="fas fa-code"></i> SQL de esta vista:
                        </small>
                    </div>
                    <div class="card-body">
                        <pre style="background: #f8f9fa; padding: 15px; border-radius: 10px; font-size: 0.85rem; margin: 0; white-space: pre-wrap; word-break: break-all;">
CREATE OR REPLACE VIEW vista_rescatista AS
SELECT 
    m.id_mascota,
    m.nombre,
    s.descripcion as sexo,
    r.descripcion as raza,
    TIMESTAMPDIFF(YEAR, m.fecha_nacimiento, CURDATE()) as edad,
    ea.descripcion as estado_adopcion,
    re.fecha_rescate,
    re.ubicacion_resc