<?php 
            try{
                $db_connection = new PDO("mysql:host=127.0.0.1;dbname=ga_immobilier;charset=utf8mb4;", 'root', '');
                // ads selection with all images 
                $search_request = "SELECT * FROM `annonces` RIGHT JOIN `image` ON annonces.N_Annonce = image.N_Annonce";
                $search_results = $db_connection->prepare($search_request);
                $search_results->execute(); // an array containes all the informations from the 3 tables

                // Selection d'annonce avec l'image pricipale
                $ad_img_principale_request = "SELECT * FROM `annonces` RIGHT JOIN `image` ON annonces.N_Annonce = image.N_Annonce WHERE image.IMG_Principal='oui'";
                $ad_img_principale = $db_connection->prepare($ad_img_principale_request);
                $ad_img_principale->execute();
                $row_count = $ad_img_principale->rowCount();
            }
            catch(PDOException $e){
              echo 'Erreur : ' . $e->getMessage();
            }
    ?>
