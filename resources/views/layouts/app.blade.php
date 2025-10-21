<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestión de Productos') - AE_CDAG</title>
</head>
<body>
    <!-- Header -->
    <header style="background-color: #f0f0f0; padding: 20px; border-bottom: 2px solid #333;">
        <h2>Sistema de Gestión de Productos CDAG</h2>
        <nav>
            <a href="{{ route('productos.index') }}">Listado de Productos</a> |
        </nav>
    </header>

    <!-- Contenido Principal -->
    <main style="padding: 20px; min-height: 500px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background-color: #f0f0f0; padding: 20px; border-top: 2px solid #333; margin-top: 40px;">
        <p><strong>AE_CDAG - Sistema de Gestión de Productos</strong></p>
        <p>Carlos de Alda Garcia</p>
        <p>Tecnología: Laravel 12</p>
    </footer>
</body>
</html>
