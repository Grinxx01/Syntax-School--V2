<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'config/db.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Email atau password salah.";
    }
}
?>

<div class="container">
    <form action="process_login.php" method="POST" class="form">
        <h1>Login</h1>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit" class="btn">Login</button>
        <p>Belum punya akun? <a href="index.php?page=signup">Daftar</a></p>
    </form>
</div>
