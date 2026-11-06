# Actividades Realizadas Durante las Prácticas Preprofesionales - Fibercom

A continuación, se detallan las actividades realizadas durante el periodo de prácticas preprofesionales, estructuradas y alineadas directamente con las funciones del departamento donde se desarrollaron.

---

## 12. Actividades realizadas durante las prácticas pre profesionales

### Área 1: Desarrollo y Mantenimiento de Soluciones de Software
*Desarrollo del Sistema de Gestión de Contratos y Aprovisionamiento utilizando el framework Laravel 11, MySQL y Tailwind CSS.*

1. **Diseño y Normalización de la Base de Datos Relacional (MySQL)**
   - **Actividad:** Diseñar y estructurar la base de datos relacional del sistema para garantizar la integridad referencial y la consistencia de los datos.
   - **Detalle:** Creación de migraciones y modelos Eloquent en Laravel para gestionar tablas interrelacionadas (`users`, `clients`, `contracts`, `equipment`, `anexo2` y `audit_logs`). Se configuraron relaciones de tipo `hasMany`, `belongsTo` y `hasOne` para estructurar la asociación de abonados, contratos, equipos entregados y bitácoras de auditoría.

2. **Implementación del Sistema de Autenticación y Control de Acceso basado en Roles (RBAC)**
   - **Actividad:** Desarrollar el módulo de seguridad de accesos para proteger los datos sensibles de la empresa y delimitar las acciones permitidas por cada perfil de usuario.
   - **Detalle:** Creación de rutas protegidas mediante Middlewares en Laravel. Se definieron tres perfiles de acceso:
     - **Administrador:** Acceso total (gestión de personal, catálogos de planes, inventario general y visualización de logs de auditoría).
     - **Administrativo:** Acceso a la gestión de clientes, creación de nuevos contratos y descarga de PDFs.
     - **Técnico (Jefe de grupo):** Acceso exclusivo para consultar sus instalaciones asignadas y cumplimentar actas de entrega de equipos a domicilio (Anexo 2).

3. **Desarrollo de Módulos CRUD Dinámicos para la Gestión de Clientes y Catálogo de Planes**
   - **Actividad:** Codificar y optimizar las interfaces para la creación, actualización y baja del personal, abonados y planes de internet ofrecidos.
   - **Detalle:** Construcción de controladores (`ClientController`, `PlanController`, `PersonalController`) y vistas responsivas integrando Tailwind CSS. Se implementaron llamadas de búsqueda dinámica mediante rutas API locales para agilizar el registro de contratos buscando abonados por cédula y filtrando planes disponibles según la tecnología (por ejemplo, Fibra Óptica).

4. **Desarrollo del Motor de Creación de Contratos y Generación Automatizada de PDFs**
   - **Actividad:** Automatizar la generación de la documentación contractual física a partir del ingreso de datos digitales en el sistema.
   - **Detalle:** Programación de la lógica comercial en `ContractController` para almacenar las condiciones del contrato de internet y configurar el motor de renderizado de plantillas HTML a PDF a través de la librería `Barryvdh-Dompdf` (`DOMPDF`). El sistema guarda el registro de la ruta física en el servidor local para consultas posteriores y proporciona un botón de descarga inmediata para su firma física o archivo.

5. **Desarrollo del Control de Inventario y Equipos en Comodato (Equipo de Última Milla)**
   - **Actividad:** Implementar el control lógico sobre los dispositivos de red (ONUs, routers, etc.) asignados a los abonados en el contrato.
   - **Detalle:** Desarrollo del modelo de inventario (`EquipmentController`) donde se registra marca, modelo y número de serie único de cada equipo, asociándolo directamente al identificador del contrato. Esto permite tener la trazabilidad exacta de qué hardware se instaló y dónde se localiza físicamente.

6. **Desarrollo del Módulo Técnico de Instalaciones de Campo (Anexo 2)**
   - **Actividad:** Crear un flujo de trabajo para el personal técnico encargado de realizar las instalaciones en sitio.
   - **Detalle:** Implementación del formulario dinámico del "Anexo 2" (`Anexo2.php` y `TecnicoController`) donde el técnico, al finalizar la instalación física, registra los equipos instalados, el tipo de financiamiento (arrendamiento, compra a crédito o al contado) y los datos complementarios del anexo técnico para dejar constancia formal y digital de la entrega del servicio.

7. **Implementación de Auditoría del Sistema (Logs de Trazabilidad)**
   - **Actividad:** Desarrollar un sistema interno de seguimiento de operaciones críticas para resguardar la seguridad de la información.
   - **Detalle:** Programación de un disparador automático que almacena logs de auditoría en la tabla `audit_logs` registrando el ID del usuario, acción (Crear, Editar, Eliminar) y una descripción del registro modificado. Además, se habilitó la exportación de estos registros en formato CSV (`AuditoriaController`) exclusiva para los administradores.

---

### Área 2: Gestión, Aprovisionamiento e Infraestructura del Servicio de Internet
*Tareas operativas y de soporte de red de última milla para asegurar la continuidad del servicio de banda ancha de Fibercom.*

1. **Configuración, Aprovisionamiento y Homologación de Equipos ONT/ONU**
   - **Actividad:** Configurar lógica y físicamente el equipamiento que se instalará en el domicilio de los nuevos abonados.
   - **Detalle:** Asignación de parámetros de red y VLANs configuradas desde la OLT (Optical Line Terminal) en la central, garantizando que el tráfico se encapsule correctamente. Programación de enrutadores locales para soportar esquemas de direccionamiento IP y control de calidad de servicio (QoS) en puertos específicos.

2. **Control y Medición de los Parámetros de Señal Óptica en Campo**
   - **Actividad:** Asegurar que la señal de luz de fibra óptica llegue con los valores de atenuación correctos para evitar desconexiones constantes.
   - **Detalle:** Uso de herramientas de medición de potencia óptica (Power Meter) en el domicilio de los abonados. Verificación de que la potencia de recepción (RX) se encuentre dentro del rango operativo establecido por Fibercom (-15 dBm a -25 dBm), corrigiendo fusiones mecánicas o soldaduras ópticas con empalmadora por arco eléctrico en caso de atenuación excesiva.

3. **Pruebas de Estabilidad de Red y Asignación de Anchos de Banda (Bandwidth Control)**
   - **Actividad:** Auditar que el canal de datos aprovisionado concuerde con el plan contratado por el cliente.
   - **Detalle:** Configuración del ancho de banda y perfiles de velocidad de subida (upload) y bajada (download) en las plataformas de administración de Fibercom. Ejecución de pruebas de rendimiento de red post-instalación para validar latencias, jitter y pérdida de paquetes.

4. **Instalación Física y Tendido de Enlaces de Fibra Óptica (Última Milla)**
   - **Actividad:** Realizar el despliegue del cable drop óptico y la canalización física del cableado estructurado.
   - **Detalle:** Despliegue de fibra óptica aérea desde los divisores ópticos de las cajas NAP (Network Access Point) hasta la roseta interna del abonado, respetando los radios de curvatura del cable para evitar microcurvaturas que degraden la señal.

5. **Mantenimiento Preventivo, Diagnóstico y Soporte Técnico de Red**
   - **Actividad:** Brindar soporte oportuno ante fallas físicas o lógicas reportadas por el centro de operaciones de red (NOC) o el cliente.
   - **Detalle:** Detección de cortes de fibra óptica mediante localizadores visuales de fallas (VFL) o reflectómetros ópticos (OTDR). Sustitución y reconfiguración rápida de equipos de última milla dañados por descargas eléctricas o fallas del hardware.
