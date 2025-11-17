<?php
declare(strict_types=1);

require_once __DIR__ . '/../../classes/Contact.php';
require_once __DIR__ . '/../classes/Toast.php';
require_once __DIR__ . '/../../includes/auth.php';

requireAdmin();

// solo por post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?sec=admin&page=contacts');
    exit;
}

$contactId = isset($_POST['contact_id']) ? (int)$_POST['contact_id'] : 0;
$status = $_POST['status'] ?? '';

if ($contactId <= 0 || !in_array($status, ['new', 'in_progress', 'resolved', 'spam'])) {
    Toast::error('Datos inválidos');
    header('Location: /?sec=admin&page=contacts');
    exit;
}

$contact = Contact::find($contactId);

if (!$contact) {
    Toast::error('Contacto no encontrado');
    header('Location: /?sec=admin&page=contacts');
    exit;
}

try {
    $adminId = (int)$_SESSION['admin_id'];
    $contact->updateStatus($status, $adminId);
    
    $labels = [
        'new' => 'nuevo',
        'in_progress' => 'en proceso',
        'resolved' => 'resuelto',
        'spam' => 'spam'
    ];
    
    Toast::success("Contacto marcado como {$labels[$status]}");
    
} catch (Exception $e) {
    Toast::error('Error al actualizar el estado');
}

header('Location: /?sec=admin&page=contacts');
exit;
