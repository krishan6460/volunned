<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    echo "<div class='message'>You must be logged in to submit the quiz.</div>";
    exit();
}

// Retrieve user ID from session email
$email = $_SESSION['email'];
$userQuery = "SELECT id FROM users WHERE email='$email'";
$userResult = $conn->query($userQuery);

if ($userResult->num_rows === 0) {
    echo "<div class='message'>User not found.</div>";
    exit();
}

$user = $userResult->fetch_assoc();
$user_id = $user['id'];

// Fetch all 25 questions (make sure to limit this to 25 questions)
$questionQuery = "SELECT * FROM questions LIMIT 10"; 
$questionResult = $conn->query($questionQuery);

// If there are no questions, exit
if ($questionResult->num_rows === 0) {
    echo "<div class='message'>No questions available in the quiz.</div>";
    exit();
}

// Calculate score
$score = 0;
$total_questions = 10; // We are setting the total number of questions to 10

while ($question = $questionResult->fetch_assoc()) {
    $question_id = $question['id'];
    if (isset($_POST['answers'][$question_id])) {
        $selected_option_id = $_POST['answers'][$question_id];
        
        // Check if the selected option is correct
        $optionQuery = "SELECT is_correct FROM options WHERE id = $selected_option_id AND question_id = $question_id";
        $optionResult = $conn->query($optionQuery);

        if ($optionResult->num_rows > 0) {
            $option = $optionResult->fetch_assoc();
            if ($option['is_correct']) {
                $score++;
            }
        }
    }
}

// Insert the result into the results table
$insertResult = "INSERT INTO results (user_id, score, total_questions, quiz_date, email) 
                 VALUES ('$user_id', '$score', '$total_questions', NOW(), '$email')";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f8cdda 0%, #1d2b64 100%);
            color: #333;
        }
        .result-container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        .result-container h1 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #4CAF50;
        }
        .score {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #4CAF50;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .message {
            color: red;
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="result-container">
    <?php if ($conn->query($insertResult) === TRUE) { ?>
        <h1>Quiz Completed!</h1>
        <div class="score">Your Score: <?php echo "$score out of $total_questions"; ?></div>
        <a href="profile.php" class="btn">Go to Profile to View Results</a>
    <?php } else { ?>
        <div class="message">Error saving result: <?php echo $conn->error; ?></div>
    <?php } ?>
</div>

</body>
</html>

<?php
$conn->close();
?>
