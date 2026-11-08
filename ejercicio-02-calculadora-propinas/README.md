# 💰 Ejercicio 02 — Calculadora de Propinas

Aplicación PHP MVC que calcula la propina de forma inteligente, divide la cuenta entre cualquier número de personas y guarda el historial de cálculos en un archivo JSON.

---

## 📋 Descripción

Este ejercicio implementa una calculadora de propinas con las siguientes características:

- Ingreso del monto total de la cuenta
- Selección visual de porcentaje de propina (5%, 10%, **15% ⭐ Recomendado**, 18%, 20%, 25%)
- División automática entre N personas
- Muestra propina total, total a pagar y el desglose por persona
- Historial de los últimos 10 cálculos persistido en JSON
- Diseño moderno con esquema de colores verde esmeralda

---

## ✨ Funcionalidades

| Funcionalidad | Descripción |
|---|---|
| 🧮 Cálculo de propina | Monto × porcentaje / 100 |
| 👥 División por personas | Propina y total divididos equitativamente |
| 💾 Historial JSON | Últimos 10 cálculos guardados en `data/historial.json` |
| ✅ Validación | Monto > 0, porcentaje válido, personas ≥ 1 |
| 📱 Responsive | Adaptado a móvil y escritorio |

---

## 🏗️ Estructura MVC

```
ejercicio-02-calculadora-propinas/
├── index.php                        ← Front Controller
├── .htaccess                        ← Reescritura de URLs
├── data/
│   ├── .gitkeep
│   └── historial.json               ← Generado automáticamente
└── app/
    ├── core/
    │   ├── App.php                  ← Router
    │   ├── Controller.php           ← Controlador base
    │   └── Model.php                ← Modelo base (JSON)
    ├── controllers/
    │   └── PropinaController.php    ← Lógica de rutas
    ├── models/
    │   └── PropinaModel.php         ← Cálculos y persistencia
    └── views/
        └── propina/
            ├── index.php            ← Formulario + resultado
            └── historial.php        ← Tabla de historial
```

---

## 🔀 Rutas disponibles

| URL | Método | Acción |
|---|---|---|
| `/ejercicio-02-calculadora-propinas/` | GET | Formulario principal |
| `/ejercicio-02-calculadora-propinas/propina/calcular` | POST | Procesar cálculo |
| `/ejercicio-02-calculadora-propinas/propina/historial` | GET | Ver historial completo |

---

## ▶️ Cómo ejecutar

### Con XAMPP / WAMP / Laragon

1. Copia la carpeta `ejercicio-02-calculadora-propinas/` dentro de `htdocs/` (o `www/`)
2. Asegúrate de que **mod_rewrite** esté habilitado en Apache
3. Abre en el navegador:
   ```
   http://localhost/ejercicio-02-calculadora-propinas/
   ```

### Verificar mod_rewrite en XAMPP

Edita `httpd.conf` y busca la línea:
```apache
#LoadModule rewrite_module modules/mod_rewrite.so
```
Quita el `#` al inicio, guarda y reinicia Apache.

---

## 🧮 Fórmulas usadas

```
propina_total       = monto × (porcentaje / 100)
total_general       = monto + propina_total
propina_por_persona = propina_total / personas
total_por_persona   = total_general / personas
```

---

## 🎨 Tecnologías

- **PHP 8.x** — Lógica del servidor, MVC, tipos estrictos
- **JSON** — Persistencia del historial (sin base de datos)
- **HTML5 + CSS3** — Interfaz moderna sin frameworks externos
- **JavaScript** — Validación de inputs en cliente (vanilla)

---

## 📸 Vistas

- **Calculadora**: Formulario con radios visuales para el %, resultado en tarjetas, tabla de últimos 5 cálculos
- **Historial**: Tabla completa con estadísticas rápidas (suma de cuentas, propinas y % promedio)

---

> **Ejercicio 02** del módulo de PHP MVC — Persistencia con JSON
