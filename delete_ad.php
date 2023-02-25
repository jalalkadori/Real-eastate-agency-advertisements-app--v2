<?php include("./dbConnection.php"); #error_reporting(E_ERROR | E_PARSE);?>
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
        </header>
        <br>



<?php 
    // if(isset($_SERVER['HTTP_REFERER'])){
        echo 
        '<section class="mt-5" >
            <div class="content mt-5">
                <h1>Voulez-vous vraiment supprimer cette annonce ?</h1>
                <p>Vous ne pouvez pas le récupérer, ainsi que ses données !</p>
                <form method="post" class="buttons">
                    <button name="delete" class="btnYes">Yes</button>
                    <button name="back" class="btnBack">Back</button>
                </form>
            </div>
        </section>';
    // }
        session_start();
        $N_Client = $_SESSION['N_Client'];
        $N_Annonce = $_GET['N_Annonce'];
        echo $N_Annonce;

    if(isset($_SESSION['email'])){
        if(isset($_POST['delete'])){
            $delete = "DELETE FROM `image` WHERE `image`.`N_Annonce` = '$N_Annonce';
            DELETE FROM `annonces` WHERE `annonces`.`N_Annonce` = '$N_Client';";
            $apply = $db_connection->prepare($delete);
            $apply->execute();
            header('Location: ./profil.php');
        }elseif(isset($_POST['back'])){
            header('Location: ./profil.php');
        }
    }
    ?>





        
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
<style>
section{
    width: 50%;
    height: 100%;
    display: flex;
    margin: auto;
    align-items: center;
    justify-content: center;
}

section .content{
    display: grid;
    justify-items: center;
    text-align: center;
    background-color: #b89259;
    padding : 50px;
    border-radius: 5px;
}

section .content button{
padding: 13px 100px;
margin: 15px;
color: #fff;
outline: none;
border:none;
border-radius: 5px;
transition: 0.3s;
}

section .content .btnBack{
background: #000;

}

section .content .btnYes{
background:red;
}
section .content button:hover{
    transform: scale(1.1)
}
</style>