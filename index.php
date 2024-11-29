<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
    <title>SyntaxSchool</title>
    <link rel="stylesheet" href="resources/css/styles.css">
</head>
<body>
    <?php if (!in_array($page, ['login', 'signup'])): ?>
        <?php include "views/components/header.php"; ?>
    <?php endif; ?>
    <main class="main">
        <?php
            if (strpos($page, 'admin/') === 0) {
                $filePath = "views/pages/admin/" . str_replace('admin/', '', $page) . ".php";
            } else {
                $filePath = "views/pages/$page.php";
            }
            if (file_exists($filePath)) {
                include $filePath;
            } else {
                include "views/pages/404.php";
            }
        ?>
    </main>
    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'): ?>
        <?php if ($page !== 'login' && $page !== 'signup'): ?>
            <?php include "views/components/footer.php"; ?>
        <?php endif; ?>
    <?php endif; ?>
    <script src="resources/js/script.js"></script>
</body>
</html>