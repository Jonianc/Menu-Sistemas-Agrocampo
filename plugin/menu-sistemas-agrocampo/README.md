# Menú Sistemas Agrocampo

Plugin WordPress para publicar un menú standalone en frontend con accesos a los sistemas de Agrocampo.

## Árbol de archivos
```
menu-sistemas-agrocampo/
├── menu-sistemas-agrocampo.php
├── includes/
│   ├── class-msa-activator.php
│   ├── class-msa-admin.php
│   ├── class-msa-deactivator.php
│   ├── class-msa-frontend.php
│   ├── class-msa-plugin.php
│   └── class-msa-settings.php
├── templates/
│   ├── admin-settings.php
│   └── standalone.php
├── assets/
│   ├── css/
│   │   ├── menu-sistemas-agrocampo-admin.css
│   │   └── menu-sistemas-agrocampo.css
│   └── js/
│       └── menu-sistemas-agrocampo-admin.js
├── CHANGELOG.md
└── README.md
```

## Instalación
1. Copia la carpeta `menu-sistemas-agrocampo` dentro de `wp-content/plugins/`.
2. Activa el plugin desde **Plugins** en el panel de WordPress.
3. (Opcional) Re-guardar los enlaces permanentes para asegurar la regla de reescritura.

## Configuración
1. En el panel encontrarás **Menú Sistemas**.
2. Ajusta el título, subtítulo, logo y layout del header.
3. Configura el **link de acceso rápido** para mostrar un botón adicional en el header.
4. Configura apertura de enlaces (misma o nueva pestaña).
5. Agrega, elimina, oculta temporalmente o etiqueta los sistemas y sus accesos.

## Uso (frontend standalone)
El menú queda disponible en la ruta:
```
/menu-sistemas-agrocampo
```

## Changelog breve
- **1.4.4**: Añade vista previa en vivo en admin para visualizar cambios del menú antes de guardar.
- **1.4.3**: Agrega nonce admin dedicado y validación de sesión en acciones destructivas (eliminar sistema/acceso).
- **1.4.2**: Endurece validación de accesos (requiere nombre + URL) y evita render de enlaces incompletos en frontend.
- **1.4.1**: Se agrega bloque de acceso rápido a la ruta pública en admin y submenú de Ajustes.
- **1.4.0**: Sprint 3 agrega visibilidad por sistema, etiqueta (badge) y configuración global de apertura de enlaces.
- **1.3.1**: Corrige comportamiento de drag & drop en admin con inicialización/reindexación robusta y actualización de estado sortable.
- **1.3.0**: Sprint 2 agrega reordenamiento drag & drop en admin, mejoras de accesibilidad de foco en frontend y estado vacío en frontend.
- **1.2.2**: Se agrega confirmación al eliminar sistemas y estado vacío en admin al no existir elementos.
- **1.2.1**: Se crea `CHANGELOG.md` y se referencia como historial principal de cambios.
- **1.2.0**: Mejora UX del panel admin con eliminación de sistemas, validación inline de URLs y separación de estilos admin en CSS dedicado.
- **1.1.0**: Reestructura a arquitectura de clases + templates, agrega link de acceso rápido y mantiene controles dinámicos de sistemas/accesos para mejor mantenimiento y escalabilidad.

Para el historial completo revisa `CHANGELOG.md`.

## Checklist de pruebas manuales
- [ ] Activar el plugin sin warnings en WP 6.x / PHP 8.x.
- [ ] Visitar `/menu-sistemas-agrocampo` y validar render sin theme.
- [ ] Cambiar título/subtítulo/logo y verificar en frontend.
- [ ] Probar layouts (centrado, logo derecha, logo izquierda).
- [ ] Configurar link de acceso rápido y validar botón en header.
- [ ] Agregar/Eliminar sistemas y accesos; guardar y validar persistencia.
- [ ] Verificar enlaces en nueva pestaña y sanitización de URLs.

## Notas
- El menú se renderiza sin depender del theme activo.
- Los enlaces se abren en una nueva pestaña.
