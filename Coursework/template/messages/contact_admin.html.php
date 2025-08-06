<?php require_once 'contact_admin.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Admin</title>
    <link rel="stylesheet" href="chat.css?v=<?= time() ?>">
</head>
<body>
<div class="chat-container">
    <div style="margin-bottom: 10px;">
        <a href="../home.html.php" class="back">← Back to Home</a>
    </div>
    <h1><?= $role === 'admin' ? 'Messages with Student' : 'Messages with Admin' ?></h1>

    <?php if ($role === 'admin'): ?>
        <form method="get" style="margin-bottom: 15px;">
            <label for="user_id">Select User:</label>
            <select name="user_id" onchange="this.form.submit()">
                <option value="">-- Select a user --</option>
                <?php foreach ($users as $u): 
                    $selected = ($u['id'] == $receiver_id) ? 'selected' : '';
                    ?>
                    <option value="<?= $u['id'] ?>" <?= $selected ?>>
                        <?= htmlspecialchars($u['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    <?php endif; ?>

    <div class="messages">
        <?php foreach ($messages as $msg): ?>
            <div class="message <?= $msg['sender_id'] == $user_id ? 'sent' : 'received' ?>">
                <strong><?= htmlspecialchars($msg['name']) ?>:</strong><br>
                <p><?= nl2br(htmlspecialchars($msg['text'])) ?></p>
                <small><?= $msg['sent_at'] ?></small>
            </div>
        <?php endforeach; ?>
    </div>

    <form method="POST" action="send_message.php">
        <input type="hidden" name="receiver_id" value="<?= htmlspecialchars($receiver_id) ?>">
        <textarea name="text" required placeholder="Type a message..."></textarea>
        <button type="submit">Send</button>
    </form>
</div>
</body>
</html>
