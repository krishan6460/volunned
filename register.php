<?php
include 'connect.php';

// Handle sign-up
if (isset($_POST['signUp'])) {
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Encrypt password using MD5
    $course = $_POST['course']; // Course and Year
    $university = $_POST['university']; // University Name

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);
    
    if ($result->num_rows > 0) {
        echo "Email Address Already Exists!";
    } else {
        // Insert new user into the database
        $insertQuery = "INSERT INTO users (firstName, lastName, email, password, course, university)
                        VALUES ('$firstName', '$lastName', '$email', '$password', '$course', '$university')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "Sign up successful! Redirecting...";
            header("refresh:2; url=index1.html"); // Redirect after 2 seconds
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Handle sign-in
if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Encrypt password using MD5

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Incorrect Email or Password!";
    }
}
?>