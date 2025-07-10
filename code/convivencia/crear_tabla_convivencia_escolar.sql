-- Configurar la conexión para UTF-8
SET NAMES utf8mb4;
SET character_set_client = utf8mb4;
SET character_set_connection = utf8mb4;
SET character_set_results = utf8mb4;
SET collation_connection = utf8mb4_unicode_ci;

-- Tabla para almacenar los documentos de convivencia escolar
CREATE TABLE IF NOT EXISTS `convivencia_escolar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cole` int(11) NOT NULL,
  `anio_documento` int(4) NOT NULL,
  `tipo_documento` enum('conformacion','reglamento','actas') NOT NULL,
  `nombre_archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_original` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '1.0',
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `numero_acta` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_reunion` date DEFAULT NULL,
  `ruta_archivo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tamano_archivo` bigint(20) NOT NULL,
  `fecha_subida` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_id_cole` (`id_cole`),
  KEY `idx_anio_documento` (`anio_documento`),
  KEY `idx_tipo_documento` (`tipo_documento`),
  KEY `idx_fecha_subida` (`fecha_subida`),
  KEY `idx_convivencia_activo` (`activo`),
  KEY `idx_convivencia_cole_anio_tipo` (`id_cole`, `anio_documento`, `tipo_documento`),
  CONSTRAINT `fk_convivencia_escolar_colegio` FOREIGN KEY (`id_cole`) REFERENCES `colegios` (`id_cole`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Índices adicionales para optimizar las consultas
CREATE INDEX `idx_convivencia_cole_tipo` ON `convivencia_escolar` (`id_cole`, `tipo_documento`);

-- Comentarios para documentar la tabla
ALTER TABLE `convivencia_escolar` 
COMMENT = 'Tabla para almacenar los documentos de convivencia escolar (conformación, reglamento, actas) - Codificación UTF-8';

-- Comentarios para las columnas principales
ALTER TABLE `convivencia_escolar` 
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único del documento',
MODIFY `id_cole` int(11) NOT NULL COMMENT 'ID del colegio al que pertenece el documento',
MODIFY `anio_documento` int(4) NOT NULL COMMENT 'Año al que corresponde el documento',
MODIFY `tipo_documento` enum('conformacion','reglamento','actas') NOT NULL COMMENT 'Tipo de documento: conformación, reglamento o actas',
MODIFY `nombre_archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del archivo en el servidor',
MODIFY `nombre_original` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre original del archivo subido',
MODIFY `version` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '1.0' COMMENT 'Versión del documento (ej: 1.0, 2.1)',
MODIFY `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Descripción opcional del documento',
MODIFY `numero_acta` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Número de acta (solo para documentos tipo actas)',
MODIFY `fecha_reunion` date DEFAULT NULL COMMENT 'Fecha de reunión (solo para documentos tipo actas)',
MODIFY `ruta_archivo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Ruta completa del archivo en el servidor',
MODIFY `tamano_archivo` bigint(20) NOT NULL COMMENT 'Tamaño del archivo en bytes',
MODIFY `fecha_subida` datetime NOT NULL COMMENT 'Fecha y hora de subida del archivo',
MODIFY `id_usuario` int(11) NOT NULL COMMENT 'ID del usuario que subió el archivo',
MODIFY `activo` tinyint(1) DEFAULT 1 COMMENT 'Estado del documento (1=activo, 0=inactivo)';
