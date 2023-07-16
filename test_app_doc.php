<?php
session_start();

if ($_SESSION['type'] != 'Medecin') {
    // Redirect user if not a doctor
    header('Location: pro.php');
    exit();
}

$id_app = $_SESSION['id'];

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'connexion';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Database connection error : ' . $conn->connect_error);
}

// Retrieve all doctor's appointments
$sql = "SELECT * FROM app WHERE id_app = $id_app";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    
<nav class="navbar navbar-dark bg-primary">
    <a href="pro.php">Profil</a>
    <a href="download-upload/files.php">Files</a>
    <a href="messaging/chat0.php">Chat</a>
    <a href="videostream/videostream.php">Video</a>
    <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
        <a href="data/visualise.php">Doctor Space</a>
    <?php endif; ?>
    <a href="disconnect.php">Sign out</a>   
</nav>

        
<div class="container">

<h1 class="subject mt-5 mb-5 text-center">My appointments</h1>

<div class="row justify-content-center mb-5" >



</div>
    
	<table>
		<thead>
			<tr>
            <th>ID</th>
            <th>Date</th>
            <th>Hour</th>
            <th>Patient</th>
            <th>Status</th>
			</tr>
		</thead>
		<tbody>
        
        <?php 
if ($result->num_rows > 0) {
    echo "<table><thead><tr><th>ID</th><th>Date</th><th>Hour</th><th>Patient Name</th><th>Status</th><th>Action</th></tr></thead><tbody>";
    while ($row = $result->fetch_assoc()) {
        $id_app = $row['id_app'];
        $date_app = $row['date'];
        $hour_app = $row['hour'];
        $name = $row['name'];
        $status = $row['status'];

        // Retrieve patient information
        $sql_pat = "SELECT * FROM app WHERE id_app = $id_app";
        $result_pat = $conn->query($sql_pat);

        if ($result_pat->num_rows > 0) {
            $row_pat = $result_pat->fetch_assoc();
            $name = $row_pat['name'];
            $tel = $row_pat['tel'];

        } else {
            $name_complete_pat= 'Not available';
        }

        // View appointment information
        echo "<tr><td>$id_app</td><td>$date_app</td><td>$hour_app</td><td>$name</td><td>$status</td>";
        echo "<td><button type='button' class='btn btn-primary btn-modifier' data-id='$id_app'>Modify</button></td></tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p>No appointments found</p>";
}
$conn->close();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.btn-modifier').click(function() {
        var id_app = $(this).data('id');
        var new_status = prompt("Enter the new status:");
        if (new_status !== null) {
            $.post('modify_app.php', {id_app: id_app, status: new_status}, function(data) {
                alert(data);
                location.reload();
            });
        }
    });
});
</script>

                
</div>
</body>
</html>
