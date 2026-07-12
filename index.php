<?php
include 'config.php';
include 'header.php';
?>

<div class="container mt-4">
    <!-- Banner -->
    <div class="banner-welcome text-center">
        <div class="icon-paw">
            <i class="fas fa-paw"></i>
        </div>
        <h1>🐾 ¡Bienvenido a Adóptame!</h1>
        <p>Sistema de Gestión de Adopciones - Fundación Canina</p>
    </div>

    <div class="row mt-4">
        <!-- ===== VISTAS POR ROL ===== -->
        <div class="col-md-12 mb-4">
            <div class="table-container">
                <h5 style="color: #B5838D; font-weight: 700; margin-bottom: 20px;">
                    <i class="fas fa-user-shield" style="color: #E8A0A0;"></i> Vistas por Rol de Usuario
                </h5>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="vista_admin.php" class="btn btn-pastel-danger w-100 py-3">
                            <i class="fas fa-user-cog"></i><br>
                            Administrador
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="vista_adopciones.php" class="btn btn-pastel-primary w-100 py-3">
                            <i class="fas fa-handshake"></i><br>
                            Personal Adopciones
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="vista_veterinario.php" class="btn btn-pastel-success w-100 py-3">
                            <i class="fas fa-user-md"></i><br>
                            Veterinario
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="vista_rescatista.php" class="btn btn-pastel-warning w-100 py-3">
                            <i class="fas fa-user-nurse"></i><br>
                            Rescatista
                        </a>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4 mx-auto">
                        <a href="vista_adoptante.php" class="btn btn-pastel-info w-100 py-3">
                            <i class="fas fa-user"></i><br>
                            Adoptante (Mascotas Disponibles)
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== CONSULTAS ESPECIALES ===== -->
        <div class="col-md-12">
            <div class="table-container">
                <h5 style="color: #B5838D; font-weight: 700; margin-bottom: 20px;">
                    <i class="fas fa-database" style="color: #6BA3D6;"></i> Consultas Especiales (15 Consultas SQL)
                </h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="consulta_inner_join.php" class="btn btn-outline-primary w-100 py-2">
                            <i class="fas fa-link"></i> 1. INNER JOIN
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="consulta_group_by.php" class="btn btn-outline-success w-100 py-2">
                            <i class="fas fa-chart-bar"></i> 2. GROUP BY
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="consulta_subquery.php" class="btn btn-outline-warning w-100 py-2">
                            <i class="fas fa-search"></i> 3. SUBQUERY
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="consulta_multiple_join.php" class="btn btn-outline-info w-100 py-2">
                            <i class="fas fa-code-branch"></i> 4. MULTIPLE JOIN
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="consulta_reunion_natural.php" class="btn btn-outline-secondary w-100 py-2">
                            <i class="fas fa-project-diagram"></i> 5. REUNIÓN NATURAL
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="consulta_producto_cartesiano.php" class="btn btn-outline-danger w-100 py-2">
                            <i class="fas fa-times"></i> 6. PRODUCTO CARTESIANO
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="consulta_diferencia.php" class="btn btn-outline-dark w-100 py-2">
                            <i class="fas fa-minus-circle"></i> 7. DIFERENCIA
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="consulta_intersect.php" class="btn btn-outline-primary w-100 py-2">
                            <i class="fas fa-intersection"></i> 8. INTERSECT
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="consulta_proyeccion.php" class="btn btn-outline-success w-100 py-2">
                            <i class="fas fa-arrow-right"></i> 9. PROYECCIÓN
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="consulta_asignacion.php" class="btn btn-outline-warning w-100 py-2">
                            <i class="fas fa-tag"></i> 10. ASIGNACIÓN
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="consulta_division.php" class="btn btn-outline-info w-100 py-2">
                            <i class="fas fa-divide"></i> 11. DIVISIÓN
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="consulta_revoke.php" class="btn btn-outline-secondary w-100 py-2">
                            <i class="fas fa-user-slash"></i> 12. REVOKE
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="consulta_alter.php" class="btn btn-outline-danger w-100 py-2">
                            <i class="fas fa-edit"></i> 13. ALTER
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="consulta_grant.php" class="btn btn-outline-dark w-100 py-2">
                            <i class="fas fa-user-check"></i> 14. GRANT
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="consulta_drop.php" class="btn btn-outline-primary w-100 py-2">
                            <i class="fas fa-trash-alt"></i> 15. DROP (Info incompleta)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos -->
