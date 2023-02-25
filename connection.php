<?php include("./dbConnection.php"); error_reporting(E_ERROR | E_PARSE);?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IMMO HORIZON | Connection</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    </head>

    <body>
    <header class="container-fluid bg-dark fixed-top mb-1">
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
                                    <a href="./index.php" class="nav-link active" aria-current="page">Home</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
        <br>




        <?php 
            if(isset($_COOKIE['email'])) { echo $_COOKIE['email'];}
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if(isset($_POST['btn'])){
                $email = $_POST['email'];

                $sql_check = "SELECT N_Client, Nom_Client, Prénom_Client, Email_client, pass FROM client WHERE Email_client = '$email'";
                $sqlresponse = $db_connection->prepare($sql_check);
                $sqlresponse->execute();
                $sqlresult = $sqlresponse->fetch( PDO::FETCH_ASSOC );
                $count = $sqlresponse->rowCount();

                $password = $_POST['password'];
                $HASHEDpassword = $sqlresult['pass'];

                if($count == 0){
                    $error_email = 'There is no user with this email!';
                }elseif(!password_verify($password, $HASHEDpassword)) {
                    $error_password = 'Password is not valid!';
                }else{
                    session_start();
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['password'] = $_POST['password'];
                    $_SESSION['N_Client'] = $sqlresult['N_Client'];
                    $_SESSION['full_name'] = $sqlresult['Nom_Client'] . ' ' . $sqlresult['Prénom_Client'];
                    header('Location: profil.php');
                }
                header('Location: index.php');
            }
        }
        ?>






        
        <main class="mt-5 pt-5">
            <div class="container-fluid pt-5">
                <div class="row">
                    <div class="col d-flex justify-content-center align-items-center">
                        <div class="card" style="width: 20rem;">
                            <div class="card-body">
                                <form class="" method='POST' action=''>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" value='<?php echo $_POST['email'];?>'>
                                        <span class="text-danger"><?= $error_email ?></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" value='<?php echo $_POST['password'];?>'>
                                        <span class="text-danger"><?= $error_password?></span>
                                    </div>
                                
                                    <button type="submit" class="btn btn-dark w-100 mb-3" name="btn">Connexion</button>

                                    <div class="mb-3">
                                        <a href="./inscription.php" class="btn btn-outline-dark w-100">Créer un compte !</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>















        

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