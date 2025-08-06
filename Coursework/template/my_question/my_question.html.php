<?php include 'my_questions.php'; ?>
<head>
  <link rel="stylesheet" href="community/community.css">
</head>

<div class="feeds-container">
  <?php if (empty($questions)): ?>
    <p style="text-align:center; font-size: 1.4rem; color: #777;">😶 You haven't posted any questions yet.</p>
  <?php else: ?>
    <?php foreach ($questions as $q): ?>
      <div class="post">
        <div class="post_header">
          <div class="author-info">
           <img class="post_author-pic" src="images/<?php echo htmlspecialchars($_SESSION['image']); ?>" alt="Avatar">
            <div class="author-details">
              <span class="post_author">You</span>
              <span class="post_date"><?= htmlspecialchars($q['date']) ?></span>
              <span class="post_module"><?= htmlspecialchars($q['module_name']) ?></span>
            </div>
          </div>
          <div class="edit-btn-container">
            <a href="edit_question.html.php?id=<?= $q['id'] ?>" class="edit-btn">✏️ Edit</a>
            <form method="post" action="delete_question.php" onsubmit="return confirm('Are you sure you want to delete this post?');" style="display:inline;">
                <input type="hidden" name="id" value="<?= $q['id'] ?>">
                <button type="submit" class="delete-btn">🗑️ Delete</button>
            </form>
          </div>    
        </div>

        <div class="content_paragraph"><?= nl2br(htmlspecialchars($q['text'])) ?></div>

        <?php if (!empty($q['img'])): ?>
          <img class="content_image" src="images/<?= htmlspecialchars($q['img']) ?>" alt="Attached image">
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
