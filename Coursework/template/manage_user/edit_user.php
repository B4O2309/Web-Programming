<?php
require_once __DIR__ . '/../../includes/DatabaseFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = $_POST['id'] ?? null;
    $username = $_POST['username'] ?? '';
    $email    = $_POST['email'] ?? '';
    $role     = $_POST['role'] ?? '';
    $avatar   = $_POST['avatar'] ?? '';

    if ($id && updateUser($id, $username, $email, $role, $avatar, $pdo)) {
        header("Location: ../home.html.php");
        exit;
    } else {
        echo "Failed to update user.";
    }
} else {
    echo "Invalid request.";
}
