# Validaciones de Vehículos - Documentación

## Descripción General

Este sistema de validaciones implementa verificaciones del lado del cliente para los modales de agregar y editar vehículos, siguiendo el mismo patrón de las validaciones de registro de usuarios.

## Archivos Implementados

### 1. `vehiculo_modals.php` (Modificado)
- **Ubicación:** `roles/admin/modals_vehiculos/vehiculo_modals.php`
- **Función:** Contiene los modales HTML con elementos de validación integrados
- **Cambios realizados:**
  - Agregados grupos de validación para cada campo
  - Mensajes de error específicos para cada tipo de validación
  - Placeholders informativos en los campos

### 2. `vehiculo-validaciones.js` (Nuevo)
- **Ubicación:** `roles/admin/js/vehiculo-validaciones.js`
- **Función:** Lógica de validación JavaScript
- **Características:**
  - Validación en tiempo real
  - Expresiones regulares para cada campo
  - Manejo de errores específicos
  - Limpieza automática de validaciones

### 3. `vehiculo-validaciones.css` (Nuevo)
- **Ubicación:** `roles/admin/css/vehiculo-validaciones.css`
- **Función:** Estilos visuales para las validaciones
- **Características:**
  - Indicadores visuales de éxito/error
  - Animaciones suaves
  - Diseño responsive
  - Estilos específicos para campos de placa

## Validaciones Implementadas

### 1. Placa del Vehículo
- **Formato:** 3 letras + 3 números (ej: ABC123)
- **Expresión regular:** `/^[A-Z]{3}[0-9]{3}$/`
- **Características:**
  - Conversión automática a mayúsculas
  - Validación en tiempo real
  - Mensaje de error específico

### 2. Año del Vehículo
- **Rango:** 1900 hasta año actual + 1
- **Validación:** Número entero dentro del rango
- **Características:**
  - Validación dinámica del año máximo
  - Mensaje de error con rango específico

### 3. Modelo del Vehículo
- **Formato:** Letras, números, espacios, guiones
- **Longitud:** 2-50 caracteres
- **Expresión regular:** `/^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s\-]{2,50}$/`
- **Características:**
  - Incluye acentos y ñ
  - Permite guiones para modelos compuestos

### 4. Kilometraje Actual
- **Rango:** 0 a 999,999
- **Validación:** Número entero positivo
- **Características:**
  - Límite máximo realista
  - Validación de rango específico

### 5. Campos Select (Obligatorios)
- **Validación:** No puede estar vacío
- **Campos incluidos:**
  - Tipo de vehículo
  - Marca
  - Color
  - Estado
  - Propietario

## Funcionalidades Adicionales

### 1. Validación en Tiempo Real
- Los campos se validan mientras el usuario escribe
- Feedback visual inmediato
- Mensajes de error específicos

### 2. Limpieza Automática
- Las validaciones se limpian al abrir los modales
- Estado limpio para cada nueva operación

### 3. Enfoque Automático
- Al enviar el formulario, se enfoca en el primer campo inválido
- Mejora la experiencia del usuario

### 4. Mensajes de Error
- Mensajes específicos para cada tipo de error
- Duración automática de 3 segundos
- Posicionamiento contextual

## Cómo Implementar

### 1. Incluir los archivos CSS y JS
```html
<!-- En el head de tu página -->
<link rel="stylesheet" href="css/vehiculo-validaciones.css">

<!-- Antes del cierre del body -->
<script src="js/vehiculo-validaciones.js"></script>
```

### 2. Incluir los modales
```php
<?php include 'modals_vehiculos/vehiculo_modals.php'; ?>
```

### 3. Dependencias requeridas
```html
<!-- Bootstrap CSS y JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery (opcional, para funcionalidades adicionales) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
```

## Estructura de Clases CSS

### Campos Correctos
- `.input_field_[campo]_correcto`
- Borde verde
- Sombra verde
- Icono de check

### Campos Incorrectos
- `.input_field_[campo]_incorrecto`
- Borde rojo
- Sombra roja
- Icono de X

### Selects
- `.is-valid` - Campo válido
- `.is-invalid` - Campo inválido

## Eventos JavaScript

### Event Listeners
- `keyup` - Validación mientras escribe
- `blur` - Validación al perder foco
- `change` - Validación de selects
- `show.bs.modal` - Limpieza al abrir modal

### Funciones Principales
- `validarFormularioAgregar()` - Validación modal agregar
- `validarFormularioEditar()` - Validación modal editar
- `limpiarValidaciones()` - Limpieza de validaciones
- `mostrarErroresValidacion()` - Mostrar errores generales

## Compatibilidad

- **Navegadores:** Chrome, Firefox, Safari, Edge
- **Bootstrap:** 5.1.3+
- **jQuery:** 3.6.0+ (opcional)
- **PHP:** 7.4+

## Personalización

### Modificar Expresiones Regulares
```javascript
const expresionesVehiculo = {
    validaplaca: /^[A-Z]{3}[0-9]{3}$/, // Cambiar formato de placa
    validamodelo: /^[A-Za-z0-9\s\-]{2,50}$/, // Cambiar reglas de modelo
    // ... más validaciones
};
```

### Modificar Estilos CSS
```css
.input_field_placa_correcto {
    border-color: #your-color !important;
    box-shadow: 0 0 0 0.2rem rgba(your-color, 0.25) !important;
}
```

### Agregar Nuevas Validaciones
1. Agregar expresión regular en `expresionesVehiculo`
2. Crear función de validación específica
3. Agregar al switch de `validarFormulario`
4. Agregar elementos HTML correspondientes

## Troubleshooting

### Problemas Comunes

1. **Las validaciones no funcionan**
   - Verificar que los archivos JS y CSS estén incluidos
   - Revisar la consola del navegador para errores

2. **Los mensajes no aparecen**
   - Verificar que los IDs de los elementos coincidan
   - Revisar que los elementos HTML estén presentes

3. **Los estilos no se aplican**
   - Verificar que el archivo CSS esté incluido
   - Revisar la ruta del archivo CSS

### Debug
```javascript
// Agregar al inicio del archivo JS para debug
console.log('Validaciones de vehículos cargadas');
```

## Mantenimiento

### Actualizaciones
- Revisar regularmente las expresiones regulares
- Actualizar rangos de años automáticamente
- Mantener compatibilidad con nuevas versiones de Bootstrap

### Mejoras Futuras
- Validación de archivos de imagen
- Validación de tamaño de archivo
- Integración con validaciones del servidor
- Soporte para más formatos de placa 