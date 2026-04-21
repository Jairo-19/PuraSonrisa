# Agentes y Skills — PuraSonrisa

Este archivo documenta las skills de Copilot instaladas en el proyecto y las instrucciones para el agente de IA.

---

## 🤖 Skills Instaladas

### `laravel-specialist`
- **Ruta:** `.agents/skills/laravel-specialist/SKILL.md`
- **Propósito:** Especialista en Laravel 10+. Cubre Eloquent ORM, autenticación con Sanctum, colas con Horizon, componentes Livewire, APIs RESTful y pruebas con Pest/PHPUnit.
- **Usar cuando:** Se creen modelos, migraciones, controladores, rutas API, componentes Livewire o tests de Laravel.

### `frontend-design`
- **Ruta:** `.agents/skills/frontend-design/SKILL.md`
- **Propósito:** Genera interfaces frontend de calidad producción con HTML, Tailwind CSS y TypeScript. Evita diseños genéricos de IA.
- **Usar cuando:** Se construyan vistas Blade, componentes UI, layouts o cualquier interfaz visual del proyecto.

---

## 🎨 Paleta de Colores del Proyecto

| Nombre | Hex       |
|--------|-----------|
| Blanco | `#fffbf4` |
| Azul   | `#08beff` |
| Rosa   | `#cc0247` |

---

## 🧭 Contexto del Proyecto

- **Nombre:** PuraSonrisa
- **Tipo:** Clínica dental — gestión de citas, pacientes y usuarios
- **Backend:** Laravel + PHP + Composer
- **Frontend:** HTML + Tailwind + TypeScript 
- **Base de datos:** MariaDB (XAMPP)
- **Nomenclatura:** `PascalCase`
- **Ramas:** `main` (estable) / `dev` (desarrollo)

---

## 📋 Roles del Sistema

| Rol      | Permisos                                      |
|----------|-----------------------------------------------|
| Empleado | Gestión completa de citas, historial, CRUD    |
| Cliente  | Reservar, cancelar y ver citas propias        |
