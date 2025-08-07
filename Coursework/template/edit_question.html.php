<head>
  <link rel="stylesheet" href="edit.css">
</head>

<?php
session_start();
require_once '../includes/DatabaseConnection.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.html');
  exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
  echo "<p>Invalid question ID.</p>";
  exit();
}

$stmtModules = $pdo->query("SELECT id, name FROM modules ORDER BY name ASC");
$modules = $stmtModules->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$question = $stmt->fetch();

if (!$question) {
  echo "<p>Question not found or access denied.</p>";
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $text = $_POST['text'] ?? '';
  $module_id = $_POST['module_id'] ?? $question['module_id'];
  $img = $question['img'];

  if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === 0) {
    $targetDir = 'images/';
    $filename = basename($_FILES['fileToUpload']['name']);
    $targetFile = $targetDir . $filename;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($imageFileType, $allowedTypes)) {
      if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
        $img = $filename;
      } else {
        echo "<p style='color:red;'>Failed to upload image.</p>";
      }
    } else {
      echo "<p style='color:red;'>Only JPG, PNG, GIF images are allowed.</p>";
    }
  }

  $update = $pdo->prepare("UPDATE questions SET text = ?, img = ?, module_id = ? WHERE id = ? AND user_id = ?");
  $update->execute([$text, $img, $module_id, $id, $_SESSION['user_id']]);

  header('Location: home.html.php');
  exit();
}
?>

<div class="edit-box">
  <h2>Edit Your Question</h2>
  <form method="post" enctype="multipart/form-data">
    <label for="text">Content:</label>
    <textarea name="text" rows="4"><?= htmlspecialchars($question['text']) ?></textarea>

    <label>Module:</label>
    <input type="hidden" name="module_id" id="module_id" value="<?= $question['module_id'] ?>">

    <div class="menu">
      <div class="item">
        <a href="#" class="link">
          <span id="module-label">
            <?php
              foreach ($modules as $m) {
                if ($m['id'] == $question['module_id']) {
                  echo htmlspecialchars($m['name']);
                  break;
                }
              }
            ?>
          </span>
          <svg viewBox="0 0 360 360" xml:space="preserve">
            <g>
              <path d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393 
              c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150
              c2.813,2.813,6.628,4.393,10.606,4.393s7.794-1.581,10.606-4.394l149.996-150
              C331.465,94.749,331.465,85.251,325.607,79.393z"></path>
            </g>
          </svg>
        </a>
        <div class="submenu">
          <?php foreach ($modules as $m): ?>
            <div class="submenu-item">
              <a href="#" class="submenu-link" onclick="event.preventDefault(); setModule('<?= $m['id'] ?>', '<?= htmlspecialchars($m['name']) ?>')">
                <?= htmlspecialchars($m['name']) ?>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <br><br>

    <label for="img">Current Image:</label><br>
    <img class="img" src="images/<?= htmlspecialchars($question['img']) ?>" alt="Post Image" style="max-width: 200px;"><br>

    <label for="fileToUpload">Change Image (optional):</label>
    <input type="file" name="fileToUpload" accept="image/*"><br><br>

    <button type="submit">Update</button>
  </form>
</div>

<script>
function setModule(id, name) {
  document.getElementById('module_id').value = id;
  document.getElementById('module-label').textContent = name;
}
</script>
