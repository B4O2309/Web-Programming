<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // Xóa session nếu không hợp lệ
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
