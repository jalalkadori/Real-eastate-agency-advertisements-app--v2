
<?php include("./dbConnection.php"); ?>


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
                                </ul>
                            </div>
    
                        </div>
                    </nav>
                </div>
            </div>
        </header>
    <main class="mt-5 pt-5">
        <div class="container-fluid pt-5">
            <div class="row">
                <div class="col d-flex justify-content-center">
                <div class="card" style="width: 20rem;">
                    <div class="card-body">
                        <form method='POST' action=''>
                            <div class="mb-3">
                                <label class="form-label">Titre d'anonce</label>
                                <input type="text" class="form-control" name="Titre">
                                <span class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Prix</label>
                                <input type="number" class="form-control" name="prix">
                                <span class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date de la publication : </label>
                                <input type="date" class="form-control" name="prix">
                                <span class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Adresse : </label>
                                <textarea class="form-control" name="prix" cols="30" rows="2"></textarea>
                                <span class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Titre d'anonce</label>
                                <input type="text" class="form-control" name="Titre">
                                <span class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Categorie d'annonce : </label>
                                <select class="form-select" aria-label="type" name="categorie">
                                    <option></option>
                                    <option value="Location">Location</option>
                                    <option value="Vente">Vente</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Type d'annonce : </label>
                                <select class="form-select" aria-label="type" name="type">
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
                                <input type="number" class="form-control" name="prix">
                                <span class="text-danger"></span>
                            </div>
                                                 
                            <button type="submit" name='btn' class="btn btn-success w-100">Confirmer</button>
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