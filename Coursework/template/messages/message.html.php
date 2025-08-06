<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Access Denied.";
    exit;
}

$role = $_SESSION['role'] ?? 'student';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages</title>
    <link rel="stylesheet" href="messages/chat.css">
</head>
<body>
<div class="message-container">
    <h1><?= $role === 'admin' ? 'Send messages to Students' : 'Send messages to Admin' ?></h1>
    <a class="send-btn" href="messages/contact_admin.html.php">Send Message</a>
</div>
</body>
</html>
