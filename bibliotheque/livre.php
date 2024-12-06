<?php
include "pdo.php";
include('header.php');

$error = null;
@$auteur = strip_tags($_POST["auteur"]);
@$categorie = strip_tags($_POST["categorie"]);
@$titre = strip_tags($_POST["titre"]);

if (isset($_POST["ajouter"])) {
    if (empty($auteur)) {
        $error .= "<p>Vous devez ajouter un auteur</p>";
    } elseif (strlen($auteur) < 2 || strlen($auteur) > 50) {
        $error .= "<p>L'auteur que vous avez mis n'est pas comforme</p>";
    }
    if (empty($categorie)) {
        $error .= "<p>Une catégorie est obligatoire</p>";
    } elseif (strlen($categorie) < 2 || strlen($categorie) > 30) {
        $error .= "<p>La catégorie n'est pas conforme</p>";
    }
    if (empty($titre)) {
        $error .= "<p>Un titre est obligatoire</p>";
    } elseif (strlen($categorie) < 2 || strlen($categorie) > 30) {
        $error .= "<p>Le titre n'est pas conforme</p>";
    }
    if (empty($error)) {
        try {
            $sql = "INSERT INTO livre (auteur, categorie, titre) VALUES (:auteur, :categorie, :titre)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                "auteur" => $auteur,
                "categorie" => $categorie,
                "titre" => $titre
            ]);
            header('Location: list_livre.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>
<h1>Ajouter un livre</h1>
<?php if (isset($_SESSION['connection']) && $_SESSION['connection'] === true) { ?>
<div class="formulaire">
    <form action="" method="post">
        <div>
            <label for="exampleInputEmail1" class="form-label mt-4">Auteur: </label>
            <input type="text" class="form-control" placeholder="Auteur" name="auteur">
        </div>
        <div>
            <label for="exampleInputEmail1" class="form-label mt-4">Categorie: </label>
            <input type="text" class="form-control" placeholder="Categorie" name="categorie">
        </div>
        <div>
            <label for="exampleInputEmail1" class="form-label mt-4">Titre du livre: </label>
            <input type="text" class="form-control" placeholder="Nom du livre" name="titre">
        </div>
        <button type="submit" class="btn btn-success mt-4" name="ajouter">Ajouter</button>
    </form>
</div>
</body>
<?php } else { echo "Vous devez vous connecter pour ajouter des livres"; ?>
<br>
<button type="button" class="btn btn-outline-success"><a href="connection.php">Se connecter</a></button>
<?php } ?>
</html>