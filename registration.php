
//user=utilisateur

<?php
session_start();
$bdd= new PDO('mysql:host=localhost;dbname=connection;charset=utf8;', 'root', '');

if (isset($_POST['send'])){
    $lastname = $_POST['lastname'];
    $name = $_POST['name'];
    $email = $_POST['email']; 
    $pwd = $_POST['pwd'];

    $insertUser = $bdd->prepare('INSERT INTO user(lastname,name,email,pwd)VALUES(?,?,?,?)');
    $insertUser->execute(array($lastname,$name,$email,$pwd));

    $recupUser = $bdd->prepare('SELECT * FROM user WHERE lastname=? AND name=? AND email=? AND pwd=?');
    $recupUser->execute(array($lastname,$name,$email,$pwd));

    if($recupUser->rowCount() > 0 ){
       $_SESSION['lastname'] = $lastname ;
       $_SESSION['name'] = $name ;
       $_SESSION['email'] = $email ;
       $_SESSION['pwd'] = $pwd ;
       $_SESSION['id'] = $recupUser->fetch()['id'];
       $_SESSION['type'] = $recupUser->fetch()['type'];
//HL7
//Patient
       $patient = array(
        "resourceType" => "Patient",
        "id" => 1,
        "meta" => array(
            "lastUpdated" => date('c')
        ),
        "identifier" => $_SESSION['id'],
        "active" => true,
        "name" => $_SESSION['lastname'],
        "telecom" => "Not available",
        "gender" => "Not available",
        "birthDate" => "Not available",
        "address" => "Not available"
    );
//Observation
$observation = array(
    "resourceType" => "Observation",
    "id" => 3,
    "meta" => array(
      "lastUpdated" => date('c')
    ),
    "identifier" => $_SESSION['id'],
    "status" => "Modified +",
    "subject" => array(
      "reference" => "Patient/".$_SESSION['id'],
      "display" => $_SESSION['lastname']
    ),
    "effectiveDateTime" => date('Y-m-d'),
    "valueQuantity" => array(
      "value" => "Not available",
      "unit" => "Cel",
      "system" => "http://unitsofmeasure.org",
      "code" => "Cel"
    )
);


    $immunization = array(
        "resourceType" => "Immunization",
        "id" => 2,
        "meta" => array(
            "lastUpdated" => date('c')
        ),
        "identifier" => $_SESSION['id'],
        "status" => "Not available",
        "vaccineCode" => "000",
        "patient" => array(
            "reference" => "Patient/".$_SESSION['id'],
            "display" => $_SESSION['lastname']
        ),
        "occurrenceDateTime" => date('c')
    );
    
    $practitioner = array(
        "resourceType" => "Practitioner",
        "id" => 4,
        "meta" => array(
            "lastUpdated" => date('c')
        ),
        "identifier" => $_SESSION['id'],
        "active" => true,
        "name" => "Not available",
        "gender" => "Not available",
        "birthDate" => "Not available",
        "address" => "Not available",
        "communication" => array(
            array(
                "language" => array(
                    "text" => "English"
                )
            )
        )
    );
    

    $patients = json_decode(file_get_contents('data/patient.json'), true);
    $patients[] = $patient;
    file_put_contents('data/patient.json', json_encode($patients, JSON_PRETTY_PRINT));

    $observations = json_decode(file_get_contents('data/observation.json'), true);
    $observations[] = $observation;
    file_put_contents('data/observation.json', json_encode($observations, JSON_PRETTY_PRINT));

    $immunizations = json_decode(file_get_contents('data/immunization.json'), true);
    $immunizations[] = $immunization;
    file_put_contents('data/immunization.json', json_encode($immunizations, JSON_PRETTY_PRINT));

    $practitioners = json_decode(file_get_contents('data/practitioner.json'), true);
    $practitioners[] = $practitioner;
    file_put_contents('data/practitioner.json', json_encode($practitioners, JSON_PRETTY_PRINT));
    }

    header("location:pro.php");
}
?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My health - Sign up</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
        <link rel="stylesheet" href="css/connectionv3.css">
        <link rel="stylesheet" href="./fontawesome-free-6.1.1-web/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    </head>
    <body>
        <!-- Modal Layout -->
        <div class="modal"> <!-- the entire window -->
            <div class="modal__overlay"> <!-- Background picture -->

            </div>
                    
            <!-- a box -->
            <div class="modal__body">
                <!-- Register / Sign in -->
                <div class="auth-form__header">
                    <h3 class="auth-form__heading">Sign up</h3>
                    <a class="auth-form__switch-btn-link" href="connection.php" target="_blank">
                        <button class="auth-form__switch-btn">Sign in</button>
                    </a>
                </div>
                    
                <!-- lastname / name / Email / password / Password Confirmation -->
                <form class="auth-form__form" action="" method="POST" id="form-1">
                    <!-- lastname -->
                    <div class="auth-form__group">
                        <input for="lastname" id="lastname" name="lastname" type="text" class="auth-form__input auth-form__input2" placeholder="Lastname" required>
                        <span class="form-message"></span>
                    </div>

                    <!-- name -->
                    <div class="auth-form__group">
                        <input for="name" id="name" name="name" type="text" class="auth-form__input auth-form__input2" placeholder="Name" required>
                        <span class="form-message"></span>
                    </div>

                    <!-- Email -->
                    <div class="auth-form__group">
                        <input for="email" id="email" name="email" type="email" class="auth-form__input auth-form__input2" placeholder="Email" required>
                        <span class="form-message"></span>
                    </div>

                    <!-- Password -->
                    <div class="auth-form__group">
                        <input for="pwd" id="pwd" name="pwd" type="password" class="auth-form__input auth-form__input2" placeholder="Password" required minlength="8">
                        <span class="form-message"></span>
                    </div>

                    <!-- Password Confirmation -->
                    <div class="auth-form__group">
                        <input for="Cpwd" id="Cpwd" name="Cpwd" type="password" class="auth-form__input auth-form__input2" placeholder="Password Confirmation" required minlength="8">
                        <span class="form-message"></span>
                    </div>
                    
                    <!-- Terms of use / Privacy Policy -->
                    <div class="auth-form__group">
                        <div class="auth-form__aside">
                            <div class="auth-form__policy-text">
                                <input type="checkbox" name="acceptation" class="auth-form__input2" required>
                                <label class="auth-form__policy">
                                    I accept the 
                                    <a href="" class="auth-form__text-link" target="_blank">Terms of use</a> and the
                                    <a href="" class="auth-form__text-link" target="_blank">Privacy Policy</a> of your website
                                </label>
                                <br>
                                <span class="form-message"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Button Return to homepage / Sign up Button-->
                    <div class="auth-form__control">
                        <a href="" class="auth-form__control-link">
                            <button class="btn btn--primary" name="send" type="submit">Sign up</button>
                        </a>
                    </div>
                </form>

                <div class="auth-form__control auth-form__bonus">
                    <a href="index.html" class="auth-form__control-link">
                        <button class="btn btn--normal auth-form__control-back">Homepage</button>
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
                                    <a href="https://www.instagram.com/" class="footer-item__link" target="_blank">
                                        <i class="footer-item__icon fa-brands fa-instagram-square"></i>
                                        Instagram
                                    </a>
                                </li>
                                <li class="footer-item">
                                    <a href="https://www.linkedin.com/" class="footer-item__link" target="_blank">
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
                
                Validator({
                    form: '#form-1',
                    formGroupSelector: '.auth-form__group',
                    errorSelector: '.form-message',
                    rules: [
                        Validator.isRequired('#lastname'),
                        Validator.isRequired('#name'),
                        Validator.isRequired('#email'),
                        Validator.isEmail('#email'),
                        Validator.isRequired('#pwd'),
                        Validator.minLength('#pwd', 8),
                        Validator.isRequired('input[name="acceptation"]'),
                        Validator.isRequired('#Cpwd'),
                        Validator.isConfirmed('#Cpwd', function () {
                            return document.querySelector('#form-1 #pwd').value;
                        }, 'The re-entered password is incorrect')
                    ],
                    onSubmit: function (data) { 
                       
                        console.log(data);
                    }
                });
            });
        </script>
    </body>
</html>
