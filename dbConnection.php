<?php 
            try{
              $db_connection = new PDO("mysql:host=127.0.0.1;dbname=ga_immobilier;charset=utf8mb4;", 'root', ''); 
              
               // Selection d'annonce avec l'image pricipale
               
            }
            catch(PDOException $e){
              echo 'Erreur : ' . $e->getMessage();
            }
    ?>
