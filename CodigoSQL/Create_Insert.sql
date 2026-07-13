
-- ============================================
-- ELIMINAR TABLAS EXISTENTES (si las hay)
-- ============================================
DROP TABLE IF EXISTS Vacuna;
DROP TABLE IF EXISTS ValoracionMedica;
DROP TABLE IF EXISTS Rescate;
DROP TABLE IF EXISTS Adopta;
DROP TABLE IF EXISTS Adoptante;
DROP TABLE IF EXISTS Rescatista;
DROP TABLE IF EXISTS Mascota;
DROP TABLE IF EXISTS Persona;
DROP TABLE IF EXISTS EstadoHabilitacion;
DROP TABLE IF EXISTS EstadoProcesoAdopcion;
DROP TABLE IF EXISTS EstadoAdopcion;
DROP TABLE IF EXISTS Ocupacion;
DROP TABLE IF EXISTS Rol;
DROP TABLE IF EXISTS Raza;
DROP TABLE IF EXISTS Sexo;

-- ============================================
-- 1. TABLAS DE REFERENCIA (Catálogos)
-- ============================================

-- Tabla Sexo
CREATE TABLE Sexo (
    id_sexo INT PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(20) NOT NULL
);

-- Tabla Raza
CREATE TABLE Raza (
    id_raza INT PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL
);

-- Tabla Rol
CREATE TABLE Rol (
    id_rol INT PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL
);

-- Tabla Ocupación
CREATE TABLE Ocupacion (
    id_ocupacion INT PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(100) NOT NULL
);

-- Tabla Estado Adopción (para Mascota)
CREATE TABLE EstadoAdopcion (
    id_estado_adopcion INT PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(30) NOT NULL
);

-- Tabla Estado Proceso Adopción
CREATE TABLE EstadoProcesoAdopcion (
    id_estado_proceso INT PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(30) NOT NULL
);

-- Tabla Estado Habilitación (para Adoptante)
CREATE TABLE EstadoHabilitacion (
    id_estado_habilitacion INT PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(30) NOT NULL
);

-- ============================================
-- 2. TABLAS PRINCIPALES
-- ============================================

-- Tabla Persona
CREATE TABLE Persona (
    id_persona INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    correo_electronico VARCHAR(100)
);

-- Tabla Mascota (con campo imagen)
CREATE TABLE Mascota (
    id_mascota INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    id_sexo INT,
    id_raza INT,
    fecha_nacimiento DATE,
    id_estado_adopcion INT,
    imagen VARCHAR(255) NULL,  -- <--- CAMPO PARA IMÁGENES
    FOREIGN KEY (id_sexo) REFERENCES Sexo(id_sexo),
    FOREIGN KEY (id_raza) REFERENCES Raza(id_raza),
    FOREIGN KEY (id_estado_adopcion) REFERENCES EstadoAdopcion(id_estado_adopcion)
);

-- Tabla Rescatista
CREATE TABLE Rescatista (
    id_persona INT PRIMARY KEY,
    id_rol INT,
    FOREIGN KEY (id_persona) REFERENCES Persona(id_persona),
    FOREIGN KEY (id_rol) REFERENCES Rol(id_rol)
);

-- Tabla Adoptante
CREATE TABLE Adoptante (
    id_persona INT PRIMARY KEY,
    direccion VARCHAR(150),
    id_ocupacion INT,
    id_estado_habilitacion INT,
    FOREIGN KEY (id_persona) REFERENCES Persona(id_persona),
    FOREIGN KEY (id_ocupacion) REFERENCES Ocupacion(id_ocupacion),
    FOREIGN KEY (id_estado_habilitacion) REFERENCES EstadoHabilitacion(id_estado_habilitacion)
);

-- Tabla Valoración Médica
CREATE TABLE ValoracionMedica (
    id_valoracion INT PRIMARY KEY AUTO_INCREMENT,
    id_mascota INT,
    fecha_revision DATE NOT NULL,
    diagnostico TEXT,
    tratamiento TEXT,
    observaciones TEXT,
    FOREIGN KEY (id_mascota) REFERENCES Mascota(id_mascota)
);

