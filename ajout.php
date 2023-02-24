
<?php include("./dbConnection.php"); ?>


<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./Style_form/style.css">

    </head>
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
                            </ul>
                        </div>

                    </div>
                </nav>
            </div>
        </div>
    </header>
    <h1></h1>
    <body>
    <div class="container col-md-6 position-centre">
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Ajouter une annonce</h3>
                        <p></p>
                        <form class="requires-validation" enctype="multipart/form-data" action="" method="post">

                            <div class="col-md-12">
                               <input class="form-control" type="text" name="T_Annonce" placeholder="Titre">
                            </div>

                            <div class="col-md-12">
                                <input class="form-control" type="numero" name="P_Annonce" placeholder="Prix">
                            </div>

                            <div class="col-md-12">
                                <input class="form-control" type="date" name="Date_Pub" placeholder="Date">
                            </div>

                           <div class="col-md-12">
                              <input class="form-control" type="text" name="A_Annonce" placeholder="Adress">
                           </div>

                           <div class="col-md-12">
                           <select name="C_Annonce">
                                 <option value="">Categorie</option>
                                 <option value="Vente">Vente</option>
                                 <option value="Location">Location</option>
                    
                            </select>
                            </div>

                            <div class="col-md-12">
                           <select name="Type_Annonce">
                                 <option value="">Type</option>
                                 <option value="Maison">Maison</option>
                                 <option value="Villa">Villa</option>
                                 <option value="Terrain">Terrain</option>
                            </select>
                            </div>

                            <div class="col-md-12">
                                <input class="form-control" type="email" name="email" placeholder="Email">
                            </div>

                            <div class="col-md-12">
                                <input class="form-control"type="hidden"  value="30000"  name="CH_Image" multiple/>
                                <input name="CH_Image" type="file" multiple/>
                            </div>

                            <div class="col-md-12">
                                <input class="form-control" type="list" name="ville" placeholder="Ville">
                            </div>

                            <div class="col-md-12">
                                <input class="form-control" type="numero" name="superficie" placeholder="Superficie">
                            </div>

                            <div class="form-button mt-3">
                                <button name="submit" type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>      
    <?php
            




            
              

                if(isset($_POST['submit'])){
                    $T_Annonce = $_POST['T_Annonce']; 
                    $P_Annonce = $_POST['P_Annonce']; 
                    $D_Annonce = $_POST['Date_Pub'];
                    $A_Annonce = $_POST['A_Annonce'];
                    $C_Annonce = $_POST['C_Annonce'];
                    $Type_Annonce = $_POST['Type_Annonce'];

                    $image = $_FILES['CH_Image']['name'];
                  //  $filetype = $_FILES['CH_Image']['type'];
                    $fileExtension = explode('.', $image);     
                    $fileExtensions = strtolower(end($fileExtension));     
                    echo 'test '.$fileExtensions;
                    $allowedExtensions = array('jpg', 'png', 'jpeg','jfif');

                    if(in_array($fileExtensions, $allowedExtensions)){
                        
                    $img = uniqid('IMG-', true).".".$fileExtensions;

                    $filedestination = 'images/' .$img;
                    move_uploaded_file($_FILES['CH_Image']['tmp_name'], $filedestination);
                    }
                    else{
                        echo 'Extension non autorisée !!';
                    }


                    $ville = $_POST['ville'];
                    $superficie = $_POST['superficie'];


                     $sql = "INSERT INTO `annonces` (T_Annonce , P_Annonce , Date_Pub , A_Annonce , C_Annonce , Type_Annonce , Ville , Superficie) VALUE('$T_Annonce' , '$P_Annonce' , '$D_Annonce' , '$A_Annonce' , '$C_Annonce' , '$Type_Annonce' , '$ville' , '$superficie')";
                    

                    $insert_info = $db_connection->prepare($sql);
                    $insert_info->execute();
                    
                    


                    $I_sql = "INSERT INTO `image`  ( CH_Image ) VALUES ('$filedestination')";

                    $insert_img = $db_connection->prepare($I_sql);
                    $insert_img->execute();
                }
                
               
                  {
                    if (strlen($T_Annonce) < 50 && strlen($P_Annonce) > 0 && strlen($D_Annonce) > 0 && strlen($A_Annonce) < 50 && strlen($C_Annonce) < 50 && strlen($Type_Annonce) < 50 && strlen($ville) < 50 && strlen($superficie) > 0 && strlen($image) < 50) {
                      if (in_array($fileExtension, $allowedExtensions)) {
                        if (move_uploaded_file($_FILES['CH_Image']['tmp_name'], $image)) {
                          echo "Votre annonce a été ajouté avec succès";
                        } else {
                          echo "Une erreur est survenue lors de l'ajout de votre annonce";
                        }
                      } else {
                        echo "Votre image doit être au format jpg, png, jpeg ou jfif";
                      }
                    } else {
                      echo "Veuillez remplir tous les champs";
                    }
                  }  
                
                
            ?>


    <script>
        (function () {
    'use strict'
    const forms = document.querySelectorAll('.requires-validation')
    Array.from(forms)
  .forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
 </body>
</html>   