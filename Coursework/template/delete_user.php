<?php
require_once __DIR__ . '/../includes/DatabaseConnection.php';
require_once __DIR__ . '/../includes/DatabaseFunctions.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    try {
        deleteUserById($pdo, $id);
        header("Location: home.html.php");
        exit;
    } catch (PDOException $e) {
        echo "Lỗi khi xóa người dùng: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "Invalid request: Missing ID.";
}
?>