-- Tabla Vacuna
CREATE TABLE Vacuna (
    id_vacuna INT PRIMARY KEY AUTO_INCREMENT,
    id_valoracion INT,
    nombre_vacuna VARCHAR(100) NOT NULL,
    dosis VARCHAR(50),
    fecha_aplicacion DATE,
    FOREIGN KEY (id_valoracion) REFERENCES ValoracionMedica(id_valoracion)
);

-- Tabla Rescate
CREATE TABLE Rescate (
    id_rescate INT PRIMARY KEY AUTO_INCREMENT,
    id_mascota INT,
    id_persona INT,
    fecha_rescate DATE NOT NULL,
    ubicacion_rescate VARCHAR(150),
    historia_rescate TEXT,
    FOREIGN KEY (id_mascota) REFERENCES Mascota(id_mascota),
    FOREIGN KEY (id_persona) REFERENCES Persona(id_persona)
);

-- Tabla Adopta
CREATE TABLE Adopta (
    id_adopcion INT PRIMARY KEY AUTO_INCREMENT,
    id_mascota INT,
    id_persona INT,
    fecha_solicitud DATE NOT NULL,
    fecha_entrega DATE,
    id_estado_proceso INT,
    FOREIGN KEY (id_mascota) REFERENCES Mascota(id_mascota),
    FOREIGN KEY (id_persona) REFERENCES Persona(id_persona),
    FOREIGN KEY (id_estado_proceso) REFERENCES EstadoProcesoAdopcion(id_estado_proceso)
);

-- ============================================
-- 3. INSERCIÓN DE DATOS (10 registros por tabla)
-- ============================================

-- 3.1 Tablas de referencia

-- Sexo (10)
INSERT INTO Sexo (descripcion) VALUES 
('Macho'),
('Hembra'),
('Macho Esterilizado'),
('Hembra Esterilizada'),
('Macho'),
('Hembra'),
('Macho'),
('Hembra'),
('Macho'),
('Hembra');

-- Raza (10)
INSERT INTO Raza (descripcion) VALUES 
('Labrador Retriever'),
('Pastor Alemán'),
('Golden Retriever'),
('Bulldog'),
('Poodle'),
('Chihuahua'),
('Husky Siberiano'),
('Doberman'),
('Boxer'),
('Beagle');

-- Rol (10)
INSERT INTO Rol (descripcion) VALUES 
('Voluntario'),
('Coordinador'),
('Veterinario'),
('Asistente Veterinario'),
('Rescatista Principal'),
('Rescatista'),
('Coordinador de Adopciones'),
('Voluntario Senior'),
('Rescatista'),
('Coordinador de Rescates');

-- Ocupacion (10)
INSERT INTO Ocupacion (descripcion) VALUES 
('Ingeniero'),
('Médico'),
('Abogado'),
('Docente'),
('Arquitecto'),
('Estudiante'),
('Empresario'),
('Diseñador'),
('Psicólogo'),
('Veterinario');

-- EstadoAdopcion (10)
INSERT INTO EstadoAdopcion (descripcion) VALUES 
('Disponible'),
('En proceso'),
('Adoptada'),
('Disponible'),
('En proceso'),
('Adoptada'),
('Disponible'),
('En proceso'),
('Adoptada'),
('Disponible');

-- EstadoProcesoAdopcion (10)
INSERT INTO EstadoProcesoAdopcion (descripcion) VALUES 
('Solicitada'),
('En evaluación'),
('Aprobada'),
('Finalizada'),
('Cancelada'),
('Solicitada'),
('En evaluación'),
('Aprobada'),
('Finalizada'),
('Cancelada');

-- EstadoHabilitacion (10)
INSERT INTO EstadoHabilitacion (descripcion) VALUES 
('Habilitado'),
('No habilitado'),
('En evaluación'),
('Habilitado'),
('No habilitado'),
('En evaluación'),
('Habilitado'),
('No habilitado'),
('En evaluación'),
('Habilitado');

