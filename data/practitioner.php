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
    <title>Profile</title>
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <a href="../pro.php">Profil</a>
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

$file = 'practitioner.json';
$practitioner_id = $_GET['id'];

$data = file_get_contents($file);
$practitioners = json_decode($data, true);

foreach ($practitioners as $practitioner) {
    if ($practitioner['identifier'] == $practitioner_id) {
        echo "<table>";
        echo "<h2>Practitioner record for ID $practitioner_id:</h2>";
        echo "<tr><td>Name: </td><td>" . $practitioner['name'] . "</td></tr>";
        echo "<tr><td>Gender: </td><td>" . $practitioner['gender'] . "</td></tr>";
        echo "<tr><td>Birth Date: </td><td>" . $practitioner['birthDate'] . "</td></tr>";
        echo "<tr><td>Address: </td><td>" . $practitioner['address'] . "</td></tr>";
        echo "<tr><td>Languages: </td><td>" . $practitioner['communication'][0]['language']['text'] . "</td></tr>";
        echo "</table>";
        echo '<div style="display:flex;justify-content:center;margin-top:10px;">';
        echo '<a href="observation.php?id=' . $practitioner['identifier'] .' " style="background-color: #007bff;color: white;padding: 10px 20px;text-align: center;text-decoration: none;display: inline-block;border-radius: 10px;margin-right:10px;">Observation</a>';
        echo '<a href="practitioner.php?id=' . $practitioner['identifier'] .' " style="background-color: #007bff;color: white;padding: 10px 20px;text-align: center;text-decoration: none;display: inline-block;border-radius: 10px;margin-right:10px;">Practitioner</a>';
        echo '</div>';
        echo '<div style="display:flex;justify-content:center;margin-top:10px;">';
        echo '<a href="visualise.php?patient_id=' . $practitioner['identifier'] .'" style="background-color: #28a745;color: white;padding: 15px 30px;text-align: center;text-decoration: none;display: inline-block;border-radius: 10px;">Review the patient</a>';
        echo '</div>';
        break;
    }
}

?>
        </div>

</body>
</html>