<?php
include 'config/db.php';

// Ambil daftar quiz
$sqlQuiz = "SELECT q.id, m.judul AS materi, q.created_at FROM quizzes q JOIN upload_materi m ON q.materi_id = m.id ORDER BY q.created_at DESC";
$resultQuiz = $conn->query($sqlQuiz);
?>

<h1>Daftar Quiz</h1>

<div class="quiz-cards-container">
    <?php if ($resultQuiz->num_rows > 0): ?>
        <?php while ($row = $resultQuiz->fetch_assoc()): ?>
            <div class="quiz-card">
                <a href="index.php?page=detail_quiz&quiz_id=<?php echo $row['id']; ?>">
                    <h3><?php echo htmlspecialchars($row['materi']); ?></h3>
                </a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Tidak ada quiz yang tersedia.</p>
    <?php endif; ?>
</div>
<script src="resources/js/script.js"></script>
