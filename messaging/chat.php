<?php session_start();
$bdd= new PDO('mysql:host=localhost;dbname=connection;charset=utf8;', 'root', '');
if(!$_SESSION['id']){
    header("location:../index.html");
}

if(isset($_GET['id']) AND !empty($_GET['id'])){
    $getid = $_GET['id'];
    $recupUser = $bdd->prepare('SELECT * FROM user  WHERE id=?');
    $recupUser ->execute(array($getid));
    if($recupUser->rowCount() > 0){
        if (isset($_POST['Send'])){
            $message = htmlspecialchars($_POST['message']);
            $insertMessage = $bdd->prepare('INSERT INTO message(message, id_addressee, id_writer)VALUES(?,?,?)');
            $insertMessage->execute(array($message, $getid, $_SESSION['id']));    
        }
        }else{
            echo'No users found';
        }
        }else{
            echo'No login found';
        }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Private messaging</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
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
                <a  class="nav-link"href="../app_doc.php">Appointments</a>
            <?php else: ?>
                <a  class="nav-link"href="../app1.php">Appointments</a>
            <?php endif; ?>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="../disconnect.php">Sign out</a>
            </li>
   

            
        </ul>
    </div>
</nav>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">Chat</div>

                    <div class="card-body">
                        <div id="messages">
                            <?php
                            $recupMessages = $bdd->prepare('SELECT * FROM message WHERE id_writer = ? AND id_addressee = ? OR id_writer =? AND id_addressee=?');
                            $recupMessages->execute(array($_SESSION['id'] , $getid , $getid, $_SESSION['id']));
                            while($message = $recupMessages->fetch()){
                                if($message['id_addressee'] == $_SESSION['id']){
                                    ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= $message['message']; ?>
                                    </div>
                                    <?php
                                }elseif($message['id_addressee'] == $getid){
                                    ?>
                                    <div class="alert alert-dark" role="alert">
                                        <?= $message['message']; ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form method="POST" action="">
                            <div class="form-group">
                                <textarea name="message" class="form-control" rows="3" placeholder="Write your message here..."></textarea>
                            </div>
                            <button type="submit" name ="Send"class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>
</html>
