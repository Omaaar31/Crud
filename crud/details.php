<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `utilisateur` WHERE `id` = :id;';

    // On prépare la requête
    $query = $bdd->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le produit
    $utilisateur = $query->fetch();

    // On vérifie si le produit existe
    if(!$utilisateur){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: index.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails</title>
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Détails de l'utilisateur <?= $utilisateur['id'] ?></h1>
                <p>ID : <?= $utilisateur ['id'] ?></p>
                <p>Nom : <?= $utilisateur ['nom'] ?></p>
                <p>Prénom : <?= $utilisateur ['prenom'] ?></p>
                <p>Mail : <?= $utilisateur ['mail'] ?></p>
                <p>Mot de passe : <?= $utilisateur ['mdp'] ?></p>
                <p><a href="index.php">Retour</p>
                <p><a href="update.php?id=<?=$utilisateur['id']?>">Modifier données</p>


            </section>
        </div>
    </main>
</body>
</html>