-- 3.2 Persona (10)
INSERT INTO Persona (nombre, telefono, correo_electronico) VALUES 
('Juan Pérez', '300123456', 'juan@email.com'),
('María Gómez', '301234567', 'maria@email.com'),
('Carlos Rodríguez', '302345678', 'carlos@email.com'),
('Ana Martínez', '303456789', 'ana@email.com'),
('Luis Sánchez', '304567890', 'luis@email.com'),
('Laura Torres', '305678901', 'laura@email.com'),
('Pedro Ramírez', '306789012', 'pedro@email.com'),
('Carla Fernández', '307890123', 'carla@email.com'),
('Jorge Castro', '308901234', 'jorge@email.com'),
('Sofía Díaz', '309012345', 'sofia@email.com');

-- 3.3 Mascota (10 con imagen NULL)
INSERT INTO Mascota (nombre, id_sexo, id_raza, fecha_nacimiento, id_estado_adopcion, imagen) VALUES 
('Firulais', 1, 1, '2023-01-15', 1, NULL),
('Luna', 2, 2, '2022-08-20', 2, NULL),
('Max', 1, 3, '2023-03-10', 3, NULL),
('Bella', 2, 4, '2022-11-05', 1, NULL),
('Rocky', 1, 5, '2023-06-25', 2, NULL),
('Maya', 2, 6, '2022-09-12', 3, NULL),
('Simón', 1, 7, '2023-02-18', 1, NULL),
('Nina', 2, 8, '2022-07-30', 2, NULL),
('Toby', 1, 9, '2023-04-22', 3, NULL),
('Lola', 2, 10, '2022-10-08', 1, NULL);

-- 3.4 Rescatista (10)
INSERT INTO Rescatista (id_persona, id_rol) VALUES 
(1, 1),
(2, 2),
(3, 3),
(4, 1),
(5, 4),
(6, 5),
(7, 1),
(8, 2),
(9, 3),
(10, 6);

-- 3.5 Adoptante (10)
INSERT INTO Adoptante (id_persona, direccion, id_ocupacion, id_estado_habilitacion) VALUES 
(1, 'Calle 123 #45-67', 1, 1),
(2, 'Carrera 89 #12-34', 2, 2),
(3, 'Avenida 45 #67-89', 3, 3),
(4, 'Calle 78 #90-12', 4, 1),
(5, 'Transversal 56 #78-90', 5, 2),
(6, 'Carrera 34 #56-78', 6, 3),
(7, 'Calle 90 #12-34', 7, 1),
(8, 'Avenida 67 #89-01', 8, 2),
(9, 'Carrera 12 #34-56', 9, 3),
(10, 'Calle 56 #78-90', 10, 1);

-- 3.6 ValoracionMedica (10)
INSERT INTO ValoracionMedica (id_mascota, fecha_revision, diagnostico, tratamiento, observaciones) VALUES 
(1, '2024-01-10', 'Desnutrición leve', 'Alimentación balanceada', 'Peso 15kg, requiere ganar 3kg'),
(2, '2024-01-15', 'Parásitos intestinales', 'Desparasitación', 'Estado general regular'),
(3, '2024-01-20', 'Sano', 'Vacunación al día', 'Excelente estado'),
(4, '2024-01-25', 'Infección en oído', 'Antibióticos tópicos', 'Limpiar oídos diariamente'),
(5, '2024-02-01', 'Fractura en pata', 'Inmovilización', 'Yeso por 4 semanas'),
(6, '2024-02-05', 'Desnutrición severa', 'Alimentación especial', 'Requiere control semanal'),
(7, '2024-02-10', 'Sano', 'Vacunación', 'Perro saludable'),
(8, '2024-02-15', 'Alergia en piel', 'Antihistamínicos', 'Cambiar alimento'),
(9, '2024-02-20', 'Infección respiratoria', 'Antibióticos', 'Requiere reposo'),
(10, '2024-02-25', 'Sano', 'Chequeo general', 'Apto para adopción');

