-- Configurar la conexión para UTF-8
SET NAMES utf8mb4;
SET character_set_client = utf8mb4;
SET character_set_connection = utf8mb4;
SET character_set_results = utf8mb4;
SET collation_connection = utf8mb4_unicode_ci;

-- Tabla para almacenar los manuales de convivencia
CREATE TABLE IF NOT EXISTS `manual_convivencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cole` int(11) NOT NULL,
  `anio_manual` int(4) NOT NULL,
  `nombre_archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_original` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '1.0',
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ruta_archivo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tamaño_archivo` bigint(20) NOT NULL,
  `fecha_subida` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_id_cole` (`id_cole`),
  KEY `idx_anio_manual` (`anio_manual`),
  KEY `idx_fecha_subida` (`fecha_subida`),
  CONSTRAINT `fk_manual_convivencia_colegio` FOREIGN KEY (`id_cole`) REFERENCES `colegios` (`id_cole`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Índices adicionales para optimizar las consultas
CREATE INDEX `idx_manual_activo` ON `manual_convivencia` (`activo`);
CREATE INDEX `idx_manual_cole_anio` ON `manual_convivencia` (`id_cole`, `anio_manual`);

-- Comentarios para documentar la tabla
ALTER TABLE `manual_convivencia` 
COMMENT = 'Tabla para almacenar los manuales de convivencia de las instituciones educativas, organizados por año - Codificación UTF-8';

-- Comentarios para las columnas principales
ALTER TABLE `manual_convivencia` 
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único del manual',
MODIFY `id_cole` int(11) NOT NULL COMMENT 'ID del colegio al que pertenece el manual',
MODIFY `anio_manual` int(4) NOT NULL COMMENT 'Año al que corresponde el manual de convivencia',
MODIFY `nombre_archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del archivo en el servidor',
MODIFY `nombre_original` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre original del archivo subido',
MODIFY `version` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '1.0' COMMENT 'Versión del manual (ej: 1.0, 2.1)',
MODIFY `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Descripción opcional del manual',
MODIFY `ruta_archivo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Ruta completa del archivo en el servidor',
MODIFY `tamaño_archivo` bigint(20) NOT NULL COMMENT 'Tamaño del archivo en bytes',
MODIFY `fecha_subida` datetime NOT NULL COMMENT 'Fecha y hora de subida del archivo',
MODIFY `id_usuario` int(11) NOT NULL COMMENT 'ID del usuario que subió el archivo',
MODIFY `activo` tinyint(1) DEFAULT 1 COMMENT 'Estado del manual (1=activo, 0=inactivo)';
