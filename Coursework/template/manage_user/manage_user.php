<?php
session_start();
require_once __DIR__ . '/../../includes/DatabaseFunctions.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Lấy dữ liệu người dùng
$users = getAllUsers($pdo);

// Hiển thị giao diện
include 'manage_user.html.php';
