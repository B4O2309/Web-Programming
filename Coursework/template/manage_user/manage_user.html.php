<?php
require_once __DIR__ . '/../../includes/DatabaseConnection.php';

$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="manage_user/manage_user.css?v=<?= time() ?>">
</head>
<body>
    <div class="user-container">
        <h1>Manage Users</h1>
        <div style="margin-bottom: 20px;">
            <a href="manage_user/create_user.html.php" class="edit-btn">Create New User</a><br><br>
        </div>
        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Password</th> <!-- ✅ Thêm cột password -->
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td>
                        <img class="avatar-img" src="images/<?= !empty($user['images']) ? htmlspecialchars($user['images']) : 'default_avatar.jpg' ?>" alt="avatar" width="50">
                    </td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['role'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($user['password']) ?></td>
                    <td>
                        <a class="edit-btn" href="manage_user/edit_user.html.php?id=<?= $user['id'] ?>">Edit</a>
                        |
                        <a class="delete-btn" href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
