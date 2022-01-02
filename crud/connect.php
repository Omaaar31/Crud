<?php
    try{
        //Connexion à la base de données
        $bdd = new PDO ('mysql:host=localhost;dbname=crud','root', '');
        $bdd->exec('SET NAMES "UTF8"');
        
    } catch(PDOException $e) {
        echo 'Erreur : '. $e->getMessage();
        die();
    }