# Módulo Manual de Convivencia

Este módulo permite a las instituciones educativas subir, gestionar y visualizar sus manuales de convivencia organizados por año.

## 📋 Características

- ✅ Subida de archivos PDF, DOC y DOCX
- ✅ Organización por año
- ✅ Filtrado por año
- ✅ Información detallada de cada archivo
- ✅ Validación de archivos (tipo y tamaño)
- ✅ Vinculación automática con la institución educativa
- ✅ Gestión de versiones
- ✅ Descripciones opcionales
- ✅ **Interfaz mejorada con botones grandes y claros**
- ✅ **Botones separados para Ver y Descargar**
- ✅ **Diseño responsivo para dispositivos móviles**
- ✅ **Efectos visuales y hover mejorados**

## 🚀 Instalación

1. **Crear la tabla en la base de datos:**
   - Visita: `convivencia/instalar.php`
   - O ejecuta el archivo SQL: `crear_tabla_manual_convivencia.sql`

2. **Verificar permisos:**
   - El directorio `files/` debe tener permisos de escritura (755 o 777)

## 📁 Estructura de Archivos

```
convivencia/
├── manualConvivencia.php       # Página principal - listado de manuales
├── subirManual.php            # Formulario para subir nuevos manuales
├── procesarManual.php         # Procesa la subida de archivos
├── eliminarManual.php         # Elimina manuales
├── instalar.php              # Instalador del módulo
├── crear_tabla_manual_convivencia.sql  # Script SQL
├── files/                    # Directorio para archivos subidos
│   └── [id_cole]/
│       └── [año]/
│           └── [archivos]
└── README.md                 # Este archivo
```

## 🗂️ Organización de Archivos

Los archivos se organizan de la siguiente manera:
```
files/
└── [ID_COLEGIO]/
    ├── 2023/
    │   ├── Manual_Convivencia_2023_20240115123456.pdf
    │   └── Manual_Convivencia_2023_20240215123456.pdf
    ├── 2024/
    │   └── Manual_Convivencia_2024_20240315123456.pdf
    └── 2025/
        └── Manual_Convivencia_2025_20240415123456.pdf
```

## 🔧 Configuración

### Tamaños y Tipos de Archivo Permitidos

- **Tipos:** PDF, DOC, DOCX
- **Tamaño máximo:** 50 MB
- **Extensiones:** .pdf, .doc, .docx

### Base de Datos

La tabla `manual_convivencia` tiene la siguiente estructura:

| Campo           | Tipo         | Descripción                           |
|-----------------|--------------|---------------------------------------|
| id              | int(11)      | ID único del manual                   |
| id_cole         | int(11)      | ID del colegio                        |
| anio_manual     | int(4)       | Año del manual                        |
| nombre_archivo  | varchar(255) | Nombre del archivo en el servidor     |
| nombre_original | varchar(255) | Nombre original del archivo           |
| version         | varchar(20)  | Versión del manual                    |
| descripcion     | text         | Descripción opcional                  |
| ruta_archivo    | varchar(500) | Ruta completa del archivo             |
| tamaño_archivo  | bigint(20)   | Tamaño en bytes                       |
| fecha_subida    | datetime     | Fecha y hora de subida                |
| id_usuario      | int(11)      | Usuario que subió el archivo          |
| activo          | tinyint(1)   | Estado del manual (1=activo)          |

## 🎯 Uso

1. **Acceder al módulo:**
   - Desde el menú de la institución educativa
   - Seleccionar "Convivencia" > "Manual Convivencia"

2. **Subir un nuevo manual:**
   - Hacer clic en "Subir Manual de Convivencia"
   - Seleccionar el año
   - Añadir versión y descripción (opcional)
   - Seleccionar el archivo
   - Confirmar y guardar

3. **Ver manuales:**
   - En la página principal se muestran todos los manuales
   - Se puede filtrar por año
   - Cada manual muestra información detallada

