{{-- Vista de listado de productos --}}
@extends('layouts.app')

{{-- Define el título de la página --}}
@section('title', 'Listado de Productos')

{{-- Contenido principal de la vista --}}
@section('content')
<h1>Catálogo de Productos CDAG</h1>

{{-- Estadísticas --}}
<p><strong>Total de Productos:</strong> {{ $totalProductos }}</p>
<p><strong>Productos Disponibles:</strong> {{ $productosDisponibles }}</p>
<p><strong>Valor Total del Stock:</strong> €{{ number_format($valorTotalStock, 2, ',', '.') }}</p>

<hr>

{{-- Tabla de productos --}}
@if($productos->count() > 0)
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ Str::limit($producto->descripcion, 80) }}</td>
                <td>{{ $producto->getPrecioFormateado() }}</td>
                <td>{{ $producto->stock }}</td>
                <td>
                    @if($producto->stock > 20)
                        Stock Alto
                    @elseif($producto->stock > 5)
                        Stock Normal
                    @elseif($producto->stock > 0)
                        Stock Bajo
                    @else
                        Agotado
                    @endif
                </td>
                <td>
                    <a href="{{ route('productos.show', $producto->id) }}">Ver Detalle</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No hay productos disponibles.</p>
@endif
@endsection
