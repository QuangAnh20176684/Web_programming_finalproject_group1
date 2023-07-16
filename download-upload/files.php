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

    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>



<nav class="navbar navbar-dark bg-primary">
    <a class="nav-link" href="../pro.php">Profile</a>
    <a class="nav-link" href="../download-upload/files.php">Files</a>
    <a class="nav-link" href="../messaging/chat0.php">Chat</a>
    <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
        <a class="nav-link" href="../data/visualise.php">Doctor Space</a>
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
    <p style="font-size: 20px; font-weight: bold; text-align: center;">Find your old medical prescriptions in one click!</p>
<p style="font-size: 16px; text-align: center;">Easily access all of your previous medical prescriptions in one place right at the bottom of the page. You can also upload medical documents securely using our "Upload" button.</p>
<br>
<p style="font-size: 16px; font-weight: bold; text-align: center; color: green;">Simplify your medical follow-up now!</p>
</div>

<form  method="POST" action="upload.php" enctype="multipart/form-data">
    <div style="display: flex; margin: 10px;">
    <input class="form-control mr-sm-2" type="file" placeholder="Search" aria-label="Search" name="file"> 
    <input class="btn btn-outline-success my-2 my-sm-0" type="submit" value="Upload"></button>
    </div>
</form>

	<table>


		<thead>
			<tr>
                <th>Id</th>
				<th>user</th>
				<th>File</th>
				<th>Download</th>
                <th>Delete</th>
			</tr>
		</thead>
		<tbody>
        <?php
        // This will return all files in that folder
        $files = scandir("uploads");
        
        for ($a = 2; $a < count($files); $a++)
        {
        ?>
			<tr>
				<td><?php echo $_SESSION['id'];?></td>
				<td><?php echo $_SESSION['name']; echo" ";echo $_SESSION['lastname']; ?></td>
                <td><?php echo $files[$a]; ?></td>
                <td>
                    <a href="uploads/<?php echo $files[$a]; ?>" download="<?php echo $files[$a]; ?>">
                        Download
                    </a>
                </td>
                <td>
                    <a href="delete.php?name=uploads/<?php echo $files[$a]; ?>" style="color: red;">
                         Delete
                    </a>
                </td>
			</tr>
        <?php         
        }
        ?>

		</tbody>
	</table>
</div>


</body>

</html>


