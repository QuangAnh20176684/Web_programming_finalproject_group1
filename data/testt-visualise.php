<?php session_start();
if(!$_SESSION['id']){
    header("location:../index.html");
}
 ;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    
    <link rel="stylesheet" href="../css/profiles.css">
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
    <a href="../pro.php">Profile</a>
    <a href="../download-upload/testtt.php">Files</a>
    <a href="../messaging/chat0.php">Chat</a>
    <a href="../videostream/videostream.php">Video</a>
    <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
        <a href="visualise.php">Doctor Space</a>
    <?php endif; ?>
    <a href="../disconnect.php">Sign out</a>   
</nav>

<?php
//Retrieving data from JSON file
$json = file_get_contents('patient.json');
$patients = json_decode($json, true);

// Checking if a patient is selected
if(isset($_GET['patient_id'])) {
  $patient_id = $_GET['patient_id'];
  $patient = null;
  
  // Finding Patient Matching ID
  foreach($patients as $p) {
    if($p['identifier'] == $patient_id) {
      $patient = $p;
      break;
    }
  }

  // Viewing patient details
  if($patient) {
    echo "<h1>Patient details: ".$patient['name']."</h1>";
    echo "<p>ID : ".$patient['identifier']."</p>";
    echo "<p>Gender : ".$patient['gender']."</p>";
    echo "<p>BirthDate : ".$patient['birthDate']."</p>";
    echo "<p>Address : ".$patient['address']."</p>";
  } else {
    echo "<p>The selected patient doesn't exist.</p>";
  }
} else {
  // Viewing the patient list
  echo "<h1>Patients' List</h1>";
  foreach($patients as $p) {
    echo "<p>".$p['name']." (<a href=\"?patient_id=".$p['identifier']."\">details</a>)</p>";
  }
}
?>


</body>
</html>