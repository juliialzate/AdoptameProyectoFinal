<?php
include 'config.php';
include 'header.php';
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-info text-white d-flex justify-content-between">
            <h4>🆘 Lista de Rescatistas</h4>
            <a href="rescatista_agregar.php" class="btn btn-light">
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
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT p.id_persona, p.nombre, p.telefono, p.correo_electronico,
                                   r.descripcion as rol
                            FROM Rescatista re
                            JOIN Persona p ON re.id_persona = p.id_persona
                            LEFT JOIN Rol r ON re.id_rol = r.id_rol";
                    
                    $result = $conexion->query($sql);
                    while($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $row['id_persona']; ?></td>
                        <td><strong><?php echo $row['nombre']; ?></strong></td>
                        <td><?php echo $row['telefono']; ?></td>
                        <td><?php echo $row['correo_electronico']; ?></td>
                        <td>
                            <span class="badge bg-primary"><?php echo $row['rol'] ?: 'Sin rol'; ?></span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>