<?php
include 'config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login");
    exit();
}

$sql = "SELECT id, judul, deskripsi, tipe_input, created_at FROM upload_materi ORDER BY created_at DESC";
$result = $conn->query($sql);

$sqlQuiz = "
    SELECT q.id, m.judul AS materi, COUNT(qq.id) AS jumlah_pertanyaan, q.created_at 
    FROM quizzes q 
    JOIN upload_materi m ON q.materi_id = m.id 
    LEFT JOIN questions qq ON q.id = qq.quiz_id 
    GROUP BY q.id 
    ORDER BY q.created_at DESC";
$resultQuiz = $conn->query($sqlQuiz);

?>

<div class="admin-container">
    <h1>Admin Dashboard</h1>
    <p>Selamat datang, admin!</p>
</div>
<div class="table-wrapper">
    <h2>Daftar Materi</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Tipe Input</th>
                <th>Dibuat Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['judul']); ?></td>
                        <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                        <td><?php echo htmlspecialchars($row['tipe_input']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        <td>
                            <a href="index.php?page=admin/edit_materi&id=<?php echo $row['id']; ?>">Edit</a> | 
                            <a href="index.php?page=admin/hapus_materi&id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus materi ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Belum ada materi yang diunggah.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="table-wrapper">
    <h2>Daftar Quiz</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Materi</th>
                <th>Jumlah Pertanyaan</th>
                <th>Dibuat Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultQuiz->num_rows > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = $resultQuiz->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['materi']); ?></td>
                        <td><?php echo htmlspecialchars($row['jumlah_pertanyaan']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        <td> 
                            <a href="index.php?page=admin/delete_quiz&quiz_id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus quiz ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Belum ada quiz yang dibuat.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="resources/js/script.js"></script>