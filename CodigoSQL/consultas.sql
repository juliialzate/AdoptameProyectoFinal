-- ============================================
-- 2. CONSULTAS ESPECIALES (CORREGIDAS)
-- ============================================

-- Consulta 1: INNER JOIN - Mascotas con sus adoptantes
CREATE OR REPLACE VIEW consulta_inner_join AS
SELECT 
    m.nombre as mascota,
    s.descripcion as sexo,
    raza.descripcion as raza,
    p.nombre as adoptante,
    p.telefono,
    a.fecha_solicitud,
    ep.descripcion as estado
FROM Adopta a
INNER JOIN Mascota m ON a.id_mascota = m.id_mascota
INNER JOIN Persona p ON a.id_persona = p.id_persona
INNER JOIN EstadoProcesoAdopcion ep ON a.id_estado_proceso = ep.id_estado_proceso
LEFT JOIN Sexo s ON m.id_sexo = s.id_sexo
LEFT JOIN Raza raza ON m.id_raza = raza.id_raza
ORDER BY a.fecha_solicitud DESC;

-- Consulta 2: GROUP BY - Estadísticas por estado de adopción
CREATE OR REPLACE VIEW consulta_group_by AS
SELECT 
    ea.descripcion as estado,
    COUNT(*) as cantidad,
    AVG(TIMESTAMPDIFF(YEAR, m.fecha_nacimiento, CURDATE())) as edad_promedio,
    COUNT(DISTINCT m.id_raza) as razas_diferentes
FROM Mascota m
JOIN EstadoAdopcion ea ON m.id_estado_adopcion = ea.id_estado_adopcion
GROUP BY ea.descripcion
ORDER BY cantidad DESC;

-- Consulta 3: SUBQUERY - Mascotas con más de 2 revisiones médicas
CREATE OR REPLACE VIEW consulta_subquery AS
SELECT 
    m.nombre,
    s.descripcion as sexo,
    raza.descripcion as raza,
    (SELECT COUNT(*) FROM ValoracionMedica WHERE id_mascota = m.id_mascota) as total_revisiones
FROM Mascota m
LEFT JOIN Sexo s ON m.id_sexo = s.id_sexo
LEFT JOIN Raza raza ON m.id_raza = raza.id_raza
WHERE (SELECT COUNT(*) FROM ValoracionMedica WHERE id_mascota = m.id_mascota) > 2;

-- Consulta 4: MULTIPLE JOIN - Información completa de adopciones
CREATE OR REPLACE VIEW consulta_multiple_join AS
SELECT 
    a.id_adopcion,
    m.nombre as mascota,
    p.nombre as adoptante,
    pe.nombre as rescatista,
    re.ubicacion_rescate,
    re.fecha_rescate,
    a.fecha_solicitud,
    a.fecha_entrega,
    ep.descripcion as estado_proceso,
    s.descripcion as sexo,
    raza.descripcion as raza
FROM Adopta a
JOIN Mascota m ON a.id_mascota = m.id_mascota
JOIN Persona p ON a.id_persona = p.id_persona
LEFT JOIN Rescate re ON m.id_mascota = re.id_mascota
LEFT JOIN Persona pe ON re.id_persona = pe.id_persona
LEFT JOIN Sexo s ON m.id_sexo = s.id_sexo
LEFT JOIN Raza raza ON m.id_raza = raza.id_raza
LEFT JOIN EstadoProcesoAdopcion ep ON a.id_estado_proceso = ep.id_estado_proceso
ORDER BY a.fecha_solicitud DESC;

-- Consulta 5: REUNIÓN NATURAL - Personas y sus roles
CREATE OR REPLACE VIEW consulta_reunion_natural AS
SELECT 
    p.id_persona,
    p.nombre,
    p.telefono,
    p.correo_electronico,
    CASE 
        WHEN a.id_persona IS NOT NULL THEN 'Adoptante'
        WHEN re.id_persona IS NOT NULL THEN 'Rescatista'
        ELSE 'Sin rol'
    END as rol,
    a.direccion,
    o.descripcion as ocupacion,
    ro.descripcion as rol_rescatista
FROM Persona p
NATURAL LEFT JOIN Adoptante a
NATURAL LEFT JOIN Rescatista re
LEFT JOIN Ocupacion o ON a.id_ocupacion = o.id_ocupacion
LEFT JOIN Rol ro ON re.id_rol = ro.id_rol;

