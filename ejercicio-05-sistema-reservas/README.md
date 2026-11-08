# Ejercicio 05 - Sistema de Reservas

**Materia:** Programación Orientada a la Web con PHP  
**Patrón:** MVC (Modelo-Vista-Controlador)

## Descripción
Sistema de reservas en línea para citas y servicios, con verificación de disponibilidad en tiempo real y confirmación de reservas.

## Funcionalidades
- 📋 Listar reservas con filtro por estado
- 📝 Nueva reserva con selección de servicio, fecha y hora
- ✅ Confirmar reservas pendientes
- ❌ Cancelar reservas
- 🕐 Verificación de disponibilidad (sin traslapes)
- 🛎️ Servicios: Consulta General, Corte de Cabello, Masaje, Manicure, Pedicure

## Estructura MVC
- **Model:** `ReservaModel` - persistencia en JSON con lógica de disponibilidad
- **Views:** `reserva/index.php`, `reserva/form.php`, `reserva/disponibilidad.php`
- **Controller:** `ReservaController` - CRUD + gestión de estados

## Ejecución
```bash
php -S localhost:8080
# Abrir: http://localhost:8080
```

