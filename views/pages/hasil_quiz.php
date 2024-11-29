<?php
include 'config/db.php';

$quiz_id = $_GET['quiz_id'];
$user_id = 1;

$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM questions WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];

$stmt = $conn->prepare("
    SELECT COUNT(*) AS correct_answers 
    FROM user_answers 
    WHERE quiz_id = ? AND user_id = ? AND is_correct = 1
");
$stmt->bind_param("ii", $quiz_id, $user_id);
$stmt->execute();
$correct = $stmt->get_result()->fetch_assoc()['correct_answers'];

$stmt = $conn->prepare("
    SELECT q.id AS question_id, q.question, ua.answer AS user_answer, q.correct_answer 
    FROM questions q
    LEFT JOIN user_answers ua ON q.id = ua.question_id AND ua.user_id = ? 
    WHERE q.quiz_id = ?
");
$stmt->bind_param("ii", $user_id, $quiz_id);
$stmt->execute();
$answers = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['retry'])) {
    $stmt = $conn->prepare("DELETE FROM user_answers WHERE quiz_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $quiz_id, $user_id);
    $stmt->execute();

    header("Location: index.php?page=detail_quiz&quiz_id=$quiz_id");
    exit();
}
?>

<h1>Hasil Quiz</h1>
<p>Hasil Quiz: <?php echo $correct; ?> benar dari <?php echo $total; ?> soal.</p>

<form method="POST">
    <button type="submit" name="retry">Ulangi Quiz</button>
</form>

<a href="index.php">Kembali ke Beranda</a>

<script src="resources/js/script.js"></script>