-- Consulta 6: PRODUCTO CARTESIANO - Mascotas y adoptantes (combinaciones posibles)
CREATE OR REPLACE VIEW consulta_producto_cartesiano AS
SELECT 
    m.nombre as mascota,
    m.id_mascota,
    p.nombre as adoptante,
    p.id_persona
FROM Mascota m, Persona p
WHERE m.id_estado_adopcion = 1
LIMIT 20;

-- Consulta 7: DIFERENCIA - Mascotas sin adopciones
CREATE OR REPLACE VIEW consulta_diferencia AS
SELECT 
    m.id_mascota,
    m.nombre,
    s.descripcion as sexo,
    raza.descripcion as raza,
    ea.descripcion as estado
FROM Mascota m
LEFT JOIN Adopta a ON m.id_mascota = a.id_mascota
LEFT JOIN Sexo s ON m.id_sexo = s.id_sexo
LEFT JOIN Raza raza ON m.id_raza = raza.id_raza
LEFT JOIN EstadoAdopcion ea ON m.id_estado_adopcion = ea.id_estado_adopcion
WHERE a.id_mascota IS NULL;

-- Consulta 8: INTERSECT - Mascotas que han sido rescatadas y tienen adopción
CREATE OR REPLACE VIEW consulta_intersect AS
SELECT DISTINCT
    m.id_mascota,
    m.nombre,
    s.descripcion as sexo,
    raza.descripcion as raza
FROM Mascota m
JOIN Rescate re ON m.id_mascota = re.id_mascota
JOIN Adopta a ON m.id_mascota = a.id_mascota
LEFT JOIN Sexo s ON m.id_sexo = s.id_sexo
LEFT JOIN Raza raza ON m.id_raza = raza.id_raza;

-- Consulta 9: PROYECCIÓN GENERALIZADA - Datos completos de mascotas con cálculos
CREATE OR REPLACE VIEW consulta_proyeccion AS
SELECT 
    m.id_mascota,
    m.nombre,
    s.descripcion as sexo,
    raza.descripcion as raza,
    m.fecha_nacimiento,
    TIMESTAMPDIFF(YEAR, m.fecha_nacimiento, CURDATE()) as edad_anios,
    TIMESTAMPDIFF(MONTH, m.fecha_nacimiento, CURDATE()) as edad_meses,
    DAY(m.fecha_nacimiento) as dia_nacimiento,
    MONTH(m.fecha_nacimiento) as mes_nacimiento,
    YEAR(m.fecha_nacimiento) as anio_nacimiento,
    ea.descripcion as estado,
    (SELECT COUNT(*) FROM Adopta WHERE id_mascota = m.id_mascota) as total_adopciones,
    (SELECT COUNT(*) FROM ValoracionMedica WHERE id_mascota = m.id_mascota) as total_revisiones,
    (SELECT COUNT(*) FROM Rescate WHERE id_mascota = m.id_mascota) as total_rescates
FROM Mascota m
LEFT JOIN Sexo s ON m.id_sexo = s.id_sexo
LEFT JOIN Raza raza ON m.id_raza = raza.id_raza
LEFT JOIN EstadoAdopcion ea ON m.id_estado_adopcion = ea.id_estado_adopcion;

-- Consulta 10: ASIGNACIÓN - Renombrar columnas para mejor entendimiento
CREATE OR REPLACE VIEW consulta_asignacion AS
SELECT 
    p.nombre AS "Nombre Adoptante",
    p.telefono AS "Teléfono Adoptante",
    m.nombre AS "Nombre Mascota",
    s.descripcion AS "Sexo Mascota",
    raza.descripcion AS "Raza Mascota",
    ea.descripcion AS "Estado Mascota",
    a.fecha_solicitud AS "Fecha Solicitud",
    ep.descripcion AS "Estado Proceso"
FROM Adopta a
JOIN Persona p ON a.id_persona = p.id_persona
JOIN Mascota m ON a.id_mascota = m.id_mascota
LEFT JOIN Sexo s ON m.id_sexo = s.id_sexo
LEFT JOIN Raza raza ON m.id_raza = raza.id_raza
LEFT JOIN EstadoAdopcion ea ON m.id_estado_adopcion = ea.id_estado_adopcion
LEFT JOIN EstadoProcesoAdopcion ep ON a.id_estado_proceso = ep.id_estado_proceso;

