<?php
include 'config/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: index.php?page=admin/admin");
        } else {
            header("Location: index.php?page=tutorial");
        }
        exit();
    } else {
        echo "Password salah!";
    }
} else {
    echo "Email tidak ditemukan!";
}

// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>
