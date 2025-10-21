# EXPLICACIÓN DEL DISEÑO Y SEPARACIÓN DE RESPONSABILIDADES
**Proyecto:** AE_CDAG - Laravel Actividad Evaluable
**Autor:** Carlos de Alda Garcia  
**Framework:** Laravel 12  
**Fecha:** 21 de octubre de 2025

---

## 1. DISEÑO REALIZADO

El proyecto implementa un **sistema de gestión de productos** utilizando Laravel 12, aplicando el patrón arquitectónico **MVC (Modelo-Vista-Controlador)** para garantizar una separación clara entre la lógica de negocio, el acceso a datos y la presentación.

### Estructura del Sistema:

```
┌─────────────────────────────────────────────────────────┐
│                     NAVEGADOR (Cliente)                 │
│                  http://localhost:8000                  │
└────────────────────┬────────────────────────────────────┘
                     │ Petición HTTP
                     ↓
┌─────────────────────────────────────────────────────────┐
│              RUTAS (routes/web.php)                     │
│  Define qué controlador maneja cada URL                │
└────────────────────┬────────────────────────────────────┘
                     │
                     ↓
┌─────────────────────────────────────────────────────────┐
│         CONTROLADOR (Producto_CDAG_Controller)          │
│  • Recibe peticiones                                    │
│  • Ejecuta lógica de negocio                           │
│  • Prepara datos para las vistas                       │
└──────────┬─────────────────────────┬────────────────────┘
           │                         │
           ↓                         ↓
┌──────────────────────┐  ┌────────────────────────────┐
│  MODELO              │  │  VISTAS (Blade)            │
│  (Producto_CDAG)     │  │  • layouts/app.blade.php   │
│  • Define estructura │  │  • index.blade.php         │
│  • Acceso a datos    │  │  • show.blade.php          │
│  • Métodos auxiliares│  │  (Solo presentación)       │
└──────────┬───────────┘  └────────────────────────────┘
           │
           ↓
┌─────────────────────────────────────────────────────────┐
│         BASE DE DATOS (MySQL - productos_cdag)          │
│  Almacena los datos persistentes                        │
└─────────────────────────────────────────────────────────┘
```

---

## 2. SEPARACIÓN DE RESPONSABILIDADES

### 2.1. MODELO (Producto_CDAG.php)

**Responsabilidad Única:** Representar la entidad "Producto" y gestionar el acceso a datos.

**Lo que SÍ hace:**
- Define la estructura de datos (`$fillable`, `$casts`)
- Especifica la tabla asociada (`$table = 'productos_cdag'`)
- Implementa métodos auxiliares relacionados con datos:
  - `estaDisponible()`: Verifica si hay stock
  - `getPrecioFormateado()`: Formatea el precio para mostrar

**Lo que NO hace:**
- ❌ No contiene lógica de negocio compleja
- ❌ No contiene HTML ni código de presentación
- ❌ No maneja peticiones HTTP

**Ejemplo de código:**
```php
protected $fillable = ['nombre', 'descripcion', 'precio', 'stock'];

public function estaDisponible(): bool {
    return $this->stock > 0;
}
```

---

### 2.2. CONTROLADOR (Producto_CDAG_Controller.php)

**Responsabilidad Única:** Coordinar entre el modelo y las vistas, ejecutando la lógica de negocio.

**Lo que SÍ hace:**
- Recibe y procesa peticiones HTTP
- Consulta datos a través del modelo Eloquent
- Ejecuta lógica de negocio:
  - Calcula estadísticas (total productos, valor inventario)
  - Determina estados del stock (Alto/Normal/Bajo/Agotado)
- Prepara datos estructurados para las vistas
- Maneja errores (404 si producto no existe)

**Lo que NO hace:**
- ❌ No contiene HTML
- ❌ No accede directamente a la base de datos con SQL
- ❌ No define estructura de datos

**Ejemplo de separación:**
```php
// Método index() - Lógica de negocio en el controlador
public function index(): View {
    // Obtiene datos del modelo
    $productos = Producto_CDAG::orderBy('nombre', 'asc')->get();
    
    // Ejecuta cálculos (lógica de negocio)
    $totalProductos = $productos->count();
    $productosDisponibles = $productos->where('stock', '>', 0)->count();
    $valorTotalStock = $productos->sum(fn($p) => $p->precio * $p->stock);
    
    // Envía datos preparados a la vista
    return view('productos.index', compact('productos', 'totalProductos', ...));
}
```

