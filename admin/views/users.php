<?php
require_once BASE_PATH . '/classes/User.php';
require_once BASE_PATH . '/admin/classes/Toast.php';

$users = User::all();
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
		<div class="mb-12">
			<h1 id="dashTitle" class="text-6xl font-bold tracking-widest text-amber-500">
				<span class="block">ABYSSUM</span>
				<span class="block text-2xl mt-2 tracking-wide text-amber-600/80">// USUARIOS</span>
			</h1>
		</div>

		<!-- Stats Cards -->
		<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
			<div class="bg-black/70 border border-amber-600/30 rounded-xl p-6 backdrop-blur-sm" data-stat>
				<div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">TOTAL USUARIOS</div>
				<div class="text-amber-500 text-3xl font-bold"><?= count($users) ?></div>
			</div>
			<div class="bg-black/70 border border-amber-600/30 rounded-xl p-6 backdrop-blur-sm" data-stat>
				<div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">ACTIVOS</div>
				<div class="text-green-500 text-3xl font-bold"><?= count(array_filter($users, fn($u) => $u->is_active)) ?></div>
			</div>
			<div class="bg-black/70 border border-amber-600/30 rounded-xl p-6 backdrop-blur-sm" data-stat>
				<div class="text-xs uppercase tracking-widest text-amber-600/70 mb-1">ADMINS</div>
				<div class="text-blue-500 text-3xl font-bold"><?= count(array_filter($users, fn($u) => $u->isAdmin())) ?></div>
			</div>
		</div>

		<!-- Users Table -->
		<div id="usersTable" class="bg-black/70 border border-amber-600/30 rounded-xl overflow-hidden backdrop-blur-sm">
			<table class="w-full">
				<thead class="bg-black/50 border-b border-amber-600/30">
					<tr>
						<th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-amber-500">ID</th>
						<th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-amber-500">Usuario</th>
						<th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-amber-500">Email</th>
						<th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-amber-500">Roles</th>
						<th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-amber-500">Estado</th>
						<th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-amber-500">Último Login</th>
						<th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-amber-500">Acciones</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-amber-600/20">
					<?php foreach ($users as $user): ?>
						<tr class="user-row hover:bg-amber-600/5 transition">
							<td class="px-6 py-4 text-gray-300">#<?= $user->id ?></td>
							<td class="px-6 py-4">
								<div class="font-semibold text-amber-400"><?= htmlspecialchars($user->display_name) ?></div>
							</td>
							<td class="px-6 py-4 text-gray-400"><?= htmlspecialchars($user->email) ?></td>
							<td class="px-6 py-4">
								<div class="flex gap-2">
									<?php foreach ($user->roles as $role): ?>
										<span class="px-2 py-1 text-xs rounded <?= $role === 'admin' ? 'bg-blue-600/20 text-blue-400 border border-blue-600/40' : 'bg-gray-700/50 text-gray-400 border border-gray-600/40' ?>">
											<?= strtoupper($role) ?>
										</span>
									<?php endforeach; ?>
								</div>
							</td>
							<td class="px-6 py-4">
								<?php if ($user->is_active): ?>
									<span class="px-3 py-1 text-xs rounded bg-green-600/20 text-green-400 border border-green-600/40">ACTIVO</span>
								<?php else: ?>
									<span class="px-3 py-1 text-xs rounded bg-red-600/20 text-red-400 border border-red-600/40">INACTIVO</span>
								<?php endif; ?>
							</td>
						<td class="px-6 py-4 text-gray-400 text-sm">
							<?php
							if ($user->last_login_at) {
								date_default_timezone_set('America/Argentina/Buenos_Aires');
								$datetime = new DateTime($user->last_login_at);
								echo $datetime->format('d/m/Y H:i');
							} else {
								echo 'Nunca';
							}
							?>
						</td>
							<td class="px-6 py-4">
								<div class="flex gap-2 justify-center">
									<!-- Toggle Active -->
									<form action="/?sec=admin&action=toggle-user-status" method="POST" class="inline">
										<input type="hidden" name="user_id" value="<?= $user->id ?>">
										<input type="hidden" name="active" value="<?= $user->is_active ? '0' : '1' ?>">
										<button type="submit" class="px-3 py-1 text-xs rounded border <?= $user->is_active ? 'border-red-600/40 bg-red-600/10 text-red-500 hover:bg-red-600/20' : 'border-green-600/40 bg-green-600/10 text-green-500 hover:bg-green-600/20' ?> transition">
											<?= $user->is_active ? 'DESACTIVAR' : 'ACTIVAR' ?>
										</button>
									</form>
								
								<!-- Role Selector -->
								<form action="/?sec=admin&action=update-roles" method="POST" class="inline">
									<input type="hidden" name="user_id" value="<?= $user->id ?>">
									<select name="is_admin" onchange="this.form.submit()" class="px-3 py-1 text-xs rounded border border-amber-600/40 bg-black/60 text-amber-300 hover:bg-amber-600/10 transition cursor-pointer focus:border-amber-500 focus:outline-none">
										<option value="0" class="bg-black text-amber-300" <?= !$user->isAdmin() ? 'selected' : '' ?>>CUSTOMER</option>
										<option value="1" class="bg-black text-amber-300" <?= $user->isAdmin() ? 'selected' : '' ?>>ADMIN</option>
									</select>
								</form>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