-- 3.7 Vacuna (10)
INSERT INTO Vacuna (id_valoracion, nombre_vacuna, dosis, fecha_aplicacion) VALUES 
(1, 'Rabia', '1ml', '2024-01-10'),
(2, 'Moquillo', '2ml', '2024-01-15'),
(3, 'Parvovirus', '1ml', '2024-01-20'),
(4, 'Hepatitis', '1.5ml', '2024-01-25'),
(5, 'Rabia', '1ml', '2024-02-01'),
(6, 'Moquillo', '2ml', '2024-02-05'),
(7, 'Parvovirus', '1ml', '2024-02-10'),
(8, 'Hepatitis', '1.5ml', '2024-02-15'),
(9, 'Rabia', '1ml', '2024-02-20'),
(10, 'Moquillo', '2ml', '2024-02-25');

-- 3.8 Rescate (10)
INSERT INTO Rescate (id_mascota, id_persona, fecha_rescate, ubicacion_rescate, historia_rescate) VALUES 
(1, 1, '2024-01-01', 'Parque Simón Bolívar', 'Encontrado abandonado en el parque con signos de desnutrición'),
(2, 2, '2024-01-05', 'Calle 80', 'Rescatado de la calle por voluntarios'),
(3, 3, '2024-01-10', 'Barrio Kennedy', 'Dueño lo abandonó en la puerta de la fundación'),
(4, 4, '2024-01-15', 'Cerro de Suba', 'Encontrado en estado de desnutrición severa'),
(5, 5, '2024-01-20', 'Zona rural', 'Rescatado de una situación de maltrato'),
(6, 6, '2024-01-25', 'Carrera 15', 'Abandonado en una caja de cartón'),
(7, 7, '2024-02-01', 'Parque Nacional', 'Rescatado junto con otros 5 perros'),
(8, 8, '2024-02-05', 'Usaquén', 'Perro callejero en mal estado'),
(9, 9, '2024-02-10', 'Fontibón', 'Rescatado de predio en abandono'),
(10, 10, '2024-02-15', 'Bosa', 'Encontrado con heridas en la pata');

-- 3.9 Adopta (10)
INSERT INTO Adopta (id_mascota, id_persona, fecha_solicitud, fecha_entrega, id_estado_proceso) VALUES 
(1, 1, '2024-02-01', '2024-02-15', 3),
(2, 2, '2024-02-05', NULL, 2),
(3, 3, '2024-02-10', NULL, 1),
(4, 4, '2024-02-15', NULL, 2),
(5, 5, '2024-02-20', NULL, 1),
(6, 6, '2024-02-25', NULL, 4),
(7, 7, '2024-03-01', NULL, 2),
(8, 8, '2024-03-05', '2024-03-20', 3),
(9, 9, '2024-03-10', NULL, 5),
(10, 10, '2024-03-15', NULL, 2);

-- ============================================
-- 4. Creacion De Vistas para el Sistema de Adopción
-- ============================================

-- Vista Administrador
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

    -- Vista Veterinario
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

    -- Vista Adopciones
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

    -- Vista Rescatista
    CREATE OR REPLACE VIEW vista_rescatista AS
    SELECT 
        m.id_mascota,
        m.nombre,
        s.descripcion as sexo,
        r.descripcion as raza,
    m.fecha_nacimiento,
    TIMESTAMPDIFF(YEAR, m.fecha_nacimiento, CURDATE()) as edad,
    ea.descripcion as estado_adopcion,
    re.fecha_rescate,
    re.ubicacion_rescate,
    p.nombre as rescatista_asignado,
    (SELECT COUNT(*) FROM ValoracionMedica vm WHERE vm.id_mascota = m.id_mascota) as total_revisiones
    FROM Mascota m
    JOIN Rescate re ON m.id_mascota = re.id_mascota
    LEFT JOIN Persona p ON re.id_persona = p.id_persona   -- <--- corregido aquí
    LEFT JOIN Sexo s ON m.id_sexo = s.id_sexo
    LEFT JOIN Raza r ON m.id_raza = r.id_raza
    LEFT JOIN EstadoAdopcion ea ON m.id_estado_adopcion = ea.id_estado_adopcion;