-- Consulta 11: DIVISIÓN - Mascotas adoptadas por todos los tipos de adoptantes
CREATE OR REPLACE VIEW consulta_division AS
SELECT 
    m.id_mascota,
    m.nombre,
    COUNT(DISTINCT a.id_persona) as total_adoptantes,
    COUNT(DISTINCT o.id_ocupacion) as ocupaciones_diferentes
FROM Mascota m
JOIN Adopta a ON m.id_mascota = a.id_mascota
JOIN Adoptante ad ON a.id_persona = ad.id_persona
JOIN Ocupacion o ON ad.id_ocupacion = o.id_ocupacion
GROUP BY m.id_mascota, m.nombre
HAVING COUNT(DISTINCT o.id_ocupacion) >= 2;

-- Consulta 12: REVOKE (simulada) - Reporte de permisos
CREATE OR REPLACE VIEW consulta_revoke AS
SELECT 
    'Administrador' as usuario,
    'Todos los datos' as permiso,
    'SELECT, INSERT, UPDATE, DELETE' as operaciones
UNION ALL
SELECT 'Personal Adopciones', 'Datos de adopciones', 'SELECT, UPDATE'
UNION ALL
SELECT 'Veterinario', 'Datos médicos', 'SELECT, INSERT, UPDATE'
UNION ALL
SELECT 'Rescatista', 'Mascotas asignadas', 'SELECT, UPDATE'
UNION ALL
SELECT 'Adoptante', 'Mascotas disponibles', 'SELECT';

-- Consulta 13: ALTER - Historial de cambios de estado
CREATE OR REPLACE VIEW consulta_alter AS
SELECT 
    m.id_mascota,
    m.nombre,
    m.fecha_nacimiento,
    s.descripcion as sexo,
    raza.descripcion as raza,
    ea.descripcion as estado_actual,
    (SELECT COUNT(*) FROM Adopta WHERE id_mascota = m.id_mascota) as veces_adoptado,
    CASE 
        WHEN (SELECT COUNT(*) FROM Adopta WHERE id_mascota = m.id_mascota) > 1 THEN 'Múltiples intentos'
        WHEN (SELECT COUNT(*) FROM Adopta WHERE id_mascota = m.id_mascota) = 1 THEN 'Adoptado una vez'
        ELSE 'Nunca adoptado'
    END as historial_adopcion
FROM Mascota m
LEFT JOIN Sexo s ON m.id_sexo = s.id_sexo
LEFT JOIN Raza raza ON m.id_raza = raza.id_raza
LEFT JOIN EstadoAdopcion ea ON m.id_estado_adopcion = ea.id_estado_adopcion
ORDER BY veces_adoptado DESC;

-- Consulta 14: GRANT - Resumen de accesos por rol
CREATE OR REPLACE VIEW consulta_grant AS
SELECT 
    ro.descripcion as rol,
    COUNT(DISTINCT re.id_persona) as cantidad_usuarios,
    'SELECT, INSERT, UPDATE' as permisos_base,
    CASE ro.id_rol
        WHEN 3 THEN 'Acceso a todos los datos médicos'
        WHEN 1 THEN 'Acceso a rescates y asignaciones'
        ELSE 'Acceso general'
    END as privilegios_especiales
FROM Rol ro
LEFT JOIN Rescatista re ON ro.id_rol = re.id_rol
GROUP BY ro.id_rol, ro.descripcion;

-- Consulta 15: DROP - Mascotas con información incompleta (para revisión)
CREATE OR REPLACE VIEW consulta_drop AS
SELECT 
    m.id_mascota,
    m.nombre,
    CASE WHEN m.id_sexo IS NULL THEN '❌' ELSE '✅' END as sexo_completo,
    CASE WHEN m.id_raza IS NULL THEN '❌' ELSE '✅' END as raza_completa,
    CASE WHEN m.fecha_nacimiento IS NULL THEN '❌' ELSE '✅' END as fecha_completa,
    CASE WHEN m.id_estado_adopcion IS NULL THEN '❌' ELSE '✅' END as estado_completo,
    CASE WHEN m.imagen IS NULL OR m.imagen = '' THEN '❌' ELSE '✅' END as imagen_completa,
    (SELECT COUNT(*) FROM ValoracionMedica WHERE id_mascota = m.id_mascota) as revisiones
FROM Mascota m
WHERE m.id_sexo IS NULL 
   OR m.id_raza IS NULL 
   OR m.fecha_nacimiento IS NULL 
   OR m.id_estado_adopcion IS NULL
   OR m.imagen IS NULL 
   OR m.imagen = '';
