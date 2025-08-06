<?php
session_start();
require_once __DIR__ . '/../../includes/DatabaseConnection.php';
require_once __DIR__ . '/../../includes/DatabaseFunctions.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');

    if ($name === '') {
        header("Location: create_module.html.php?status=error&msg=Name%20is%20required");
        exit;
    }

    if (addModule($pdo, $name)) {
        header("Location: ../home.html.php");
    } else {
        header("Location: create_module.html.php?status=error&msg=Failed%20to%20add%20module");
    }
} else {
    echo "Invalid request.";
}
