<?php 
session_start();
if(!$_SESSION['id']){
    header("location:../index.html");
}
// Restrict access to specific pages for non-Medecin users
if(!isset($_SESSION['type']) && $_SESSION['type'] !== 'doctor') {
  header("location:../pro.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <a href="../pro.php">Profile</a>
        <a href="../download-upload/files.php">Files</a>
        <a href="../messaging/chat0.php">Chat</a>
        <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
            <a href="visualise.php">Doctor Space</a>
        <?php endif; ?>
        <a href="../disconnect.php">Sign out</a>   
    </nav>
    
    <div class="container">
        <div>
        <br>
        <p style="font-size: 16px; font-weight: bold; text-align: center; color: green;">Simplify the medical follow-up of your patients now!</p>
        </div>

            <?php
            $jsondata = file_get_contents("observation.json");
            $data = json_decode($jsondata, true);

            if(isset($_GET['id'])) {
            $id = $_GET['id'];
            foreach ($data as $observation) {
                if (isset($observation['identifier']) && $observation['identifier'] == $id) {
                echo "<table>";
                echo "<h2>Observation record for ID $id:</h2>";
                echo "<tr><td>Observation ID:</td><td> " . $observation['identifier'] . "</td></tr>";
                echo "<tr><td>Status: </td><td>" . $observation['status'] . "</td></tr>";
                echo "<tr><td>Subject: </td><td>" . $observation['subject']['display'] . "</td></tr>";
                echo "<tr><td>Effective Date Time: </td><td>" . $observation['effectiveDateTime'] . "</td></tr>";
                echo "<tr><td>Value Quantity: </td><td>" . $observation['valueQuantity']['value'] . " " . $observation['valueQuantity']['unit'] . "</td></tr>";
                echo "</table>";
                echo '<div style="display:flex;justify-content:center;margin-top:10px;">';
                echo '<a href="observation.php?id=' . $observation['identifier'] .' " style="background-color: #007bff;color: white;padding: 10px 20px;text-align: center;text-decoration: none;display: inline-block;border-radius: 10px;margin-right:10px;">Observation</a>';
                echo '<a href="practitioner.php?id=' . $observation['identifier'] .' " style="background-color: #007bff;color: white;padding: 10px 20px;text-align: center;text-decoration: none;display: inline-block;border-radius: 10px;margin-right:10px;">Practitioner</a>';
                echo '</div>';
                echo '<div style="display:flex;justify-content:center;margin-top:10px;">';
                echo '<a href="visualise.php?patient_id=' . $observation['identifier'] .'" style="background-color: #28a745;color: white;padding: 15px 30px;text-align: center;text-decoration: none;display: inline-block;border-radius: 10px;">Review the patient</a>';
                echo '</div>';
                exit();
                }
            }
            echo "No observation record found for ID " . $id;
            }
            else {
            echo "No observation ID specified";
            }
            ?>
         </div>

    </body>
</html>