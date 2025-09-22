-- Script SQL para crear el sistema de Circulares
-- Ejecutar este script en la base de datos del sistema PEI

-- Tabla para las circulares globales (fechas de inicio y fin)
CREATE TABLE circulares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    estado ENUM('activa', 'inactiva') DEFAULT 'activa',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    usuario_creacion INT,
    INDEX idx_fechas (fecha_inicio, fecha_fin),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla para documentos y observaciones por institución relacionados a las circulares
CREATE TABLE circular_instituciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    circular_id INT NOT NULL,
    id_cole INT NOT NULL,
    nombre_archivo VARCHAR(255),
    ruta_archivo VARCHAR(500),
    tipo_archivo VARCHAR(50),
    tamaño_archivo INT,
    observaciones TEXT,
    retroalimentacion TEXT,
    estado_institucion ENUM('pendiente', 'enviado', 'revisado', 'aprobado') DEFAULT 'pendiente',
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    usuario_subida INT,
    FOREIGN KEY (circular_id) REFERENCES circulares(id) ON DELETE CASCADE,
    FOREIGN KEY (id_cole) REFERENCES colegios(id_cole) ON DELETE CASCADE,
    INDEX idx_circular_colegio (circular_id, id_cole),
    INDEX idx_estado_institucion (estado_institucion),
    INDEX idx_fecha_subida (fecha_subida)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos de ejemplo (opcional)
INSERT INTO circulares (titulo, descripcion, fecha_inicio, fecha_fin, estado) VALUES 
('Circular 001 - Informe Académico Primer Periodo', 'Circular para la entrega de informes académicos del primer periodo académico', '2025-01-15', '2025-02-15', 'activa'),
('Circular 002 - Actualización PEI 2025', 'Circular para la actualización anual del Proyecto Educativo Institucional', '2025-02-01', '2025-03-31', 'activa');