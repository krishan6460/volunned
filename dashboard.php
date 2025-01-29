
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html"); // Redirect to login if not authenticated
    exit();
}

// Database connection (update with your credentials)
$servername = "localhost";
$username = "krishabhi_2003";
$password = "Volunned@2024";
$dbname = "krishabhi_2003";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch quiz status
$sql = "SELECT quiz_status FROM quiz WHERE id = 1"; // Replace 'id = 1' with your quiz identifier
$result = $conn->query($sql);

$quiz_status = "inactive"; // Default status if the query fails
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $quiz_status = $row['quiz_status'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Full Page Background with Gradient */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #74ebd5 0%, #9face6 100%);
        }
        /* Dashboard Container Styling */
        .dashboard-container {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        /* Title Styling */
        .dashboard-container h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
            font-weight: 700;
        }
        /* Button Styling */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px;
            font-size: 18px;
            color: #fff;
            background-color: #4CAF50;
            text-decoration: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }
        .btn.disabled {
            background-color: #bbb;
            pointer-events: none;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h1>Welcome to Your Dashboard</h1>
    <?php if ($quiz_status === "active") { ?>
        <a href="quiz.php" class="btn">Begin Test</a>
    <?php } else { ?>
        <a class="btn disabled">Quiz Not Started Yet</a>
    <?php } ?>
    <a href="profile.php" class="btn">View Profile</a>
</div>

</body>
</html>