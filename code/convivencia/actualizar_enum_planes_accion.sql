-- Script para agregar 'planes_accion' al ENUM de tipo_documento
-- Ejecutar este script en la base de datos para permitir el nuevo tipo

-- Configurar la conexión para UTF-8
SET NAMES utf8mb4;
SET character_set_client = utf8mb4;
SET character_set_connection = utf8mb4;
SET character_set_results = utf8mb4;
SET collation_connection = utf8mb4_unicode_ci;

-- Actualizar el ENUM para incluir 'planes_accion'
ALTER TABLE `convivencia_escolar` 
MODIFY `tipo_documento` enum('conformacion','reglamento','actas','planes_accion') NOT NULL 
COMMENT 'Tipo de documento: conformación, reglamento, actas o planes de acción';

-- Verificar que el cambio se aplicó correctamente
SHOW COLUMNS FROM convivencia_escolar LIKE 'tipo_documento';

-- Mostrar cualquier registro existente para verificar integridad
SELECT COUNT(*) as total_registros, tipo_documento 
FROM convivencia_escolar 
GROUP BY tipo_documento;