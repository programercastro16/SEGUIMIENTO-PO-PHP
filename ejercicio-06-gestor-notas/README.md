# Ejercicio 06 - Gestor de Notas

- Materia: Programacion Orientada a la Web con PHP
- Arquitectura: MVC (Modelo-Vista-Controlador)

## Descripcion

Aplicacion para la redaccion, archivo y consulta de notas breves y apuntes. Ofrece organizacion tematica por categorias y esquema visual por paleta de colores.

## Funcionalidades

- Operaciones CRUD completas para notas (creacion, lectura, edicion y borrado).
- Clasificacion tematica (Personal, Trabajo, Ideas, Recordatorios, Estudio, Proyectos, Otros).
- Personalizacion de color de fondo por nota.
- Busqueda por coincidencia de texto en titulos y contenidos.
- Vista ampliada de detalle por nota.

## Componentes MVC

- Modelo: `NotaModel` (persistencia JSON y motor de busqueda interna).
- Vistas: `nota/index.php`, `nota/form.php` y `nota/ver.php`.
- Controlador: `NotaController` (atencion de busquedas y peticiones CRUD).

## Ejecucion

```bash
cd ejercicio-06-gestor-notas
php -S localhost:8080
```
Acceso desde el navegador: `http://localhost:8080`.
