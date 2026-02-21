# Changelog

Todos los cambios importantes de este plugin se documentan en este archivo.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/es-ES/1.1.0/) y este proyecto adhiere a versionado semántico.

## [1.4.6] - 2026-02-21
### Added
- Opción de allowlist de hosts (`allowed_hosts`) en ajustes admin para restringir dominios válidos de enlaces.

### Changed
- Sanitización de `quick_access_url` y accesos por sistema ahora descarta URLs fuera de los hosts permitidos cuando la allowlist está configurada.
- Normalización de hosts soporta entrada por línea o por coma y elimina protocolo/ruta/puerto antes de guardar.

## [1.4.5] - 2026-02-21
### Added
- Capability dedicada `manage_msa_menu` para delegar la administración del plugin sin usar `manage_options`.

### Changed
- Activación asigna la capability a `administrator` y `editor`; desactivación la remueve de ambos roles.
- Menú, submenú y guard de la pantalla de ajustes ahora validan `manage_msa_menu`.
- Se ajusta la capability del `options.php` para el grupo `msa_menu_settings_group`, permitiendo guardar ajustes con la capability nueva.

## [1.4.4] - 2026-02-21
### Added
- Vista previa en vivo en la pantalla de ajustes para header, acceso rápido y tarjetas de sistemas.

### Changed
- JS admin sincroniza en tiempo real la vista previa al editar campos, agregar/quitar sistemas y accesos, o subir logo.
- Nuevos estilos admin para el bloque de vista previa, con comportamiento responsive.

## [1.4.3] - 2026-02-21
### Added
- Nonce dedicado (`msa_admin_actions`) en la pantalla admin para endurecer acciones de edición sensibles.

### Changed
- JS admin ahora valida contexto de nonce antes de eliminar sistemas o accesos y muestra mensaje si la sesión no es válida.
- Sanitización backend conserva `items` previos cuando el nonce admin no es válido, evitando aplicar payload sensible sin validación.

## [1.4.2] - 2026-02-21
### Changed
- Endurece sanitización de accesos: ahora solo se guardan enlaces cuando tienen nombre y URL válidos.
- Render frontend filtra defensivamente enlaces incompletos para evitar botones vacíos o rotos.

## [1.4.1] - 2026-02-20
### Added
- Bloque de acceso rápido en admin con URL pública del menú y botón para abrirla.
- Submenú "Ajustes" bajo el menú del plugin en el admin.

### Changed
- Carga de assets admin compatible con hook de página principal y submenú.

## [1.4.0] - 2026-02-20
### Added
- Opción global para abrir enlaces en nueva pestaña (`_blank`) o misma pestaña (`_self`).
- Campo de etiqueta (badge) opcional por sistema.
- Opción por sistema para ocultarlo temporalmente desde frontend.

### Changed
- Frontend ahora renderiza solo sistemas no ocultos y muestra badge cuando está configurado.

## [1.3.1] - 2026-02-20
### Fixed
- Corrección del drag & drop en admin para operar solo sobre bloques de sistema válidos.
- Reindexación más robusta tras agregar/eliminar/reordenar elementos.
- Actualización dinámica del estado de sortable (habilitar/deshabilitar según cantidad de sistemas).

## [1.3.0] - 2026-02-20
### Added
- Reordenamiento de sistemas en admin mediante drag & drop.
- Estado vacío en frontend cuando no existen sistemas configurados.

### Changed
- Reindexación automática de campos tras ordenar/agregar/eliminar sistemas en admin para persistir correctamente.
- Mejoras de accesibilidad visual con `:focus-visible` en enlaces principales del frontend.

## [1.2.2] - 2026-02-20
### Added
- Confirmación al eliminar un sistema desde el panel admin.
- Estado vacío en admin cuando no hay sistemas configurados.

### Changed
- Ajuste del JS admin para mostrar/ocultar estado vacío dinámicamente.

## [1.2.1] - 2026-02-20
### Added
- Se crea `CHANGELOG.md` para centralizar el historial de cambios del plugin.

### Changed
- Se actualiza el `README.md` para referenciar el changelog principal.

## [1.2.0] - 2026-02-20
### Added
- Botón **Eliminar sistema** por bloque en la configuración admin.
- Validación inline de URLs en el panel admin con feedback visual.
- Nuevo archivo de estilos admin: `assets/css/menu-sistemas-agrocampo-admin.css`.

### Changed
- Se mueven estilos inline del template admin a CSS dedicado.
- Se encola CSS admin desde `includes/class-msa-admin.php`.

## [1.1.0] - 2026-02-20
### Changed
- Reestructura a arquitectura de clases + templates.
- Se agrega link de acceso rápido en header.
- Se mantienen controles dinámicos de sistemas/accesos para mejor mantenimiento y escalabilidad.
