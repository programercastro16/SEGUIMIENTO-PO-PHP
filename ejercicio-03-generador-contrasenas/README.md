# 🔐 Ejercicio 03 — Generador de Contraseñas Seguras

Aplicación PHP MVC que genera contraseñas criptográficamente seguras usando `random_int()` de PHP, con historial persistente en JSON y un medidor de fortaleza visual.

---

## 📁 Estructura del proyecto

```
ejercicio-03-generador-contrasenas/
├── index.php                        # Front controller
├── .htaccess                        # Rewrite rules para Apache
├── README.md
├── data/
│   ├── .gitkeep
│   └── historial.json               # Generado automáticamente
└── app/
    ├── core/
    │   ├── App.php                  # Router MVC
    │   ├── Controller.php           # Clase base controlador
    │   └── Model.php                # Clase base modelo (JSON persistence)
    ├── controllers/
    │   └── ContrasenaController.php
    ├── models/
    │   └── ContrasenaModel.php
    └── views/
        └── contrasena/
            └── index.php            # Vista principal + historial
```

---

## 🚀 Instalación y uso

### Requisitos
- PHP 8.0 o superior
- Apache con `mod_rewrite` habilitado (o servidor de desarrollo PHP)

### Opción A — Apache (XAMPP / WAMP / Laragon)

1. Copia la carpeta al directorio raíz del servidor web (p. ej. `htdocs/`).
2. Accede a: `http://localhost/ejercicio-03-generador-contrasenas/`

### Opción B — Servidor de desarrollo PHP

```bash
cd ejercicio-03-generador-contrasenas
php -S localhost:8003
```

Luego abre: [http://localhost:8003](http://localhost:8003)

> **Nota:** Con el servidor integrado de PHP no funciona el `.htaccess`. Las URLs de navegación interna usarán el parámetro `?url=`. El formulario funciona correctamente de todas formas.

---

## ⚙️ Funcionalidades

| Función | Descripción |
|---------|-------------|
| **Generación segura** | Usa `random_int()` (CSPRNG) para cada carácter |
| **Longitud configurable** | Slider de 8 a 128 caracteres |
| **Tipos de caracteres** | Mayúsculas, minúsculas, números, especiales |
| **Garantía de inclusión** | Siempre incluye al menos 1 carácter de cada tipo activo |
| **Medidor de fortaleza** | Barra animada con puntuación 0–100 |
| **Copiar al portapapeles** | Botón con feedback visual "¡Copiado!" |
| **Historial** | Últimas 10 contraseñas (parcialmente enmascaradas) |
| **Persistencia** | Archivo `data/historial.json` |

---

## 🛡️ Niveles de fortaleza

| Nivel | Puntuación | Color |
|-------|-----------|-------|
| **Débil** | 0 – 39 | 🔴 Rojo |
| **Media** | 40 – 59 | 🟠 Naranja |
| **Fuerte** | 60 – 79 | 🟢 Verde |
| **Muy Fuerte** | 80 – 100 | 🔵 Cyan |

La puntuación se calcula en base a:
- Longitud (hasta 40 pts)
- Variedad de tipos de caracteres (10 pts por tipo)
- Combinaciones mixtas (hasta 20 pts extra)
- Penalización por caracteres repetidos consecutivos (-15 pts)

---

## 🔀 Rutas disponibles

| URL | Acción |
|-----|--------|
| `/` o `index.php` | Formulario principal |
| `index.php?url=contrasena/generar` | POST: genera contraseña |
| `index.php?url=contrasena/historial` | Vista de historial |

---

## 🏗️ Patrón MVC

```
Request → index.php → App (router) → ContrasenaController → ContrasenaModel
                                             ↓
                                      contrasena/index.php (vista)
```

- **`App.php`** — Parsea `?url=controller/method` y despacha.
- **`Controller`** — Base con métodos `model()`, `view()`, `redirect()`.
- **`Model`** — Base con `readJson()` / `writeJson()` para persistencia.
- **`ContrasenaModel`** — Lógica: `generar()`, `calcularFortaleza()`, `guardarHistorial()`, `getHistorial()`.
- **`ContrasenaController`** — Acciones: `index()`, `generar()`, `historial()`.

---

## 🎨 Diseño

- **Tema oscuro** (fondo `#0d1117` estilo GitHub Dark)
- **Acento cyan/teal** (`#00bcd4`)
- **Sin frameworks CSS** — todo CSS3 vanilla con custom properties
- **Responsive** — adaptado para móviles
- **Animaciones** — barra de fortaleza animada, hover effects, feedback de copiado
