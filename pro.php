<?php session_start();
if(!$_SESSION['id']){
    header("location:index.html");
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
    
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    
<nav class="navbar navbar-dark bg-primary">
    <a href="pro.php">Profile</a>
    <a href="download-upload/files.php">Files</a>
    <a href="messaging/chat0.php">Chat</a>
    <a href="videostream/videostream.php">Visio</a>
    <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
        <a href="data/visualise.php">Doctor Space</a>
    <?php endif; ?>
    <a href="disconnect.php">Sign out</a>        
    <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
        <a href="app_doc.php">Appointment</a>
    <?php else: ?>
        <a href="app1.php">Appointment</a>
    <?php endif; ?>
</nav>

        
<div class="container">

<h1 class="subject mt-5 mb-5 text-center">My personal information</h1>

<div class="row justify-content-center mb-5" >

<img src="images/gallery/avatar.png" class="rounded-circle mx-auto d-block" width="200" alt="<?php echo $_SESSION['lastname']; echo" "; echo $_SESSION['name']?>"/>


</div>
    
	<table>
		<thead>
			<tr>
            <th>Id</th>
            <td><?php echo $_SESSION['id'];?></td>

			</tr>
		</thead>
		<tbody>
        <tr>
			<th>Lastname</th>
            <td><?php echo $_SESSION['lastname'];?></td>
		</tr>

        <tr>
            <th>Name</th>
            <td><?php echo $_SESSION['name'];?></td>
        </tr>

		<tr>
            <th>Email</th>
            <td><?php echo $_SESSION['email'];?></td>
		</tr>

		<tr>
            <th>Rights (Doctor or Patient)</th>
            <td>
            <?php if($_SESSION['type'] == NULL){echo "Patient";
                }else{echo $_SESSION['type'];}?>    
            </td>
		</tr>

		</tbody>
	</table>


</div>   
</body>
</html>