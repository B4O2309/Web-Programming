<?php include 'community.php'; ?>
<head>
    <link rel="stylesheet" href="community/community.css">
</head>
<body>
<div class="feeds-container">
<?php foreach ($questions as $question): ?>
    <div class="post">
        <div class="post_header">
            <div class="header_left">
                <div class="author-info">
                <img class="post_author-pic" src="images/<?= htmlspecialchars($question['user_img']) ?>" alt="Avatar">
                <div class="author-details">
                    <div class="post_author"><?= htmlspecialchars($question['username']) ?></div>
                    <div class="post_date"><?= date('d M Y H:i', strtotime($question['date'])) ?></div>
                    <div class="post_module">📘 <?= htmlspecialchars($question['module_name']) ?></div>
                </div>
                </div>
            </div>

            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $question['user_id']): ?>
            <div class="edit-btn-container">
                <a href="edit_question.html.php?id=<?= $question['id'] ?>" class="edit-btn">✏️ Edit</a>
                <form method="post" action="../delete_question.php" onsubmit="return confirm('Are you sure you want to delete this post?');" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $question['id'] ?>">
                    <button type="submit" class="delete-btn">🗑️ Delete</button>
                </form>
            </div>
            <?php endif; ?>
        </div>

        <div class="content_paragraph">
            <?= nl2br(htmlspecialchars($question['text'])) ?>
        </div>

        <?php if (!empty($question['img'])): ?>
            <img class="content_image" src="images/<?= htmlspecialchars($question['img']) ?>" alt="Post Image">
        <?php endif; ?>
    </div>
<?php endforeach; ?>
</div>
</body>

