<?php
require_once 'includes/DatabaseConnection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name     = $_POST['name'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $image    = '';

    // Upload image logic
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
        $target_dir = "template/images/";
        $filename   = time() . '_' . basename($_FILES["fileToUpload"]["name"]); // thêm time tránh trùng tên
        $target_file = $target_dir . $filename;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOk = 1;

        // Validate image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check === false) {
            echo "<p style='color:red;'>Uploaded file is not an image.</p>";
            $uploadOk = 0;
        }

        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "<p style='color:red;'>Image file is too large.</p>";
            $uploadOk = 0;
        }

        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "<p style='color:red;'>Only JPG, JPEG, PNG & GIF are allowed.</p>";
            $uploadOk = 0;
        }

        // Move file nếu tất cả điều kiện đều hợp lệ
        if ($uploadOk && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $image = $filename;
        }
    }

    // Validate and insert user
    if (!empty($name) && !empty($email) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);

            if ($stmt->fetchColumn() > 0) {
                echo "<p style='color:red; text-align:center;'>Email already exists. Please use another one.</p>";
                exit();
            }

            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, images)
                                   VALUES (:name, :email, :password, :role, :images)");
            $stmt->execute([
                'name'     => $name,
                'email'    => $email,
                'password' => $password,
                'role'     => 'student',
                'images'   => $image // chính xác lúc này là tên file ảnh đã upload
            ]);

            echo "<p style='color:green; text-align:center; font-weight:bold;'>Account created successfully! Redirecting to login...</p>";
            echo '<meta http-equiv="refresh" content="2;url=login.html">';
            exit();

        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        echo "<p style='color:red; text-align:center;'>Please fill in all required fields.</p>";
    }
}
?>
