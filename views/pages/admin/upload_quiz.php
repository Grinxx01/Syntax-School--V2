<?php
include 'config/db.php';

$sqlMateri = "SELECT id, judul FROM upload_materi ORDER BY created_at DESC";
$resultMateri = $conn->query($sqlMateri);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $materi_id = $_POST['materi_id'];
    $questions = $_POST['questions'];
    $options = $_POST['options'];
    $correct_answers = $_POST['correct_answers'];

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO quizzes (materi_id) VALUES (?)");
        $stmt->bind_param("i", $materi_id);
        $stmt->execute();
        $quiz_id = $stmt->insert_id;

        foreach ($questions as $index => $question) {
            $stmt = $conn->prepare("INSERT INTO questions (quiz_id, question, correct_answer) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $quiz_id, $question, $correct_answers[$index]);
            $stmt->execute();
            $question_id = $stmt->insert_id;

            $option_index = ['A', 'B', 'C', 'D'];
            foreach ($options[$index] as $key => $option) {
                $stmt = $conn->prepare("INSERT INTO options (question_id, option_text, option_index) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $question_id, $option, $option_index[$key]);
                $stmt->execute();
            }
        }

        $conn->commit();
        echo "Quiz berhasil ditambahkan!";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Gagal menambahkan quiz: " . $e->getMessage();
    }
}
?>
<div class="admin-container">
<h1>Upload Quiz</h1>
<form method="POST" class="form">
    <label for="materi_id">Pilih Materi:</label>
    <select name="materi_id" id="materi_id" required>
        <option value="" disabled selected>-- Pilih Materi --</option>
        <?php while ($row = $resultMateri->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['judul']); ?></option>
        <?php endwhile; ?>
    </select>
    <br>

    <div id="question-list">
        <div class="question-wrapper" id="question-1">
            <label for="question-1">Pertanyaan 1:</label>
            <input type="text" name="questions[]" id="question-1" required>
            <div class="options">
                <label for="option-a-1">Opsi A:</label>
                <input type="text" name="options[0][]" id="option-a-1" required>
                <label for="option-b-1">Opsi B:</label>
                <input type="text" name="options[0][]" id="option-b-1" required>
                <label for="option-c-1">Opsi C:</label>
                <input type="text" name="options[0][]" id="option-c-1" required>
                <label for="option-d-1">Opsi D:</label>
                <input type="text" name="options[0][]" id="option-d-1" required>
            </div>

            <div class="correct-answer">
            <label for="answer-1">Jawaban Benar:</label>
            <select name="correct_answers[]" id="answer-1" required>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
            </div>
        </div>
    </div>

    <button type="button" onclick="addQuestion()" class="add-btn">Tambah Pertanyaan</button><br>
    <button type="submit" class="btn">Simpan Quiz</button>
</form>
<script src="resources/js/script.js"></script>

</div>