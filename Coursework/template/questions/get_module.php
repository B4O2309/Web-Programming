<?php
session_start();
require_once 'includes/DatabaseFunctions.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p style='color:red;'>You must be logged in to post a question.</p>";
    exit();
}

try {
    $modules = getAllModules($pdo);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Failed to load modules: " . htmlspecialchars($e->getMessage()) . "</p>";
    $modules = [];
}
