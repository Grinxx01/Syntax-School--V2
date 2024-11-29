<?php
include_once 'config/db.php';

if (!isset($_GET['id'])) {
    echo "ID materi tidak ditemukan.";
    exit;
}

$id = $_GET['id'];
$sql = "DELETE FROM upload_materi WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php?page=admin/admin");
    exit();
} else {
    echo "Gagal menghapus data.";
}
?>
