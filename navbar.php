<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File</title>
</head>
<body>
    <style>
        .navbar-dark.bg-primary {
            background-color: #343a40;
        }
    
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #fff;
        }
        
        .dropdown-menu {
            background-color: #343a40;
            border: none;
        }
        
        .dropdown-item {
            color: #fff !important;
        }
        
        .dropdown-item:hover {
            color: #000 !important;
            background-color: #fff;
        }
    </style>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="../pro.php">Profile</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../download-upload/testtt.php">Files</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="chat0.php">Chat</a>
                </li>
                <li class="nav-item active dropdown">
                    <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'doctor'): ?>
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Doctor Space
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../data/visualiser.php">Page 1</a>
                        <a class="dropdown-item" href="#">Page 2</a>
                        <a class="dropdown-item" href="#">Page 3</a>
                    </div>
                    <?php endif; ?>
                </li>
                <li class="nav-item active ml-auto">
                    <a class="nav-link" href="../disconnect.php">Sign out</a>
                </li>
            </ul>
        </div>
    </nav>
    
</body>
</html>