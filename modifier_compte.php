<?php include("./dbConnection.php"); error_reporting(E_ERROR | E_PARSE);
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IMMO HORIZON</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    </head>

    <body>
        <header class="container-fluid bg-dark fixed-top mb-1">
            <div class="container ">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-dark py-2">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="index.php">
                            <img src="./logo/black.png" alt="logo" width="120">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-light">
                                <li class="nav-item">
                                    <a href="index.php" class="nav-link active" aria-current="page">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a href="profil.php" class="btn btn-outline-light">Mon Profil !</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <br>

        <?php
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];

        $check_email = "SELECT Email_client FROM client";
        $check_response = $db_connection->prepare($check_email);
        $check_response->execute();
        $check_email_response = $check_response->fetchAll( PDO::FETCH_ASSOC );
        $email = str_replace(" ", "", $email);
        for($i=0; $i < $check_response->rowCount(); $i++){
            if(preg_match("/$email/i", $check_email_response[$i]['Email_client'])){
                $exist = true;
            }
        }

        session_start();
        if(isset($_SESSION['email'])){
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['btn'])){    
                
                if(strlen($_POST['lname']) > 15 or strlen($_POST['lname']) == 0){
                    $error_lname = 'Your First Name must not be empty and over 15 characters!';
                }
                elseif(preg_match_all("/[&<>\|`_@}{()@~'!§£=€]/", $_POST['lname'])){
                    $error_lname = 'Your First Name must not contain special characters!';
                }        
                elseif(strlen($_POST['fname']) > 15){
                    $error_fname = 'Your Last Name must not be empty and over 15 characters!';
                }
                elseif(preg_match_all("/[&<>\|`_@}{()@~'!§£=€]/", $_POST['fname'])){
                    $error_fname = 'Your Last Name must not contain special characters!';
                }
                elseif(strlen($_POST['tel']) !== 10){
                    $error_tel = 'Your Phone Number must contain 10 numbers!';
                }     
                else{
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $Inser_client_data = "UPDATE client SET 
                    Nom_Client = '$lname',
                    Prénom_Client = '$fname',
                    N_téléphone = '$tel'
                    WHERE Email_client = '$session'";
                    $send_data = $db_connection->prepare($Inser_client_data);
                    $send_data->execute();
                    header('Location: profil.php');
                    $_SESSION['email'] = $_POST['email'];
                }
            }  
        }
    }else{
            header('Location: profil.php');
        }
    
?>





        <main class="signupbox mt-5 pt-5">
            <div class="container-fluid pt-5">
                <div class="row">
                    <h4 class="text-center my-2">Mise à jour de vos information Personnels</h4>
                    <div class="col d-flex justify-content-center">
                    <div class="card" style="width: 20rem;">
                        <div class="card-body">
                            <form method='POST' action=''>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nom</label>
                                    <input type="text" class="form-control" name="lname" value="<?= $_SESSION['lname'] ?>">
                                    <span class="text-danger"><?= $error_lname ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Prénom</label>
                                    <input type="text" class="form-control" name="fname" value="<?= $_SESSION['fname'] ?>">
                                    <span class="text-danger"><?= $error_fname ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Numero de telephone</label>
                                    <input type="tel" class="form-control" name="tel" value="<?= $_SESSION['tel'] ?>">                                    
                                    <span class="text-danger"><?= $error_tel ?></span>

                                </div>                       
                                <button type="submit" name='btn' class="btn btn-dark w-100">Enregistrer</button>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>





        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
            integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
        </script>
    </body>
</html>