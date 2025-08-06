<?php
session_start();
require_once __DIR__ . '/../includes/DatabaseConnection.php';
require_once __DIR__ . '/../includes/DatabaseFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_SESSION['user_id'])) {
    $id = $_POST['id'];
    $userId = $_SESSION['user_id'];

    $question = getQuestionByIdAndUser($pdo, $id, $userId);

    if ($question) {
        if (deleteQuestionById($pdo, $id)) {
            header("Location: home.html.php");
            exit;
        } else {
            echo "Failed to delete the question.";
        }
    } else {
        echo "You are not authorized to delete this post.";
    }
} else {
    echo "Invalid request.";
}
