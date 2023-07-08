<?php 
session_start();
$bdd= new PDO('mysql:host=localhost;dbname=connection;charset=utf8;', 'root', '');

if (isset($_POST['send'])){
    $email = $_POST['email']; 
    $pwd = $_POST['pwd'];


    $recupUser = $bdd->prepare('SELECT * FROM user WHERE email=? AND pwd=?');
    $recupUser->execute(array($email,$pwd));

    if($recupUser->rowCount() > 0 ){
        $user = $recupUser->fetch();
        $_SESSION['email'] = $email ;
        $_SESSION['pwd'] = $pwd ;
        $_SESSION['lastname'] = $user['lastname'] ;
        $_SESSION['name'] = $user['name'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['type'] = $user['type'];

       header("location:pro.php");
    }else{
        echo'Your email address or password is incorrect';
    }

    
}
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My health- Connexion</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
        <link rel="stylesheet" href="css/connectionv3.css">
        <link rel="stylesheet" href="./fontawesome-free-6.1.1-web/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
        
    </head>

    <body>
        <!-- Modal Layout -->
        <div class="modal">  <!-- The whole window -->
            <div class="modal__overlay"> <!-- background picture -->

            </div>
                    
            <!-- a box -->
            <div class="modal__body">
                <!-- Login / Register -->
                <div class="auth-form__header">
                    <h3 class="auth-form__heading">Sign in</h3>
                    <a class="auth-form__switch-btn-link" href="registration.php" target="_blank">
                        <button class="auth-form__switch-btn">Sign up</button>
                    </a>
                </div>
                 

                <!-- Email Address / Password -->
                <form class="auth-form__form" action="" method="POST" id="form-1">
                    <!--EMail -->
                    <div class="auth-form__group">
                        <input for="email" id="email" name="email" type="email" class="auth-form__input auth-form__input2" placeholder="Email" required>
                        <span class="form-message"></span>
                    </div>

                    <!-- Password -->
                    <div class="auth-form__group">
                        <input for="pwd" id="pwd" name="pwd" type="password" class="auth-form__input auth-form__input2" placeholder="Password" required minlength="8">
                        <span class="form-message"></span>
                    </div>

                    <!-- Forgot password / Need help -->
                    <div class="auth-form__aside">
                        <div class="auth-form__help">
                            <a href="" class="auth-form__help-link auth-form__help-link-forgot" target="_blank">Forgot your password ?</a>
                            <span class="auth-form__help-separate"></span>
                            <a href="" class="auth-form__help-link" target="_blank">Need help ?</a>
                        </div>
                    </div>

                    <!-- Button Home Page / Sign in Button -->
                    <div class="auth-form__control">
                        <a href="" class="auth-form__control-link">
                            <button class="btn btn--primary" name="send">Sign in</button>
                        </a>
                    </div>
                </form>

                <div class="auth-form__control auth-form__bonus">
                        <a href="index.html" class="auth-form__control-link">
                            <button class="btn btn--normal auth-form__control-back">Return to homepage</button>
                        </a>
                </div>       
            </div>
            <footer class="footer">
                <div class="grid">
                    <div class="grid__row">
                        <div class="grid__column-2-4">
                            <h2 class="footer__heading">Our website</h2>
                            <ul class="footer-list">
                                <li class="footer-item">
                                    <a href="a_propos.php" class="footer-item__link">About us</a>
                                </li>
                                <li class="footer-item">
                                    <a href="Contact.php" class="footer-item__link">Contact</a>
                                </li>
                                <li class="footer-item">
                                    <a href="" class="footer-item__link">Helpline 24/7 : 15</a>
                                </li>
                            </ul>
                        </div>
                        <div class="grid__column-2-4">
                            <h2 class="footer__heading"></h2>
                        </div>
                        <div class="grid__column-2-4">
                            <h2 class="footer__heading">Legal Notice</h2>
                            <ul class="footer-list">
                                <li class="footer-item">
                                    <a href="" class="footer-item__link">Code of conduct</a>
                                </li>
                                <li class="footer-item">
                                    <a href="" class="footer-item__link">Privacy Policy</a>
                                </li>
                                <li class="footer-item">
                                    <a href="" class="footer-item__link">Cookies</a>
                                </li>
                            </ul>
                        </div>
                        <div class="grid__column-2-4">
                            <h2 class="footer__heading"></h2>
                        </div>
                        <div class="grid__column-2-4">
                            <h2 class="footer__heading">Follow us</h2>
                            <ul class="footer-list">
                                <li class="footer-item">
                                    <a href="https://www.facebook.com/profile.php?id=100074862716045" class="footer-item__link" target="_blank">
                                        <i class="footer-item__icon fa-brands fa-facebook-square"></i>
                                        Facebook
                                    </a>
                                </li>
                                <li class="footer-item">
                                    <a href="https://www.instagram.com/its.episen/" class="footer-item__link" target="_blank">
                                        <i class="footer-item__icon fa-brands fa-instagram-square"></i>
                                        Instagram
                                    </a>
                                </li>
                                <li class="footer-item">
                                    <a href="https://www.linkedin.com/company/esipe-cr%C3%A9teil-its/" class="footer-item__link" target="_blank">
                                        <i class="footer-item__icon fa-brands fa-linkedin"></i>
                                        Linkedin
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
            </footer>
        </div>
        <script src="./test.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                //Our wish
                Validator({
                    form: '#form-1',
                    formGroupSelector: '.auth-form__group',
                    errorSelector: '.form-message',
                    rules: [
                        Validator.isRequired('#email'),
                        Validator.isEmail('#email'),
                        Validator.isRequired('#pwd'),
                        Validator.minLength('#pwd', 8),
                    ],
                    onSubmit: function (data) {
                        //Call API
                        console.log(data);
                    }
                });
            });
        </script>
    </body>
</html>