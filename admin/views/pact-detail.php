<?php
require_once BASE_PATH . '/classes/Pact.php';
require_once BASE_PATH . '/classes/Demon.php';
require_once BASE_PATH . '/classes/Category.php';
require_once BASE_PATH . '/classes/DbConnection.php';

// obtener ID del pacto
$pactId = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$pactId) {
    header('Location: /?sec=admin&page=pacts');
    exit;
}

$dbError = false;
$pact = null;
$demon = null;
$demonName = 'Desconocido';
$pactImage = null;
$categories = [];

try {
    // obtener el pacto
    $pact = Pact::find($pactId);

    if (!$pact) {
        header('Location: /?sec=admin&page=pacts');
        exit;
    }

    // obtener el demonio
    $pdo = DbConnection::get();
    $stmtDemon = $pdo->prepare('SELECT id, name FROM demons WHERE id = ?');
    $stmtDemon->execute([$pact->demon_id]);
    $demon = $stmtDemon->fetch(PDO::FETCH_ASSOC);
    $demonName = $demon ? $demon['name'] : 'Desconocido';

    // obtener imagen
    if ($pact->image_file_id) {
        $stmt = $pdo->prepare('SELECT filename FROM files WHERE id = ?');
        $stmt->execute([$pact->image_file_id]);
        $file = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($file) {
            $pactImage = '/assets/img/' . $file['filename'];
        }
    }

    // obtener categorías del pacto
    $categories = $pact->categories();
} catch (Exception $e) {
    $dbError = true;
    error_log('Error loading pact detail: ' . $e->getMessage());
}
?>

