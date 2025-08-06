<head>
    <meta charset="UTF-8">
    <title>Edit Module</title>
    <link rel="stylesheet" href="create_module.css">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Module</h4>
        </div>
        <div class="card-body">
            <form action="edit_module.php" method="post">
                <!-- Hidden ID -->
                <input type="hidden" name="id" value="<?= isset($module['id']) ? htmlspecialchars($module['id']) : '' ?>">

                <div class="form-group mb-3">
                    <label for="module_name" class="form-label">Module Name</label>
                    <input type="text" class="form-control" id="module_name" name="name"
                        value="<?= isset($module['name']) ? htmlspecialchars($module['name']) : '' ?>" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="../home.html.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Update Module</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
