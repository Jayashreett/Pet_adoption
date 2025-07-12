<?php
// Database credentials
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form fields
    $ownerName   = $_POST['ownerName'];
    $petName     = $_POST['petName'];
    $petType     = $_POST['petType'];
    $petAge      = $_POST['petAge'];
    $phoneNumber = $_POST['phonenumber'];

    // Handle image upload
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true); // Create uploads/ if it doesn't exist
    }

    $fileName = basename($_FILES["petImage"]["name"]);
    $targetFile = $targetDir . time() . "_" . $fileName; // To avoid name conflict
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $allowedTypes = array("jpg", "jpeg", "png", "gif");

    if (in_array($imageFileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["petImage"]["tmp_name"], $targetFile)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO pet_adoption (ownerName, petName, petType, petAge, phoneNumber, petImage) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiss", $ownerName, $petName, $petType, $petAge, $phoneNumber, $targetFile);

            if ($stmt->execute()) {
                echo "🐾 Pet submitted for adoption successfully!<br>";
                echo "<a href='index.html'>Back to Home</a>";
            } else {
                echo "❌ Error saving pet info: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "❌ Error uploading image.";
        }
    } else {
        echo "❌ Invalid image file type. Only JPG, JPEG, PNG, GIF are allowed.";
    }
}

$conn->close();
?>
