   # Metodología de Desarrollo: Scrum

Para el desarrollo del **Sistema de Contratos - Fibercom**, se implementó la metodología ágil **Scrum**, adaptando el ciclo de vida del software a un periodo intensivo de **4 semanas**.

## 📅 Cronograma de Sprints (4 Semanas)

El proyecto se dividió en **2 Sprints de 2 semanas cada uno**, asegurando entregas de valor continuas y feedback temprano.

### Sprint 1: Cimientos y Gestión Base (Semanas 1-2)
*   **Objetivo**: Establecer la arquitectura base, gestión de usuarios y entidades maestras.
*   **Entregables**:
    - Configuración de Laravel y Base de Datos.
    - Módulo de Gestión de Personal (Roles y Permisos).
    - Gestión de Clientes (CRUD completo).
    - Catálogo de Planes de Internet y Tipos de Servicio.
*   **Hito**: Sistema funcional con autenticación y administración de datos base.

### Sprint 2: Core de Negocio e Impresión (Semanas 3-4)
*   **Objetivo**: Implementación de la lógica de contratos, inventario y reportes PDF.
*   **Entregables**:
    - Módulo de Creación de Contratos (Lógica de negocio).
    - Asignación de Equipos (ONUs/Routers) e Inventario.
    - Generación automatizada de Contratos y Anexos en PDF.
    - Módulo de Auditoría para seguimiento de cambios.
*   **Hito**: Sistema listo para producción con generación legal de documentos.

---

## 👥 Roles de Scrum

| Rol | Responsabilidad |
| :--- | :--- |
| **Product Owner** | Define las prioridades del negocio (Fibercom) y aprueba los criterios de aceptación. |
| **Scrum Master** | Facilita la metodología, elimina impedimentos y asegura el cumplimiento de tiempos. |
| **Development Team** | Equipo multidisciplinario encargado del diseño, codificación y pruebas (Fullstack Laravel). |

---

## 🛠️ Artefactos Utilizados

1.  **Product Backlog**: Lista maestra de requerimientos (Contratos, Clientes, Inventario, Audit).
2.  **Sprint Backlog**: Tareas específicas seleccionadas para cada sprint (ej: "Integrar DOMPDF").
3.  **Incremento**: Versión funcional del sistema al final de cada sprint.

---

## 🔄 Eventos de Scrum

- **Sprint Planning**: Definición de objetivos al inicio de cada quincena.
- **Daily Scrum**: Sincronización diaria para reportar avances y bloqueos.
- **Sprint Review**: Demostración de las funcionalidades terminadas al cliente (Fibercom).
- **Sprint Retrospective**: Análisis interno para mejorar el proceso de desarrollo.
