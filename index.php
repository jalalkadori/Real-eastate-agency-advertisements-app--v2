<?php include("./dbConnection.php"); session_start()?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IMMO HORIZON</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/75c6b1327b.js" crossorigin="anonymous"></script>
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
                                <?php 
                                    if(isset($_SESSION['email'])) {
                                        echo ("
                                        
                                        <li class='nav-item'>
                                            <form action='profil.php' class='nav-link m-0 p-0'>
                                                <button type='submit' class='btn btn-outline-light me-2'>Mon Profil</button>
                                            </form>
                                        </li>
                                        <li class='nav-item'>
                                            <form action='logout.php' class='nav-link m-0 p-0'>
                                                <button type='submit' class='btn btn-outline-light me-2'>Logout</button>
                                            </form>
                                        </li>
                                        ");

                                    } else {
                                        echo ("
                                        <li class='nav-item'>
                                            <a class='nav-link m-0 ' href='./inscription.php'>
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

        <main class="container-fluid pt-5">
            <section class="container pt-5">
                <h2 class="pt-5">Filtrer la liste des annonces !</h2>
                <form class="row row-cols-1 row-cols-lg-4" action="" method="POST">
                    <div class="col">
                        <h5 for="type">Categorie</h5>
                        <select class="form-select" aria-label="type" name="categorie">
                            <option></option>
                            <option value="Location">Location</option>
                            <option value="Vente">Vente</option>
                        </select>
                    </div>
                    <div class="col">
                        <h5 for="type">Ville</h5>
                        <select class="form-select" aria-label="type" name="ville">
                            <option></option>
                            <option value="Tanger">Tanger</option>
                            <option value="Asilah">Asilah</option>
                            <option value="Casablanca">Casablanca</option>
                            <option value="Rabat">Rabat</option>
                            <option value="Fes">Fes</option>
                            <option value="Tetouan">Tetouan</option>
                            <option value="Nador">Nador</option>
                            <option value="Marakech">Marakech</option>
                        </select>
                    </div>
                    <div class="col">
                        <h5>Prix : </h5>
                        <div class="d-flex gap-1">
                            <input type="number" class="form-control" name="Min" min="0" value="<?php if (isset($_POST['Min'])) echo $_POST['Min']; ?>">
                            <input type="number" class="form-control" name="Max" min="0" value="<?php if (isset($_POST['Max'])) echo $_POST['Max']; ?>">
                        </div>
                    </div>

                    <div class="col d-flex align-items-end mt-2">
                        <button class="btn btn-dark w-100" type="submit" name="chercher">Chercher</button>
                    </div>
                </form>
            </section>
            <section class="container mt-5" id="Annonce">
                <h2>Liste des Annonces disponible : </h2>
                <?php 

                    $ad_img_principale_request = "SELECT * FROM `annonces` INNER JOIN `image` ON annonces.N_Annonce = image.N_Annonce WHERE image.IMG_Principal='oui'";
                    
                    if(isset($_POST['chercher'])) {
                        $categorie = $_POST["categorie"];
                        $ville = $_POST["ville"];
                        $min_price = $_POST["Min"];
                        $max_price = $_POST["Max"];

                        if(!empty($categorie)) {
                            $ad_img_principale_request.=" AND annonces.C_Annonce = '$categorie'";
                        } 
                        if(!empty($ville)) {
                            $ad_img_principale_request.=" AND annonces.Ville = '$ville'";
                        }
                        if(!empty($min_price)) {
                            $ad_img_principale_request.=" AND annonces.P_Annonce > '$min_price'";
                        }
                        if(!empty($max_price)) {
                            $ad_img_principale_request.=" AND annonces.P_Annonce < '$max_price'";
                        }
                        
                    }
                    $ad_img_principale = $db_connection->prepare($ad_img_principale_request);
                    $ad_img_principale->execute();
                    displayCards($ad_img_principale);

                    function displayCards($arrToBeDisplayed) {
                        echo "<div class='row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 mt-5'>";
                        while ($row = $arrToBeDisplayed->fetch(PDO::FETCH_ASSOC)) {
                            echo("
                                <div class='col mt-2'>
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
                                        </div>
                                    </div>
                                </div>"

                            );
                        } 
                        echo "</div>";
                    }  
                ?>
            </section>
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