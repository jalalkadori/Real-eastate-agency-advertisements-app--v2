<?php include("./dbConnection.php"); 
session_start();
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IMMO HORIZON | Details</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="./slider/css/my-slider.css"/>
        <script src="https://kit.fontawesome.com/75c6b1327b.js" crossorigin="anonymous"></script>
        <script src="./slider/js/ism-2.2.min.js"></script>
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

                                <?php 
                                    if(isset($_SESSION['email'])) {
                                        echo ("
                                        <li class='nav-item'>
                                            <form action='logout.php' class='nav-link m-0 p-0'>
                                                <button type='submit' class='btn btn-outline-light me-2'>Logout</button>
                                            </form>
                                        </li>
                                        <li class='nav-item'>
                                            <form action='profil.php' class='nav-link m-0 p-0'>
                                                <button type='submit' class='btn btn-outline-light me-2'>Mon Profil</button>
                                            </form>
                                        </li>
                                        
                                        ");

                                    } else {
                                        echo ("
                                        <li class='nav-item'>
                                            <a class='nav-link m-1 ' href='./inscription.php'>
                                                <i class='fa-solid fa-user-plus'></i>
                                            </a>
                                        </li>
                                        
                                        ");
                                    }

                                ?> 
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <main class="container-fluid mt-5 pt-5">
           <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <?php 

                                if(isset($_GET["id"])){
                                    $id= $_GET["id"];  
                                }

                                 $selected_ad_request = "SELECT * FROM `annonces` INNER JOIN `client` ON annonces.N_Client = client.N_Client WHERE annonces.N_Annonce = $id";
                                 $selected_ad = $db_connection->prepare($selected_ad_request);
                                 $selected_ad->execute();

                                 $image_gallery_request = "SELECT * FROM `image` where `N_Annonce` = $id";
                                 $image_gallery = $db_connection->prepare($image_gallery_request);
                                 $image_gallery->execute();
                              
                                    echo ("
                                    <div class='ism-slider' data-transition_type='fade' id='img-gallery'>
                                        <ol>
                                        ");
                                        while ($row = $image_gallery->fetch(PDO::FETCH_ASSOC)) {
                                            echo ("
                                            <li>
                                                <img src='".$row['CH_Image']."'>
                                            </li>
                                        ");
                                    }
                                    echo("
                                            </ol>
                                        </div>
                                    ");
                             
                                 while ($row = $selected_ad->fetch(PDO::FETCH_ASSOC)) {
                                    
                                    echo("
                                        <div class='mt-5'>
                                            <div class='card'>
                                                <div class='card-body'>
                                                    <div class='row'>
                                                        <div class='col'>
                                                        <h6 class='card-title'>".$row["T_Annonce"]." de ".$row["Superficie"]." m²</h6></div>
                                                        <div class='col d-flex justify-content-end'>
                                                            <!-- Button trigger modal -->
                                                                <button type='button' class='btn btn-dark' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                                                                Contacter L'annonceur !
                                                                </button>
                                                                
                                                            <!-- Modal -->
                                                                <div class='modal fade' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                                <div class='modal-dialog'>
                                                                    <div class='modal-content'>
                                                                        <div class='modal-header'>
                                                                            <button type='button' class='btn-close btn btn-light' data-bs-dismiss='modal' aria-label='Close'></button>
                                                                        </div>
                                                                        <div class='modal-body text-center'>
                                                                            <h6 class='fs-2 text-danger' >+212 ".$row["N_téléphone"]."</h6>                                                                    
                                                                            <h6 class='fs-2 text-dark' >".$row["Nom_Client"].' '.$row["Prénom_Client"]."</h6>                                                                    
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class='d-flex justify-content-between align-items-center'>
                                                        <h5 class='text-danger fs-5'>".$row["P_Annonce"]." DH</h5>
                                                    </div>
                                                    <p class='fs-6'>".$row["A_Annonce"]." , ".$row["Ville"]."</p>
                                                    <p class='fs-6'>Publié le ".$row["Date_Pub"].".</p>                            
                                                </div>
                                            </div>
                                        </div>"
        
                                    );
                                } 
                            ?>
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