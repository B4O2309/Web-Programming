<?php
session_start();
require_once '../includes/DatabaseConnection.php';
require_once '../functions/getQuestionById.php';
require_once '../functions/getAllModules.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.html');
  exit();
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? null;
if (!is_numeric($id)) {
  echo "<p>Invalid question ID.</p>";
  exit();
}

// Lấy module và question
$modules = getAllModules($pdo);
$question = getQuestionById($pdo, (int)$id, $user_id);

if (!$question) {
  echo "<p>Question not found or access denied.</p>";
  exit();
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $text = $_POST['text'] ?? '';
  $module_id = $_POST['module_id'] ?? $question['module_id'];
  $img = $question['img'];

  if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === 0) {
    $targetDir = __DIR__ . '/images/';
    $filename = basename($_FILES['fileToUpload']['name']);
    $targetFile = $targetDir . $filename;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($imageFileType, $allowedTypes)) {
      if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
        $img = $filename;
      } else {
        echo "<p style='color:red;'>Failed to upload image.</p>";
      }
    } else {
      echo "<p style='color:red;'>Only JPG, PNG, GIF images are allowed.</p>";
    }
  }

  $update = $pdo->prepare("UPDATE questions SET text = ?, img = ?, module_id = ? WHERE id = ? AND user_id = ?");
  $update->execute([$text, $img, $module_id, $id, $user_id]);

  header('Location: home.html.php');
  exit();
}

// Hiển thị HTML
include '../template/edit_question.html.php';
