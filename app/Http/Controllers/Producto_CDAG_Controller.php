<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto_CDAG;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Gestiona las operaciones relacionadas con los productos
 * Implementa la lógica de negocio y separa responsabilidades
 */
class Producto_CDAG_Controller extends Controller
{
    /**
     * Muestra el listado completo de productos
     * Obtiene todos los productos de la base de datos ordenados por nombre
     * y los envía a la vista index
     */
    public function index(): View
    {
        // Lógica de negocio: obtener todos los productos ordenados alfabéticamente
        $productos = Producto_CDAG::orderBy('nombre', 'asc')->get();
        
        // Calcular estadísticas para mostrar en la vista
        $totalProductos = $productos->count();
        $productosDisponibles = $productos->where('stock', '>', 0)->count();
        $valorTotalStock = $productos->sum(function ($producto) {
            return $producto->precio * $producto->stock;
        });
        
        // Enviar datos a la vista
        return view('productos.index', [
            'productos' => $productos,
            'totalProductos' => $totalProductos,
            'productosDisponibles' => $productosDisponibles,
            'valorTotalStock' => $valorTotalStock,
        ]);
    }

    /**
     * Muestra el detalle de un producto específico
     * Busca el producto por ID y muestra su información completa
     * Si no existe, lanza una excepción 404
     */
    public function show(int $id): View
    {
        // Lógica de negocio: buscar el producto por ID o fallar con 404
        $producto = Producto_CDAG::findOrFail($id);
        
        // Calcular el valor total del stock de este producto
        $valorStockProducto = $producto->precio * $producto->stock;
        
        // Determinar el estado del stock
        $estadoStock = $this->determinarEstadoStock($producto->stock);
        
        // Enviar datos a la vista
        return view('productos.show', [
            'producto' => $producto,
            'valorStockProducto' => $valorStockProducto,
            'estadoStock' => $estadoStock,
        ]);
    }

    /**
     * Método privado para determinar el estado del stock
     */
    private function determinarEstadoStock(int $stock): array
    {
        if ($stock === 0) {
            return [
                'texto' => 'Agotado',
                'clase' => 'danger',
            ];
        } elseif ($stock <= 5) {
            return [
                'texto' => 'Stock Bajo',
                'clase' => 'warning',
            ];
        } elseif ($stock <= 20) {
            return [
                'texto' => 'Stock Normal',
                'clase' => 'info',
            ];
        } else {
            return [
                'texto' => 'Stock Alto',
                'clase' => 'success',
            ];
        }
    }
}
