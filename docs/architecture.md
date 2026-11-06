# Arquitectura del Sistema: MVC con Laravel

El **Sistema de Contratos - Fibercom** se basa en el patrón de diseño **Modelo-Vista-Controlador (MVC)** proporcionado por el framework Laravel, asegurando una separación de responsabilidades, mantenibilidad y escalabilidad.

## 🏗️ Patrón MVC

### 1. Modelos (Models)
Ubicados en `app/Models/`, representan la estructura de datos y las reglas de negocio.
- **Eloquent ORM**: Se utiliza para interactuar con la base de datos de forma expresiva.
- **Relaciones**: Se definen relaciones `belongsTo`, `hasMany` y `hasOne` para vincular Contratos, Clientes, Equipos y Usuarios.

### 2. Vistas (Views)
Ubicadas en `resources/views/`, encargadas de la interfaz de usuario.
- **Blade Templating Engine**: Permite la herencia de layouts y el uso de componentes reutilizables.
- **Tailwind CSS**: Utilizado para un diseño responsivo y moderno sin salir del HTML.

### 3. Controladores (Controllers)
Ubicados en `app/Http/Controllers/`, actúan como intermediarios entre los Modelos y las Vistas.
- **Lógica de Aplicación**: Gestionan las solicitudes HTTP, validan datos y coordinan la ejecución de procesos (ej: generación de PDF).

---

## 💻 Stack Tecnológico

| Capa | Tecnología |
| :--- | :--- |
| **Lenguaje** | PHP 8.2+ |
| **Framework** | Laravel 11 |
| **Base de Datos** | MySQL |
| **Frontend Styling** | Tailwind CSS |
| **Servidor Web** | Apache (vía Laragon) |
| **Generación de Documentos** | DOMPDF / Barryvdh-Dompdf |

---

## 🛠️ Flujo de una Solicitud (Request Lifecycle)

1.  **Ruta (`routes/web.php`)**: El servidor recibe una petición y la dirige al controlador correspondiente.
2.  **Middleware**: Se verifica la autenticación y el rol del usuario (Admin, Técnico, etc.).
3.  **Controlador**: Procesa la lógica, consulta al **Modelo** si es necesario.
4.  **Modelo**: Realiza la consulta a la base de datos MySQL y devuelve objetos Eloquent.
5.  **Vista**: El controlador pasa los datos a la **Vista Blade**, que se renderiza con Tailwind CSS y se envía al navegador del usuario.

## 🔒 Seguridad
- **Bcrypt**: Encriptación de contraseñas.
- **CSRF Protection**: Protección contra ataques de falsificación de solicitudes entre sitios.
- **Validación de Datos**: Reglas estrictas en los controladores para evitar inyecciones y datos corruptos.
