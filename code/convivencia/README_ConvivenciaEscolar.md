# Módulo de Convivencia Escolar

## Descripción
Este módulo permite gestionar los documentos relacionados con la convivencia escolar de las instituciones educativas. El sistema maneja tres tipos de documentos:

1. **Conformación del Comité** - Documentos que establecen la conformación del Comité de Convivencia Escolar
2. **Reglamento de Convivencia** - Reglamentos del Comité de Convivencia Escolar
3. **Actas de Reuniones** - Actas de las reuniones del Comité de Convivencia Escolar

## Funcionalidades

### Gestión de Documentos
- **Subir documentos** por tipo (conformación, reglamento, actas)
- **Listar documentos** organizados por tipo y año
- **Filtrar por año** todos los documentos
- **Visualizar documentos** en nueva ventana
- **Descargar documentos** directamente
- **Eliminar documentos** con confirmación

### Características Técnicas
- Soporte completo para **UTF-8** (acentos, ñ, caracteres especiales)
- Formatos soportados: **PDF, DOC, DOCX**
- Tamaño máximo de archivo: **50MB**
- Interfaz responsive con **Bootstrap 5**
- Validaciones de seguridad
- Mensajes de confirmación con **SweetAlert2**

## Estructura de Archivos

### Archivos Principales
```
code/convivencia/
├── convivenciaEscolar.php          # Página principal - listado de documentos
├── subirConvivenciaEscolar.php     # Formulario de subida de documentos
├── procesarConvivenciaEscolar.php  # Procesamiento de archivos subidos
├── eliminarConvivenciaEscolar.php  # Eliminación de documentos
└── crear_tabla_convivencia_escolar.sql # Script SQL para crear la tabla
```

### Base de Datos
**Tabla:** `convivencia_escolar`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | int(11) | ID único del documento |
| id_cole | int(11) | ID del colegio |
| anio_documento | int(4) | Año del documento |
| tipo_documento | enum | Tipo: 'conformacion', 'reglamento', 'actas' |
| nombre_archivo | varchar(255) | Nombre del archivo en servidor |
| nombre_original | varchar(255) | Nombre original del archivo |
| version | varchar(20) | Versión del documento |
| descripcion | text | Descripción del documento |
| numero_acta | varchar(50) | Número de acta (solo para actas) |
| fecha_reunion | date | Fecha de reunión (solo para actas) |
| ruta_archivo | varchar(500) | Ruta completa del archivo |
| tamano_archivo | bigint(20) | Tamaño en bytes |
| fecha_subida | datetime | Fecha y hora de subida |
| id_usuario | int(11) | Usuario que subió el archivo |
| activo | tinyint(1) | Estado del documento |

## Instalación

### 1. Crear la tabla en la base de datos
```bash
mysql -u usuario -p nombre_base_datos < crear_tabla_convivencia_escolar.sql
```

### 2. Verificar permisos de carpetas
Asegurar que el servidor web tenga permisos de escritura en:
```
code/convivencia/files/
```

### 3. Configuración de PHP
Verificar las siguientes configuraciones en `php.ini`:
```ini
upload_max_filesize = 50M
post_max_size = 50M
max_execution_time = 300
memory_limit = 256M
```

## Uso del Sistema

### Subir un Documento
1. Acceder a "Convivencia Escolar" desde el menú principal
2. Hacer clic en el botón correspondiente:
   - "Subir Conformación" - para documentos de conformación
   - "Subir Reglamento" - para reglamentos
   - "Subir Actas" - para actas de reuniones
3. Completar el formulario:
   - **Año del documento** (obligatorio)
   - **Versión** (opcional, por defecto 1.0)
   - **Descripción** (opcional, máximo 500 caracteres)
   - Para actas: **Número de acta** y **Fecha de reunión** (opcionales)
   - **Archivo** (obligatorio, PDF/DOC/DOCX, máximo 50MB)
4. Confirmar y guardar

### Gestionar Documentos
- **Ver**: Abrir documento en nueva ventana
- **Descargar**: Descargar archivo al dispositivo
- **Eliminar**: Eliminar documento (requiere confirmación)
- **Filtrar**: Usar el filtro por año para mostrar solo documentos de un año específico

### Organización por Tipos
Los documentos se muestran organizados en tres secciones:
1. **Conformación del Comité** (verde)
2. **Reglamento de Convivencia** (azul)
3. **Actas de Reuniones** (amarillo)

## Características de Seguridad

### Validaciones de Archivo
- Verificación de tipo MIME
- Validación de extensión
- Límite de tamaño
- Nombres únicos para evitar conflictos

### Control de Acceso
- Verificación de sesión activa
- Validación de permisos por colegio
- Solo usuarios autorizados pueden gestionar documentos

### Manejo de Errores
- Validación de datos de entrada
- Mensajes de error descriptivos
- Rollback en caso de fallos
- Logs de actividad

## Integración

### Menú Principal
Para integrar en el menú principal, agregar:
```php
<a href="code/convivencia/convivenciaEscolar.php">
    <i class="fas fa-users"></i> Convivencia Escolar
</a>
```

### Navegación
El módulo incluye navegación consistente:
- Botón "Regresar" en formularios
- Enlaces de retorno a la página principal
- Breadcrumbs implícitos

## Mantenimiento

### Respaldos
Recomendaciones para respaldos:
1. **Base de datos**: Incluir tabla `convivencia_escolar`
2. **Archivos**: Respaldar carpeta `files/*/convivencia_escolar/`

### Monitoreo
- Verificar espacio en disco periódicamente
- Revisar logs de errores de PHP
- Monitorear tamaño de archivos subidos

### Limpieza
- Revisar archivos huérfanos (sin registro en BD)
- Eliminar documentos muy antiguos según políticas
- Optimizar tablas de base de datos

## Soporte Técnico

### Problemas Comunes
1. **Error de subida**: Verificar permisos y tamaño de archivo
2. **Caracteres raros**: Verificar configuración UTF-8
3. **Archivos no se muestran**: Verificar rutas y permisos

### Logs
Los errores se registran en:
- Error log de PHP
- Logs personalizados del sistema

## Versiones
- **v1.0** - Implementación inicial con tres tipos de documentos
- Soporte UTF-8 completo
- Interfaz moderna con Bootstrap 5
- Validaciones de seguridad

---
*Desarrollado para el Sistema PEI SOFT - Secretaría de Educación*
