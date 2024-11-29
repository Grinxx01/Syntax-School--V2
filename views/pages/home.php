<?php
// Koneksi ke database
include_once 'config/db.php';

// Query untuk mengambil tiga materi terbaru
$sql = "SELECT id, judul, deskripsi, tipe_input, contoh_code FROM upload_materi ORDER BY created_at DESC LIMIT 3";
$result = $conn->query($sql);
?>

<div class="hero-container">
    <div class="hero">
        <div class="hero-text">
            <h1>
                Ngoding Lebih Cerdas,<br>
                Impian Lebih Besar.
            </h1>
            <p>Learn, Code, Achieve.</p>
            <div class="mulai">
                <h2><a href="#mulai">Mulai Ngoding</a></h2>
            </div>
        </div>
        <div class="hero-img">
            <img src="resources/img/hero.png" alt="hero image">
        </div>
    </div>

    <div class="start-code">
        <div class="start-code-text">
            <h1 id="mulai">Ayo Mulai Ngoding</h1>
            <p>Pilih Bahasa Pemrograman yang ingin Kamu Pelajari.</p>
        </div>
        <div class="materi-cards">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="materi-card">
                    <h3>
                        <a href="index.php?page=materi&id=<?php echo $row['id']; ?>">
                            <?php echo htmlspecialchars($row['judul']); ?>
                        </a>
                    </h3>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Belum ada materi yang diunggah.</p>
        <?php endif; ?>
        </div>
    </div>
</div>
