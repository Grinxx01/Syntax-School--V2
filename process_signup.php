<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name'], $_POST['email'], $_POST['password'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (empty($name) || empty($email) || empty($password)) {
            echo "Semua field harus diisi!";
        } else {
            $conn = new mysqli("localhost", "root", "", "syntax_school"); // Sesuaikan dengan database Anda

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password); // Pastikan tipe datanya sesuai

            if ($stmt->execute()) {
                header("Location: index.php?page=login");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        echo "Data tidak lengkap!";
    }
}
?>
