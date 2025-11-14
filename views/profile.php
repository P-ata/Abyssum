<?php
require_once BASE_PATH . '/includes/auth.php';
require_once BASE_PATH . '/classes/User.php';
require_once BASE_PATH . '/admin/classes/Toast.php';

requireLogin();

$user = User::find($_SESSION['user_id']);
if (!$user) {
    header('Location: /login');
    exit;
}
?>

<div class="min-h-screen bg-black text-white py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-500 mb-2">MI CUENTA</h1>
            <p class="text-gray-400">Gestiona tu información personal</p>
        </div>

        <!-- User Info Card -->
        <div class="bg-gray-900 border border-amber-600 rounded-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-amber-500 mb-4">INFORMACIÓN DE CUENTA</h2>
            <div class="space-y-3">
                <div>
                    <span class="text-gray-400">ID:</span>
                    <span class="text-white ml-2">#<?= $user->id ?></span>
                </div>
                <div>
                    <span class="text-gray-400">Email:</span>
                    <span class="text-white ml-2"><?= htmlspecialchars($user->email) ?></span>
                </div>
                <div>
                    <span class="text-gray-400">Nombre:</span>
                    <span class="text-white ml-2"><?= htmlspecialchars($user->display_name) ?></span>
                </div>
                <?php if ($user->isAdmin()): ?>
                    <div>
                        <span class="text-gray-400">Roles:</span>
                        <?php foreach ($user->roles as $role): ?>
                            <span class="ml-2 px-2 py-1 text-xs rounded <?= $role === 'admin' ? 'bg-blue-600/20 text-blue-400 border border-blue-600/40' : 'bg-gray-700/50 text-gray-400 border border-gray-600/40' ?>">
                                <?= strtoupper($role) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <div>
                        <span class="text-gray-400">Estado:</span>
                        <?php if ($user->is_active): ?>
                            <span class="ml-2 px-2 py-1 text-xs rounded bg-green-600/20 text-green-400 border border-green-600/40">ACTIVO</span>
                        <?php else: ?>
                            <span class="ml-2 px-2 py-1 text-xs rounded bg-red-600/20 text-red-400 border border-red-600/40">INACTIVO</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div>
                    <span class="text-gray-400">Último login:</span>
                    <span class="text-white ml-2">
                        <?= $user->last_login_at ? date('d/m/Y H:i', strtotime($user->last_login_at)) : 'Nunca' ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Update Profile Form -->
        <div class="bg-gray-900 border border-amber-600 rounded-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-amber-500 mb-4">ACTUALIZAR PERFIL</h2>
            <form action="/actions/update-profile" method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-300 mb-2 font-bold">Nombre:</label>
                    <input 
                        type="text" 
                        name="display_name" 
                        value="<?= htmlspecialchars($user->display_name) ?>"
                        required 
                        class="w-full bg-gray-800 border border-gray-700 rounded px-4 py-2 text-white focus:border-amber-600 focus:outline-none"
                    >
                </div>
                
                <div>
                    <label class="block text-gray-300 mb-2 font-bold">Email:</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="<?= htmlspecialchars($user->email) ?>"
                        required 
                        class="w-full bg-gray-800 border border-gray-700 rounded px-4 py-2 text-white focus:border-amber-600 focus:outline-none"
                    >
                </div>
                
                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-black font-bold py-2 px-6 rounded transition">
                    ACTUALIZAR INFORMACIÓN
                </button>
            </form>
        </div>

        <!-- Change Password Form -->
        <div class="bg-gray-900 border border-amber-600 rounded-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-amber-500 mb-4">CAMBIAR CONTRASEÑA</h2>
            <form action="/actions/change-password" method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-300 mb-2 font-bold">Contraseña Actual:</label>
                    <input 
                        type="password" 
                        name="current_password" 
                        required 
                        class="w-full bg-gray-800 border border-gray-700 rounded px-4 py-2 text-white focus:border-amber-600 focus:outline-none"
                    >
                </div>
                
                <div>
                    <label class="block text-gray-300 mb-2 font-bold">Nueva Contraseña:</label>
                    <input 
                        type="password" 
                        name="new_password" 
                        required 
                        minlength="6"
                        class="w-full bg-gray-800 border border-gray-700 rounded px-4 py-2 text-white focus:border-amber-600 focus:outline-none"
                        placeholder="Mínimo 6 caracteres"
                    >
                </div>
                
                <div>
                    <label class="block text-gray-300 mb-2 font-bold">Confirmar Nueva Contraseña:</label>
                    <input 
                        type="password" 
                        name="confirm_password" 
                        required 
                        minlength="6"
                        class="w-full bg-gray-800 border border-gray-700 rounded px-4 py-2 text-white focus:border-amber-600 focus:outline-none"
                    >
                </div>
                
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded transition">
                    CAMBIAR CONTRASEÑA
                </button>
            </form>
        </div>

        <!-- Logout Button -->
        <div class="text-center">
            <a href="/actions/logout" class="inline-block bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded transition">
                CERRAR SESIÓN
            </a>
        </div>
    </div>
</div>
