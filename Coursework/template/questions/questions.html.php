<?php include 'get_module.php'; ?>
<head>
  <link rel="stylesheet" href="questions.css">
</head>

<div class="ask-container">
  <div class="title">📢 Post a New Question</div> <br>

  <form class="ask-form" action="questions/questions.php" method="post" enctype="multipart/form-data">
    <label for="text">Question:</label>
    <textarea name="text" rows="3" placeholder="What are you thinking..." required></textarea>

    <label for="module_id">Module:</label>
    <select name="module_id" required>
      <option value="">-- Choose a module --</option>
      <?php foreach ($modules as $module): ?>
        <option value="<?= htmlspecialchars($module['id']) ?>">
          <?= htmlspecialchars($module['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label for="fileToUpload">Attach Image (optional):</label>
    <input type="file" name="fileToUpload" accept="image/*">

    <button type="submit" name="submit">📤 Post</button>
  </form>
</div>
