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
- [Bootstrap Icons](https://icons.getbootstrap.com/) — cargado vía CDN (`cdn.jsdelivr.net`) en los layouts Blade (`master.blade.php` y `admin.blade.php`). Se usa con la clase `<i class="bi bi-nombre-icono">`.

### 🔹 Backend
- Laravel
- PHP
- Composer

### 🔹 Base de Datos
- MariaDB (gestionada desde XAMPP)

### 🔹 Infraestructura
- XAMPP (Apache + MySQL/MariaDB)

### 🔹 Contenedores (Docker)
- **n8n** — Plataforma de automatización de flujos de trabajo en contenedor
- **Cloudflare Tunnel** — Expone n8n a internet sin abrir puertos en el router (mismo contenedor que n8n)
- Acceso local: `http://localhost:5678`
- Orquestación: `docker-compose.yml` con volumen persistente `n8n_data`

### 🔹 Automatización & IA
- n8n
  -  Recordatorio de Cita por Email
  -  Email de bienvenida automático
- Mailtrap (entorno de desarrollo)
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
- Eliminación de citas
- Creación manual desde panel admin
- Envío automático de recordatorios por correo (gestionado por n8n)

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
- Ver perfil propio (`/mi-perfil`)
- Cerrar sesión

### � Agenda del Admin
- Vista diaria (`/admin/agenda`) y mensual (`/admin/agenda/mes`) de las citas
- Permite visualizar la distribución de citas por día y por mes desde el panel de administración

### 🦷 Gestión de Servicios (Admin)
- Listado de todos los servicios (`/admin/servicios`)
- Crear nuevo servicio con nombre, descripción, duración, precio y foto
- Editar y eliminar servicios existentes
- CRUD completo accesible solo para empleados

### 👥 Gestión de Usuarios (Admin)
- Listado de todos los usuarios (`/admin/usuarios`)
- Crear nuevo usuario desde el panel (`/admin/usuarios/crear`) con asignación de rol
- Editar datos de cualquier usuario existente
- CRUD completo accesible solo para empleados

### 🔐 Autenticación y Validaciones

- Login con email y contraseña; opción "Recordarme"
- Pantalla de carga animada (`/login/cargando`) antes de mostrar el formulario de login
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

### 🤖 Chatbot
- Respuestas automáticas a preguntas frecuentes
- Opciones rápidas: Horarios, Servicios y precios, Ubicación, Contacto
- Servicios y precios cargados dinámicamente desde la base de datos

### 📊 Estadísticas
- Total de citas del mes actual
- Nuevos clientes registrados este mes
- Ingresos generados por citas completadas este mes
- Top 5 servicios más reservados (gráfico de barras con Chart.js)

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

### Paso 8 — Acceder a la aplicación

La aplicación está disponible en el VirtualHost que configuraste:

```
http://purasonrisa.example.com/
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
```

---

## 🤖 n8n + Cloudflare Tunnel (Docker)

El proyecto usa **n8n** como plataforma de automatización (recordatorios de citas por email, emails de bienvenida, etc.) y **Cloudflare Tunnel** para exponer n8n a internet sin abrir puertos en el router. Ambos se gestionan con el `docker-compose.yml` incluido en el repositorio.

### ✅ Requisitos

- Docker Desktop instalado: https://www.docker.com/products/docker-desktop

### Paso 1 — VirtualHost en XAMPP

n8n necesita acceder a la API de Laravel desde dentro del contenedor. Para ello, Laravel debe estar accesible mediante un VirtualHost de XAMPP, no solo en `localhost:8000`.

Añade este bloque al archivo `C:\xampp\apache\conf\extra\httpd-vhosts.conf`:

```apache
<VirtualHost *:80>
    ServerAdmin admin
    DocumentRoot "C:\xampp\htdocs\PuraSonrisa\public"
    ServerName PuraSonrisa.example.com
    ServerAlias www.dummy-host.example.com

    # Permitir que .htaccess reescriba URLs (necesario para Laravel)
    <Directory "C:\xampp\htdocs\PuraSonrisa\public">
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog "logs/dummy-host.example.com-error.log"
    CustomLog "logs/dummy-host.example.com-access.log" common
</VirtualHost>
```

Luego reinicia Apache desde el panel de XAMPP.

También añade esta línea al archivo `C:\Windows\System32\drivers\etc\hosts` (abre el Bloc de notas como administrador):

```
127.0.0.1   PuraSonrisa.example.com
```

### Paso 2 — Levantar los contenedores

Desde el directorio raíz del proyecto:

```bash
docker volume create n8n_data
docker compose up -d
```

n8n estará disponible en `http://localhost:5678`.

Para ver la URL pública temporal del túnel de Cloudflare:

```bash
docker compose logs -f cloudflared
```

### Paso 3 — Importar los flujos de n8n

Los flujos de automatización están guardados en la carpeta `flujos/` del proyecto. Para cargarlos en n8n:

1. Abre n8n en `http://localhost:5678`
2. Ve a **Workflows → Import from file**
3. Selecciona el archivo `.json` correspondiente de la carpeta `flujos/`
4. Guarda y activa el flujo

### 📡 Endpoint que usan los flujos

Los flujos de n8n llaman a este endpoint de Laravel para obtener las citas del día siguiente:

```
http://purasonrisa.example.com/api/citas/manana
```

Devuelve un JSON con las citas confirmadas del día siguiente: nombre del paciente, email, fecha, hora y servicio.

### � Correos con Mailtrap

En desarrollo, todos los correos (recordatorios de citas, emails de bienvenida, etc.) se envían a **Mailtrap** — un servicio que los intercepta de forma segura. **No se envían correos reales**.

Para verificar los correos "capturados":

1. Accede a https://mailtrap.io
2. Inicia sesión con tu cuenta
3. Ve a **Inbox → PuraSonrisa** (o el que hayas configurado)
4. Verás todos los correos que n8n intentó enviar durante las pruebas

Esto permite probar el flujo sin enviar emails ficticios a direcciones reales.

### �📋 Comandos Docker

```bash
docker compose up -d      # Arrancar
docker compose stop       # Parar
docker compose down       # Eliminar contenedores (los datos se conservan)
docker compose logs n8n   # Ver logs de n8n
```
