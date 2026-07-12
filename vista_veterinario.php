<?php
include 'config.php';
include 'header.php';

$sql = "SELECT * FROM vista_veterinario";
$result = $conexion->query($sql);
?>

<div class="container mt-4">
    <div class="table-container">
        <div class="card-header" style="background: linear-gradient(135deg, #D4F5D4, #B8E8B8);">
            <h4><i class="fas fa-user-md" style="color: #3D7A4A;"></i> Personal Veterinario</h4>
            <p class="mb-0" style="font-size: 0.9rem; color: #3D7A4A;">
                <i class="fas fa-info-circle"></i> Mascotas con información de salud, tratamientos e historial médico
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
                            <th>Última Revisión</th>
                            <th>Diagnóstico</th>
                            <th>Vacunas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): 
                            $badge_color = $row['estado_adopcion'] == 'Disponible' ? 'success' : 
                                          ($row['estado_adopcion'] == 'En proceso' ? 'warning' : 'secondary');
                        ?>
                        <tr>
                            <td><?php echo $row['id_mascota']; ?></td>
                            <td><strong><?php echo $row['nombre']; ?></strong></td>
                            <td><?php echo $row['sexo'] ?? '—'; ?></td>
                            <td><?php echo $row['raza'] ?? '—'; ?></td>
                            <td><?php echo $row['edad'] ?? '—'; ?> años</td>
                            <td>
                                <span class="badge bg-<?php echo $badge_color; ?>">
                                    <?php echo $row['estado_adopcion'] ?? '—'; ?>
                                </span>
                            </td>
                            <td><?php echo $row['ultima_revision'] ? date('d/m/Y', strtotime($row['ultima_revision'])) : 'Sin revisión'; ?></td>
                            <td>
                                <small><?php echo substr($row['diagnostico'] ?? '—', 0, 30); ?></small>
                            </td>
                            <td>
                                <span class="badge bg-primary"><?php echo $row['total_vacunas'] ?? 0; ?></span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="fas fa-info-circle fa-2x" style="color: #E8A0A0;"></i>
                                <p class="mt-2">No hay mascotas con registros médicos</p>
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
CREATE OR REPLACE VIEW vista_veterinario AS
SELECT 
    m.id_mascota,
    m.nombre,
    s.descripcion as sexo,
    r.descripcion as raza,
    m.fecha_nacimiento,
    TIMESTAMPDIFF(YEAR, m.fecha_nacimiento, CURDATE()) as edad,
    ea.descripcion as estado_adopcion,
    v.fecha_revision as ultima_revision,
    v.diagnostico,
    v.tratamiento,
    v.observaciones,
    (SELECT COUNT(*) FROM Vacuna WHERE id_valoracion = v.id_valoracion) as total_vacunas
FROM Mascota m
LEFT JOIN Sexo s ON m.id_sexo = s.id_sexo
LEFT JOIN Raza r ON m.id_raza = r.id_raza
LEFT JOIN EstadoAdopcion ea ON m.id_estado_adopcion = ea.id_estado_adopcion
LEFT JOIN ValoracionMedica v ON m.id_mascota = v.id_mascota
WHERE v.fecha_revision = (
    SELECT MAX(fecha_revision) 
    FROM ValoracionMedica 
    WHERE id_mascota = m.id_mascota
) OR v.fecha_revision IS NULL;
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>