<?php
include_once 'config/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tipe_input = $_POST['tipe_input'];
    $contoh_code = isset($_POST['contoh_code']) ? $_POST['contoh_code'] : null;
    $file_path = null;

    if ($tipe_input === 'file' && isset($_FILES['file'])) {
        $target_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES["file"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $file_path = $target_file;
        } else {
            echo "File gagal diupload.";
            exit;
        }
    }

    $sql = "INSERT INTO upload_materi (judul, deskripsi, tipe_input, contoh_code, file_path) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $judul, $deskripsi, $tipe_input, $contoh_code, $file_path);

    if ($stmt->execute()) {
        header("Location: index.php?page=admin/admin");
    } else {
        echo "Gagal menyimpan materi.";
    }

    $stmt->close();
    $conn->close();
}
?>
