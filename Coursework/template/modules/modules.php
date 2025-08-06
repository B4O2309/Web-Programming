<?php
session_start();
require_once __DIR__ . '/../../includes/DatabaseFunctions.php';

$module_id = $_GET['module_id'] ?? null;
$module_id = is_numeric($module_id) ? (int)$module_id : null;

try {
    $modules = getAllModules($pdo);
    $questions = $module_id ? getQuestionsByModule($pdo, $module_id) : [];
} catch (PDOException $e) {
    echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    $modules = [];
    $questions = [];
}
