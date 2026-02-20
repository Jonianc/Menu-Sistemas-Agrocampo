# Changelog

Todos los cambios importantes de este plugin se documentan en este archivo.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/es-ES/1.1.0/) y este proyecto adhiere a versionado semántico.

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
