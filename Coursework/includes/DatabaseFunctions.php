<?php
require_once 'DatabaseConnection.php';

function getAllQuestions(PDO $pdo) {
    $stmt = $pdo->query("
        SELECT q.id, q.text, q.date, q.img, q.user_id, q.module_id,
            u.name AS username, u.images AS user_img,
            m.name AS module_name
        FROM questions q
        JOIN users u ON q.user_id = u.id
        JOIN modules m ON q.module_id = m.id
        ORDER BY q.date DESC
    ");
    return $stmt->fetchAll();
}

function getQuestionsByModule(PDO $pdo, $moduleId) {
    $stmt = $pdo->prepare("
        SELECT q.id, q.text, q.date, q.img, q.user_id, q.module_id,
            u.name AS username, u.images AS user_img,
            m.name AS module_name
        FROM questions q
        JOIN users u ON q.user_id = u.id
        JOIN modules m ON q.module_id = m.id
        WHERE q.module_id = ?
        ORDER BY q.date DESC
    ");
    $stmt->execute([$moduleId]);
    return $stmt->fetchAll();
}

function getUserQuestions(PDO $pdo, int $userId): array {
    $stmt = $pdo->prepare("
        SELECT q.id, q.text, q.date, q.img, m.name AS module_name
        FROM questions q
        JOIN modules m ON q.module_id = m.id
        WHERE q.user_id = :user_id
        ORDER BY q.date DESC
    ");
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll();
}

function getAllModules(PDO $pdo): array {
    $stmt = $pdo->query("SELECT id, name FROM modules ORDER BY name ASC");
    return $stmt->fetchAll();
}

function postNewQuestion(PDO $pdo, string $text, ?string $img, int $userId, int $moduleId): bool {
    $stmt = $pdo->prepare("
        INSERT INTO questions (text, date, img, user_id, module_id)
        VALUES (:text, NOW(), :img, :user_id, :module_id)
    ");
    return $stmt->execute([
        'text' => $text,
        'img' => $img,
        'user_id' => $userId,
        'module_id' => $moduleId
    ]);
}
function getAdminId($pdo) {
    return $pdo->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1")->fetchColumn();
}
function getReceiverId($pdo, $role, $admin_id, $user_id) {
    if ($role === 'admin') {
        $receiver_id = $_GET['user_id'] ?? null;
        if (!$receiver_id) {
            $receiver = $pdo->query("SELECT id FROM users WHERE role != 'admin' LIMIT 1")->fetch();
            return $receiver['id'] ?? null;
        }
        return $receiver_id;
    } else {
        return $admin_id;
    }
}
function getAllUsersExceptAdmin($pdo) {
    return $pdo->query("SELECT id, name FROM users WHERE role != 'admin'")->fetchAll();
}
function getMessages($pdo, $user_id, $receiver_id) {
    $stmt = $pdo->prepare("
        SELECT m.*, u.name 
        FROM messages m 
        JOIN users u ON m.sender_id = u.id 
        WHERE 
            (sender_id = :user AND receiver_id = :receiver) OR 
            (sender_id = :receiver AND receiver_id = :user)
        ORDER BY sent_at ASC
    ");
    $stmt->execute(['user' => $user_id, 'receiver' => $receiver_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function addModule($pdo, $name) {
    $stmt = $pdo->prepare("INSERT INTO modules (name) VALUES (?)");
    return $stmt->execute([$name]);
}
function deleteModuleById(PDO $pdo, int $id): bool {
    $stmt = $pdo->prepare("DELETE FROM modules WHERE id = ?");
    return $stmt->execute([$id]);
}
function getModuleById(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT * FROM modules WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function updateModule(PDO $pdo, int $id, string $name): void {
    $stmt = $pdo->prepare("UPDATE modules SET name = ? WHERE id = ?");
    $stmt->execute([$name, $id]);
}
function createUser($name, $email, $password, $role, $imageName = null)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, images) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$name, $email, $password, $role, $imageName]);
}

function getUserById($id, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUser($id, $username, $email, $role, $avatar, $pdo) {
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, role = ?, images = ? WHERE id = ?");
    return $stmt->execute([$username, $email, $role, $avatar, $id]);
}
function getAllUsers(PDO $pdo): array {
    $stmt = $pdo->query("SELECT id, name AS username, email, images AS avatar, role FROM users");
    return $stmt->fetchAll();
}
function getQuestionById(PDO $pdo, int $id, int $user_id): ?array {
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    return $stmt->fetch();
}

function updateQuestion(PDO $pdo, int $id, int $user_id, string $text, ?string $img, int $module_id): void {
    $stmt = $pdo->prepare("UPDATE questions SET text = ?, img = ?, module_id = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$text, $img, $module_id, $id, $user_id]);
}

function handleImageUpload(?string $existingImage): ?string {
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === 0) {
        $targetDir = __DIR__ . '/../template/images/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $filename = uniqid() . '_' . basename($_FILES['fileToUpload']['name']);
        $targetFile = $targetDir . $filename;

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
                return $filename;
            }
        }
    }

    return $existingImage;
}

function getQuestionByIdAndUser($pdo, $id, $user_id) {
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE id = :id AND user_id = :user_id");
    $stmt->execute([
        'id' => $id,
        'user_id' => $user_id
    ]);
    return $stmt->fetch();
}

function deleteQuestionById($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM questions WHERE id = :id");
    return $stmt->execute(['id' => $id]);
}
function deleteUserById(PDO $pdo, int $id): void {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
?>
