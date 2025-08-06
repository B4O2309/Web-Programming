<?php include 'modules.php'; ?>

<head>
  <link rel="stylesheet" href="modules/modules.css?v=<?= time() ?>">
  <link rel="stylesheet" href="../community/community.css?v=<?= time() ?>">
</head>

<body>
<div class="right-panel">
    <div class="modules-container">
        <h1>🔍 Filter Questions by Module</h1>
        <form method="get" action="modules/modules.html.php">
          <select name="module_id" required>
            <option value="">-- Choose a module --</option>
            <?php foreach ($modules as $module): ?>
              <option value="<?= $module['id'] ?>" <?= ($module_id == $module['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($module['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <button class="filter_button" type="submit">Filter</button>
        </form>
    </div>

    <?php if ($module_id): ?>
      <a href="../home.html.php" class="back-button"><</a>
      <div class="community-questions">
        <h3>📝 Questions for this Module</h3>
        <?php if (count($questions)): ?>
          <?php foreach ($questions as $q): ?>
            <div class="question">
              <div class="question-header">
                <img src="../images/<?= htmlspecialchars($q['user_img']) ?>" class="avatar" alt="User Avatar">
                <span class="username"><?= htmlspecialchars($q['username']) ?></span>
                <span class="date"><?= htmlspecialchars($q['date']) ?></span>
              </div>
              <p class="question-text"><?= nl2br(htmlspecialchars($q['text'])) ?></p>
              <?php if ($q['img']): ?>
                <img src="../images/<?= htmlspecialchars($q['img']) ?>" class="question-img" alt="Attached Image">
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No questions found for this module.</p>
        <?php endif; ?>
      </div>
    <?php endif; ?>
</div>
</body>
