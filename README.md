# Sistema de Gestión de Contratos - Fibercom

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)

Este proyecto es una plataforma integral diseñada para la empresa **Fibercom**, orientada a la gestión eficiente de contratos de servicios de internet por fibra óptica. Permite la administración de clientes, planes, personal técnico y la generación automatizada de documentos legales (Contratos y Anexos).

## 🚀 Características Principales

- **Gestión de Contratos**: Creación, edición y visualización de contratos con generación de PDF.
- **Control de Clientes**: Registro detallado de abonados y estado de sus servicios.
- **Administración de Personal**: Gestión de roles (Administrador, Administrativo, Técnico).
- **Inventario de Equipos**: Seguimiento de hardware (ONUs, Routers) asignado a cada contrato.
- **Módulo de Auditoría**: Registro de todas las acciones críticas realizadas en el sistema.
- **Panel Técnico**: Interfaz optimizada para técnicos encargados de las instalaciones.

## 🛠️ Stack Tecnológico

- **Framework**: Laravel 11
- **Frontend**: Tailwind CSS / Blade Templates
- **Base de Datos**: MySQL
- **Iconografía**: Material Symbols (Google)
- **Metodología**: Scrum (Ciclo de 4 semanas)

## 📁 Estructura de Documentación

Para una comprensión profunda del sistema, consulte la documentación detallada en la carpeta `docs/`:

1.  **[Metodología de Desarrollo (Scrum)](docs/scrum.md)**: Detalle de los Sprints y roles.
2.  **[Arquitectura del Sistema](docs/architecture.md)**: Explicación del modelo MVC y capas técnicas.
3.  **[Diseño de Base de Datos](docs/database.md)**: Diccionario de datos y Diagrama Entidad-Relación.

## 🛠️ Instalación y Configuración

1.  **Requisitos**: PHP 8.2+, Composer, MySQL.
2.  **Clonar proyecto**: `git clone <url-del-repo>`
3.  **Instalar dependencias**: `composer install`
4.  **Configurar entorno**: Copiar `.env.example` a `.env` y configurar credenciales de BD.
5.  **Migrar y Sembrar**: `php artisan migrate --seed`
6.  **Ejecutar**: `php artisan serve`

---
Desarrollado para **Fibercom** © 2026.
