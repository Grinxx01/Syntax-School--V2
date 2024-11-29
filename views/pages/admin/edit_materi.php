<?php
include_once 'config/db.php';

if (!isset($_GET['id'])) {
    echo "ID materi tidak ditemukan.";
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM upload_materi WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Materi tidak ditemukan.";
    exit;
}

$materi = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tipe_input = $_POST['tipe_input'];

    $update_sql = "UPDATE upload_materi SET judul = ?, deskripsi = ?, tipe_input = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssi", $judul, $deskripsi, $tipe_input, $id);

    if ($update_stmt->execute()) {
        header("Location: index.php?page=admin/admin");
        exit();
    } else {
        echo "Gagal mengupdate data.";
    }
}
?>

<div class="container">
    <h1>Edit Materi</h1>
    <form method="POST" class="form">
        <label>Judul:</label>
        <input type="text" name="judul" value="<?php echo htmlspecialchars($materi['judul']); ?>" required>
        <br>
        <label>Deskripsi:</label>
        <textarea name="deskripsi" required><?php echo htmlspecialchars($materi['deskripsi']); ?></textarea>
        <br>
        <label>Tipe Input:</label>
        <input type="text" name="tipe_input" value="<?php echo htmlspecialchars($materi['tipe_input']); ?>" required>
        <br>
        <button type="submit">Simpan</button>
    </form>
</div>
