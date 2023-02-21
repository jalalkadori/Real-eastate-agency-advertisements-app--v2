<?php include("./dbConnection.php"); error_reporting(E_ERROR | E_PARSE);?>

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
                                    <form action="logout.php" class="nav-link m-0 p-0">
                                        <button type='submit' class="btn btn-outline-light me-2">Logout</button>
                                    </form>
                                </li>
                                <li class="nav-item">
                                    <a href="ajout.php" class="btn btn-outline-light"> + Ajouter une Annonce</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <main class="container-fluid pt-5 mt-5">
            <div class="container-fluid pt-5 mt-5">
                <div class="container">
                    <div class="row gap-1">
                        <div class="col">
                            <?php 
                                if($row_count > 0) {
                                    displayCards($ad_img_principale);
                                } else {
                                    echo "Pas d'annonces trouvées !";
                                }
            
                                function displayCards($arrToBeDisplayed) {
                                    echo "<div class='row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4'>";
                                    while ($row = $arrToBeDisplayed->fetch(PDO::FETCH_ASSOC)) {
                                        echo("
                                            <div class='col-7'>
                                                <div class='card'>
                                                    <img src='".$row["CH_Image"]."' class='card-img-top'>
                                                    <div class='card-body'>
                                                        <h6 class='card-title'>".$row["T_Annonce"]." de ".$row["Superficie"]." m²</h6>
                                                        <div class='d-flex justify-content-between align-items-center'>
                                                            <h5 class='text-danger fs-5'>".$row["P_Annonce"]." DH</h5>
                                                        </div>
                                                        <p class='fs-6'>".$row["A_Annonce"]." , ".$row["Ville"]."</p>
                                                        <p class='fs-6'>Publié le ".$row["Date_Pub"].".</p>
                                                        <a class='btn btn-dark w-100' href='./details.php?id=".$row["N_Annonce"]."'>Voir Plus ...</a>
                                                        <div class='d-flex justify-content-between align-items-center mt-1'>
                                                            <a class='btn btn-danger' href='./details.php?id=".$row["N_Annonce"]."'>Supprimer</a>
                                                            <a class='btn btn-success' href='./details.php?id=".$row["N_Annonce"]."'>Modifer</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>"
            
                                        );
                                    } 
                                    echo "</div>";
                                }
                                    
                                    ?>
                        </div>
                                <?php 
                                    echo("
                                    
                                        <div class='col-3'>
                                            <div class='card'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>Informations Personnels</h5>
                                                    <h6 class='card-subtitle mb-2 text-muted'>Nom et pronom</h6>
                                                    <p class='card-text'>Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                    <a href='#' class='card-link'>Card link</a>
                                                    <a href='#' class='card-link'>Another link</a>
                                                </div>
                                            </div>
                                        </div>
                                    ");
                                ?>
                            
                        
                    </div>
                </div>
            </div>
        <main class="container-fluid mt-5 pt-5">
            <?php
            session_start();

            if(isset($_SESSION['email'])){
                $email = $_SESSION['email'];
                $sql = "SELECT * FROM annonces LEFT JOIN client ON client.N_Client = annonces.N_Client WHERE client.Email_client = '$email'";
                $sql_response = $db_connection->prepare($sql);
                $sql_response->execute();
                $sql_result = $sql_response->fetchAll(PDO::FETCH_ASSOC);
                $count = $sql_response->rowCount();                        

                    for($c = 0; $c < $count; $c++){
                        echo 
                        "<div class='col mt-2'>
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
                                </div>
                            </div>
                        </div>"       ;
                    }

                }else{
                header('Location: connection.php');
            }
                  
            
            ?>
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