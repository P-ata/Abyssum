<?php
declare(strict_types=1);

require_once __DIR__ . '/../classes/Contact.php';
require_once __DIR__ . '/../admin/classes/Toast.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /contact');
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validaciones
if (empty($name) || empty($email) || empty($message)) {
    Toast::error('Por favor completá todos los campos obligatorios');
    header('Location: /contact');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    Toast::error('Email inválido');
    header('Location: /contact');
    exit;
}

// Obtener IP del usuario
$ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;

try {
    $contactId = Contact::create([
        'name' => $name,
        'email' => $email,
        'subject' => $subject ?: null,
        'message' => $message,
        'ip_address' => $ipAddress
    ]);

    Toast::success('Mensaje enviado correctamente. Te responderemos pronto.');
    header('Location: /contact');
    exit;

} catch (Exception $e) {
    Toast::error('Error al enviar el mensaje. Intentá de nuevo.');
    header('Location: /contact');
    exit;
}
