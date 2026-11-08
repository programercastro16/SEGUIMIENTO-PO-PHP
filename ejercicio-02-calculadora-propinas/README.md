# Ejercicio 02 - Calculadora de Propinas

- Materia: Programacion Orientada a la Web con PHP
- Arquitectura: MVC (Modelo-Vista-Controlador)

## Descripcion

Aplicacion web para el calculo de propinas en cuentas de consumo. Permite ingresar el importe base, definir el porcentaje correspondiente y prorratear el valor final entre varios comensales, almacenando un historial local de consultas.

## Funcionalidades

- Calculo de propina basado en porcentajes predefinidos (5%, 10%, 15%, 18%, 20%, 25%).
- Distribucion del subtotal y propina por numero de comensales.
- Historial persistente en formato JSON con los ultimos calculos realizados.
- Validacion de datos de entrada en el servidor.

## Componentes MVC

- Modelo: `PropinaModel` (calculos matematicos y lectura/escritura en `data/historial.json`).
- Vista: `propina/index.php` e `historial.php` (interfaz de calculo y reporte).
- Controlador: `PropinaController` (validacion de entradas y entrega de resultados).

## Estructura de Archivos

```text
ejercicio-02-calculadora-propinas/
├── index.php
├── .htaccess
├── README.md
├── app/
│   ├── core/
│   │   ├── App.php
│   │   ├── Controller.php
│   │   └── Model.php
│   ├── controllers/
│   │   └── PropinaController.php
│   ├── models/
│   │   └── PropinaModel.php
│   └── views/
│       └── propina/
│           ├── index.php
│           └── historial.php
├── data/
│   └── historial.json
└── public/
    └── css/
```

## Ejecucion

```bash
cd ejercicio-02-calculadora-propinas
php -S localhost:8080
```
Acceso desde el navegador: `http://localhost:8080`.
