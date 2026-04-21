# PURA SONRISA

## 📌 Descripción del Proyecto

**PURA SONRISA** es una aplicación web orientada a la gestión de una clínica dental. El sistema permite administrar citas, historial de pacientes y operaciones internas mediante un panel de control, diferenciando roles entre empleados y clientes.

El objetivo del proyecto es consolidar una arquitectura moderna desacoplada, separando frontend y backend, e integrando automatización y funciones básicas de inteligencia artificial.

---

## 🧱 Stack Tecnológico

### 🔹 Frontend
- HTML
- TypeScript
- Vite
- Tailwind

### 🔹 Backend
- Laravel
- PHP
- Composer

### 🔹 Base de Datos
- MariaDB (gestionada desde XAMPP)

### 🔹 Infraestructura
- XAMPP (Apache + MySQL/MariaDB)

### 🔹 Automatización & IA
- n8n (opcional)
- Funciones de IA (agents.md, skills)

### 🤖 Skills instaladas (Copilot Agent)
- [`laravel-specialist`](.agents/skills/laravel-specialist/SKILL.md) — Especialista en Laravel 10+, Eloquent, Sanctum, Livewire, Horizon y Pest
- [`frontend-design`](.agents/skills/frontend-design/SKILL.md) — Diseño de interfaces frontend de calidad producción con HTML/CSS/Tailwind

### 🔹 Control de Versiones
- Git
- GitHub

---

## 🏗️ Arquitectura del Sistema

El proyecto está basado en una arquitectura monolítica (todo lo maneja Laravel):

```
[ frontend ] → HTML + Tailwind
[ backend ]  → Laravel + PHP
[ db ]       → MariaDB (XAMPP)
[ n8n ]      → Automatizaciones (opcional)
```

---

## ⚙️ Funcionalidades

### 🗓️ Gestión de Citas
- Reserva de citas por parte de clientes
- Edición y eliminación de citas
- Creación manual desde panel admin
- Envío automático de recordatorios por correo

### 👤 Sistema de Usuarios

**Empleado**
- Gestión completa de citas
- Acceso a historial
- CRUD de datos

**Cliente**
- Reservar citas
- Cancelar citas
- Ver citas futuras

### 🧾 Historial del Paciente
- Sistema de notas por paciente
- Registro de tratamientos y observaciones

### 🤖 Chatbot (Simulación)
- Respuestas automáticas a preguntas frecuentes
- Soporte básico inicial

### 📊 Estadísticas
- Número de citas
- Servicios más demandados
- Actividad de usuarios

---

## 🔀 Estrategia de Ramas (GitHub)

| Rama   | Descripción         |
|--------|---------------------|
| `main` | Versión estable     |
| `dev`  | Desarrollo activo   |

---

## 🎯 Buenas Prácticas

- Uso de ramas con git
- Commits claros
- Uso de `.gitignore`
- Código comentado claramente
- Nomenclatura: `PascalCase` (inicial mayúscula)
- Documentación actualizada

---

## 📌 Colores

| Nombre | Hex       |
|--------|-----------|
| Blanco | `#fffbf4` |
| Azul   | `#08beff` |
| Rosa   | `#cc0247` |

---

## 🚀 Instalación del Proyecto

Guía completa para instalar y ejecutar PuraSonrisa desde cero en un entorno local con Windows y XAMPP.

### ✅ Requisitos previos

Antes de empezar, asegúrate de tener instalado:

| Herramienta | Versión mínima | Descarga |
|-------------|---------------|----------|
| XAMPP       | 8.2+          | https://www.apachefriends.org |
| PHP         | 8.2+          | Incluido en XAMPP |
| Composer    | 2.x           | https://getcomposer.org |
| Node.js     | 18+           | https://nodejs.org |
| Git         | cualquiera    | https://git-scm.com |

---

### Paso 1 — Clonar el repositorio

Abre una terminal en la carpeta `htdocs` de XAMPP y clona el proyecto:

```bash
cd C:\xampp\htdocs
git clone https://github.com/Jairo-19/PuraSonrisa.git
cd PuraSonrisa
```

> Esto descarga todos los archivos del proyecto en `C:\xampp\htdocs\PuraSonrisa`.

---

### Paso 2 — Instalar dependencias de PHP

Composer descarga todas las librerías del backend (Laravel y sus paquetes):

```bash
composer install
```

> Si no tienes Composer instalado globalmente, descárgalo desde https://getcomposer.org e instálalo antes de ejecutar este comando.

---

### Paso 3 — Instalar dependencias de Node.js

npm descarga Vite, Tailwind y el resto de herramientas de frontend:

```bash
npm install
```

---

### Paso 4 — Configurar el archivo de entorno

Laravel usa un archivo `.env` para gestionar variables de configuración. Copia el archivo de ejemplo:

```bash
copy .env.example .env
```

Luego genera la clave de la aplicación (necesaria para cifrado y sesiones):

```bash
php artisan key:generate
```

---

### Paso 5 — Configurar la base de datos

1. Abre XAMPP y arranca los servicios **Apache** y **MySQL**
2. Entra a `http://localhost/phpmyadmin`
3. Crea una base de datos nueva llamada `PuraSonrisa`
4. Abre el archivo `.env` y ajusta estas líneas:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=PuraSonrisa
DB_USERNAME=root
DB_PASSWORD=
```

> Por defecto XAMPP usa el usuario `root` sin contraseña. Si tienes contraseña configurada, ponla en `DB_PASSWORD`.

---

### Paso 6 — Ejecutar las migraciones

Las migraciones crean todas las tablas necesarias en la base de datos:

```bash
php artisan migrate
```

> Si quieres también cargar datos de prueba, ejecuta:
> ```bash
> php artisan migrate --seed
> ```

---

### Paso 7 — Compilar los assets del frontend

Compila los archivos de Tailwind y TypeScript con Vite:

```bash
# Compilación única (producción)
npm run build

# O en modo desarrollo con recarga automática
npm run dev
```

---

### Paso 8 — Iniciar el servidor

Arranca el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

La aplicación estará disponible en:

```
http://localhost:8000
```

---

### 🗂️ Resumen de comandos

```bash
git clone https://github.com/Jairo-19/PuraSonrisa.git
cd PuraSonrisa
composer install
npm install
copy .env.example .env
php artisan key:generate
# (configurar .env con los datos de la BD)
php artisan migrate
npm run build
php artisan serve
```