<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modelo Producto_CDAG
 * Representa un producto en el sistema
 * Tabla asociada: productos_cdag
 */
class Producto_CDAG extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada al modelo
     */
    protected $table = 'productos_cdag';

    /**
     * Los atributos que son asignables en masa
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos
     */
    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
    ];

    /**
     * Verifica si el producto está disponible en stockl
     */
    public function estaDisponible(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Obtiene el precio formateado con símbolo de moneda
     */
    public function getPrecioFormateado(): string
    {
        return '€' . number_format($this->precio, 2, ',', '.');
    }
}
