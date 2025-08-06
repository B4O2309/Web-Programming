<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
  header("Location: ../login.html");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <link rel="stylesheet" href="home.css?v=<?= time() ?>">
</head>
<body>
  <div class="container">
    <div class="left-panel">
      <h2>KIVRA</h2>  
      <?php
      $avatar = !empty($_SESSION['image']) ? htmlspecialchars($_SESSION['image']) : 'default_avatar.jpg';
      ?>

      <img src="images/<?php echo $avatar; ?>" alt="Avatar" class="left-avatar">

      <div class="hi"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
      <div class="email"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
    </div>

    <ul class="sidebar-menu">
      <li class="menu-item active" data-page="home">
        <span class="icon">🏠</span>
        <span class="label">Home</span>
      </li>
      <li class="menu-item" data-page="community">
        <span class="icon">👨‍🎓</span>
        <span class="label">Community</span>
      </li>
      <li class="menu-item" data-page="ask">
        <span class="icon">💡</span>
        <span class="label">Ask Question</span>
      </li>
      <li class="menu-item" data-page="my_question">
        <span class="icon">📝</span>
        <span class="label">My Questions</span>
      </li>
      <li class="menu-item" data-page="modules">
        <span class="icon">📚</span>
        <span class="label">Browse Modules</span>
      </li>
      <li class="menu-item" data-page="message">
          <span class="icon">💬</span>
          <span class="label">Message</span>
        </li>
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <li class="menu-item" data-page="create_module">
          <span class="icon">🗂️</span>
          <span class="label">Manage Module</span>
        </li>
        <li class="menu-item" data-page="manage_user">
          <span class="icon">👤</span>
          <span class="label">Manage User</span>
        </li>
      <?php else: ?>
        <li class="menu-item disabled">
          <span class="icon">🗂️</span>
          <span class="label">Manage Module</span>
        </li>
        <li class="menu-item disabled">
          <span class="icon">👤</span>
          <span class="label">Manage User</span>
        </li>
      <?php endif; ?>
      <li class="menu-item" onclick="window.location.href = '../logout.php'">
        <img class="icon" width="20px" height="20px" src="images/log-out.png" alt="log_out">
        <span class="label">Log Out</span>
      </li>

    </ul>

    <div class="right-panel"></div>
  </div>

<script>
  const menuItems = document.querySelectorAll('.menu-item');
  const rightPanel = document.querySelector('.right-panel');

  window.addEventListener('DOMContentLoaded', () => {
    loadPage('home');
  });

  menuItems.forEach(item => {
    item.addEventListener('click', () => {
      const page = item.getAttribute('data-page');
      if (!page) return;
      menuItems.forEach(i => i.classList.remove('active'));
      item.classList.add('active');
      loadPage(page);
    });
  });

  document.addEventListener('click', function(e) {
    const button = e.target.closest('.card-btn');
    if (button && button.dataset.page) {
      const page = button.dataset.page;
      loadPage(page);
    }
  });

  function loadPage(page) {
    fetch('../page_loader.php?page=' + page)
      .then(res => res.text())
      .then(data => {
        rightPanel.innerHTML = data;
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
          if (item.getAttribute('data-page') === page) {
            item.classList.add('active');
          } else {
            item.classList.remove('active');
          }
        });
      })
      .catch(err => {
        rightPanel.innerHTML = '<p style="color:red;">Failed to load content.</p>';
        console.error(err);
      });
  }
</script>

</body>
</html>
