<?php
session_start();
require_once __DIR__ . '/../../includes/DatabaseConnection.php';
require_once __DIR__ . '/../../includes/DatabaseFunctions.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied.";
    exit;
}

// Xử lý GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $module = getModuleById($pdo, $id);

    if (!$module) {
        echo "Module not found.";
        exit;
    }

    include 'edit_module.html.php';
    exit;
}

// Xử lý POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    $name = trim($_POST['name'] ?? '');

    if ($name === '') {
        echo "Name is required.";
        exit;
    }

    updateModule($pdo, $id, $name);
    header("Location: ../home.html.php");
    exit;
}

echo "Invalid request.";
