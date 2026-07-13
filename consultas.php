<?php
include 'config.php';
include 'header.php';

// ===== LISTA BLANCA DE VISTAS PERMITIDAS =====
// (Seguridad: nunca metas el nombre de la vista directo en el SQL sin validarlo,
//  porque si viene de $_GET alguien podría inyectar SQL malicioso)
$vistas_permitidas = [
    'consulta_alter'               => 'ALTER',
    'consulta_asignacion'          => 'Asignación',
    'consulta_diferencia'          => 'Diferencia',
    'consulta_division'            => 'División',
    'consulta_grant'               => 'GRANT',
    'consulta_group_by'            => 'GROUP BY',
    'consulta_inner_join'          => 'INNER JOIN',
    'consulta_intersect'           => 'INTERSECT',
    'consulta_multiple_join'       => 'Multiple JOIN',
    'consulta_producto_cartesiano' => 'Producto Cartesiano',
    'consulta_proyeccion'          => 'Proyección',
    'consulta_reunion_natural'     => 'Reunión Natural',
    'consulta_revoke'              => 'REVOKE',
    'consulta_subquery'            => 'Subconsulta',
];

// ===== DETERMINAR QUÉ VISTA MOSTRAR =====
$vista_seleccionada = isset($_GET['vista']) ? $_GET['vista'] : 'consulta_inner_join';

// Validar que la vista pedida esté en la lista blanca (seguridad)
if (!array_key_exists($vista_seleccionada, $vistas_permitidas)) {
    $vista_seleccionada = 'consulta_inner_join';
}

// ===== EJECUTAR LA CONSULTA =====
$columnas = [];
$filas = [];
$error_sql = null;

$sql = "SELECT * FROM `" . $vista_seleccionada . "`";
$result = $conexion->query($sql);

if ($result === false) {
    $error_sql = $conexion->error;
} else {
    while ($row = $result->fetch_assoc()) {
        $filas[] = $row;
    }
    if (count($filas) > 0) {
        $columnas = array_keys($filas[0]);
    }
}
?>

<div class="container mt-4">
    <div class="table-container">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4><i class="fas fa-database" style="color: #E8A0A0;"></i> Taller de Consultas SQL</h4>
        </div>
        <div class="p-3">
            <!-- Selector de consulta -->
            <div class="mb-3">
                <label class="form-label">Selecciona una consulta:</label>
                <select class="form-select w-auto d-inline-block" onchange="window.location.href='consultas.php?vista='+this.value">
                    <?php foreach ($vistas_permitidas as $nombre_vista => $etiqueta): ?>
                    <option value="<?php echo $nombre_vista; ?>" <?php echo ($vista_seleccionada == $nombre_vista) ? 'selected' : ''; ?>>
                        <?php echo $etiqueta; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if ($error_sql): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Error al ejecutar la vista <strong><?php echo htmlspecialchars($vista_seleccionada); ?></strong>:
                    <?php echo htmlspecialchars($error_sql); ?>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <?php foreach ($columnas as $col): ?>
                                <th><?php echo htmlspecialchars($col); ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($filas) == 0): ?>
                            <tr>
                                <td colspan="<?php echo max(count($columnas), 1); ?>" class="text-center py-4">
                                    <i class="fas fa-info-circle fa-2x" style="color: #E8A0A0;"></i>
                                    <p class="mt-2">Esta consulta no devolvió resultados</p>
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($filas as $fila): ?>
                                <tr>
                                    <?php foreach ($fila as $valor): ?>
                                    <td><?php echo htmlspecialchars($valor ?? '—'); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <!-- Mostrar el SQL de la vista seleccionada (opcional, ayuda para el informe del taller) -->
            <div class="mt-4">
                <div class="card bg-light">
                    <div class="card-header bg-light">
                        <small class="text-muted">
                            <i class="fas fa-code"></i> Consulta ejecutada:
                        </small>
                    </div>
                    <div class="card-body">
                        <pre style="background: #f8f9fa; padding: 15px; border-radius: 10px; font-size: 0.85rem; margin: 0; white-space: pre-wrap; word-break: break-all;">SELECT * FROM <?php echo htmlspecialchars($vista_seleccionada); ?>;</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
