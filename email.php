<?php
$server = "localhost";
$username = "krishabhi_2003";
$password = "Volunned@2024";
$databasename = "krishabhi_2003";

// Connect to database
$con = mysqli_connect($server, $username, $password, $databasename);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start
$email = $_POST['email'];

// Insert email into database
$sql = "INSERT INTO `email`(`email`) VALUES ('$email')";
$result = mysqli_query($con, $sql);

// Close database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Submission</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
        }
        .message-box {
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .message-box h2 {
            color: #4CAF50;
        }
        .message-box p {
            color: #333;
        }
        .back-button {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <?php if ($result): ?>
            <h2>Submission Successful!</h2>
            <p>Your email has been submitted successfully.</p>
        <?php else: ?>
            <h2>Submission Failed</h2>
            <p>There was an error submitting your email. Please try again.</p>
        <?php endif; ?>
        <a href="index.html" class="back-button">Go Back</a>
    </div>
</body>
</html>
