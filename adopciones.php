<?php
include 'config.php';
include 'header.php';
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-warning text-white d-flex justify-content-between">
            <h4>🤝 Lista de Adopciones</h4>
            <a href="adopcion_agregar.php" class="btn btn-light">
                <i class="fas fa-plus"></i> Agregar
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mascota</th>
                        <th>Adoptante</th>
                        <th>Fecha Solicitud</th>
                        <th>Fecha Entrega</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT a.id_adopcion, m.nombre as mascota, p.nombre as adoptante,
                                   a.fecha_solicitud, a.fecha_entrega, e.descripcion as estado
                            FROM Adopta a
                            JOIN Mascota m ON a.id_mascota = m.id_mascota
                            JOIN Persona p ON a.id_persona = p.id_persona
                            LEFT JOIN EstadoProcesoAdopcion e ON a.id_estado_proceso = e.id_estado_proceso
                            ORDER BY a.fecha_solicitud DESC";
                    
                    $result = $conexion->query($sql);
                    while($row = $result->fetch_assoc()):
                        $color = $row['estado'] == 'Aprobada' ? 'success' : 
                                ($row['estado'] == 'En evaluación' ? 'warning' : 
                                ($row['estado'] == 'Finalizada' ? 'info' : 'secondary'));
                    ?>
                    <tr>
                        <td><?php echo $row['id_adopcion']; ?></td>
                        <td><strong><?php echo $row['mascota']; ?></strong></td>
                        <td><?php echo $row['adoptante']; ?></td>
                        <td><?php echo $row['fecha_solicitud']; ?></td>
                        <td><?php echo $row['fecha_entrega'] ?: 'Pendiente'; ?></td>
                        <td>
                            <span class="badge bg-<?php echo $color; ?>">
                                <?php echo $row['estado'] ?: 'Sin estado'; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>