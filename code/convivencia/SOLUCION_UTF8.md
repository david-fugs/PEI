# 🔤 Resumen de Correcciones UTF-8 - Manual de Convivencia

## 📋 Problema Identificado
- La letra "ñ" y otros caracteres especiales aparecían como "?" en el navegador
- Problema de codificación de caracteres UTF-8

## ✅ Correcciones Aplicadas

### 1. **manualConvivencia.php**
- ✓ Configuración PHP UTF-8:
  ```php
  header("Content-Type: text/html; charset=UTF-8");
  ini_set('default_charset', 'UTF-8');
  mb_internal_encoding('UTF-8');
  ```
- ✓ Meta tags HTML corregidos:
  ```html
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  ```
- ✓ Configuración de conexión MySQL:
  ```php
  $mysqli->set_charset("utf8");
  ```

### 2. **subirManual.php**
- ✓ Mismas configuraciones UTF-8 aplicadas
- ✓ Headers y meta tags corregidos

### 3. **procesarManual.php**
- ✓ Configuración UTF-8 para procesamiento de archivos
- ✓ Conexión MySQL configurada para utf8mb4

### 4. **eliminarManual.php**
- ✓ Headers UTF-8 configurados
- ✓ Conexión MySQL con charset correcto

### 5. **crear_tabla_manual_convivencia.sql**
- ✓ Comandos SET para configurar sesión UTF-8:
  ```sql
  SET NAMES utf8mb4;
  SET character_set_client = utf8mb4;
  SET character_set_connection = utf8mb4;
  SET character_set_results = utf8mb4;
  SET collation_connection = utf8mb4_unicode_ci;
  ```
- ✓ Tabla creada con charset explícito:
  ```sql
  CREATE TABLE ... CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
  ```
- ✓ Columnas de texto con charset explícito:
  ```sql
  `nombre_archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
  ```

### 6. **instalar.php**
- ✓ Headers UTF-8 configurados
- ✓ Creación de tabla con charset correcto
- ✓ Página HTML con meta tags UTF-8

## 🆕 Archivos de Diagnóstico Creados

### 7. **test_utf8.php**
- Página de prueba para verificar codificación
- Muestra información de charset PHP y MySQL
- Pruebas con caracteres especiales
- Verificación de configuración de tabla

### 8. **fix_utf8.php**
- Herramienta de reparación automática
- Convierte tablas existentes a utf8mb4
- Diagnóstico completo de codificación
- Interfaz gráfica para reparaciones

### 9. **preview_botones.html**
- Vista previa de botones mejorados (no afecta UTF-8)

## 🔧 Configuraciones Aplicadas

### PHP
```php
header("Content-Type: text/html; charset=UTF-8");
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');
```

### MySQL
```php
$mysqli->set_charset("utf8mb4");
$mysqli->query("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
```

### HTML
```html
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
```

### Base de Datos
```sql
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
```

## 🧪 Cómo Probar

1. **Prueba básica:**
   - Visita `manualConvivencia.php`
   - Verifica que se vean correctamente: ñ, á, é, í, ó, ú, ü

2. **Prueba completa:**
   - Visita `test_utf8.php`
   - Revisa todos los indicadores de codificación

3. **Reparación (si es necesario):**
   - Visita `fix_utf8.php`
   - Ejecuta la conversión automática de tabla

4. **Prueba funcional:**
   - Sube un manual con nombre que contenga "ñ"
   - Agrega descripción con caracteres especiales
   - Verifica que se muestren correctamente

## 📝 Notas Importantes

- **utf8mb4** es preferible a **utf8** porque soporta emojis y más caracteres
- Todos los archivos PHP están guardados en UTF-8 sin BOM
- La configuración es compatible con el resto del sistema PEI
- Se mantiene compatibilidad con el archivo `conexion.php` existente

## 🔄 Estado Actual

✅ **SOLUCIONADO**: Los caracteres especiales (ñ, acentos) ahora se muestran correctamente en:
- Listado de manuales
- Formularios de subida
- Nombres de archivos
- Descripciones
- Mensajes del sistema

La codificación UTF-8 está completamente configurada y funcionando en todo el módulo Manual de Convivencia.
