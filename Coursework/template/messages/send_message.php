<?php
session_start();
require_once __DIR__ . '/../../includes/DatabaseConnection.php';

$sender_id = $_SESSION['user_id'] ?? null;
$text = trim($_POST['text'] ?? '');

if (!$sender_id || $text === '') {
    die("Invalid input.");
}

// Get admin user
$admin = $pdo->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
if (!$admin) die("No admin found.");

if ($sender_id == $admin['id']) {
    $receiver_id = $_POST['receiver_id'] ?? null;

    // Kiểm tra xem user đó có tồn tại thật không
    $stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
    $stmt->execute([$receiver_id]);
    $exists = $stmt->fetchColumn();

    if (!$exists) {
        die("Receiver does not exist.");
    }

} else {
    $receiver_id = $admin['id'];
}


$stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, text) VALUES (?, ?, ?)");
$stmt->execute([$sender_id, $receiver_id, $text]);

header("Location: contact_admin.html.php");
exit;