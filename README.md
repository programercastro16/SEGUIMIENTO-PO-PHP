# Seguimiento - Programacion Orientada a la Web con PHP

Repositorio con 11 ejercicios practicos desarrollados bajo la arquitectura MVC (Modelo-Vista-Controlador) utilizando PHP nativo y persistencia basada en archivos JSON.

## Estructura del Proyecto

El repositorio esta organizado de forma modular, manteniendo cada ejercicio de manera independiente en la raiz:

```text
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
├── index.php
└── README.md
```

## Arquitectura MVC Implementada

Cada aplicacion implementa el patron arquitectonico MVC de manera desacoplada:

```text
ejercicio-XX/
├── index.php              # Punto de entrada (Front Controller)
├── .htaccess              # Reescritura de URLs amigables
├── app/
│   ├── core/
│   │   ├── App.php        # Enrutador
│   │   ├── Controller.php # Controlador base
│   │   └── Model.php      # Modelo base y persistencia JSON
│   ├── controllers/       # Controladores del modulo
│   ├── models/            # Logica de negocio y datos
│   └── views/             # Vistas de la aplicacion
├── public/                # Recursos estaticos (CSS, JS)
├── data/                  # Archivos de datos JSON
└── README.md
```

## Relacion de Ejercicios

| No. | Ejercicio | Descripcion |
|---|---|---|
| 01 | Lista de Tareas | Gestion de tareas: creacion, eliminacion y actualizacion de estado (pendiente/completada). |
| 02 | Calculadora de Propinas | Calculo del porcentaje de propina, total de cuenta y distribucion por persona con historial. |
| 03 | Generador de Contraseñas | Generacion de cadenas seguras aleatorias con evaluacion de robustez y longitud configurable. |
| 04 | Gestor de Gastos | Registro de egresos categorizados con resumen y distribucion mensual. |
| 05 | Sistema de Reservas | Gestion y control de reservas de servicios, verificando disponibilidad de horarios. |
| 06 | Gestor de Notas | Creacion, categorizacion, filtrado y busqueda textual de notas personales. |
| 07 | Calendario de Eventos | Calendario dinamico mensual con gestion de eventos, horarios y recordatorios. |
| 08 | Plataforma de Recetas | Catalogo y administracion de recetas de cocina con filtros por categoria y tiempo. |
| 09 | Juego de Memoria | Juego de concentracion por turnos con niveles de dificultad y registro de puntajes. |
| 10 | Plataforma de Encuestas | Administrador y receptor de cuestionarios con generacion de reportes visuales. |
| 11 | Cronometro Online | Cronometro de precision en navegador con medicion de tiempos parciales y vueltas. |

## Instrucciones de Ejecucion

### Opcion 1: Servidor integrado de PHP (Recomendado)

Para levantar el portal general con acceso a todos los ejercicios:
```bash
php -S localhost:8000
```
Luego abrir `http://localhost:8000` en el navegador.

Para ejecutar un ejercicio en especifico de forma aislada:
```bash
cd ejercicio-01-lista-tareas
php -S localhost:8080
```

### Opcion 2: Servidor Apache (XAMPP / WAMP / Laragon)

1. Clonar o copiar el repositorio dentro de la carpeta publica (`htdocs` o `www`).
2. Acceder mediante el navegador a la ruta correspondiente (ej. `http://localhost/SEGUIMIENTO-PO-PHP`).

## Tecnologias Utilizadas

- PHP 8.x (sin dependencias externas ni frameworks)
- JavaScript (ES6+)
- HTML5 / CSS3
- Formato JSON para persistencia de datos

## Informacion Academica

- Estudiante: Thomas Castro
- Institucion: Instituto Tecnologico Metropolitano (ITM)
- Asignatura: Programacion Orientada a la Web con PHP
