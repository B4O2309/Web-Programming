<!-- template/create_user.html.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <link rel="stylesheet" href="../manage_module/create_module.css?v=<?= time() ?>">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4>Create New User</h4>
        </div>
        <div class="card-body">
            <form action="create_user.php" method="post" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="name">Username</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="form-group mb-3">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="student">Student</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="avatar">Avatar (optional)</label>
                    <input type="file" class="form-control" id="avatar" name="avatar">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="../home.html.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
