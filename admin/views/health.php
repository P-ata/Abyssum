<?php
require_once BASE_PATH . '/classes/DbConnection.php';

// Obtener información del sistema
try {
    $pdo = DbConnection::get();
    
    // Base de datos actual
    $stmt = $pdo->query("SELECT DATABASE() as db_name");
    $currentDb = $stmt->fetch(PDO::FETCH_ASSOC)['db_name'];
    
    // Listar tablas
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Contar registros
    $tableCounts = [];
    $tablesToCheck = ['demons', 'pacts', 'users', 'orders', 'contacts', 'roles', 'admin_sections', 'public_sections'];
    foreach ($tablesToCheck as $table) {
        if (in_array($table, $tables)) {
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM `{$table}`");
            $tableCounts[$table] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        }
    }
    
    // Variables del servidor
    $stmt = $pdo->query("SHOW VARIABLES LIKE 'version'");
    $mysqlVersion = $stmt->fetch(PDO::FETCH_ASSOC)['Value'];
    
    $connectionOk = true;
} catch (Exception $e) {
    $connectionOk = false;
    $errorMsg = $e->getMessage();
}
?>

<div class="min-h-screen bg-black relative overflow-hidden px-6 py-12 font-mono">
	<!-- Ambient background grid & glow -->
	<div class="pointer-events-none fixed inset-0 opacity-5">
		<div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
	</div>
	<div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
	<div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>

	<div class="max-w-7xl mx-auto relative z-10">
		<!-- Header -->
		<div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8 mb-12">
			<div>
				<h1 id="dashTitle" class="text-6xl font-bold tracking-widest text-amber-500">
					<span class="block">ABYSSUM</span>
					<span class="block text-2xl mt-2 tracking-wide text-amber-600/80">// ESTADO DEL SISTEMA</span>
				</h1>
			</div>
			<div class="flex gap-3">
				<a href="/?sec=admin" class="px-5 py-2.5 rounded border border-amber-600/30 bg-black/60 hover:bg-amber-600/10 text-amber-500 text-sm tracking-wide transition">VOLVER</a>
			</div>
		</div>

		<?php if (!$connectionOk): ?>
			<!-- Error de conexión -->
			<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
				<div class="bg-black/70 border border-red-600/30 rounded-xl p-4 backdrop-filter" data-stat>
					<div class="text-xs uppercase tracking-widest text-red-600/70 mb-1">ESTADO DB</div>
					<div class="flex items-center gap-2 text-red-500 text-2xl font-bold">
						<i class="fas fa-times-circle text-xl"></i>
						<span>OFF</span>
					</div>
				</div>
				<div class="bg-black/70 border border-amber-600/30 rounded-xl p-4 backdrop-filter" data-stat>
					<div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">TABLAS</div>
					<div class="text-amber-500/40 text-3xl font-bold">--</div>
				</div>
				<div class="bg-black/70 border border-blue-600/30 rounded-xl p-4 backdrop-filter" data-stat>
					<div class="text-xs uppercase tracking-widest text-blue-600/70 mb-1">MYSQL</div>
					<div class="text-blue-500/40 text-xl font-bold">--</div>
				</div>
				<div class="bg-black/70 border border-purple-600/30 rounded-xl p-4 backdrop-filter" data-stat>
					<div class="text-xs uppercase tracking-widest text-purple-600/70 mb-1">PHP</div>
					<div class="text-purple-500 text-xl font-bold"><?= PHP_VERSION ?></div>
				</div>
			</div>
			
			<div class="bg-red-900/20 border border-red-600/40 rounded-xl p-6 mb-8 health-card">
				<h2 class="text-red-500 text-xl font-bold mb-3"><i class="fas fa-exclamation-triangle mr-2"></i>ERROR DE CONEXIÓN</h2>
				<p class="text-red-400"><?= htmlspecialchars($errorMsg) ?></p>
			</div>
		<?php else: ?>
			<!-- Estado del sistema -->
			<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
				<div class="bg-black/70 border border-green-600/30 rounded-xl p-4 backdrop-filter" data-stat>
					<div class="text-xs uppercase tracking-widest text-green-600/70 mb-1">ESTADO DB</div>
					<div class="flex items-center gap-2 text-green-500 text-2xl font-bold">
						<i class="fas fa-check-circle text-xl"></i>
						<span>OK</span>
					</div>
				</div>
				<div class="bg-black/70 border border-amber-600/30 rounded-xl p-4 backdrop-filter" data-stat>
					<div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">TABLAS</div>
					<div class="text-amber-500 text-3xl font-bold"><?= count($tables) ?></div>
				</div>
				<div class="bg-black/70 border border-blue-600/30 rounded-xl p-4 backdrop-filter" data-stat>
					<div class="text-xs uppercase tracking-widest text-blue-600/70 mb-1">MYSQL</div>
					<div class="text-blue-500 text-xl font-bold"><?= htmlspecialchars($mysqlVersion) ?></div>
				</div>
				<div class="bg-black/70 border border-purple-600/30 rounded-xl p-4 backdrop-filter" data-stat>
					<div class="text-xs uppercase tracking-widest text-purple-600/70 mb-1">PHP</div>
					<div class="text-purple-500 text-xl font-bold"><?= PHP_VERSION ?></div>
				</div>
			</div>

			<!-- Información de la base de datos -->
			<div class="bg-black/70 border border-amber-600/30 rounded-xl p-6 mb-8 health-card">
				<h2 class="text-amber-500 text-2xl font-bold mb-4 tracking-wide"><i class="fas fa-database mr-2"></i>BASE DE DATOS</h2>
				<div class="space-y-3">
					<div class="flex items-center gap-3">
						<span class="text-amber-600/70 text-sm uppercase tracking-wider">Base de datos activa:</span>
						<span class="text-amber-400 font-mono"><?= htmlspecialchars($currentDb) ?></span>
					</div>
				</div>
			</div>

			<!-- Tablas y registros -->
			<div class="bg-black/70 border border-amber-600/30 rounded-xl p-6 mb-8 health-card">
				<h2 class="text-amber-500 text-2xl font-bold mb-6 tracking-wide"><i class="fas fa-table mr-2"></i>REGISTROS POR TABLA</h2>
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
					<?php foreach ($tableCounts as $table => $count): ?>
						<div class="bg-black/50 border border-amber-600/20 rounded-lg p-4">
							<div class="text-amber-600/70 text-xs uppercase tracking-wider mb-1"><?= htmlspecialchars($table) ?></div>
							<div class="text-amber-400 text-2xl font-bold"><?= number_format($count) ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Todas las tablas -->
			<div class="bg-black/70 border border-amber-600/30 rounded-xl p-6 health-card">
				<h2 class="text-amber-500 text-2xl font-bold mb-6 tracking-wide"><i class="fas fa-list mr-2"></i>TODAS LAS TABLAS (<?= count($tables) ?>)</h2>
				<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
					<?php foreach ($tables as $table): ?>
						<div class="bg-black/50 border border-amber-600/20 rounded px-3 py-2">
							<code class="text-amber-400 text-sm"><?= htmlspecialchars($table) ?></code>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
