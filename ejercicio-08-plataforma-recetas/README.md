# Ejercicio 08 - Plataforma de Recetas

- Materia: Programacion Orientada a la Web con PHP
- Arquitectura: MVC (Modelo-Vista-Controlador)

## Descripcion

Sistema web para la publicacion, exploracion y consulta de recetas culinarias, provisto de filtros multidimensionales para busquedas precisas.

## Funcionalidades

- Exploracion de recetas en formato de catalogo visual.
- Busqueda por terminos clave aplicados sobre titulos, descripciones e ingredientes.
- Filtros por clasificacion de comida (Desayuno, Almuerzo, Cena, Postre, etc.), nivel de dificultad y tiempo maximo de preparacion.
- Registro y modificacion de recetas con listas estructuradas de ingredientes y pasos secuenciales.
- Vista de lectura optimizada para cocina.

## Componentes MVC

- Modelo: `RecetaModel` (administracion del dataset JSON de recetas precargadas y nuevas).
- Vistas: `receta/index.php`, `receta/ver.php` y `receta/form.php`.
- Controlador: `RecetaController` (gestion de catalogo, filtros y formularios).

## Ejecucion

```bash
cd ejercicio-08-plataforma-recetas
php -S localhost:8080
```
Acceso desde el navegador: `http://localhost:8080`.
