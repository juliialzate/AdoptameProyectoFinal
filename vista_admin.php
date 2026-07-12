<?php
include 'config.php';
include 'header.php';

$sql = "SELECT * FROM vista_administrador";
$result = $conexion->query($sql);
?>

<div class="container mt-4">
    <div class="table-container">
        <div class="card-header" style="background: linear-gradient(135deg, #FFD9D9, #FFC8C8);">
            <h4><i class="fas fa-user-cog" style="color: #8B4A4A;"></i> Panel de Administrador</h4>
            <p class="mb-0" style="font-size: 0.9rem; color: #8B6B6B;">
                <i class="fas fa-info-circle"></i> Vista general del sistema con acceso a toda la información
            </p>
        </div>
        <div class="p-4">
            <div class="row">
                <?php
                $colores = ['#FFD9E6', '#D6E8FF', '#D4F5D4', '#FFF5D6'];
                $iconos = ['fa-dog', 'fa-users', 'fa-user-md', 'fa-handshake'];
                $titulos = ['Mascotas', 'Adoptantes', 'Rescatistas', 'Adopciones'];
                $i = 0;
                
                while($row = $result->fetch_assoc()):
                ?>
                <div class="col-md-3 mb-4">
                    <div class="card" style="border: 3px solid <?php echo $colores[$i]; ?>; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <div class="card-body text-center">
                            <i class="fas <?php echo $iconos[$i]; ?>" style="font-size: 2rem; color: <?php echo $colores[$i]; ?>;"></i>
                            <h6 class="text-uppercase text-muted mt-2"><?php echo $titulos[$i]; ?></h6>
                            <h2 class="mb-2"><?php echo $row['total']; ?></h2>
                            <div class="mt-2">
                                <small class="text-success">✅ Disponibles: <?php echo $row['disponibles'] ?? 0; ?></small><br>
                                <small class="text-warning">⏳ En proceso: <?php echo $row['en_proceso'] ?? 0; ?></small><br>
                                <small class="text-secondary">✅ Adoptados: <?php echo $row['adoptadas'] ?? 0; ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                $i++;
                endwhile; 
                ?>
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
CREATE OR REPLACE VIEW vista_administrador AS
SELECT 
    'Mascotas' as tipo,
    COUNT(*) as total,
    (SELECT COUNT(*) FROM Mascota WHERE id_estado_adopcion = 1) as disponibles,
    (SELECT COUNT(*) FROM Mascota WHERE id_estado_adopcion = 2) as en_proceso,
    (SELECT COUNT(*) FROM Mascota WHERE id_estado_adopcion = 3) as adoptadas
FROM Mascota
UNION ALL
SELECT 'Adoptantes', COUNT(*), 
    (SELECT COUNT(*) FROM Adoptante WHERE id_estado_habilitacion = 1),
    (SELECT COUNT(*) FROM Adoptante WHERE id_estado_habilitacion = 2),
    (SELECT COUNT(*) FROM Adoptante WHERE id_estado_habilitacion = 3)
FROM Adoptante
UNION ALL
SELECT 'Rescatistas', COUNT(*), 
    (SELECT COUNT(*) FROM Rescatista WHERE id_rol = 1),
    (SELECT COUNT(*) FROM Rescatista WHERE id_rol = 2),
    (SELECT COUNT(*) FROM Rescatista WHERE id_rol = 3)
FROM Rescatista
UNION ALL
SELECT 'Adopciones', COUNT(*),
    (SELECT COUNT(*) FROM Adopta WHERE id_estado_proceso = 1),
    (SELECT COUNT(*) FROM Adopta WHERE id_estado_proceso = 2),
    (SELECT COUNT(*) FROM Adopta WHERE id_estado_proceso = 3)
FROM Adopta;
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>