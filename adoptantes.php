<?php
include 'config.php';
include 'header.php';
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-success text-white d-flex justify-content-between">
            <h4>👤 Lista de Adoptantes</h4>
            <a href="adoptante_agregar.php" class="btn btn-light">
                <i class="fas fa-plus"></i> Agregar
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Ocupación</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT p.id_persona, p.nombre, p.telefono, p.correo_electronico,
                                   a.direccion, o.descripcion as ocupacion, e.descripcion as estado
                            FROM Adoptante a
                            JOIN Persona p ON a.id_persona = p.id_persona
                            LEFT JOIN Ocupacion o ON a.id_ocupacion = o.id_ocupacion
                            LEFT JOIN EstadoHabilitacion e ON a.id_estado_habilitacion = e.id_estado_habilitacion";
                    
                    $result = $conexion->query($sql);
                    while($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $row['id_persona']; ?></td>
                        <td><strong><?php echo $row['nombre']; ?></strong></td>
                        <td><?php echo $row['telefono']; ?></td>
                        <td><?php echo $row['correo_electronico']; ?></td>
                        <td><?php echo $row['direccion']; ?></td>
                        <td><?php echo $row['ocupacion'] ?: 'No especificada'; ?></td>
                        <td>
                            <span class="badge bg-<?php echo $row['estado'] == 'Habilitado' ? 'success' : 'danger'; ?>">
                                <?php echo $row['estado'] ?: 'Sin evaluar'; ?>
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