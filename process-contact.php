<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $service = trim($_POST['service']);
    $budget = trim($_POST['budget'] ?? '');
    $message = trim($_POST['message']);
    
    // Validasi dasar
    if (empty($name) || empty($email) || empty($service) || empty($message)) {
        header('Location: contact.html?status=error');
        exit;
    }
    
    try {
        $stmt = $pdo->prepare("INSERT INTO contact_submissions (name, email, phone, company, service, budget, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $company, $service, $budget, $message]);
        
        header('Location: contact.html?status=success');
        exit;
    } catch (PDOException $e) {
        header('Location: contact.html?status=error');
        exit;
    }
} else {
    header('Location: contact.html');
    exit;
}
?>