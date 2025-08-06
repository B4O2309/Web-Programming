<?php
session_start();
require 'includes/DatabaseConnection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if (!empty($username) && !empty($password)) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {
      session_regenerate_id(true);
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['name'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['image'] = $user['images'];
      $_SESSION['role'] = $user['role'];

      header("Location: template/home.html.php");
      exit();
    } else {
      echo "<p style='color:red;'>Invalid username or password.</p>";
    }
  } else {
    echo "<p style='color:red;'>Please fill in both fields.</p>";
  }
  
}
