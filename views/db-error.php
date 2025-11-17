<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error de Conexión - ABYSSUM</title>
    <link rel="stylesheet" href="/assets/css/tailwind.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>
<body class="bg-black text-amber-500 font-mono">
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden px-4">
        
        <div class="pointer-events-none fixed inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
        </div>
        <div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
        <div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>

        <div class="relative z-10 max-w-2xl w-full">
            <div class="bg-black/80 border border-red-600/40 rounded-xl p-8 md:p-12 backdrop-blur-sm">
                <!-- icono de error -->
                <div class="text-center mb-6">
                    <i class="fas fa-exclamation-triangle text-6xl text-red-500 mb-4 animate-pulse"></i>
                    <h1 class="text-4xl md:text-5xl font-bold tracking-widest text-red-500 mb-2">
                        ERROR DE CONEXIÓN
                    </h1>
                    <div class="text-amber-600/70 text-sm uppercase tracking-widest">
                        // SERVICIO TEMPORALMENTE NO DISPONIBLE
                    </div>
                </div>

                <!-- mensaje -->
                <div class="bg-red-900/20 border border-red-600/30 rounded-lg p-6 mb-6">
                    <p class="text-amber-400/80 text-center mb-4">
                        No se puede establecer conexión con la base de datos.
                    </p>
                    <p class="text-amber-600/60 text-sm text-center">
                        El servicio se encuentra temporalmente fuera de línea. Por favor, intenta nuevamente en unos momentos.
                    </p>
                </div>

                <!-- acciones -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/" class="inline-block bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 px-8 py-3 rounded text-sm font-bold transition-all text-center uppercase tracking-wider">
                        <i class="fa-solid fa-home mr-2"></i>Volver al Inicio
                    </a>
                    <button onclick="location.reload()" class="inline-block bg-black/60 hover:bg-black/80 border border-amber-600/40 text-amber-600 hover:text-amber-500 px-8 py-3 rounded text-sm font-bold transition-all text-center uppercase tracking-wider">
                        <i class="fa-solid fa-rotate-right mr-2"></i>Reintentar
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
