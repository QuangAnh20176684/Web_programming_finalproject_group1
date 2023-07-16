<?php 
session_start();
if(!$_SESSION['id']){
    header("location:../index.html");
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
    <a href="../videostream/videostream.php">Video</a>
    <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
        <a href="visualise.php">Doctor Space</a>
    <?php endif; ?>
    <a href="../disconnect.php">Sign out</a>   
</nav>

<div class="container">
    <div>
        <p style="font-size: 20px; font-weight: bold; text-align: center;">Find your patients in one click!</p>
        <br>
        <p style="font-size: 16px; font-weight: bold; text-align: center; color: green;">Simplify the medical follow-up of your patients now!</p>
    </div>

    <form action="" method="GET">
        <div style="display: flex; margin: 10px;">
            <input class="form-control mr-sm-2" type="text" placeholder="Search by name" aria-label="Search" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"> 
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Retrieving data from JSON file
            $json = file_get_contents('patient.json');
            $patients = json_decode($json, true);

            // Filter patients by search
            if(isset($_GET['search']) && $_GET['search'] !== '') {
                $search = strtolower($_GET['search']);
                $patients = array_filter($patients, function($p) use ($search) {
                    return strpos(strtolower($p['name']), $search) !== false;
                });
            }

            // Viewing the patient list
            foreach($patients as $p) {
                echo "<tr>";
                echo "<td>".$p['identifier']."</td>";
                echo "<td>".$p['name']."</td>";
                echo "<td><a href=\"?patient_id=".$p['identifier']."\">See the details</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Viewing selected patient details
if (isset($_GET['patient_id'])) {
            $patient = $patients[$_GET['patient_id']];
            echo "<tr>";
            echo "<td>".$patient['identifier']."</td>";
            echo "<td>";
            echo "<h1>Patient details : ".$patient['name']."</h1>";
            echo "<p>ID : ".$patient['identifier']."</p>";
            echo "<p>Gender : ".$patient['gender']."</p>";
            echo "<p>BirthDate : ".$patient['birthDate']."</p>";
            echo "<p>Address : ".$patient['address'];}
                ?>
</body>
</html>
