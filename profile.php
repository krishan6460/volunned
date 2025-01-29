<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Retrieve user information
$email = $_SESSION['email'];
$userQuery = "SELECT id, firstName, lastName, email FROM users WHERE email='$email'";
$userResult = $conn->query($userQuery);
$user = $userResult->fetch_assoc();

// Store candidate name in session for easy access in other pages
$_SESSION['firstName'] = $user['firstName'];
$_SESSION['lastName'] = $user['lastName'];

// Retrieve quiz results
$resultsQuery = "SELECT score, total_questions, quiz_date FROM results WHERE user_id=" . $user['id'];
$results = $conn->query($resultsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        /* Page Styling */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            color: #333;
        }
        .profile-container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        /* Header Styling */
        .profile-header h1 {
            color: #4CAF50;
            font-size: 26px;
            margin-bottom: 5px;
        }
        .profile-header p {
            font-size: 18px;
            color: #555;
            margin: 5px 0 20px;
        }
        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        /* Certificate Link and Status */
        .certificate-link a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
        .certificate-link a:hover {
            text-decoration: underline;
        }
        .no-certificate {
            color: #e74c3c;
            font-weight: bold;
        }
        /* Logout Button Styling */
        .logout-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #e74c3c;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .logout-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <div class="profile-header">
        <h1>Welcome, <?php echo $user['firstName'] . ' ' . $user['lastName']; ?></h1>
        <p>Email: <?php echo $user['email']; ?></p>
    </div>

    <h2>Your Quiz Results:</h2>
    <table>
        <tr>
            <th>Score</th>
            <th>Total Questions</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php while ($result = $results->fetch_assoc()): 
            $score_percentage = ($result['score'] / $result['total_questions']) * 100;
        ?>
        <tr>
            <td><?php echo $result['score']; ?></td>
            <td><?php echo $result['total_questions']; ?></td>
            <td><?php echo $result['quiz_date']; ?></td>
            <td class="certificate-link">
                <?php if ($score_percentage > 5): ?>
                    <a href="certificate.php">Download Certificate</a>
                <?php else: ?>
                    <span class="no-certificate">Better luck next time</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="logout.php" class="logout-button">Logout</a>
</div>

</body>
</html>