<?php
require_once BASE_PATH . '/includes/auth.php';
require_once BASE_PATH . '/classes/User.php';

requireLogin();

$user = User::find($_SESSION['user_id']);
if (!$user) {
    header('Location: /?sec=login');
    exit;
}
?>

<div class="min-h-screen bg-black relative overflow-hidden py-20 px-4 font-mono">
    <!-- Ambient background grid & glow -->
    <div class="pointer-events-none fixed inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(251,191,36,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(251,191,36,0.12) 1px, transparent 1px); background-size: 55px 55px;"></div>
    </div>
    <div class="pointer-events-none fixed top-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-20" style="background: radial-gradient(circle at center, rgba(251,191,36,0.45), transparent 70%);"></div>
    <div class="pointer-events-none fixed bottom-0 right-0 w-[28rem] h-[28rem] rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle at center, rgba(251,191,36,0.35), transparent 70%);"></div>

    <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Título -->
        <div class="text-center mb-6 profile-title">
            <h1 class="text-6xl font-bold tracking-widest text-amber-500">MI CUENTA</h1>
        </div>

        <!-- Subtítulo -->
        <div class="text-center mb-12 profile-subtitle">
            <p class="text-amber-600/70 text-sm uppercase tracking-widest">
                // Gestiona tu información personal
            </p>
        </div>

        <div class="max-w-6xl mx-auto">
            
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <a href="/?sec=orders" class="quick-action bg-black/70 border border-amber-600/30 hover:border-amber-600/50 hover:bg-amber-600/10 rounded-xl p-6 text-center transition-all backdrop-blur-sm group">
                    <div class="text-5xl mb-3 group-hover:scale-110 transition-transform text-amber-500"><i class="fa-solid fa-scroll"></i></div>
                    <div class="text-amber-500 font-bold text-lg tracking-wider mb-2">MIS COMPRAS</div>
                    <div class="text-amber-600/70 text-xs uppercase tracking-wider">Ver historial de órdenes</div>
                </a>
                <a href="/?sec=pacts" class="quick-action bg-black/70 border border-amber-600/30 hover:border-amber-600/50 hover:bg-amber-600/10 rounded-xl p-6 text-center transition-all backdrop-blur-sm group">
                    <div class="text-5xl mb-3 group-hover:scale-110 transition-transform text-amber-500"><i class="fa-solid fa-file-contract"></i></div>
                    <div class="text-amber-500 font-bold text-lg tracking-wider mb-2">EXPLORAR PACTOS</div>
                    <div class="text-amber-600/70 text-xs uppercase tracking-wider">Ver pactos disponibles</div>
                </a>
            </div>

            <!-- User Info Card -->
            <div class="info-card bg-black/70 border border-amber-600/30 rounded-xl p-8 mb-6 backdrop-blur-sm">
                <h2 class="text-2xl font-bold text-amber-500 mb-6 uppercase tracking-wider border-b border-amber-600/30 pb-3">
                    <i class="fa-solid fa-user mr-2"></i>Información de Cuenta
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="info-item flex items-center justify-between p-3 bg-black/50 border border-amber-600/20 rounded">
                            <span class="text-amber-600/80 text-sm uppercase tracking-wider">ID:</span>
                            <span class="text-amber-300 font-semibold">#<?= $user->id ?></span>
                        </div>
                        <div class="info-item flex items-center justify-between p-3 bg-black/50 border border-amber-600/20 rounded">
                            <span class="text-amber-600/80 text-sm uppercase tracking-wider">Email:</span>
                            <span class="text-amber-300 font-semibold text-xs"><?= htmlspecialchars($user->email) ?></span>
                        </div>
                        <div class="info-item flex items-center justify-between p-3 bg-black/50 border border-amber-600/20 rounded">
                            <span class="text-amber-600/80 text-sm uppercase tracking-wider">Nombre:</span>
                            <span class="text-amber-300 font-semibold"><?= htmlspecialchars($user->display_name) ?></span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <?php if ($user->isAdmin()): ?>
                            <div class="info-item flex items-center justify-between p-3 bg-black/50 border border-amber-600/20 rounded">
                                <span class="text-amber-600/80 text-sm uppercase tracking-wider">Roles:</span>
                                <div class="flex gap-2">
                                    <?php foreach ($user->roles as $role): ?>
                                        <span class="px-2 py-1 text-xs rounded uppercase font-semibold <?= $role === 'admin' ? 'bg-blue-600/20 text-blue-400 border border-blue-600/40' : 'bg-amber-600/20 text-amber-400 border border-amber-600/40' ?>">
                                            <?= $role ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="info-item flex items-center justify-between p-3 bg-black/50 border border-amber-600/20 rounded">
                                <span class="text-amber-600/80 text-sm uppercase tracking-wider">Estado:</span>
                                <?php if ($user->is_active): ?>
                                    <span class="px-3 py-1 text-xs rounded uppercase font-semibold bg-green-600/20 text-green-400 border border-green-600/40 flex items-center gap-2">
                                        <i class="fa-solid fa-circle text-[6px]"></i>Activo
                                    </span>
                                <?php else: ?>
                                    <span class="px-3 py-1 text-xs rounded uppercase font-semibold bg-red-600/20 text-red-400 border border-red-600/40 flex items-center gap-2">
                                        <i class="fa-solid fa-circle text-[6px]"></i>Inactivo
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($user->last_login_at): ?>
                        <div class="info-item flex items-center justify-between p-3 bg-black/50 border border-amber-600/20 rounded">
                            <span class="text-amber-600/80 text-sm uppercase tracking-wider">Último login:</span>
                            <span class="text-amber-300 font-semibold text-xs">
                                <?php
                                $lastLoginUTC = new DateTime($user->last_login_at, new DateTimeZone('UTC'));
                                $lastLoginUTC->setTimezone(new DateTimeZone('America/Argentina/Buenos_Aires'));
                                echo $lastLoginUTC->format('d/m/Y H:i');
                                ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Update Profile Form -->
            <div class="update-form bg-black/70 border border-amber-600/30 rounded-xl p-8 mb-6 backdrop-blur-sm">
                <h2 class="text-2xl font-bold text-amber-500 mb-6 uppercase tracking-wider border-b border-amber-600/30 pb-3">
                    <i class="fa-solid fa-pen-to-square mr-2"></i>Actualizar Perfil
                </h2>
                <form action="/?sec=actions&action=update-profile" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-amber-500 text-xs mb-2 uppercase tracking-wider">
                            <i class="fa-solid fa-user mr-2"></i>Nombre:
                        </label>
                        <input 
                            type="text" 
                            name="display_name" 
                            value="<?= htmlspecialchars($user->display_name) ?>"
                            required 
                            class="w-full bg-black/60 border border-amber-600/40 text-amber-300 rounded px-4 py-3 text-sm focus:border-amber-500 focus:outline-none placeholder-amber-600/30 transition-all"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-amber-500 text-xs mb-2 uppercase tracking-wider">
                            <i class="fa-solid fa-envelope mr-2"></i>Email:
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            value="<?= htmlspecialchars($user->email) ?>"
                            required 
                            class="w-full bg-black/60 border border-amber-600/40 text-amber-300 rounded px-4 py-3 text-sm focus:border-amber-500 focus:outline-none placeholder-amber-600/30 transition-all"
                        >
                    </div>
                    
                    <button type="submit" class="bg-amber-600/20 hover:bg-amber-600/30 border border-amber-600/40 text-amber-500 px-6 py-3 rounded text-sm font-bold transition-all hover:shadow-lg hover:shadow-amber-500/30 uppercase tracking-wider">
                        <i class="fa-solid fa-floppy-disk mr-2"></i>Actualizar Información
                    </button>
                </form>
            </div>

            <!-- Change Password Form -->
            <div class="password-form bg-black/70 border border-amber-600/30 rounded-xl p-8 mb-6 backdrop-blur-sm">
                <h2 class="text-2xl font-bold text-amber-500 mb-6 uppercase tracking-wider border-b border-amber-600/30 pb-3">
                    <i class="fa-solid fa-lock mr-2"></i>Cambiar Contraseña
                </h2>
                <form action="/?sec=actions&action=change-password" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-amber-500 text-xs mb-2 uppercase tracking-wider">
                            <i class="fa-solid fa-key mr-2"></i>Contraseña Actual:
                        </label>
                        <input 
                            type="password" 
                            name="current_password" 
                            required 
                            class="w-full bg-black/60 border border-amber-600/40 text-amber-300 rounded px-4 py-3 text-sm focus:border-amber-500 focus:outline-none placeholder-amber-600/30 transition-all"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-amber-500 text-xs mb-2 uppercase tracking-wider">
                            <i class="fa-solid fa-lock mr-2"></i>Nueva Contraseña:
                        </label>
                        <input 
                            type="password" 
                            name="new_password" 
                            required 
                            minlength="6"
                            class="w-full bg-black/60 border border-amber-600/40 text-amber-300 rounded px-4 py-3 text-sm focus:border-amber-500 focus:outline-none placeholder-amber-600/30 transition-all"
                            placeholder="Mínimo 6 caracteres"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-amber-500 text-xs mb-2 uppercase tracking-wider">
                            <i class="fa-solid fa-check-double mr-2"></i>Confirmar Nueva Contraseña:
                        </label>
                        <input 
                            type="password" 
                            name="confirm_password" 
                            required 
                            minlength="6"
                            class="w-full bg-black/60 border border-amber-600/40 text-amber-300 rounded px-4 py-3 text-sm focus:border-amber-500 focus:outline-none placeholder-amber-600/30 transition-all"
                        >
                    </div>
                    
                    <button type="submit" class="bg-red-600/20 hover:bg-red-600/30 border border-red-600/40 text-red-400 hover:text-red-300 px-6 py-3 rounded text-sm font-bold transition-all hover:shadow-lg hover:shadow-red-500/30 uppercase tracking-wider">
                        <i class="fa-solid fa-shield-halved mr-2"></i>Cambiar Contraseña
                    </button>
                </form>
            </div>

            <!-- Logout Button -->
            <div class="text-center logout-button">
                <a href="/?sec=actions&action=logout" class="inline-block bg-black/60 hover:bg-black/80 border border-amber-600/40 text-amber-600 hover:text-amber-500 font-bold py-3 px-8 rounded transition-all uppercase tracking-wider text-sm">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i>Cerrar Sesión
                </a>
            </div>
        </div>
    </div>
</div>