**Método privado para encapsular lógica:**
```php
private function determinarEstadoStock(int $stock): array {
    if ($stock === 0) return ['texto' => 'Agotado', 'clase' => 'danger'];
    if ($stock <= 5) return ['texto' => 'Stock Bajo', 'clase' => 'warning'];
    if ($stock <= 20) return ['texto' => 'Stock Normal', 'clase' => 'info'];
    return ['texto' => 'Stock Alto', 'clase' => 'success'];
}
```

---

### 2.3. VISTAS (Blade Templates)

**Responsabilidad Única:** Presentar los datos al usuario de forma clara.

**Lo que SÍ hacen:**
- Muestran datos recibidos del controlador
- Estructuran el HTML
- Usan directivas Blade para control de flujo (`@if`, `@foreach`)
- Aplican herencia de plantillas (`@extends`, `@section`)

**Lo que NO hacen:**
- ❌ No contienen lógica de negocio
- ❌ No realizan cálculos complejos
- ❌ No acceden directamente a la base de datos

**Ejemplo de vista limpia:**
```blade
{{-- index.blade.php - Solo presentación --}}
<p><strong>Total de Productos:</strong> {{ $totalProductos }}</p>

<table border="1">
    @foreach($productos as $producto)
    <tr>
        <td>{{ $producto->nombre }}</td>
        <td>{{ $producto->getPrecioFormateado() }}</td>
        <td>
            @if($producto->stock > 20)
                Stock Alto
            @elseif($producto->stock > 5)
                Stock Normal
            @else
                Stock Bajo
            @endif
        </td>
    </tr>
    @endforeach
</table>
```

**Herencia de plantillas:**
```blade
{{-- Plantilla base (app.blade.php) --}}
<body>
    <header>...</header>
    <main>
        @yield('content')  <!-- Aquí se inyecta contenido específico -->
    </main>
    <footer>...</footer>
</body>

{{-- Vista hija (index.blade.php) --}}
@extends('layouts.app')
@section('content')
    <!-- Contenido específico de esta página -->
@endsection
```

---

## 3. MIGRACIONES Y SEEDERS

### 3.1. MIGRACIÓN (create_productos_cdag_table.php)

**Responsabilidad:** Definir la estructura de la tabla en la base de datos.

```php
Schema::create('productos_cdag', function (Blueprint $table) {
    $table->id();
    $table->string('nombre', 255);
    $table->text('descripcion');
    $table->decimal('precio', 10, 2);
    $table->integer('stock')->default(0);
    $table->timestamps();
});
```

### 3.2. SEEDER (ProductosCDAGSeeder.php)

**Responsabilidad:** Poblar la base de datos con datos de prueba.

```php
$productos = [
    ['nombre' => 'Portátil HP', 'precio' => 1299.99, 'stock' => 15],
    // ... más productos
];
foreach ($productos as $producto) {
    Producto_CDAG::create($producto);
}
```

---

## 4. FLUJO DE DATOS COMPLETO

**Ejemplo: Usuario accede a /productos**

1. **Ruta** recibe la petición: `GET /productos`
2. **Ruta** llama al controlador: `Producto_CDAG_Controller@index`
3. **Controlador** ejecuta lógica:
   - Consulta al modelo: `Producto_CDAG::orderBy('nombre')->get()`
   - Calcula estadísticas
   - Determina estados de stock
4. **Modelo** consulta la base de datos y devuelve objetos
5. **Controlador** prepara array de datos para la vista
6. **Vista** recibe los datos y genera HTML
7. **Navegador** muestra el resultado al usuario

---

## 5. BENEFICIOS DE ESTA SEPARACIÓN

### ✅ Mantenibilidad
- Cada componente tiene una función clara
- Fácil localizar dónde hacer cambios

### ✅ Reutilización
- El modelo puede usarse en diferentes controladores
- Las vistas pueden extenderse de una plantilla base

### ✅ Escalabilidad
- Agregar nuevas funcionalidades sin modificar código existente
- Fácil añadir validaciones, relaciones, etc.

---

## 6. EJEMPLO PRÁCTICO DE SEPARACIÓN

**❌ MAL - Todo mezclado en la vista:**
```blade
@php
    $total = 0;
    $disponibles = 0;
    foreach($productos as $p) {
        if($p->stock > 0) $disponibles++;
        $total += $p->precio * $p->stock;
    }
@endphp
<p>Total: {{ $total }}</p>
```

**✅ BIEN - Lógica en el controlador:**
```php
// Controlador
$valorTotal = $productos->sum(fn($p) => $p->precio * $p->stock);
return view('index', ['valorTotal' => $valorTotal]);

// Vista (solo presenta)
<p>Total: {{ $valorTotal }}</p>
```

---


**Autor:** Carlos de Alda Garcia  
**Proyecto:** Actividad Evaluable
**Framework:** Laravel 12 
**Año:** 2025
