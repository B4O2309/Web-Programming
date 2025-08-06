<?php
require_once __DIR__ . '/../includes/DatabaseConnection.php';

$question_id = $_GET['question_id'] ?? null;
if (!is_numeric($question_id)) {
    die("Invalid question ID");
}

// Lấy thông tin câu hỏi
$stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
$stmt->execute([$question_id]);
$question = $stmt->fetch();

if (!$question) {
    die("Question not found.");
}

// Lấy danh sách modules
$modulesStmt = $pdo->query("SELECT id, name FROM modules ORDER BY name ASC");
$modules = $modulesStmt->fetchAll();
