<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adóptame - Sistema de Adopción</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts - Fuente más bonita -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* ===== ESTILOS GLOBALES ===== */
        * {
            font-family: 'Nunito', sans-serif;
        }
        
        body {
            background: #FFF5F5;  /* Fondo rosa pastel muy suave */
            min-height: 100vh;
        }
        
        /* ===== BARRA DE NAVEGACIÓN ===== */
        .navbar-custom {
            background: linear-gradient(135deg, #F8E8E8 0%, #E8D5D5 100%);
            box-shadow: 0 4px 20px rgba(200, 150, 150, 0.15);
            padding: 15px 0;
            border-bottom: 3px solid #FFD4D4;
        }
        
        .navbar-custom .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: #B5838D !important;
            transition: all 0.3s;
        }
        
        .navbar-custom .navbar-brand:hover {
            transform: scale(1.05);
            color: #A06B75 !important;
        }
        
        .navbar-custom .navbar-brand i {
            color: #E8A0A0;
            margin-right: 8px;
        }
        
        .navbar-custom .nav-link {
            font-weight: 600;
            color: #8B6B6B !important;
            padding: 8px 20px !important;
            border-radius: 25px;
            transition: all 0.3s;
            margin: 0 3px;
        }
        
        .navbar-custom .nav-link:hover {
            background: #FFE8E8;
            color: #B5838D !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(200, 150, 150, 0.2);
        }
        
        .navbar-custom .nav-link i {
            margin-right: 6px;
        }
        
        /* ===== TARJETAS DE ESTADÍSTICAS ===== */
        .card-stat {
            border: none;
            border-radius: 20px;
            padding: 25px 20px;
            transition: all 0.4s;
            cursor: default;
            box-shadow: 0 4px 15px rgba(200, 150, 150, 0.1);
        }
        
        .card-stat:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(200, 150, 150, 0.2);
        }
        
        .card-stat .icon {
            font-size: 2.8rem;
            opacity: 0.7;
        }
        
        .card-stat h2 {
            font-weight: 800;
            font-size: 2.5rem;
            margin: 0;
        }
        
        .card-stat h6 {
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.85rem;
            opacity: 0.8;
        }
        
        /* Colores pastel para las tarjetas */
        .bg-pink-pastel {
            background: linear-gradient(135deg, #FFD9E6, #FFC8D6);
            color: #8B5A6B;
        }
        
        .bg-blue-pastel {
            background: linear-gradient(135deg, #D6E8FF, #C4DBFF);
            color: #4A6B8B;
        }
        
        .bg-green-pastel {
            background: linear-gradient(135deg, #D4F5D4, #B8E8B8);
            color: #3D7A4A;
        }
        
        .bg-yellow-pastel {
            background: linear-gradient(135deg, #FFF5D6, #FFE8B8);
            color: #8B7A3D;
        }
        
        /* ===== BANNER DE BIENVENIDA ===== */
        .banner-welcome {
            background: linear-gradient(135deg, #FFE4E4, #FFD4D4);
            border-radius: 25px;
            padding: 40px;
            border: 3px solid #FFC8C8;
            box-shadow: 0 4px 20px rgba(200, 150, 150, 0.1);
            margin-bottom: 30px;
        }
        
        .banner-welcome h1 {
            color: #B5838D;
            font-weight: 800;
        }
        
        .banner-welcome p {
            color: #8B6B6B;
            font-weight: 400;
            font-size: 1.1rem;
        }
        
        .banner-welcome .icon-paw {
            color: #E8A0A0;
            font-size: 3rem;
        }
        
        /* ===== TABLAS ===== */
        .table-container {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(200, 150, 150, 0.08);
            border: 2px solid #FFE8E8;
        }
        
        .table-container .card-header {
            background: linear-gradient(135deg, #FFE4E4, #FFD4D4);
            border-radius: 15px 15px 0 0;
            padding: 20px 25px;
            border: none;
        }
        
        .table-container .card-header h4 {
            color: #B5838D;
            font-weight: 700;
        }
        
        .table {
            margin: 0;
        }
        
        .table thead th {
            background: #FFF5F5;
            color: #8B6B6B;
            font-weight: 700;
            border-bottom: 3px solid #FFD4D4;
            padding: 12px 15px;
        }
        
        .table tbody tr {
            transition: all 0.3s;
            border-bottom: 1px solid #FFF0F0;
        }
        
        .table tbody tr:hover {
            background: #FFF8F8;
        }
        
        .table tbody td {
            padding: 12px 15px;
            color: #5A4A4A;
            vertical-align: middle;
        }
        
        /* ===== BADGES (ETIQUETAS DE ESTADO) ===== */
        .badge-pastel-success {
            background: #D4F5D4;
            color: #3D7A4A;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .badge-pastel-warning {
            background: #FFF5D6;
            color: #8B7A3D;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .badge-pastel-secondary {
            background: #F0E8E8;
            color: #8B7A7A;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .badge-pastel-info {
            background: #D6E8FF;
            color: #4A6B8B;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .badge-pastel-danger {
            background: #FFD9D9;
            color: #8B4A4A;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        /* ===== BOTONES ===== */
        .btn-pastel-primary {
            background: #FFD4D4;
            color: #B5838D;
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 700;
            transition: all 0.3s;
        }
        
        .btn-pastel-primary:hover {
            background: #FFC8C8;
            color: #A06B75;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(200, 150, 150, 0.3);
        }
        
        .btn-pastel-success {
            background: #D4F5D4;
            color: #3D7A4A;
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 700;
            transition: all 0.3s;
        }
        
        .btn-pastel-success:hover {
            background: #C0E8C0;
            color: #2D6A3A;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(100, 200, 100, 0.3);
        }
        
        /* ===== PIE DE PÁGINA ===== */
        .footer-pastel {
            background: linear-gradient(135deg, #F8E8E8, #E8D5D5);
            color: #8B6B6B;
            padding: 25px 0;
            margin-top: 40px;
            border-top: 3px solid #FFD4D4;
        }
        
        .footer-pastel a {
            color: #B5838D;
            text-decoration: none;
            font-weight: 600;
        }
        
        .footer-pastel a:hover {
            color: #A06B75;
        }
        
        .footer-pastel .heart {
            color: #E8A0A0;
        }
        
        /* ===== FORMULARIOS ===== */
        .form-control {
            border-radius: 15px;
            border: 2px solid #FFE8E8;
            padding: 12px 18px;
            transition: all 0.3s;
            background: #FFFBFB;
        }
        
        .form-control:focus {
            border-color: #FFC8C8;
            box-shadow: 0 0 0 4px rgba(255, 200, 200, 0.2);
        }
        
        .form-label {
            font-weight: 600;
            color: #8B6B6B;
        }
        
        .form-control, .form-select {
            border-radius: 15px;
            border: 2px solid #FFE8E8;
            padding: 12px 18px;
            transition: all 0.3s;
            background: #FFFBFB;
        }
        
        .form-select:focus {
            border-color: #FFC8C8;
            box-shadow: 0 0 0 4px rgba(255, 200, 200, 0.2);
        }
        
        select.form-select {
            appearance: auto;
        }
    </style>
</head>
<body>
    <!-- ===== BARRA DE NAVEGACIÓN ===== -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-paw"></i> Adóptame
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mascotas.php">
                            <i class="fas fa-dog"></i> Mascotas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adoptantes.php">
                            <i class="fas fa-users"></i> Adoptantes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rescatistas.php">
                            <i class="fas fa-user-md"></i> Rescatistas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adopciones.php">
                            <i class="fas fa-handshake"></i> Adopciones
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- ===== CONTENIDO PRINCIPAL ===== -->
    <main>