<?php include("./dbConnection.php"); error_reporting(E_ERROR | E_PARSE); session_start();?>

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
                                    <a class="nav-link" href="#Annonce">Annonces</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a href="ajout.php" class="btn btn-outline-light"> + Ajouter une Annonce</a>
                                </li>
                                <li class="nav-item">
                                    <form action="logout.php" class="nav-link m-0 p-0">
                                        <button type='submit' class="btn btn-outline-light me-2">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>


        <main class="container-fluid mt-5 pt-5">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <?php

                        if(isset($_SESSION['email'])){
                            $email = $_SESSION['email'];
                            $N_Client = $_SESSION['N_Client'];
                            $sql = "SELECT * FROM annonces INNER JOIN image on annonces.N_Annonce = image.N_Annonce WHERE annonces.N_Client = '$N_Client' AND image.IMG_Principal = 'oui'";
                            $sql_response = $db_connection->prepare($sql);
                            $sql_response->execute();
                            $sql_result = $sql_response->fetchAll(PDO::FETCH_ASSOC);
                            $_SESSION['N_Annonce'] = $sql_result[0]['N_Annonce'];
                            $count = $sql_response->rowCount();

                            echo "<div class='col-6 m-3'>";
                            echo "<div class='row row-cols-2'>";
                                for($c = 0; $c < $count; $c++){
                                    echo ("

                                        <div class='col my-1'>
                                            <div class='card'>
                                                <img src='".$sql_result[$c]["CH_Image"]."' class='card-img-top'>
                                                <div class='card-body'>
                                                    <h6 class='card-title'>".$sql_result[$c]["T_Annonce"]." de ".$sql_result[$c]["Superficie"]." m²</h6>
                                                    <div class='d-flex justify-content-between align-items-center'>
                                                        <h5 class='text-danger fs-5'>".$sql_result[$c]["P_Annonce"]." DH</h5>
                                                    </div>
                                                    <p class='fs-6'>".$sql_result[$c]["A_Annonce"]." , ".$sql_result[$c]["Ville"]."</p>
                                                    <p class='fs-6'>Publié le ".$sql_result[$c]["Date_Pub"].".</p>
                                                    <a class='btn btn-dark w-100' href='./details.php?id=".$sql_result[$c]["N_Annonce"]."'>Voir Plus ...</a>
                                                    <form method='get' action='./modification.php' class='d-flex justify-content-between align-items-center mt-1'>
                                                        <button name='N_Annonce' class='btn btn-success w-100' value='".$sql_result[$c]["N_Annonce"]."'>Modifer</button>
                                                    </form>
                                                    <form method='get' action='./delete_ad.php' class='d-flex justify-content-between align-items-center mt-1 '>
                                                        <button name='N_Annonce' class='btn btn-danger w-100' value='".$sql_result[$c]["N_Annonce"]."'>Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    ");
                                }

                            echo "</div>";
                            echo "</div>";
                                $sql_info = "SELECT Nom_Client, Prénom_Client, Email_client, N_téléphone FROM client WHERE client.N_Client = '$N_Client'";
                                $sql_info_response = $db_connection->prepare($sql_info);
                                $sql_info_response->execute();
                                $sql_info_result = $sql_info_response->fetchAll(PDO::FETCH_ASSOC);
                                $count = $sql_info_response->rowCount();    
                                $_SESSION['fname'] = $sql_info_result[0]['Prénom_Client'];
                                $_SESSION['lname'] = $sql_info_result[0]['Nom_Client'];
                                $_SESSION['tel'] = '0'.$sql_info_result[0]['N_téléphone'];
                    
                                echo("
                                    <div class='col-3 m-3'>
                                    <div class='card'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>Informations Personnels:</h5>
                                            <h6 class='card-subtitle mb-2 text-muted'>Name: ".$sql_info_result[0]['Nom_Client'] . ' '. $sql_info_result[0]['Prénom_Client']."</h6>
                                            <h6 class='card-subtitle mb-2 text-muted'>Email: ".$sql_info_result[0]['Email_client']."</h6>
                                            <h6 class='card-subtitle mb-2 text-muted'>Télé: +212".$sql_info_result[0]['N_téléphone']."</h6>
                                            <div class=''>
                                            
                                            <a href='modifier_compte.php' class='btn btn-success my-1 w-100'>Modifier vos informations Personnels</a>
                                            <a href='modifier_pass.php' class='btn btn-success w-100'>Modifier le mot de passe</a>
                                            <a href='delete_account.php' class='btn btn-danger my-1 w-100'>Supprimer le compte</a>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            ");
                
                        }
                        else{
                            header('Location: connection.php');
                        }
                        
                    ?>
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