<?php
session_start();
require_once __DIR__ .'/../../includes/DatabaseFunctions.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p style='color:red;'>You must be logged in to post a question.</p>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $text = $_POST['text'] ?? '';
    $module_id = $_POST['module_id'] ?? '';
    $user_id = $_SESSION['user_id'];
    $img_filename = null;

    // Xử lý ảnh nếu có
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === 0) {
        $target_dir = "../images/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

        $img_filename = time() . '_' . basename($_FILES['fileToUpload']['name']);
        $target_file = $target_dir . $img_filename;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $isImage = getimagesize($_FILES['fileToUpload']['tmp_name']);
        if (!$isImage) {
            echo "<p style='color:red;'>File is not a valid image.</p>";
            $img_filename = null;
        } elseif ($_FILES['fileToUpload']['size'] > 500000) {
            echo "<p style='color:red;'>Image too large.</p>";
            $img_filename = null;
        } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "<p style='color:red;'>Invalid image format.</p>"; 
            $img_filename = null;
        } elseif (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
            echo "<p style='color:red;'>Error uploading file.</p>";
            $img_filename = null;
        }
    }

    // Gửi vào database
    if (!empty($text) && !empty($module_id)) {
        try {
            $success = postNewQuestion($pdo, $text, $img_filename, $user_id, $module_id);
            if ($success) {
                header("Location: ../home.html.php");
                exit();
            } else {
                echo "<p style='color:red;'>Failed to post your question.</p>";
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Please fill in all required fields.</p>";
    }
}
