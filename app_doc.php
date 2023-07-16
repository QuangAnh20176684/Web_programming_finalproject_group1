<?php
session_start();

if ($_SESSION['type'] != 'doctor') {
    // Redirect user if not a doctor
    header('Location: pro.php');
    exit();
}

$id_doc = $_SESSION['id'];

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'connection';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Database connection error : ' . $conn->connect_error);
}

// Retrieve all doctor's appointments
$sql = "SELECT * FROM app WHERE id_doc = $id_doc";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <link rel="stylesheet" href="css/profile.css">
</head>

<body>

    <nav class="navbar navbar-dark bg-primary">
        <a class="nav-link" href="pro.php">Profile</a>
        <a class="nav-link" href="download-upload/files.php">Files</a>
        <a class="nav-link" href="messaging/chat0.php">Chat</a>
        <?php if (isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
            <a class="nav-link" href="data/visualise.php">Doctor Space</a>
        <?php endif; ?>
        <a class="nav-link" href="disconnect.php">Sign out</a>

        <?php if (isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
            <a class="nav-link" href="app_doc.php">Appointments</a>
        <?php else: ?>
            <a class="nav-link" href="app_doc.php">Appointments</a>
        <?php endif; ?>
    </nav>


    <div class="container">

        <h1 class="subject mt-5 mb-5 text-center">My Appointments</h1>

        <div class="row justify-content-center mb-5">



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
                    while ($row = $result->fetch_assoc()) {
                        $id_app = $row['id_app'];
                        $date_app = $row['date'];
                        $hour_app = $row['hour'];
                        $name = $row['name'];
                        $status = $row['status'];

                        // Retrieve patient information
                        $sql_pat = "SELECT * FROM app WHERE id_doc = $id_doc";
                        $result_pat = $conn->query($sql_pat);

                        if ($result_pat->num_rows > 0) {
                            $row_pat = $result_pat->fetch_assoc();
                            $name = $row_pat['name'];
                            $tel = $row_pat['tel'];

                        } else {
                            $name_complet_pat = 'Not available';
                        }

                        //View appointment information
                        echo "<tr><td>$id_app</td><td>$date_app</td><td>$hour_app</td><td>$name</td>";
                        echo "<td><form method='POST' action='modify_app.php'>
        <input type='hidden' name='id_app' value='$id_app'>
        <input type='hidden' name='id_doc' value='$id_doc'>
        <select name='status'>
        <option value='waiting'" . ($status == 'waiting' ? 'selected' : '') . ">Waiting</option>
        <option value='accepted'" . ($status == 'accepted' ? 'selected' : '') . ">Accepted</option>
        <option value='refused'" . ($status == 'refused' ? 'selected' : '') . ">Refused</option>
        </select>
        <button type='submit' class='btn btn-primary'>Modify</button>
        </form></td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No appointments found</td></tr>";
                }
                echo "</tbody></table>";
                $conn->close();
                ?>


    </div>
</body>

</html>