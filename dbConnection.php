<?php 
            try{
                $db_connection = new PDO("mysql:host=127.0.0.1;dbname=ga_immobilier;charset=utf8mb4;", 'root', '');
                $search_request = "SELECT * FROM `annonces`";
                $search_results = $db_connection->prepare($search_request);
                $search_results->execute(); // an array containes all the informations from the 3 tables
            }
            catch(PDOException $e){
              echo 'Erreur : ' . $e->getMessage();
            }
    ?>
