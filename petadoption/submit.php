<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "adoption";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and sanitize input
$name  = trim($_POST['name']);
$email = trim($_POST['email']);
$raw_password = $_POST['password'];

// Basic validation
if (empty($name) || empty($email) || empty($raw_password)) {
    die("All fields are required.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

// Hash the password
$hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed_password);

if ($stmt->execute()) {
    echo "User registered successfully.<br>";
    echo "<a href='index.html'>Back</a> | <a href='view.php'>View Users</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
