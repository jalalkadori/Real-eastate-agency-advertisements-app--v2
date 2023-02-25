
<?php include("./dbConnection.php"); session_start();   error_reporting(E_ERROR | E_PARSE);
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
                                        <a href="./index.php" class="nav-link active" aria-current="page">Home</a>
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
            if(isset($_POST['submit'])){
                    $T_Annonce = $_POST['T_Annonce']; 
                    $P_Annonce = $_POST['P_Annonce']; 
                    $Date_Pub = $_POST['Date_Pub'];
                    $A_Annonce = $_POST['A_Annonce'];
                    $C_Annonce = $_POST['C_Annonce'];
                    echo $Type_Annonce = $_POST['Type_Annonce'];
                    $N_Client = $_POST['N_Client'];
                    $Superficie = $_POST['Superficie'];
                    $Ville = $_POST['Ville'];

                    echo $N_Client = $_SESSION['N_Client'];

                    $image = $_FILES['image']['name'];
                    $allowedExtensions = array('jpg', 'png', 'jpeg');
                    $image_p_name = 'images/'.$image;
                    $image_p_tmp_name = $_FILES['image']['tmp_name'];
                    $image_Extension = explode('.', $image_p_name);     
                    $image_Extensions = strtolower(end($image_Extension));

                #must form be validated..!
                if(empty($T_Annonce)){
                        $error_titre = 'Please choose a title!';
                }elseif(empty($image)){
                    $error_p_image = 'Please choose The Principale image!';
                }elseif(!in_array($image_Extensions, $allowedExtensions)){
                    $error_p_image = 'Not allowed file extension';
                }
                else{
                
                    $get_last_id = "SELECT N_Annonce FROM annonces ORDER BY N_Annonce DESC LIMIT 1";
                    $sql_response = $db_connection->prepare($get_last_id);
                    $sql_response->execute();
                    $sql_result = $sql_response->fetch(PDO::FETCH_ASSOC);
                    $n_annonce = array_sum(array($sql_result['N_Annonce'], 1));
                    $create_table = "INSERT INTO `annonces` (N_Annonce, T_Annonce, P_Annonce,Date_Pub,Date_Modif,A_Annonce,C_Annonce,Type_Annonce,N_Client,Superficie,Ville)
                    VALUES('$n_annonce','$T_Annonce', '$P_Annonce', '$Date_Pub', '$Date_Modif', '$A_Annonce', '$C_Annonce', '$Type_Annonce', '$N_Client', '$Superficie', '$Ville')";
                    $send_table = $db_connection -> prepare($create_table);
                    $send_table->execute();
                    $_SESSION['id_annonce'] = $n_annonce;
                    $n_annonce = $_SESSION['id_annonce'];
                    $T_Annonce = $_POST['T_Annonce']; 
                    #__________________Upload_IMG_Principal__________________
                    $upload_image_p = "INSERT INTO `image` (CH_Image, IMG_Principal, N_Annonce) VALUES('$image_p_name', 'oui', '$n_annonce')";
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

                        $upload_image = "INSERT INTO `image` (CH_Image, IMG_Principal, N_Annonce) VALUES('$image_name', 'non', '$n_annonce')";
                        move_uploaded_file($image_tmp_name, $image_name);
                        $send_data = $db_connection -> prepare($upload_image);
                        $send_data->execute();
                    }
                    #__________________________________________________________
                    header('Location: profil.php');
                }

            }

        ?>
        <main class="mt-5 pt-5">
            <div class="container-fluid pt-5">
                <div class="row d-flex justify-content-center">
                    <div class="col col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <form method='POST' action='' enctype='multipart/form-data'>
                                <div class="mb-3">
                                    <label class="form-label">Titre d'anonce</label>
                                    <input type="text" class="form-control" name="T_Annonce">
                                    <span class="text-danger"><?=$error_titre?></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Image Principal</label>
                                    <input type="file" class="form-control" name="image">
                                    <h6 class='text-secondary' style='font-size: 12px'>l'image principale va apparaître dans la page d'accueil!</h6>
                                    <span class="text-danger"><?=$error_p_image?></span>
                                </div>                                
                                <div class="mb-3">
                                    <label class="form-label">Autres photos</label>
                                    <input type="file" name="files[]" class="form-control" multiple>
                                    <span class="text-danger"><?=$error_image?></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Prix</label>
                                    <input type="number" class="form-control" name="P_Annonce">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date de la publication : </label>
                                    <input type="date" class="form-control" name="Date_Pub">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ville : </label>
                                    <select class="form-select" aria-label="type" name="Ville">
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
                                <div class="mb-3">
                                    <label class="form-label">Adresse : </label>
                                    <textarea class="form-control" name="A_Annonce" cols="30" rows="2"></textarea>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Categorie d'annonce : </label>
                                    <select class="form-select" aria-label="type" name="C_Annonce">
                                        <option></option>
                                        <option value="Location">Location</option>
                                        <option value="Vente">Vente</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Type d'annonce : </label>
                                    <select class="form-select" aria-label="type" name="Type_Annonce">
                                        <option></option>
                                        <option value="appartement">appartement</option>
                                        <option value="maison">maison</option>
                                        <option value="maison">maison</option>
                                        <option value="bureau">bureau</option>
                                        <option value="terrain">terrain</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Superficie : </label>
                                    <input type="number" class="form-control" name="Superficie">
                                    <span class="text-danger"></span>
                                </div>
                                                    
                                <button type="btn" name='submit' class="btn btn-success w-100">Confirmer</button>
                            </form>
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