<style>
.btn-pastel-danger {
    background: #FFD9D9;
    color: #8B4A4A;
    border: none;
    border-radius: 25px;
    padding: 12px 25px;
    font-weight: 700;
    transition: all 0.3s;
}
.btn-pastel-danger:hover {
    background: #FFC8C8;
    color: #6B3A3A;
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(200, 100, 100, 0.3);
}

.btn-pastel-primary {
    background: #D6E8FF;
    color: #4A6B8B;
    border: none;
    border-radius: 25px;
    padding: 12px 25px;
    font-weight: 700;
    transition: all 0.3s;
}
.btn-pastel-primary:hover {
    background: #C4DBFF;
    color: #3A5B7B;
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(100, 150, 200, 0.3);
}

.btn-pastel-success {
    background: #D4F5D4;
    color: #3D7A4A;
    border: none;
    border-radius: 25px;
    padding: 12px 25px;
    font-weight: 700;
    transition: all 0.3s;
}
.btn-pastel-success:hover {
    background: #C0E8C0;
    color: #2D6A3A;
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(100, 200, 100, 0.3);
}

.btn-pastel-warning {
    background: #FFF5D6;
    color: #8B7A3D;
    border: none;
    border-radius: 25px;
    padding: 12px 25px;
    font-weight: 700;
    transition: all 0.3s;
}
.btn-pastel-warning:hover {
    background: #FFE8B8;
    color: #7B6A2D;
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(200, 180, 100, 0.3);
}

.btn-pastel-info {
    background: #D6E8FF;
    color: #4A6B8B;
    border: none;
    border-radius: 25px;
    padding: 12px 25px;
    font-weight: 700;
    transition: all 0.3s;
}
.btn-pastel-info:hover {
    background: #C4DBFF;
    color: #3A5B7B;
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(100, 150, 200, 0.3);
}

.btn-outline-primary {
    border: 2px solid #C4DBFF;
    color: #4A6B8B;
    background: transparent;
    border-radius: 20px;
    padding: 8px 15px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-outline-primary:hover {
    background: #D6E8FF;
    border-color: #6BA3D6;
    transform: scale(1.02);
}

.btn-outline-success {
    border: 2px solid #B8E8B8;
    color: #3D7A4A;
    background: transparent;
    border-radius: 20px;
    padding: 8px 15px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-outline-success:hover {
    background: #D4F5D4;
    border-color: #6BC86B;
    transform: scale(1.02);
}

.btn-outline-warning {
    border: 2px solid #FFE8B8;
    color: #8B7A3D;
    background: transparent;
    border-radius: 20px;
    padding: 8px 15px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-outline-warning:hover {
    background: #FFF5D6;
    border-color: #E8C86B;
    transform: scale(1.02);
}

.btn-outline-info {
    border: 2px solid #C4DBFF;
    color: #4A6B8B;
    background: transparent;
    border-radius: 20px;
    padding: 8px 15px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-outline-info:hover {
    background: #D6E8FF;
    border-color: #6BA3D6;
    transform: scale(1.02);
}

.btn-outline-secondary {
    border: 2px solid #E8D5D5;
    color: #8B6B6B;
    background: transparent;
    border-radius: 20px;
    padding: 8px 15px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-outline-secondary:hover {
    background: #F0E8E8;
    border-color: #B5838D;
    transform: scale(1.02);
}

.btn-outline-danger {
    border: 2px solid #FFD9D9;
    color: #8B4A4A;
    background: transparent;
    border-radius: 20px;
    padding: 8px 15px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-outline-danger:hover {
    background: #FFD9D9;
    border-color: #E86B6B;
    transform: scale(1.02);
}

.btn-outline-dark {
    border: 2px solid #D5D5D5;
    color: #5A4A4A;
    background: transparent;
    border-radius: 20px;
    padding: 8px 15px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-outline-dark:hover {
    background: #E8E8E8;
    border-color: #8B7A7A;
    transform: scale(1.02);
}
</style>

<?php include 'footer.php'; ?>