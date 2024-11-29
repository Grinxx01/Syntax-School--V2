<?php
include_once 'config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM upload_materi WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $materi = $result->fetch_assoc();
    } else {
        echo "Materi tidak ditemukan.";
        exit;
    }
} else {
    echo "ID materi tidak ditemukan.";
    exit;
}

?>

<main class="main">
    <div class="materi-detail-container">
        <h1>Materi: <?php echo htmlspecialchars($materi['judul']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($materi['deskripsi'])); ?></p>

        <?php if ($materi['tipe_input'] === 'code' && !empty($materi['contoh_code'])): ?>
            <div class="code-example">
                <h4>Contoh Kode:</h4>
                <pre><code><?php echo htmlspecialchars($materi['contoh_code']); ?></code></pre>
            </div>
        <?php endif; ?>

        <?php if ($materi['tipe_input'] === 'file' && !empty($materi['file_path'])): ?>
            <div class="file-download">
                <h4>Download Materi:</h4>
                <a href="<?php echo $materi['file_path']; ?>" download>Download File</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php $conn->close(); ?>
<script src="resources/js/script.js"></script>
