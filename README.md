# PURA SONRISA

## 📌 Descripción del Proyecto

**PURA SONRISA** es una aplicación web orientada a la gestión de una clínica dental. El sistema permite administrar citas, historial de pacientes y operaciones internas mediante un panel de control, diferenciando roles entre empleados y clientes.

---

## 🧱 Stack Tecnológico

### 🔹 Frontend
- HTML
- TypeScript
- Vite
- Tailwind
- [Bootstrap Icons](https://icons.getbootstrap.com/) — instalado en local via `npm i bootstrap-icons`, importado en `resources/css/app.css` con `@import 'bootstrap-icons/font/bootstrap-icons.css'`. Se usa con la clase `<i class="bi bi-nombre-icono">`. Actualmente utilizado en el footer (redes sociales y horario).

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

#### 📐 Lógica de reservas y consultas

> ⚠️ **Supuesto de negocio**: la clínica dispone de **3 consultas físicas** (Rosa, Azul Claro, Azul Oscuro) y todos los **empleados son polivalentes** (cualquiera puede atender cualquier servicio).

El sistema permite que varios pacientes tengan cita a la **misma hora** siempre que estén en **consultas distintas**. La disponibilidad de un slot horario se determina así:

- Un slot (fecha + hora_inicio + hora_fin) está **disponible** si al menos una consulta no tiene ninguna cita que solape ese rango.
- Un slot está **bloqueado** solo cuando todas las consultas activas están ocupadas simultáneamente.

**Tablas implicadas:**

| Tabla | Rol |
|---|---|
| `consultas` | Gabinetes físicos de la clínica (`nombre`, `color` hex, `activa`) |
| `citas` | Cada cita lleva `consulta_id` (asignado automáticamente) y `empleado_id` (asignado automáticamente al crear la cita) |

**Flujo de una reserva (Paso 1 → 3):**
1. El paciente elige el servicio
2. Elige fecha y franja horaria — solo se muestran franjas donde haya al menos una consulta libre
3. Confirma — el sistema asigna automáticamente la primera consulta libre en ese slot y el primer empleado disponible, y crea la cita con `estado = 'confirmada'` directamente

**Detección de solapamiento:**
```sql
-- Cita B solapa con el slot solicitado si:
hora_inicio_B < hora_fin_solicitada AND hora_fin_B > hora_inicio_solicitada
```

### 👤 Sistema de Usuarios

**Empleado**
- Gestión completa de citas
- Acceso a historial
- CRUD de datos

**Cliente**
- Reservar citas
- Cancelar citas
- Ver citas futuras
- Ver estadísticas propias (citas realizadas, servicios más usados, etc.)
- Cerrar sesión

### 🔐 Autenticación y Validaciones

- Login con email y contraseña; opción "Recordarme"
- Registro con los siguientes campos y validaciones:
  - **Nombre** — obligatorio, máx. 255 caracteres
  - **Email** — obligatorio, formato válido, único en la BD
  - **Contraseña** — mínimo 8 caracteres, confirmación obligatoria
  - **DNI** — opcional; formato `12345678A` (8 dígitos + letra mayúscula)
  - **NIE** — opcional; formato `X1234567A` (X/Y/Z + 7 dígitos + letra mayúscula)
  - **Teléfono** — opcional; 9 dígitos empezando por 6, 7, 8 o 9 (se guarda con prefijo `+34`)
  - **Fecha de nacimiento** — opcional; no puede ser futura ni hace más de 120 años
  - **Alergias / Condiciones médicas** — opcionales, texto libre
- Todos los mensajes de error están en español
- Redirección por rol tras autenticarse: `empleado` → `/admin`, `cliente` → `/`

### 🧾 Historial del Paciente
- Sistema de notas por paciente
- Registro de tratamientos y observaciones

> ⚠️ **Consideraciones técnicas del historial**
>
> **Almacenamiento de fotos**
> Las imágenes adjuntas a las notas **no usan `Storage` de Laravel**. Se guardan directamente en `public/imagenes/historial/{id_nota}/` y se sirven con `asset()`. Esto es intencionado porque Apache en XAMPP Windows no sirve ficheros a través del symlink/junction que crea `php artisan storage:link`.
>
> **`migrate:fresh` y datos del historial**
> Ejecutar `migrate:fresh` borra todas las tablas, incluidas `historial_clinico` e `imagenes_clinicas`. Los ficheros físicos en `public/imagenes/historial/` quedan huérfanos (sin registro en BD). En **desarrollo** no es problema: se pierden datos de prueba como con cualquier otra tabla. En **producción** nunca se usa `migrate:fresh`; solo `migrate` para aplicar cambios incrementales sin borrar datos.

### 🤖 Chatbot (Simulación)
- Respuestas automáticas a preguntas frecuentes
- Soporte básico inicial

### 📊 Estadísticas
- Número de citas
- Servicios más demandados
- Actividad de usuarios

### 🏆 Podio de Servicios Más Pedidos
- Sección visual en la página de servicios con los 3 servicios más solicitados
- Diseño de podio: el 1º (centro) es más grande que el 2º (izquierda) y el 3º (derecha)
- Al pasar el ratón por encima de cada tarjeta se muestra una sombra de color según posición:
  - 🥇 1º puesto (centro): sombra dorada
  - 🥈 2º puesto (izquierda): sombra plateada
  - 🥉 3º puesto (derecha): sombra bronceada
- Cada tarjeta muestra únicamente la foto del servicio; el nombre aparece al hacer hover

---

## 🔀 Estrategia de Ramas (GitHub)

| Rama        | Descripción                                  |
|-------------|----------------------------------------------|
| `main`      | Versión estable                              |
| `dev`       | Desarrollo activo                            |
| `experitar` | Experimentación y pruebas de nuevas ideas    |

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