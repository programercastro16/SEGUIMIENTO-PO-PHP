# Ejercicio 01 - Lista de Tareas

- Materia: Programacion Orientada a la Web con PHP
- Arquitectura: MVC (Modelo-Vista-Controlador)

## Descripcion

Aplicacion web para la administracion de tareas pendientes. Permite registrar nuevas tareas, eliminarlas y alternar su estado entre pendiente y completada.

## Funcionalidades

- Agregar nuevas tareas a la lista.
- Eliminar tareas registradas.
- Marcar o desmarcar tareas como completadas.
- Filtrar la vista por estado: Todas, Pendientes o Completadas.
- Contador automatico de tareas totales y completadas.

## Componentes MVC

- Modelo: `TareasModel` (gestion de persistencia en `data/tareas.json`).
- Vista: `tareas/index.php` (interfaz de usuario).
- Controlador: `TareasController` (procesamiento de peticiones y flujo de datos).

## Estructura de Archivos

```text
ejercicio-01-lista-tareas/
├── index.php
├── .htaccess
├── README.md
├── app/
│   ├── core/
│   │   ├── App.php
│   │   ├── Controller.php
│   │   └── Model.php
│   ├── controllers/
│   │   └── TareasController.php
│   ├── models/
│   │   └── TareasModel.php
│   └── views/
│       └── tareas/
│           └── index.php
├── data/
│   └── tareas.json
└── public/
    └── css/
        └── style.css
```

## Ejecucion

### Con servidor integrado de PHP:
```bash
cd ejercicio-01-lista-tareas
php -S localhost:8080
```
Ingresar en el navegador a `http://localhost:8080`.

### Con Apache (XAMPP / WAMP):
Ubicar la carpeta del ejercicio en el directorio `htdocs` y acceder a:
`http://localhost/ejercicio-01-lista-tareas/`

## Rutas Disponibles

| Metodo | Parametro URL | Accion |
|---|---|---|
| GET | (raiz) | Listado general de tareas |
| GET | `?filter=pendientes` | Filtro de pendientes |
| GET | `?filter=completadas` | Filtro de completadas |
| POST | `?url=tareas/agregar` | Creacion de tarea |
| POST | `?url=tareas/eliminar` | Eliminacion de tarea |
| POST | `?url=tareas/completar` | Cambio de estado |
