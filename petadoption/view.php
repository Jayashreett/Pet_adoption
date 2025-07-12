<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "adoption";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

echo "<h2>User List</h2>";
echo "<a href='index.html'>Back to Form</a><br><br>";

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10'>
            <tr><th>ID</th><th>Name</th><th>Email</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["id"]."</td>
                <td>".$row["name"]."</td>
                <td>".$row["email"]."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No users found.";
}

$conn->close();
?>