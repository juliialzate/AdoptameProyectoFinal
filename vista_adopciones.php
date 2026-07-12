<?php
include 'config.php';
include 'header.php';

$sql = "SELECT * FROM vista_adopciones";
$result = $conexion->query($sql);
?>

<div class="container mt-4">
    <div class="table-container">
        <div class="card-header" style="background: linear-gradient(135deg, #D6E8FF, #C4DBFF);">
            <h4><i class="fas fa-handshake" style="color: #4A6B8B;"></i> Personal de Adopciones</h4>
            <p class="mb-0" style="font-size: 0.9rem; color: #4A6B8B;">
                <i class="fas fa-info-circle"></i> Vista de adoptantes, solicitudes, disponibilidad y seguimiento
            </p>
        </div>
        <div class="p-3">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mascota</th>
                            <th>Adoptante</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Fecha Solicitud</th>
                            <th>Días</th>
                            <th>Estado Proceso</th>
                            <th>Estado Mascota</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): 
                            $badge_color = $row['estado_proceso'] == 'Aprobada' ? 'success' : 
                                          ($row['estado_proceso'] == 'En evaluación' ? 'warning' : 'secondary');
                        ?>
                        <tr>
                            <td><?php echo $row['id_adopcion']; ?></td>
                            <td><strong><?php echo $row['mascota']; ?></strong></td>
                            <td><?php echo $row['adoptante']; ?></td>
                            <td><?php echo $row['telefono']; ?></td>
                            <td><?php echo $row['correo_electronico']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['fecha_solicitud'])); ?></td>
                            <td><?php echo $row['dias_en_proceso'] ?? '—'; ?></td>
                            <td>
                                <span class="badge bg-<?php echo $badge_color; ?>">
                                    <?php echo $row['estado_proceso']; ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?php echo $row['estado_mascota'] == 'Disponible' ? 'badge-pastel-success' : 'badge-pastel-secondary'; ?>">
                                    <?php echo $row['estado_mascota'] ?? '—'; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="fas fa-info-circle fa-2x" style="color: #E8A0A0;"></i>
                                <p class="mt-2">No hay adopciones registradas</p>
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
CREATE OR REPLACE VIEW vista_adopciones AS
SELECT 
    a.id_adopcion,
    m.nombre as mascota,
    p.nombre as adoptante,
    p.telefono,
    p.correo_electronico,
    a.fecha_solicitud,
    a.fecha_entrega,
    ep.descripcion as estado_proceso,
    ea.descripcion as estado_mascota,
    s.descripcion as sexo,
    r.descripcion as raza,
    DATEDIFF(CURDATE(), a.fecha_solicitud) as dias_en_proceso
FROM Adopta a
JOIN Mascota m ON a.id_mascota = m.id_mascota
JOIN Persona p ON a.id_persona = p.id_persona
JOIN EstadoProcesoAdopcion ep ON a.id_estado_proceso = ep.id_estado_proceso
LEFT JOIN EstadoAdopcion ea ON m.id_estado_adopcion = ea.id_estado_adopcion
LEFT JOIN Sexo s ON m.id_sexo = s.id_sexo
LEFT JOIN Raza r ON m.id_raza = r.id_raza;
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>