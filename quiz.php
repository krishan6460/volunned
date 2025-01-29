<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

// Assuming you have already fetched user and test details from the database
$test_name = "General Knowledge Quiz"; // Example test name, replace as needed

// Your quiz code follows here
include 'fetch_questions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="style.css">
    <script src="timer.js"></script> <!-- Link to the timer JavaScript file -->
    <style>
        /* Base Styling */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #f3e7e9 0%, #e3eeff 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full height */
            margin: 0;
            padding: 0;
        }
        .quiz-container {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 1000px; /* Maximum width */
            height: 95vh; /* Full screen minus some padding */
            padding: 30px;
            text-align: center;
            overflow-y: auto;
            animation: fadeIn 1s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        /* Header Section Styling */
        .header {
            background: linear-gradient(90deg, #007acc 0%, #00bfff 100%);
            color: #ffffff;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .header .title {
            font-size: 2.5em;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .header .info {
            font-size: 1.2em;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }
        .header .info p {
            margin: 0;
            color: #e6f7ff;
        }
        .header .timer {
            font-size: 1.2em;
            font-weight: bold;
            color: #ffdddd;
            background: #003366;
            border-radius: 8px;
            padding: 10px 20px;
            display: inline-block;
        }

        /* Question Styling */
        .question {
            background: #f5f5f5;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        .question p {
            font-size: 1.1em;
            font-weight: 600;
            color: #444;
            margin-bottom: 10px;
        }
        
        /* Option Styling */
        label {
            display: block;
            font-size: 1em;
            color: #333;
            margin: 8px 0;
            padding: 10px 15px;
            border-radius: 8px;
            background: #ffffff;
            cursor: pointer;
            transition: background 0.3s, box-shadow 0.3s;
        }
        label:hover {
            background: #fafafa;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
        input[type="radio"] {
            margin-right: 10px;
        }

        /* Submit Button Styling */
        button {
            width: 100%;
            padding: 15px;
            font-size: 1.2em;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 20px;
        }
        button:hover {
            background-color: #45a049;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .quiz-container {
                padding: 15px;
            }
            .header .title {
                font-size: 2em;
            }
            .header .info p {
                font-size: 1em;
            }
            .header .timer {
                font-size: 1em;
            }
            .question p {
                font-size: 1em;
            }
            button {
                font-size: 1.1em;
                padding: 12px;
            }
        }
    </style>
</head>
<body>

<div class="quiz-container">
    <div class="header">
        <p class="title">Gautam Buddha University</p>
        <div class="info">
            <p><strong>Test:</strong> <?php echo $test_name; ?></p>
            <p><strong>Maximum Marks:</strong> 10</p>
            <div class="timer" id="timer">Time Remaining:10:00</div>
        </div>
    </div>

    <h1>Quiz</h1>
    <form id="quiz-form" action="submit_quiz.php" method="POST">
        <?php foreach ($questions as $question_id => $question): ?>
            <div class="question">
                <p><?php echo $question['question_text']; ?></p>
                <?php foreach ($question['options'] as $option): ?>
                    <label>
                        <input type="radio" name="answers[<?php echo $question_id; ?>]" value="<?php echo $option['option_id']; ?>">
                        <?php echo $option['option_text']; ?>
                    </label>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>