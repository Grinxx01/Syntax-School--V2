<?php
include 'config/db.php';

if (!isset($_GET['quiz_id']) || empty($_GET['quiz_id'])) {
    die("Error: Parameter 'quiz_id' tidak ditemukan.");
}

$quiz_id = (int)$_GET['quiz_id'];

try {
    $stmt = $conn->prepare("DELETE FROM user_answers WHERE question_id IN (SELECT id FROM questions WHERE quiz_id = ?)");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM options WHERE question_id IN (SELECT id FROM questions WHERE quiz_id = ?)");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM questions WHERE quiz_id = ?");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM quizzes WHERE id = ?");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();

    echo "Quiz berhasil dihapus.";
    header("Location: index.php?page=admin/admin");
} catch (Exception $e) {
    echo "Gagal menghapus quiz: " . $e->getMessage();
}
?>
