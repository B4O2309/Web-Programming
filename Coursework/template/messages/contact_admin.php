<?php
session_start();
require_once __DIR__ . '/../../includes/DatabaseFunctions.php';
require_once __DIR__ . '/contact_admin.php';

$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? 'guest';

if (!$user_id) {
    echo "Access Denied.";
    exit;
}

// Lấy thông tin admin và người nhận
$admin_id = getAdminId($pdo);
$receiver_id = getReceiverId($pdo, $role, $admin_id, $user_id);

// Lấy tin nhắn
$messages = getMessages($pdo, $user_id, $receiver_id);

// Lấy danh sách user (nếu là admin)
$users = ($role === 'admin') ? getAllUsersExceptAdmin($pdo) : [];
