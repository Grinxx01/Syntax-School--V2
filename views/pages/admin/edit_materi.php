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
    $tipe_inputs = $_POST['tipe_input'];
    $isi_materi = $_POST['isi_materi'];
    $contoh_code = $_POST['contoh_code'];
    $file_paths = $_FILES['file_materi'];

    $update_sql = "UPDATE upload_materi SET judul = ?, deskripsi = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $judul, $deskripsi, $id);

    if ($update_stmt->execute()) {
        foreach ($tipe_inputs as $index => $tipe_input) {
            if ($tipe_input === 'text') {
                $update_materi_sql = "UPDATE upload_materi SET isi_materi = ? WHERE id = ?";
                $update_materi_stmt = $conn->prepare($update_materi_sql);
                $update_materi_stmt->bind_param("si", $isi_materi[$index], $id);
                $update_materi_stmt->execute();
            } elseif ($tipe_input === 'code') {
                $update_code_sql = "UPDATE upload_materi SET contoh_code = ? WHERE id = ?";
                $update_code_stmt = $conn->prepare($update_code_sql);
                $update_code_stmt->bind_param("si", $contoh_code[$index], $id);
                $update_code_stmt->execute();
            } elseif ($tipe_input === 'file') {
                if (!empty($file_paths['name'][$index])) {
                    $target_dir = "uploads/";
                    $target_file = $target_dir . basename($file_paths['name'][$index]);
                    move_uploaded_file($file_paths['tmp_name'][$index], $target_file);
                    $update_file_sql = "UPDATE upload_materi SET file_path = ? WHERE id = ?";
                    $update_file_stmt = $conn->prepare($update_file_sql);
                    $update_file_stmt->bind_param("si", $target_file, $id);
                    $update_file_stmt->execute();
                }
            }
        }

        header("Location: index.php?page=admin/admin");
        exit();
    } else {
        echo "Gagal mengupdate data.";
    }
}
?>

<div class="admin-container">
    <h1>Edit Materi</h1>
    <form method="POST" class="form" enctype="multipart/form-data">
        <label>Judul:</label>
        <input type="text" name="judul" value="<?php echo htmlspecialchars($materi['judul']); ?>" required>
        <br>
        <label>Deskripsi:</label>
        <textarea name="deskripsi" required><?php echo htmlspecialchars($materi['deskripsi']); ?></textarea>
        <br>

        <div id="dynamic-inputs">
            <?php
            if (!empty($materi['isi_materi'])) {
                $tipe_inputs = explode(',', $materi['tipe_input']);
                $isi_materis = explode(',', $materi['isi_materi']);
                $contoh_codes = explode(',', $materi['contoh_code']);
                $file_paths = explode(',', $materi['file_path']);

                foreach ($tipe_inputs as $index => $tipe_input) {
                    echo '<div class="input-group">';
                    echo '<label>Tipe Input:</label>';
                    echo '<select name="tipe_input[]" class="tipe-input" required>';
                    echo '<option value="text"' . ($tipe_input === 'text' ? ' selected' : '') . '>Text</option>';
                    echo '<option value="code"' . ($tipe_input === 'code' ? ' selected' : '') . '>Code</option>';
                    echo '<option value="file"' . ($tipe_input === 'file' ? ' selected' : '') . '>File</option>';
                    echo '</select>';
                    echo '<br>';

                    echo '<div class="text-input"' . ($tipe_input === 'text' ? '' : ' style="display:none;"') . '>';
                    echo '<label>Isi Materi:</label>';
                    echo '<textarea name="isi_materi[]" required>' . htmlspecialchars($isi_materis[$index]) . '</textarea>';
                    echo '<br></div>';

                    echo '<div class="code-input"' . ($tipe_input === 'code' ? '' : ' style="display:none;"') . '>';
                    echo '<label>Contoh Code:</label>';
                    echo '<textarea name="contoh_code[]">' . htmlspecialchars($contoh_codes[$index]) . '</textarea>';
                    echo '<br></div>';

                    echo '<div class="file-input"' . ($tipe_input === 'file' ? '' : ' style="display:none;"') . '>';
                    echo '<label>File Materi:</label>';
                    echo '<input type="file" name="file_materi[]" accept=".pdf,.doc,.docx,.ppt,.pptx">';
                    echo '<br></div>';

                    echo '<button type="button" onclick="removeInput(this)">Hapus Input</button>';
                    echo '</div>'; // Tutup input-group
                }
            }
            ?>
        </div>
        <button type="button" onclick="addInput()">Tambah Input</button>
        <button type="submit" class="btn">Simpan</button>
    </form>
</div>

<script src="resources/js/script.js"></script>