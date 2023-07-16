<?php 
session_start();
if(!$_SESSION['id']){
    header("location:../index.html");
}

// Restrict access to specific pages for non-Medecin users
if(!isset($_SESSION['type']) && $_SESSION['type'] !== 'Doctor Space') {
  header("location:../pro.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <a class="nav-link" href="../pro.php">Profile</a>
        <a class="nav-link" href="../download-upload/files.php">Files</a>
        <a class="nav-link" href="../messaging/chat0.php">Chat</a>
        <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
            <a class="nav-link" href="visualise.php">Doctor Space</a>
        <?php endif; ?>
        <a class="nav-link" href="../disconnect.php">Sign out</a>   
        
        <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
            <a class="nav-link" href="../app_doc.php">Appointments</a>
            <?php else: ?>
            <a class="nav-link" href="../app1.php">Appointments</a>
         <?php endif; ?>

    </nav>

    <div class="container">
        <div>
        <br>
        <p style="font-size: 16px; font-weight: bold; text-align: center; color: green;">Simplify the medical follow-up of your patients now!</p>
        </div>
        <?php
            // Retrieving data from JSON file
            $json = file_get_contents('patient.json');
            $patients = json_decode($json, true);

            // Check if patient ID was provided
            if(isset($_GET['patient_id'])) {
                $patient_id = $_GET['patient_id'];

                // Find the patient corresponding to the provided identifier
                $patient = null;
                foreach($patients as $p) {
                    if($p['identifier'] == $patient_id) {
                        $patient = $p;
                        break;
                    }
                }

                // Viewing patient details
                if($patient) {
                    echo "<h1>Patient Details : ".$patient['name']."</h1>";
                    echo "<table>";
                    echo "<tr><td>ID:</td><td>".$patient['identifier']."</td></tr>";
                    echo "<tr><td>Gender:</td><td>".$patient['gender']."</td></tr>";
                    echo "<tr><td>BirthDate:</td><td>".$patient['birthDate']."</td></tr>";
                    echo "<tr><td>Address:</td><td>".$patient['address']."</td></tr>";
                    echo "</table>";
                    echo '<div style="display:flex;justify-content:center;margin-top:10px;">';
                    echo '<a href="observation.php?id=' . $patient['identifier'] .' " style="background-color: #dc3545;color: white;padding: 10px 20px;text-align: center;text-decoration: none;display: inline-block;border-radius: 10px;margin-right:10px;">Observation</a>';
                    echo '<a href="practitioner.php?id=' . $patient['identifier'] .' " style="background-color: #28a745;color: white;padding: 10px 20px;text-align: center;text-decoration: none;display: inline-block;border-radius: 10px;margin-right:10px;">Practitioner</a>';
                    echo '</div>';
                } else {
                    echo "<p>No patient found with this ID".$patient_id."</p>";
                }

            } else {
                // Viewing the patients list
                ?><p style="font-size: 20px; font-weight: bold; text-align: center;">Find your patients in one click!</p>
                <?php
                echo "<table>";
                echo "<thead><tr><th>ID</th><th>Name</th><th>Details</th></tr></thead>";
                echo "<tbody>";
                foreach($patients as $p) {
                    echo "<tr>";
                    echo "<td>".$p['identifier']."</td>";
                    echo "<td>".$p['name']."</td>";
                    echo "<td><a href=\"?patient_id=".$p['identifier']."\">See the details</a></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            }
        ?>

    </div>

</body>
</html>
