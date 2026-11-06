# Diseño de Base de Datos

El sistema utiliza **MySQL** como motor de base de datos relacional. A continuación se presenta el Diccionario de Datos y el Diagrama Entidad-Relación.

## 📊 Diagrama Entidad-Relación (Mermaid)

```mermaid
erDiagram
    USER ||--o{ CONTRACT : "crea"
    USER ||--o{ AUDIT_LOG : "genera"
    CLIENT ||--o{ CONTRACT : "firma"
    INTERNET_PLAN ||--o{ CONTRACT : "se asigna"
    INTERNET_TYPE ||--o{ INTERNET_PLAN : "clasifica"
    CONTRACT ||--o| EQUIPMENT : "posee"
    CONTRACT ||--o| ANEXO2 : "complementa"

    USER {
        bigint id PK
        string name
        string cedula
        string role
        string password
    }

    CLIENT {
        bigint id_cliente PK
        string nombre
        string cedula
        string direccion
        string telefono
        string estado
    }

    INTERNET_PLAN {
        bigint id_plan PK
        string nombre_plan
        decimal precio
        bigint id_tipo FK
    }

    CONTRACT {
        bigint id_contrato PK
        bigint id_usuario FK
        bigint id_tecnico FK
        bigint id_cliente FK
        bigint id_plan FK
        date fecha
        string pdf_ruta
    }

    EQUIPMENT {
        bigint id PK
        bigint id_contrato FK
        string modelo
        string serie
        string marca
    }
```

---

## 📖 Diccionario de Datos (Entidades Clave)

### 1. Tabla: `users`
Almacena al personal administrativo y técnico.
- `id`: Identificador único.
- `name`: Nombre completo.
- `cedula`: Identificación nacional (clave de acceso).
- `role`: (`administrador`, `administrativo`, `tecnico`).

### 2. Tabla: `clients`
Información de los abonados de Fibercom.
- `id_cliente`: Identificador único.
- `cedula`: Identificación nacional.
- `estado`: Estado del cliente (Activo/Inactivo).

### 3. Tabla: `contracts`
Entidad central que vincula todos los elementos.
- `id_contrato`: Identificador único.
- `id_usuario`: ID del administrativo que creó el contrato.
- `id_tecnico`: ID del técnico asignado para la instalación.
- `id_cliente`: ID del cliente asociado.
- `id_plan`: ID del plan contratado.
- `pdf_ruta`: Ruta al archivo PDF generado en el servidor.

### 4. Tabla: `equipment` (Inventario)
Equipos entregados en comodato al cliente.
- `id_contrato`: Vínculo con el contrato donde se instaló el equipo.
- `serie`: Número de serie único del equipo.
- `marca/modelo`: Especificaciones técnicas.

### 5. Tabla: `audit_logs`
Seguridad y trazabilidad.
- `user_id`: Quién realizó la acción.
- `action`: Tipo de acción (Create, Update, Delete).
- `description`: Detalle del cambio realizado.
