<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "connection");
if ($conn->connect_error) {
    die("The connection failed : " . $conn->connect_error);
}

// Retrieve form data
$id_app = $_POST['id_app'];
$new_status = $_POST['status'];

// Update database
$sql = "UPDATE app SET status = '$new_status' WHERE id_app = $id_app";
if ($conn->query($sql) === TRUE) {
    echo "<h1 style='text-align:center;'>The appointment was successfully updated.</h1>";
} else {
    echo "<h1 style='text-align:center;'>Error : " . $conn->error . "</h1>";
}

// Close Database connection
$conn->close();
?>
