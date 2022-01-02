<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id'])
    && isset($_POST['nom']) && !empty($_POST['nom'])
    && isset($_POST['prenom']) && !empty($_POST['prenom'])
    && isset($_POST['mail']) && !empty($_POST['mail'])
    && isset($_POST['mdp']) && !empty($_POST['mdp'])){
    
        require_once('connect.php');

        // On nettoie les données envoyées
        $id = strip_tags($_POST['id']);
        $nom = strip_tags($_POST['nom']);
        $prenom = strip_tags($_POST['prenom']);
        $mail = strip_tags($_POST['mail']);
        $mdp = strip_tags($_POST['mdp']);


        $sql = 'UPDATE `utilisateur` SET `nom` =:nom, `prenom` =:prenom, `mail` =:mail, `mdp` =:mdp WHERE `id` =:id;';

        $query = $bdd->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':mail', $mail, PDO::PARAM_STR);
        $query->bindValue(':mdp', $mdp, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "Utilisateur modifié";
        require_once('close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <h1>Modifier un utilisateur</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-control" value="<?= $utilisateur['nom']?>">
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" value="<?= $utilisateur['prenom']?>">
                    </div>
                    <div class="form-group">
                        <label for="mail">Mail</label>
                        <input type="text" id="mail" name="mail" class="form-control" value="<?= $utilisateur['mail']?>">
                    </div>
                    <div class="form-group">
                        <label for="mail">Mot de passe</label>
                        <input type="text" id="mdp" name="mdp" class="form-control" value="<?= $utilisateur['mdp']?>">
                    </div>
                    <input type="hidden" value="<?= $utilisateur['id']?>" name="id">
                    <button class="btn btn-primary">Envoyer</button>
                    <button class="btn btn-secondary" href="index.php">Retour</a></button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
