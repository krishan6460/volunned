<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['email'])) {
    die("Error: You need to log in to access the certificate.");
}

include 'connect.php';

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];
$userQuery = "SELECT id, firstName, lastName FROM users WHERE email='$email'";
$userResult = $conn->query($userQuery);
$user = $userResult->fetch_assoc();

$resultQuery = "SELECT id, score, total_questions, quiz_date, serial_number FROM results WHERE user_id=" . $user['id'] . " ORDER BY quiz_date DESC LIMIT 1";
$result = $conn->query($resultQuery)->fetch_assoc();

if (!$result) {
    echo "No quiz results found!";
    exit();
}

if (empty($result['serial_number'])) {
    $serialQuery = "SELECT MAX(CAST(serial_number AS UNSIGNED)) AS max_serial FROM results WHERE serial_number REGEXP '^[0-9]+$'";
    $serialResult = $conn->query($serialQuery)->fetch_assoc();
    $max_serial = $serialResult['max_serial'] ?? 0;

    $next_serial = str_pad($max_serial + 1, 4, '0', STR_PAD_LEFT);
    $updateQuery = "UPDATE results SET serial_number='$next_serial' WHERE id=" . $result['id'];
    $conn->query($updateQuery);
} else {
    $next_serial = $result['serial_number'];
}

$certificate_image = imagecreatefrompng('img/2K24001.png');
if (!$certificate_image) {
    die("Error: Unable to load certificate template image.");
}

$black = imagecolorallocate($certificate_image, 0, 0, 0);
$font_path = 'fonts/Cinzel-Regular.otf';
if (!file_exists($font_path)) {
    die("Error: Font file not found.");
}

$name = $user['firstName'] . ' ' . $user['lastName'];

// Add name to the certificate
$name_font_size = 38;
$name_box = imagettfbbox($name_font_size, 0, $font_path, $name);
$name_text_width = $name_box[2] - $name_box[0];
$image_width = imagesx($certificate_image);
$name_x = ($image_width - $name_text_width) / 2;
$name_y = 360 + 384 - 18;
imagettftext($certificate_image, $name_font_size, 0, $name_x, $name_y, $black, $font_path, $name);

// Add serial number at the top-right corner
$serial_font_size = 15;
$serial_text = "S.No.: $next_serial";
$serial_box = imagettfbbox($serial_font_size, 0, $font_path, $serial_text);
$serial_width = $serial_box[2] - $serial_box[0];

// Move serial number 0.7 inches left (67px) and 0.1 inches down (10px)
$serial_x = $image_width - $serial_width - 20 - 300; // 67px to move left
$serial_y = 50 + 160; // 10px to move down

imagettftext($certificate_image, $serial_font_size, 0, $serial_x, $serial_y, $black, $font_path, $serial_text);



// Set the headers for file download
$filename = "Certificate_" . $name . ".png";
header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=\"$filename\"");

// Output the certificate image
ob_clean();
imagepng($certificate_image);
imagedestroy($certificate_image);
?>
