<?php
session_start();

// Redirect to index if user is not logged in
if (!isset($_SESSION['id'])) {
    header("location:index.html");
    exit;
}

// Define error and success messages
$error_msg = '';
$success_msg = '';

// Handle form submission
if (isset($_POST['send'])) {
    // Validate form data
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['tel']) || empty($_POST['date']) || empty($_POST['hour']) || empty($_POST['speciality']) || empty($_POST['id_doc'])) {
        $error_msg = 'Please complete all fields.';
    } else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $date = $_POST['date'];
        $hour = $_POST['hour'];
        $id_doc = $_POST['id_doc'];

        // Connect to database using PDO
        $dsn = 'mysql:host=localhost;dbname=connection;charset=utf8';
        $username = 'root';
        $password = '';
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            $pdo = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            $error_msg = 'Database connection error: ' . $e->getMessage();
        }

// Insert appointment into database using prepared statement
$sql = 'INSERT INTO app(name,email,tel,date,hour,id_doc) VALUES (:name, :email, :tel, :date, :hour, :id_doc)';
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
    ':name' => $name,
    ':email' => $email,
    ':tel' => $tel,
    ':date' => $date,
    ':hour' => $hour,
    ':id_doc' => $id_doc,
));

        // Store appointment details in session
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['tel'] = $tel;
        $_SESSION['date'] = $date;
        $_SESSION['hour'] = $hour;
        $_SESSION['id_doc'] = $id_doc;

        // Set success message and redirect to pro.php
        $success_msg = 'Appointment saved successfully.';
        header("location:pro.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Making appointments</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
    h1 {
      margin-top: 70px;
    }

    .navbar-nav .nav-link:hover {
  background-color: white;
  color: black !important;
}

  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="pro.php" style="color: white;">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="download-upload/files.php" style="color: white;">Files</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="messaging/chat0.php" style="color: white;">Chat</a>
      </li>
      <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
        <li class="nav-item">
          <a class="nav-link" href="data/visualise.php" style="color: white;">Doctor Space</a>
        </li>
      <?php endif; ?>

    </ul>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="disconnect.php" style="color: white;">Sign out</a>  
      </li>
    </ul>

    <ul class="navbar-nav">
      <li class="nav-item">
      <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
        <a class="nav-link" style="color: white;" href="app_med.php">app</a>
    <?php else: ?>
        <a class="nav-link" style="color: white;" href="app1.php">app</a>
    <?php endif; ?>
      </li>
    </ul>

 
  </div>
</nav>


	<div class="container">
		<h1>Making appointments</h1>
		<form action="" method="post">
			<div class="form-group">
				<label for="name">name:</label>
				<input type="text" class="form-control" id="name" name="name" required>
			</div>
			<div class="form-group">
				<label for="email">E-mail:</label>
				<input type="email" class="form-control" id="email" name="email" required>
			</div>
			<div class="form-group">
				<label for="tel">Phone Number:</label>
				<input type="tel" class="form-control" id="tel" name="tel" required>
                <div class="form-group">
                    <label for="date">Desired date:</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="hour">Desired hour:</label>
                    <input type="time" class="form-control" id="hour" name="hour" required>
                </div>
                <div class="form-group">
                    <label for="speciality">Speciality:</label>
                    <select class="form-control" id="speciality" name="speciality" required>
                        <option value="" selected disabled hidden>Choose a specialty</option>
                        <option value="cardiology">Cardiology</option>
                        <option value="dermatology">Dermatology</option>
                        <option value="gynecology">Gynecology</option>
                        <option value="neurology">Neurology</option>
                        <option value="ophthalmology">Ophthalmology</option>
                        <option value="orthopedics">Orthopedics</option>
                        <option value="pediatrics">Pediatrics</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Name of your doctor:</label>
                    <input type="text" class="form-control" id="name_doc" name="name_doc" required>
                </div>
                <div class="form-group">
                    <label for="name">Doctor ID:</label>
                    <input type="number" class="form-control" id="id_doc" name="id_doc" required>
			    </div>
                <div class="form-group">
                    <label for="message">Your text:</label>
                    <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                </div>
                <button type="submit" name="send" class="btn btn-primary">Send request</button>
            </form>
        </div>
    </div>
    </body>
    </html>
    