<?php
include_once 'config/db.php';

// Pastikan koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM upload_materi ORDER BY created_at DESC";
$result = $conn->query($sql);

// Cek apakah query berhasil dijalankan
if (!$result) {
    die("Query gagal: " . $conn->error);
}

?>
<main class="main">
    <div class="tutorial-container">
        <h2><span>S</span>yntax<span>S</span>chool</h2>
        <h1><span>T</span>utorials</h1>
        <p>
            Dirancang untuk membantu meningkatkan keterampilan<br> pemrograman melalui latihan yang beragam, mulai dari tingkat<br> dasar hingga lanjutan.
        </p>
        <?php if ($result->num_rows > 0): ?>
            <div class="materi-cards">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="materi-card">
                        <a href="index.php?page=materi&id=<?php echo $row['id']; ?>">
                            <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Belum ada materi yang diunggah.</p>
        <?php endif; ?>
    </div>
</main>