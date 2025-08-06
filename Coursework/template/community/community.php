<?php
session_start();
require_once 'includes/DatabaseFunctions.php';

try {
    $selectedModule = $_GET['module'] ?? null;

    if ($selectedModule) {
        $questions = getQuestionsByModule($pdo, $selectedModule);
    } else {
        $questions = getAllQuestions($pdo);
    }
} catch (PDOException $e) {
    echo "<p>Error loading posts: " . htmlspecialchars($e->getMessage()) . "</p>";
    $questions = [];
}
?>
