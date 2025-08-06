<head>
    <link rel="stylesheet" href="create_module.css?v=<?= time() ?>">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4>Create New Module</h4>
        </div>
        <div class="card-body">
            <form action="create_module.php" method="post">
                <div class="form-group mb-3">
                    <label for="module_name">Module Name</label>
                    <input type="text" class="form-control" id="module_name" name="name" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="../home.html.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Create Module</button>
                    <?php if (!empty($error)): ?>
                        <div class="error" style="color:red; margin-bottom: 10px;"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                </div>
            </form>
        </div>
    </div>
</div>
</body>
