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
    <link rel="stylesheet" href="css/homepage1.css">


</head>
<body>
<section class="header">
    </section>

    <section class="menu">
      <nav>
          <a href="homepage.php"> <img src="logo2.png"style="width: 100px"; height="100px" ></a>
          <div class="search button">
              <img src="orange3.png" style="width: 4em; height: 4em">
              <input class="input-elevated" type="text" placeholder="Search ..."> 
          </div> 
          <div>
              <ul>
                  <li> <a href="../profil.php">Profile</a></li>
                  <li> <a href="download-upload/testtt.php"> Files</a></li>
                  <li> <a href="videoconf/videoconf.html">Video</a></li>
                  <li> <a href="deconnexion.php"> Sign out</a></li>
              </ul>
          </div>
      </nav>
    </section>


<div class="container">
	<table>
		<thead>
			<tr>
                <th>Id</th>
				<th>Lastname</th>
				<th>Name</th>
				<th>Email</th>
                <th>Modify</th>

			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $_SESSION['id'];?></td>
				<td><?php echo $_SESSION['lastname'];?></td>
				<td><?php echo $_SESSION['name'];?></td>
                <td><?php echo $_SESSION['email'];?></td>
                <td> mod</td>

			</tr>
			<tr>
                <td>..</td>
				<td>..</td>
				<td>..</td>
                <td>..</td>
                <td>..</td>
			</tr>

			<tr>
                <td>..</td>
				<td>..</td>
				<td>..</td>
                <td>..</td>
                <td>..</td>

			</tr>

		</tbody>
	</table>


</div>   
</body>

</html>


