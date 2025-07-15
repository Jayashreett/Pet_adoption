<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "adoption";

// Connect to database
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("<p style='color:red;'>Database connection failed: " . $conn->connect_error . "</p>");
}

// Query to get pets
$sql = "SELECT * FROM pet_adoption ORDER BY id DESC";
$result = $conn->query($sql);

// Check if any pets exist
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Output each pet card
        echo "
        <div class='pet-card' data-id='" . (int)$row['id'] . "'>
            <img src='" . htmlspecialchars($row['petImage']) . "' alt='" . htmlspecialchars($row['petName']) . "' />
            <div class='pet-details'>
                <h3>Name: " . htmlspecialchars($row['petName']) . "</h3>
                <p>Type: " . htmlspecialchars($row['petType']) . "</p>
                <p>Age: " . htmlspecialchars($row['petAge']) . " years</p>
                <p>Contact: " . htmlspecialchars($row['phoneNumber']) . "</p>
                <button class='adopt-btn' data-id='" . (int)$row['id'] . "'>Adopt</button>
            </div>
        </div>";
    }
} else {
    echo "<p>No pets available at the moment.</p>";
}

$conn->close();
?>
