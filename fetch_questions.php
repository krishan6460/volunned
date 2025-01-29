<?php
// fetch_questions.php

$servername = "localhost";
$username = "krishabhi_2003";
$password = "Volunned@2024";
$dbname = "krishabhi_2003";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch questions and options
$sql = "SELECT q.id AS question_id, q.question_text, o.id AS option_id, o.option_text 
        FROM questions q 
        JOIN options o ON q.id = o.question_id 
        ORDER BY q.id, o.id";

$result = $conn->query($sql);
$questions = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[$row['question_id']]['question_text'] = $row['question_text'];
        $questions[$row['question_id']]['options'][] = [
            'option_id' => $row['option_id'],
            'option_text' => $row['option_text']
        ];
    }
}
$conn->close();
?>