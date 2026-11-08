# Ejercicio 03 - Generador de Contraseñas Seguras

- Materia: Programacion Orientada a la Web con PHP
- Arquitectura: MVC (Modelo-Vista-Controlador)

## Descripcion

Herramienta para la generacion de claves y contraseñas criptograficamente seguras. Permite parametrizar la longitud y el conjunto de caracteres requeridos, ademas de evaluar la solidez de la cadena generada.

## Funcionalidades

- Generacion aleatoria utilizando `random_int()` de PHP.
- Longitud personalizable mediante control deslizante (rango de 8 a 128 caracteres).
- Seleccion de tipos de caracteres: mayusculas, minusculas, digitos numericos y simbolos especiales.
- Analisis y metrica de fortaleza de contraseñas.
- Copiado rapido al portapapeles.
- Historial de claves generadas con mascara de proteccion.

## Componentes MVC

- Modelo: `ContrasenaModel` (algoritmo de generacion, calculo de entropia y registro en JSON).
- Vista: `contrasena/index.php` (interfaz interactiva).
- Controlador: `ContrasenaController` (gestion de peticiones y parametros).

## Ejecucion

```bash
cd ejercicio-03-generador-contrasenas
php -S localhost:8080
```
Acceso desde el navegador: `http://localhost:8080`.
