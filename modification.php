
<?php include("./dbConnection.php"); session_start();


$N_Annonce = $_GET['N_Annonce'];

$ad_update_query = "SELECT * FROM annonces WHERE N_Annonce = $N_Annonce";
$ad_update_response = $db_connection->prepare($ad_update_query);
$ad_update_response->execute();

$ad_update = $ad_update_response->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMMO HORIZON | Ajouter une annonce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./Style_form/style.css">

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
                                        <a href="./profil.php" class="nav-link active" aria-current="page">Home</a>
                                    </li>
                                    <li class='nav-item'>
                                        <form action='profil.php' class='nav-link m-0 p-0'>
                                            <button type='submit' class='btn btn-outline-light me-2'>Mon Profil</button>
                                        </form>
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
            </div>
        </header>

    <?php
        if(isset($_SESSION['email'])){
            if(isset($_POST['update'])) {
                $titre = $_POST['T_Annonce'];
                $prix = $_POST['P_Annonce'];
                $date_modif = $_POST['Date_Pub'];
                $ville = $_POST['Ville'];
                $adresse = $_POST['A_Annonce'];
                $category = $_POST['C_Annonce'];
                $type = $_POST['Type_Annonce'];
                $superficie = $_POST['Superficie'];

                $ad_update_request = "UPDATE `annonces` SET `T_Annonce` = '$titre',`P_Annonce` = '$prix', `Date_Modif` = '$date_modif', `A_Annonce` = '70, rue du Marché', `C_Annonce` = '$category', `Type_Annonce`='$type', `Superficie` = '$superficie', `Ville` = '$ville' WHERE `annonces`.`N_Annonce` = '$N_Annonce'";
                $ad_update = $db_connection->prepare($ad_update_request);
                $ad_update->execute();

                $image = $_FILES['image']['name'];
                $allowedExtensions = array('jpg', 'png', 'jpeg');
                $image_p_name = 'images/'.$image;
                $image_p_tmp_name = $_FILES['image']['tmp_name'];
                $image_Extension = explode('.', $image_p_name);     
                $image_Extensions = strtolower(end($image_Extension));

                #__________________delete_old_IMG_images__________________
                $delete_images_query = "DELETE FROM `image` WHERE `image`.`N_Annonce`='$N_Annonce'";
                $delete_images = $db_connection->prepare($delete_images_query);
                $delete_images->execute();

                #__________________Upload_new_IMG_Principal__________________
                $upload_image_p = "INSERT INTO `image` (CH_Image, IMG_Principal, N_Annonce) VALUES('$image_p_name', 'oui', '$N_Annonce')";
                move_uploaded_file($image_p_tmp_name, $image_p_name);
                $send_data_p = $db_connection -> prepare($upload_image_p);
                $send_data_p->execute();



                #__________________Upload_other_images__________________

                $images = $_FILES['images']['name']; 
                $images_Path = $_FILES['images']['tmp_name'];
                $imagescount = count($_FILES['files']['name']);

                for($i = 0; $i < $imagescount; $i++){
                    $image_name = 'images/'.$_FILES['files']['name'][$i];
                    $image_tmp_name = $_FILES['files']['tmp_name'][$i];
                    $fileExtension = explode('.', $image_name);     
                    $fileExtensions = strtolower(end($fileExtension));     

                    $upload_image = "INSERT INTO `image` (CH_Image, IMG_Principal, N_Annonce) VALUES('$image_name', 'non', '$N_Annonce')";
                    move_uploaded_file($image_tmp_name, $image_name);
                    $send_data = $db_connection -> prepare($upload_image);
                    $send_data->execute();
                }
                #__________________________________________________________
                header('Location: profil.php');
        
            }
        } else {
            header('Location: connection.php');
        }
     
    ?>
    <main class="mt-5 pt-5">
        <div class="container-fluid pt-5">
            <div class="row d-flex justify-content-center">
            <div class="row d-flex justify-content-center">
                <div class="col col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <form method='POST' action='' enctype='multipart/form-data'>
                                <div class="mb-3">
                                    <label class="form-label">Titre d'anonce</label>
                                    <input type="text" class="form-control" name="T_Annonce" value='<?php echo $ad_update['T_Annonce']?>'>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Choisir une nouvelle Image Principal </label>
                                    <h6 class='text-secondary text-danger' style='font-size: 12px'>*Les images actuelles seront supprimer automatiquement !!</h6>
                                    <input type="file" class="form-control" name="image">
                                    <h6 class='text-secondary' style='font-size: 12px'>* l'image principale va apparaître dans la page d'accueil!</h6>
                                </div>                                
                                <div class="mb-3">
                                    <label class="form-label">Autres photos</label>
                                    <input type="file" name="files[]" class="form-control" multiple>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Prix</label>
                                    <input type="number" class="form-control" name="P_Annonce" value='<?php echo $ad_update['P_Annonce']?>'>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date de la Modification : </label>
                                    <input type="date" class="form-control" name="Date_Pub" value='<?php echo $ad_update['Date_Pub']?>'>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ville : </label>
                                    <select class="form-select" aria-label="type" name="Ville">
                                        <option value='<?php echo $ad_update['Ville']?>' selected><?php echo $ad_update['Ville']?></option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Adresse : </label>
                                    <input type="text" class="form-control" name="A_Annonce" value='<?php echo $ad_update['A_Annonce']?>'></input>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Categorie d'annonce : </label>
                                    <select class="form-select" aria-label="type" name="C_Annonce">
                                        <option value='<?php echo $ad_update['C_Annonce']?>' selected><?php echo $ad_update['C_Annonce']?></option>
                                        
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Type d'annonce : </label>
                                    <select class="form-select" aria-label="type" name="Type_Annonce">
                                        <option value='<?php echo $ad_update['Type_Annonce']?>' selected><?php echo $ad_update['Type_Annonce']?></option>   
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Superficie : </label>
                                    <input type="number" class="form-control" name="Superficie" value='<?php echo $ad_update['Superficie']?>'>
                                </div>
                                                    
                                <button type="btn" name='update' class="btn btn-success w-100">Mettre à jour </button>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>    
  


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
 </body>
</html>   