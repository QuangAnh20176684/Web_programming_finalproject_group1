<?php 
session_start();
$bdd= new PDO('mysql:host=localhost;dbname=connection;charset=utf8;', 'root', '');
if(empty($_SESSION['id'])){
    header("location:/index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        .navbar-dark.bg-primary {
            background-color: #343a40;
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: #fff;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <style>
        .nav-link:hover {
            background-color: #fff;
            color: #000 !important;
        }

    </style>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="../pro.php">Profile</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="../download-upload/files.php">Files</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="chat0.php">Chat</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="../videostream/videostream.php">Video</a>
            </li>
            <li class="nav-item active">
                <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
                <a class="nav-link" href="../data/visualise.php">Doctor Space</a>
                <?php endif; ?>
            </li>


            <li class="nav-item active">
            <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
                <a class="nav-link" href="../app_doc.php">Appointments</a>
            <?php else: ?>
                <a class="nav-link" href="../app1.php">Appointments</a>
            <?php endif; ?>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="../disconnect.php">Sign out</a>
            </li>
  
            </li>
        </ul>
    </div>
</nav>




<div class="container mt-5">
    <div class="row">
        <?php
        $recupUser = $bdd->query('SELECT * FROM user');
        while($user = $recupUser->fetch()){
        ?>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <a href="chat.php?id=<?php echo $user['id'];?>" class="card-link"><?php echo $user['name'];?></a>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
