<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    echo "Please log in to view your results.";
    exit();
}

// Get user ID
$email = $_SESSION['email'];
$userQuery = "SELECT id FROM users WHERE email='$email'";
$userResult = $conn->query($userQuery);

if ($userResult->num_rows === 0) {
    echo "User not found.";
    exit();
}

$user = $userResult->fetch_assoc();
$user_id = $user['id'];

// Fetch quiz results
$resultQuery = "SELECT score, total_questions, quiz_date FROM results WHERE user_id='$user_id' ORDER BY quiz_date DESC";
$resultResult = $conn->query($resultQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome to Your Profile</h1>

    <h2>Your Quiz Results:</h2>
    <?php if ($resultResult->num_rows > 0): ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Score</th>
                <th>Total Questions</th>
            </tr>
            <?php while ($row = $resultResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['quiz_date']; ?></td>
                    <td><?php echo $row['score']; ?></td>
                    <td><?php echo $row['total_questions']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No quiz results found.</p>
    <?php endif; ?>

</body>
</html>