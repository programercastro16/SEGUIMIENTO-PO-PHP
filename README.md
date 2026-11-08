
# Seguimiento PO PHP - Programación Orientada a la Web con PHP

Monorepo con **11 ejercicios prácticos** desarrollados con arquitectura **MVC en PHP puro**.

## 📁 Estructura del Repositorio

```
SEGUIMIENTO-PO-PHP/
├── ejercicio-01-lista-tareas/
├── ejercicio-02-calculadora-propinas/
├── ejercicio-03-generador-contrasenas/
├── ejercicio-04-gestor-gastos/
├── ejercicio-05-sistema-reservas/
├── ejercicio-06-gestor-notas/
├── ejercicio-07-calendario-eventos/
├── ejercicio-08-plataforma-recetas/
├── ejercicio-09-juego-memoria/
├── ejercicio-10-plataforma-encuestas/
├── ejercicio-11-cronometro-online/
└── README.md
```

## 🏗️ Arquitectura MVC

Cada ejercicio implementa el patrón **Modelo-Vista-Controlador**:

```
ejercicio-XX/
├── index.php              # Front Controller (punto de entrada)
├── .htaccess              # URL rewriting con mod_rewrite
├── app/
│   ├── core/
│   │   ├── App.php        # Router principal
│   │   ├── Controller.php # Clase base del controlador
│   │   └── Model.php      # Clase base del modelo
│   ├── controllers/       # Controladores de la aplicación
│   ├── models/            # Modelos de datos
│   └── views/             # Plantillas HTML/PHP
├── public/
│   ├── css/style.css      # Estilos
│   └── js/app.js          # Scripts
├── data/                  # Almacenamiento JSON
└── README.md
```

## 📋 Ejercicios

| # | Ejercicio | Descripción |
|---|-----------|-------------|
| 01 | **Lista de Tareas** | Agregar, eliminar y marcar tareas como completadas |
| 02 | **Calculadora de Propinas** | Calcula propina según monto total y porcentaje |
| 03 | **Generador de Contraseñas** | Genera contraseñas seguras con opciones configurables |
| 04 | **Gestor de Gastos** | Registrar, categorizar y ver resumen de gastos mensuales |
| 05 | **Sistema de Reservas** | Reservar citas/servicios con disponibilidad en línea |
| 06 | **Gestor de Notas** | Escribir, organizar por categorías y buscar notas |
| 07 | **Calendario de Eventos** | Calendario interactivo con recordatorios y notificaciones |
| 08 | **Plataforma de Recetas** | Buscar, guardar y compartir recetas con filtros |
| 09 | **Juego de Memoria** | Juego de cartas con imágenes, niveles y puntajes |
| 10 | **Plataforma de Encuestas** | Crear/responder encuestas con informes visuales |
| 11 | **Cronómetro Online** | Cronómetro con inicio, pausa, reinicio y vueltas |

## 🚀 Cómo ejecutar cada ejercicio

```bash
# Opción 1: PHP built-in server
cd ejercicio-XX-nombre
php -S localhost:8080

# Opción 2: XAMPP/WAMP
# Copiar la carpeta del ejercicio en htdocs/www
```

## 🛠️ Tecnologías

- **PHP 8.x** (sin frameworks)
- **HTML5 + CSS3**
- **JavaScript Vanilla**
- **JSON** como almacenamiento de datos
- **Patrón MVC** implementado desde cero

## 👨‍💻 Autor

**Thomas Castro** - Instituto Tecnológico Metropolitano (ITM)  
Materia: Programación Orientada a la Web con PHP

