<?php
require_once __DIR__ . '/../../includes/DatabaseFunctions.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? 'user';

if ($name === '' || $email === '' || $password === '') {
    die("All fields are required.");
}

// ❌ Không mã hóa mật khẩu — dùng trực tiếp
$plainPassword = $password;

// Xử lý ảnh upload
$imageName = null;
if (!empty($_FILES['avatar']['name'])) {
    $uploadDir = __DIR__ . '/../images/';
    $imageName = uniqid() . '_' . basename($_FILES['avatar']['name']);
    move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $imageName);
}

// Gọi hàm tạo user
createUser($name, $email, $plainPassword, $role, $imageName);

header("Location: ../home.html.php");
exit;
