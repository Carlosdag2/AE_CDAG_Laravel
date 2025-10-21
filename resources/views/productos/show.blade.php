{{-- Vista de detalle de producto --}}
@extends('layouts.app')

{{-- Define el título de la página con el nombre del producto --}}
@section('title', $producto->nombre)

{{-- Contenido principal de la vista --}}
@section('content')
<h1>Detalle del Producto</h1>

<p><a href="{{ route('productos.index') }}">← Volver al Listado</a></p>

<hr>

{{-- Tabla con información del producto --}}
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ID</th>
        <td>{{ $producto->id }}</td>
    </tr>
    <tr>
        <th>Nombre</th>
        <td><strong>{{ $producto->nombre }}</strong></td>
    </tr>
    <tr>
        <th>Descripción</th>
        <td>{{ $producto->descripcion }}</td>
    </tr>
    <tr>
        <th>Precio</th>
        <td>{{ $producto->getPrecioFormateado() }}</td>
    </tr>
    <tr>
        <th>Stock</th>
        <td>{{ $producto->stock }} unidades</td>
    </tr>
    <tr>
        <th>Estado del Stock</th>
        <td>{{ $estadoStock['texto'] }}</td>
    </tr>
    <tr>
        <th>Valor Total en Inventario</th>
        <td>€{{ number_format($valorStockProducto, 2, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Disponibilidad</th>
        <td>{{ $producto->estaDisponible() ? 'Disponible para la venta' : 'No disponible' }}</td>
    </tr>
    <tr>
        <th>Fecha de Creación</th>
        <td>{{ $producto->created_at->format('d/m/Y H:i:s') }}</td>
    </tr>
    <tr>
        <th>Última Actualización</th>
        <td>{{ $producto->updated_at->format('d/m/Y H:i:s') }}</td>
    </tr>
</table>

<br>

<p><a href="{{ route('productos.index') }}">← Volver al Listado</a></p>
@endsection