<div class="min-h-screen bg-black relative overflow-hidden py-8 px-4 font-mono">
  
  <div class="pointer-events-none fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
  </div>
  <div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
  <div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>

  <div class="mx-auto max-w-[1400px] px-4 sm:px-6 lg:px-8 relative z-10">
    
    <?php if ($dbError): ?>
      <div class="text-center py-20">
        <div class="text-red-400 font-mono text-xl mb-2">
          // ERROR DE CONEXIÓN
        </div>
        <div class="text-amber-400/60 font-mono mb-6">
          No se pudo cargar el detalle del pacto. Por favor, intenta más tarde.
        </div>
        <a href="/?sec=admin&page=pacts" class="inline-block bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 px-6 py-3 rounded text-sm font-bold transition-all uppercase tracking-wider">
          <i class="fa-solid fa-arrow-left mr-2"></i>Volver a Pactos
        </a>
      </div>
    <?php else: ?>
    <!-- contenedor principal -->
    <div class="mx-auto max-w-7xl overflow-visible">
      
      <!-- botón volver -->
      <div class="mb-6 mt-2 pact-back">
        <a href="/?sec=admin&page=<?= isset($_GET['return_to']) ? htmlspecialchars($_GET['return_to']) : 'pacts' ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-amber-600/40 bg-amber-600/10 hover:bg-amber-600/20 hover:border-amber-600/60 transition-all text-amber-500 hover:text-amber-400 shadow-lg shadow-amber-500/10 hover:shadow-amber-500/20">
          <i class="fa-solid fa-arrow-left text-base"></i>
          <span class="font-bold text-sm uppercase tracking-wider">Volver a Pactos</span>
        </a>
      </div>

      <div class="flex flex-col lg:flex-row gap-8 lg:max-h-[850px] overflow-visible">
        
        <!-- columna izquierda -->
        <div class="pact-image lg:w-2/5 flex-shrink-0">
          <div class="bg-black/70 border-2 border-amber-600/40 backdrop-blur-sm rounded-xl overflow-hidden shadow-2xl shadow-amber-500/20 h-full">
            <?php if ($pactImage): ?>
              <img 
                src="<?= htmlspecialchars($pactImage) ?>" 
                alt="<?= htmlspecialchars($pact->name) ?>"
                class="w-full h-full object-cover"
                onerror="this.src='/assets/img/pacts/16861331.png'"
              >
            <?php else: ?>
              <div class="flex items-center justify-center bg-black/60 w-full h-full">
                <i class="fa-solid fa-scroll text-amber-600/30 text-9xl"></i>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- columna derecha información -->
        <div class="pact-info space-y-8 lg:w-3/5 flex-shrink-0 lg:overflow-hidden lg:pr-4"
             style="scrollbar-width: thin; scrollbar-color: rgba(251, 191, 36, 0.3) transparent;">

        <!-- título y demonio -->
        <div class="pact-header">
          <h1 class="text-5xl font-bold text-amber-500 mb-3 tracking-wider"><?= htmlspecialchars($pact->name) ?></h1>
          <p class="text-amber-600/80 text-lg flex items-center gap-2">
            <i class="fa-solid fa-skull"></i>
            <span>Demonio: <strong class="text-amber-500"><?= htmlspecialchars($demonName) ?></strong></span>
          </p>
        </div>

        <!-- categorías -->
        <?php if (!empty($categories)): ?>
          <div class="pact-categories">
            <h3 class="text-amber-500 text-sm font-bold uppercase tracking-wider mb-2">
              <i class="fa-solid fa-tags mr-2"></i>Categorías
            </h3>
            <div class="flex flex-wrap gap-2">
              <?php foreach ($categories as $category): ?>
                <span class="px-3 py-1 bg-amber-600/20 border border-amber-600/40 rounded-full text-amber-400 text-xs font-mono">
                  <?= htmlspecialchars($category->display_name) ?>
                </span>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- resumen -->
        <?php if ($pact->summary): ?>
          <div class="pact-summary bg-black/70 border border-amber-600/30 rounded-xl p-6">
            <h3 class="text-amber-500 text-sm font-bold uppercase tracking-wider mb-3">
              <i class="fa-solid fa-file-lines mr-2"></i>Resumen
            </h3>
            <p class="text-amber-300/90 text-sm leading-relaxed">
              <?= nl2br(htmlspecialchars($pact->summary)) ?>
            </p>
          </div>
        <?php endif; ?>

        <!-- detalles técnicos -->
        <div class="pact-details grid grid-cols-1 md:grid-cols-2 gap-4">
          
          <!-- duración -->
          <?php if ($pact->duration): ?>
            <div class="bg-black/70 border border-amber-600/30 rounded-xl p-4">
              <h4 class="text-amber-500 text-xs font-bold uppercase tracking-wider mb-2 flex items-center gap-2">
                <i class="fa-solid fa-clock"></i>Duración
              </h4>
              <p class="text-amber-300 text-sm font-mono"><?= htmlspecialchars($pact->duration) ?></p>
            </div>
          <?php endif; ?>

          <!-- cooldown -->
          <?php if ($pact->cooldown): ?>
            <div class="bg-black/70 border border-amber-600/30 rounded-xl p-4">
              <h4 class="text-amber-500 text-xs font-bold uppercase tracking-wider mb-2 flex items-center gap-2">
                <i class="fa-solid fa-hourglass-half"></i>Cooldown
              </h4>
              <p class="text-amber-300 text-sm font-mono"><?= htmlspecialchars($pact->cooldown) ?></p>
            </div>
          <?php endif; ?>

          <!-- precio -->
          <div class="bg-black/70 border border-amber-600/30 rounded-xl p-4 md:col-span-2">
            <h4 class="text-amber-500 text-xs font-bold uppercase tracking-wider mb-2 flex items-center gap-2">
              <i class="fa-solid fa-coins"></i>Precio
            </h4>
            <p class="text-amber-500 text-3xl font-bold font-mono">
              <?= $pact->price_credits ?> <span class="text-xl">CR</span>
            </p>
          </div>

        </div>

        <!-- limitaciones -->
        <?php if (!empty($pact->limitations)): ?>
          <div class="pact-limitations bg-black/70 border border-amber-600/30 rounded-xl p-6">
            <h3 class="text-amber-500 text-sm font-bold uppercase tracking-wider mb-3">
              <i class="fa-solid fa-exclamation-triangle mr-2"></i>Limitaciones
            </h3>
            <ul class="space-y-2">
              <?php foreach ($pact->limitations as $limitation): ?>
                <li class="text-amber-300/90 text-sm flex items-start gap-2">
                  <i class="fa-solid fa-circle text-amber-600/50 text-[6px] mt-1.5"></i>
                  <span><?= htmlspecialchars($limitation) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <!-- botones de acción ADMIN -->
        <div class="pact-actions flex flex-col sm:flex-row gap-3">
          <a href="/?sec=admin&page=edit-pact&id=<?= $pact->id ?>&return_to=pact-detail" class="flex-1 bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 text-sm font-bold py-3 px-6 rounded-lg transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-edit"></i>
            EDITAR PACTO
          </a>
          
          <a href="#" onclick="showDeleteModal('/?sec=admin&action=delete-pact&id=<?= $pact->id ?>', '¿Eliminar el pacto <?= htmlspecialchars($pact->name) ?>?'); return false;" class="bg-red-900/30 hover:bg-red-900/50 border border-red-600/40 text-red-500 text-sm font-bold py-3 px-6 rounded-lg transition-all text-center flex items-center justify-center gap-2">
            <i class="fa-solid fa-trash"></i>
            ELIMINAR
          </a>

          <a href="/?sec=pact-detail&pact_id=<?= $pact->id ?>" target="_blank" class="bg-black/60 hover:bg-black/80 border border-amber-600/40 text-amber-600 hover:text-amber-500 text-sm font-bold py-3 px-6 rounded-lg transition-all text-center flex items-center justify-center gap-2">
            <i class="fa-solid fa-external-link-alt"></i>
            VER PÚBLICO
          </a>
        </div>

        </div>
        

      </div>
     
    </div>
    
    <?php endif; ?>

  </div>
</div>

<script type="module" src="http://localhost:5173/public/assets/admin/js/pact-detail.js"></script>
