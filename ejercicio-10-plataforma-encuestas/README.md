# Ejercicio 10 - Plataforma de Encuestas

- Materia: Programacion Orientada a la Web con PHP
- Arquitectura: MVC (Modelo-Vista-Controlador)

## Descripcion

Sistema para la creacion, distribucion y respuesta de encuestas de opinion publica o diagnostico, acompanado de consolidacion grafica de respuestas.

## Funcionalidades

- Modulo de administracion con panel de encuestas activas y cerradas.
- Diseñador dinamico de preguntas con soporte para: seleccion multiple con opciones personalizadas, dicotomica (Verdadero/Falso) y escala Likert (1 a 5).
- Diligenciamiento de encuestas con verificacion de sesion para control de participacion unica.
- Panel de resultados con generacion de graficos de barras porcentuales.
- Eliminacion y cambio de estado de encuestas.

## Componentes MVC

- Modelo: `EncuestaModel` (persistencia de encuestas y respuestas en archivos JSON independientes).
- Vistas: `encuesta/index.php`, `encuesta/administrar.php`, `encuesta/form.php`, `encuesta/responder.php` y `encuesta/resultados.php`.
- Controlador: `EncuestaController` (manejo de formularios, captura de respuestas y reporte analitico).

## Ejecucion

```bash
cd ejercicio-10-plataforma-encuestas
php -S localhost:8080
```
Acceso desde el navegador: `http://localhost:8080`.
