<?php
require_once BASE_PATH . '/classes/Contact.php';

$stats = Contact::getStats();
$filter = $_GET['status'] ?? 'all';

$contacts = $filter === 'all' ? Contact::all() : Contact::byStatus($filter);

// Mapeo de estados a colores
$statusColors = [
    'new' => 'yellow',
    'in_progress' => 'blue',
    'resolved' => 'green',
    'spam' => 'red'
];

$statusLabels = [
    'new' => 'NUEVO',
    'in_progress' => 'EN PROCESO',
    'resolved' => 'RESUELTO',
    'spam' => 'SPAM'
];
?>

<div class="min-h-screen bg-gradient-to-br from-gray-900 via-black to-gray-900 text-white p-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-500 mb-2">MENSAJES DE CONTACTO</h1>
            <p class="text-gray-400">Gestión de mensajes de usuarios</p>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-5 gap-4 mb-8">
            <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-4">
                <div class="text-2xl font-bold text-amber-500"><?= $stats['total'] ?></div>
                <div class="text-xs text-gray-400">Total</div>
            </div>
            <div class="bg-yellow-900/20 border border-yellow-600/40 rounded-lg p-4">
                <div class="text-2xl font-bold text-yellow-400"><?= $stats['new'] ?></div>
                <div class="text-xs text-yellow-600">Nuevos</div>
            </div>
            <div class="bg-blue-900/20 border border-blue-600/40 rounded-lg p-4">
                <div class="text-2xl font-bold text-blue-400"><?= $stats['in_progress'] ?></div>
                <div class="text-xs text-blue-600">En proceso</div>
            </div>
            <div class="bg-green-900/20 border border-green-600/40 rounded-lg p-4">
                <div class="text-2xl font-bold text-green-400"><?= $stats['resolved'] ?></div>
                <div class="text-xs text-green-600">Resueltos</div>
            </div>
            <div class="bg-red-900/20 border border-red-600/40 rounded-lg p-4">
                <div class="text-2xl font-bold text-red-400"><?= $stats['spam'] ?></div>
                <div class="text-xs text-red-600">Spam</div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="flex gap-2 mb-6">
            <a href="/?sec=admin&page=contacts&status=all" class="px-4 py-2 rounded text-sm <?= $filter === 'all' ? 'bg-amber-600 text-white' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' ?>">
                Todos
            </a>
            <a href="/?sec=admin&page=contacts&status=new" class="px-4 py-2 rounded text-sm <?= $filter === 'new' ? 'bg-yellow-600 text-white' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' ?>">
                Nuevos
            </a>
            <a href="/?sec=admin&page=contacts&status=in_progress" class="px-4 py-2 rounded text-sm <?= $filter === 'in_progress' ? 'bg-blue-600 text-white' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' ?>">
                En proceso
            </a>
            <a href="/?sec=admin&page=contacts&status=resolved" class="px-4 py-2 rounded text-sm <?= $filter === 'resolved' ? 'bg-green-600 text-white' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' ?>">
                Resueltos
            </a>
            <a href="/?sec=admin&page=contacts&status=spam" class="px-4 py-2 rounded text-sm <?= $filter === 'spam' ? 'bg-red-600 text-white' : 'bg-gray-800 text-gray-400 hover:bg-gray-700' ?>">
                Spam
            </a>
        </div>

        <!-- Lista de contactos -->
        <?php if (empty($contacts)): ?>
            <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-8 text-center">
                <p class="text-gray-400">No hay mensajes <?= $filter !== 'all' ? 'con este estado' : '' ?></p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($contacts as $contact): ?>
                    <?php 
                    $color = $statusColors[$contact->status];
                    $statusLabel = $statusLabels[$contact->status];
                    ?>
                    <div class="bg-gray-800/50 border border-gray-700 rounded-lg overflow-hidden">
                        <!-- Header del contacto -->
                        <div class="p-4 flex justify-between items-start border-b border-gray-700">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-bold text-amber-400"><?= htmlspecialchars($contact->name) ?></h3>
                                    <span class="px-2 py-1 text-xs rounded bg-<?= $color ?>-900/30 text-<?= $color ?>-400 border border-<?= $color ?>-600/40">
                                        <?= $statusLabel ?>
                                    </span>
                                </div>
                                <div class="flex gap-4 text-sm text-gray-400">
                                    <span>📧 <?= htmlspecialchars($contact->email) ?></span>
                                    <span>📅 <?= date('d/m/Y H:i', strtotime($contact->sent_at)) ?></span>
                                    <?php if ($contact->ip_address): ?>
                                        <span>🌐 <?= htmlspecialchars($contact->ip_address) ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if ($contact->subject): ?>
                                    <div class="mt-2 text-sm text-amber-500">
                                        <strong>Asunto:</strong> <?= htmlspecialchars($contact->subject) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Mensaje -->
                        <div class="p-4 bg-black/30">
                            <p class="text-gray-300 whitespace-pre-wrap"><?= htmlspecialchars($contact->message) ?></p>
                        </div>

                        <!-- Acciones -->
                        <div class="p-4 flex gap-2 border-t border-gray-700">
                            <?php if ($contact->status !== 'in_progress'): ?>
                                <form method="POST" action="/?sec=admin&action=update-contact-status" class="inline">
                                    <input type="hidden" name="contact_id" value="<?= $contact->id ?>">
                                    <input type="hidden" name="status" value="in_progress">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded">
                                        📝 En proceso
                                    </button>
                                </form>
                            <?php endif; ?>

                            <?php if ($contact->status !== 'resolved'): ?>
                                <form method="POST" action="/?sec=admin&action=update-contact-status" class="inline">
                                    <input type="hidden" name="contact_id" value="<?= $contact->id ?>">
                                    <input type="hidden" name="status" value="resolved">
                                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded">
                                        ✓ Resuelto
                                    </button>
                                </form>
                            <?php endif; ?>

                            <?php if ($contact->status !== 'spam'): ?>
                                <form method="POST" action="/?sec=admin&action=update-contact-status" class="inline">
                                    <input type="hidden" name="contact_id" value="<?= $contact->id ?>">
                                    <input type="hidden" name="status" value="spam">
                                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded">
                                        🚫 Marcar spam
                                    </button>
                                </form>
                            <?php endif; ?>

                            <?php if ($contact->handled_by): ?>
                                <span class="ml-auto text-sm text-gray-500">
                                    Gestionado por: <?= htmlspecialchars($contact->handler_name ?? 'Usuario #' . $contact->handled_by) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>
