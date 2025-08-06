<?php
require_once __DIR__ . '/../../includes/DatabaseFunctions.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "User ID is missing.";
    exit;
}

$id = $_GET['id'];
$user = getUserById($id, $pdo);

if (!$user) {
    echo "User not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="edit_user.css?v=<?= time() ?>">
</head>
<body>
    <div class="edit-box">
        <h2>Edit User</h2>
        <form action="edit_user.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['name']) ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label for="role">Role:</label>
            <select name="role" id="role" class="dropdown">
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
            </select>

            <label for="avatar">Avatar Filename:</label>
            <input type="text" name="avatar" id="avatar" value="<?= htmlspecialchars($user['images']) ?>">

            <label>Current Avatar:</label><br>
            <<?php
            $avatar = !empty($user['images']) ? htmlspecialchars($user['images']) : 'default_avatar.jpg';
            ?>
            <img class="img" src="../images/<?= $avatar ?>" alt="Avatar" style="max-width: 200px; border-radius: 8px;"><br><br>
            <button type="submit">Save Changes</button>
            <a href="../home.html.php">Cancel</a>
        </form>
    </div>
</body>
</html>
