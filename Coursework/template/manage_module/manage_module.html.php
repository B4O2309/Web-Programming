<?php
session_start();
require_once __DIR__ . '/../../includes/DatabaseConnection.php';

// Kiểm tra role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.html.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM modules ORDER BY name ASC");
$stmt->execute();
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Modules</title>
  <link rel="stylesheet" href="../manage_user/edit_user.css?v=<?= time() ?>">
  <link rel="stylesheet" href="manage_user/manage_user.css?v=<?= time() ?>">

</head>
<body>
  <div class="user-container">
    <h1>Manage Modules</h1>
    <a href="manage_module/create_module.html.php" class="edit-btn" style="margin-bottom:1rem; display:inline-block;">Create New Module</a>
    <table class="user-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($modules as $module): ?>
        <tr>
          <td><?= htmlspecialchars($module['id']) ?></td>
          <td><?= htmlspecialchars($module['name']) ?></td>
          <td><?= htmlspecialchars($module['description'] ?? '') ?></td>
          <td>
            <a class="edit-btn" href="manage_module/edit_module.php?id=<?= $module['id'] ?>">Edit</a>
            |
            <a class="delete-btn" href="manage_module/delete_module.php?id=<?= $module['id'] ?>" onclick="return confirm('Are you sure you want to delete this module?');">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
