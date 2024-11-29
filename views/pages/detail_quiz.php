<?php
include 'config/db.php';

$quiz_id = $_GET['quiz_id'];
$user_id = 1;

$stmt = $conn->prepare("SELECT COUNT(*) AS completed FROM user_answers WHERE quiz_id = ? AND user_id = ?");
$stmt->bind_param("ii", $quiz_id, $user_id);
$stmt->execute();
$completed = $stmt->get_result()->fetch_assoc()['completed'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answers = $_POST['answers'];

    $stmt = $conn->prepare("DELETE FROM user_answers WHERE quiz_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $quiz_id, $user_id);
    $stmt->execute();

    foreach ($answers as $question_id => $selected_option) {
        if (empty($selected_option)) {
            continue;
        }

        $stmt = $conn->prepare("SELECT option_index FROM options WHERE question_id = ? AND option_text = ?");
        $stmt->bind_param("is", $question_id, $selected_option);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $option_index = $result->fetch_assoc()['option_index'];
        } else {
            continue;
        }

        $stmt = $conn->prepare("SELECT correct_answer FROM questions WHERE id = ?");
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $correct_answer = $stmt->get_result()->fetch_assoc()['correct_answer'];

        $is_correct = ($option_index === $correct_answer) ? 1 : 0;

        $stmt = $conn->prepare("INSERT INTO user_answers (user_id, quiz_id, question_id, answer, is_correct) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisi", $user_id, $quiz_id, $question_id, $option_index, $is_correct);
        $stmt->execute();
    }

    header("Location: index.php?page=hasil_quiz&quiz_id=$quiz_id");
    exit();
}

if ($completed > 0) {
    header("Location: index.php?page=hasil_quiz&quiz_id=$quiz_id");
    exit();
} else {
    $stmt = $conn->prepare("SELECT * FROM questions WHERE quiz_id = ?");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $questions = $stmt->get_result();
    ?>
    
    <form method="POST">
        <?php while ($question = $questions->fetch_assoc()): ?>
            <div>
                <p><?php echo htmlspecialchars($question['question']); ?></p>
                <?php
                $stmt = $conn->prepare("SELECT * FROM options WHERE question_id = ?");
                $stmt->bind_param("i", $question['id']);
                $stmt->execute();
                $options = $stmt->get_result();
                ?>
                <?php while ($option = $options->fetch_assoc()): ?>
                    <label>
                        <input type="radio" name="answers[<?php echo $question['id']; ?>]" value="<?php echo htmlspecialchars($option['option_text']); ?>" required>
                        <?php echo htmlspecialchars($option['option_text']); ?>
                    </label><br>
                <?php endwhile; ?>
            </div>
        <?php endwhile; ?>
        <button type="submit">Selesai</button>
    </form>

    <script src="resources/js/script.js"></script>
    
    <?php
}
?>
