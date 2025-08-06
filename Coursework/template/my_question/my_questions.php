<?php
session_start();
require_once 'includes/DatabaseFunctions.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p style='color:red;'>You must be logged in to view your questions.</p>";
    exit();
}

try {
    $user_id = $_SESSION['user_id'];
    $questions = getUserQuestions($pdo, $user_id);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
    $questions = [];
}
