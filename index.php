<?php
include 'config.php';
include 'header.php';
?>

<div class="container mt-4">
    <div class="p-5 bg-primary text-white rounded-3 mb-4">
        <h1>🐾 Bienvenido a Adóptame</h1>
        <p>Sistema de Gestión de Adopciones - Fundación Canina</p>
    </div>

    <div class="row">
        <?php
        $consultas = [
            'Mascotas' => "SELECT COUNT(*) as total FROM Mascota",
            'Adoptantes' => "SELECT COUNT(*) as total FROM Adoptante",
            'Rescatistas' => "SELECT COUNT(*) as total FROM Rescatista",
            'Adopciones' => "SELECT COUNT(*) as total FROM Adopta"
        ];
        
        $colores = ['primary', 'success', 'info', 'warning'];
        $iconos = ['fa-dog', 'fa-users', 'fa-user-md', 'fa-handshake'];
        $i = 0;
        
        foreach ($consultas as $titulo => $sql):
            $result = $conexion->query($sql);
            $total = $result->fetch_assoc()['total'];
        ?>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-<?php echo $colores[$i]; ?>">
                <div class="card-body">
                    <h5><?php echo $titulo; ?></h5>
                    <h2><?php echo $total; ?></h2>
                    <i class="fas <?php echo $iconos[$i]; ?> float-end" style="font-size:2rem;"></i>
                </div>
            </div>
        </div>
        <?php 
        $i++;
        endforeach; 
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>