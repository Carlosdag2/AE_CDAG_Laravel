<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto_CDAG;
use Illuminate\Support\Facades\DB;

/**
 * Seeder para la tabla productos_cdag
 */
class ProductosCDAGSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar la tabla antes de insertar (opcional)
        DB::table('productos_cdag')->truncate();

        // Array de productos de ejemplo
        $productos = [
            [
                'nombre' => 'Portátil HP EliteBook 840',
                'descripcion' => 'Portátil profesional de 14 pulgadas con procesador Intel Core i7 de 11ª generación, 16GB de RAM DDR4, SSD de 512GB NVMe, pantalla Full HD IPS y Windows 11 Pro. Ideal para trabajo empresarial y multitarea exigente.',
                'precio' => 1299.99,
                'stock' => 15,
            ],
            [
                'nombre' => 'Monitor LG UltraWide 34"',
                'descripcion' => 'Monitor panorámico profesional de 34 pulgadas con resolución WQHD (3440x1440), panel IPS con cobertura de color sRGB del 99%, frecuencia de actualización de 75Hz y tecnología AMD FreeSync. Perfecto para diseño y productividad.',
                'precio' => 449.99,
                'stock' => 8,
            ],
            [
                'nombre' => 'Teclado Mecánico Logitech MX Keys',
                'descripcion' => 'Teclado mecánico inalámbrico premium con teclas retroiluminadas, switches silenciosos, conexión Bluetooth y USB, batería recargable con autonomía de hasta 10 días. Compatible con Windows, Mac y Linux.',
                'precio' => 119.99,
                'stock' => 25,
            ],
            [
                'nombre' => 'Ratón Logitech MX Master 3S',
                'descripcion' => 'Ratón ergonómico inalámbrico de alta precisión con sensor de 8000 DPI, rueda de desplazamiento electromagnética MagSpeed, 7 botones programables y batería con autonomía de hasta 70 días. Diseño para uso prolongado sin fatiga.',
                'precio' => 99.99,
                'stock' => 32,
            ],
            [
                'nombre' => 'Webcam Logitech StreamCam',
                'descripcion' => 'Cámara web Full HD 1080p a 60fps con enfoque automático inteligente, corrección de luz HDR y conexión USB-C. Incluye soporte para monitor y trípode. Ideal para streaming, videoconferencias y creación de contenido.',
                'precio' => 169.99,
                'stock' => 12,
            ],
            [
                'nombre' => 'Auriculares Sony WH-1000XM5',
                'descripcion' => 'Auriculares inalámbricos premium con cancelación de ruido líder en la industria, audio de alta resolución, 30 horas de batería, carga rápida y controles táctiles intuitivos. Perfectos para trabajo, viajes y entretenimiento.',
                'precio' => 399.99,
                'stock' => 3,
            ],
            [
                'nombre' => 'Disco Duro Externo WD My Passport 2TB',
                'descripcion' => 'Disco duro portátil USB 3.2 Gen 1 de 2TB con cifrado por hardware AES de 256 bits, software de copia de seguridad automática WD Backup y protección por contraseña. Compacto y ligero, perfecto para almacenamiento móvil.',
                'precio' => 79.99,
                'stock' => 45,
            ],
            [
                'nombre' => 'Router Gaming ASUS ROG Rapture GT-AX11000',
                'descripcion' => 'Router Wi-Fi 6 tri-banda con velocidades de hasta 11000 Mbps, 8 antenas externas, puerto WAN de 2.5G, Game Boost para priorizar tráfico gaming, AiProtection Pro y soporte para redes mesh. El definitivo para gaming y streaming.',
                'precio' => 449.99,
                'stock' => 5,
            ],
            [
                'nombre' => 'Tablet Samsung Galaxy Tab S9',
                'descripcion' => 'Tablet Android de 11 pulgadas con pantalla Super AMOLED de 120Hz, procesador Snapdragon 8 Gen 2, 8GB de RAM, 128GB de almacenamiento, S Pen incluido y resistencia al agua IP68. Perfecta para productividad y entretenimiento.',
                'precio' => 899.99,
                'stock' => 0,
            ],
            [
                'nombre' => 'Impresora Multifunción HP LaserJet Pro MFP M428fdw',
                'descripcion' => 'Impresora láser monocromo multifunción con impresión, copia, escaneo y fax. Velocidad de hasta 40 ppm, impresión dúplex automática, pantalla táctil a color, Wi-Fi, Ethernet y bandeja de 350 hojas. Ideal para oficinas.',
                'precio' => 549.99,
                'stock' => 7,
            ],
            [
                'nombre' => 'SSD Samsung 970 EVO Plus 1TB',
                'descripcion' => 'Unidad de estado sólido NVMe M.2 con velocidades de lectura secuencial de hasta 3500 MB/s y escritura de 3300 MB/s. Tecnología V-NAND de Samsung, cifrado por hardware AES de 256 bits y garantía de 5 años.',
                'precio' => 129.99,
                'stock' => 28,
            ],
            [
                'nombre' => 'Micrófono Blue Yeti USB',
                'descripcion' => 'Micrófono de condensador USB profesional con cuatro patrones de captación (cardioide, bidireccional, omnidireccional y estéreo), controles de ganancia y silencio integrados, salida de auriculares con latencia cero. Perfecto para podcasting, streaming y grabación musical.',
                'precio' => 129.99,
                'stock' => 18,
            ],
        ];

        // Insertar los productos usando el modelo Eloquent
        foreach ($productos as $producto) {
            Producto_CDAG::create($producto);
        }

        // Mensaje de confirmación
        $this->command->info('✓ ' . count($productos) . ' productos insertados correctamente en la tabla productos_cdag');
    }
}
