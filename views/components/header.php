<?php
session_start();

$is_admin_logged_in = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<header class="header">
    <div class="head-container">
        <div class="logo">
            <a href="index.php?page=home">
                <h1><span>S</span>yntax<span>S</span>chool</h1>
            </a>
        </div>
        <?php if ($is_admin_logged_in): ?>
            <nav class="nav-bar">
                <ul>
                    <li><a href="?page=admin/admin">Dashboard</a></li>
                    <li><a href="?page=admin/upload_materi">Upload Materi</a></li>
                    <li><a href="?page=admin/upload_quiz">Upload Quiz</a></li>
                </ul>
            </nav>
        <?php else: ?>
            <nav class="nav-bar">
                <ul>
                    <li><a href="?page=home">Home</a></li>
                    <li><a href="?page=tutorial">Tutorials</a></li>
                    <li><a href="?page=quiz">Quiz</a></li>
                </ul>
            </nav>
        <?php endif; ?>
        <div class="login-method">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="profile">
                    <button class="dropdown-btn">
                        <?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?>
                    </button>
                    <div class="dropdown-content">
                        <a href="index.php?page=profile">Profile</a>
                        <a href="index.php?page=logout">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="login">
                    <p><a href="index.php?page=login">Masuk</a></p>
                </div>
                <div class="sign-up">
                    <p><a href="index.php?page=signup">Daftar</a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
<script src="resources/js/script.js"></script>
