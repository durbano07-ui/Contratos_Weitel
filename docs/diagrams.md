# Diagramas Técnicos (Mermaid)

Para complementar la documentación, se proponen los siguientes diagramas. Puede integrar este código directamente en archivos Markdown compatibles con GitHub, GitLab o extensiones de VSCode.

## 1. Diagrama de Casos de Uso
Define las interacciones de los diferentes roles con el sistema.

```mermaid
graph TD
    subgraph "Sistema de Contratos Fibercom"
        UC1(Gestión de Personal)
        UC2(Gestión de Planes)
        UC3(Gestión de Inventario)
        UC4(Gestión de Clientes)
        UC5(Creación de Contratos)
        UC6(Generación de PDF)
        UC7(Asignación de Instalaciones)
        UC8(Consulta de Auditoría)
    end

    Admin((Administrador))
    Advo((Administrativo))
    Tec((Técnico))

    Admin --> UC1
    Admin --> UC2
    Admin --> UC3
    Admin --> UC8
    
    Advo --> UC4
    Advo --> UC5
    Advo --> UC6
    
    Tec --> UC7
    Tec --> UC3
```

## 2. Diagrama de Secuencia: Generación de Contrato
Describe el flujo lógico para emitir un nuevo contrato legal.

```mermaid
sequenceDiagram
    participant U as Administrativo
    participant C as ContractController
    participant M as Modelos (Client/Plan)
    participant D as Base de Datos
    participant P as PDF Service (DomPDF)

    U->>C: Enviar formulario de contrato
    C->>M: Validar Cliente y Plan
    M->>D: Verificar existencia
    D-->>M: Confirmación
    C->>D: Guardar registro de Contrato
    C->>D: Registrar en Auditoría
    C->>P: Generar Stream de PDF
    P-->>C: Archivo PDF generado
    C-->>U: Redirigir con éxito y enlace al PDF
```

## 3. Diagrama de Arquitectura MVC (Simplificado)
Visualización de las capas logic-tecnológicas de Laravel.

```mermaid
graph LR
    Browser[Navegador/Usuario] -- HTTP Request --> Routes[Routes/Web.php]
    Routes -- Middleware Auth --> Controller[Controller/ContractController]
    Controller -- Query --> Model[Model/Contract.php]
    Model -- Eloquent --> DB[(MySQL)]
    DB -- Result --> Model
    Model -- Data --> Controller
    Controller -- Data --> View[View/Blade Template]
    View -- HTML/Tailwind --> Browser
```