4. **Gestionar manuales:**
   - **Ver:** hacer clic en el botón azul "Ver" para abrir el archivo en una nueva ventana
   - **Descargar:** hacer clic en el botón verde "Descargar" para descargar el archivo
   - **Eliminar:** hacer clic en el botón rojo "Eliminar" para eliminar el manual
   - Los botones son grandes, claros y tienen texto descriptivo
   - En dispositivos móviles, los botones se apilan verticalmente para mejor usabilidad

## 🎨 Interfaz de Usuario

### Mejoras Visuales v1.1
- **Botones grandes y amigables:** Los botones de acción ahora son más grandes (120px mínimo) con texto descriptivo
- **Colores diferenciados:**
  - 🔵 Azul para "Ver" archivos
  - 🟢 Verde para "Descargar" archivos  
  - 🔴 Rojo para "Eliminar" archivos
  - ⚫ Gris para archivos no disponibles
- **Efectos hover:** Los botones se elevan ligeramente al pasar el cursor
- **Diseño responsivo:** En pantallas pequeñas los botones se apilan verticalmente
- **Confirmación mejorada:** El diálogo de eliminación muestra más información del archivo

## � Codificación de Caracteres

### Soporte UTF-8 Completo
Este módulo tiene **soporte completo para UTF-8** incluyendo:
- ✅ Caracteres especiales: **ñ, Ñ, á, é, í, ó, ú, ü, ¡, ¿**
- ✅ Base de datos configurada con `utf8mb4`
- ✅ Headers HTTP con charset UTF-8
- ✅ Meta tags HTML correctos
- ✅ Conexión MySQL con charset apropiado

### Solución de Problemas UTF-8
Si ves caracteres como "?" en lugar de "ñ":

1. **Verificar codificación:**
   - Visita: `convivencia/test_utf8.php`

2. **Reparar automáticamente:**
   - Visita: `convivencia/fix_utf8.php`
   - Ejecuta la conversión de tabla

3. **Verificar archivos:**
   - Todos los archivos PHP deben estar en UTF-8 sin BOM
   - Ver: `SOLUCION_UTF8.md` para detalles completos

## �🔒 Seguridad

- ✅ Validación de tipos de archivo
- ✅ Validación de tamaño de archivo
- ✅ Verificación de permisos por institución
- ✅ Protección contra acceso directo a archivos
- ✅ Sanitización de nombres de archivo
- ✅ Verificación de sesión de usuario

## 🐛 Solución de Problemas

### Error: "No se pudo crear el directorio"
- Verificar permisos de escritura en el directorio `files/`
- Cambiar permisos: `chmod 755 files/` o `chmod 777 files/`

### Error: "Archivo demasiado grande"
- Verificar configuración PHP:
  - `upload_max_filesize` en php.ini
  - `post_max_size` en php.ini
  - `max_execution_time` en php.ini

### Error: "Tabla no existe"
- Ejecutar el instalador: `convivencia/instalar.php`
- O ejecutar manualmente el SQL: `crear_tabla_manual_convivencia.sql`

## 📞 Soporte

Si tienes problemas con este módulo:

1. Verificar que la tabla existe en la base de datos
2. Verificar permisos de archivos y directorios
3. Revisar logs de errores del servidor
4. Verificar configuración PHP para subida de archivos

## 🔄 Versiones

- **v1.1** - Mejoras en la interfaz de usuario
  - Botones grandes y amigables con texto descriptivo
  - Colores diferenciados para cada acción
  - Efectos visuales y hover mejorados
  - Diseño responsivo para móviles
  - Botón separado para descargar archivos
  - Confirmación de eliminación mejorada

- **v1.0** - Versión inicial con funcionalidades básicas
  - Subida de archivos
  - Filtrado por año
  - Gestión básica de manuales

---

**Desarrollado para el Sistema PEI | SOFT**
