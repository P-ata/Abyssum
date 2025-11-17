<?php
declare(strict_types=1);

require_once __DIR__ . '/../classes/Contact.php';
require_once __DIR__ . '/../admin/classes/Toast.php';

// solo por post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?sec=contact');
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// validaciones
if (empty($name) || empty($email) || empty($message)) {
    Toast::error('Por favor completá todos los campos obligatorios');
    header('Location: /?sec=contact');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    Toast::error('Email inválido');
    header('Location: /?sec=contact');
    exit;
}

// se obtiene la IP del usuario
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
    header('Location: /?sec=contact');
    exit;

} catch (Exception $e) {
    Toast::error('Error al enviar el mensaje. Intentá de nuevo.');
    header('Location: /?sec=contact');
    exit;
}
