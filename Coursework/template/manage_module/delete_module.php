<?php
session_start();
require_once __DIR__ . '/../../includes/DatabaseConnection.php';
require_once __DIR__ . '/../../includes/DatabaseFunctions.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied.";
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    if (deleteModuleById($pdo, $id)) {
        header("Location: ../home.html.php");
        exit;
    } else {
        echo "Delete failed.";
    }
} else {
    echo "Invalid request.";
}
