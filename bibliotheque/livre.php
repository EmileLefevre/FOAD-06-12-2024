<?php
include "pdo.php";
include('header.php');

$error_auteur = null;
$error_categorie = null;
$error_titre = null;
@$auteur = strip_tags($_POST["auteur"]);
@$categorie = strip_tags($_POST["categorie"]);
@$titre = strip_tags($_POST["titre"]);

if (isset($_POST["ajouter"])) {
    if (empty($auteur)) {
        $error_auteur = "<p>Vous devez ajouter un auteur</p>";
    } elseif (strlen($auteur) < 2 || strlen($auteur) > 50) {
        $error_auteur = "<p>L'auteur que vous avez mis n'est pas comforme</p>";
    }
    if (empty($categorie)) {
        $error_categorie = "<p>Une catégorie est obligatoire</p>";
    } elseif (strlen($categorie) < 2 || strlen($categorie) > 30) {
        $error_categorie = "<p>La catégorie n'est pas conforme</p>";
    }
    if (empty($titre)) {
        $error_titre = "<p>Un titre est obligatoire</p>";
    } elseif (strlen($categorie) < 2 || strlen($categorie) > 30) {
        $error_titre = "<p>Le titre n'est pas conforme</p>";
    }
    if (!empty($error)) {
        try {
            $sql = "INSERT INTO livre (auteur, categorie, titre) VALUES (:auteur, :categorie, :titre)";
            $query = $pdo->prepare($sql);
            $query->execute([
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
                <?php if (empty($error_auteur)) { ?>
                    <label for="exampleInputEmail1" class="form-label mt-4">Auteur: </label>
                    <input type="text" class="form-control" placeholder="Auteur" name="auteur">
                <?php } ?>
                <?php if (!empty($error_auteur)) { ?>
                    <div class="has-danger">
                        <label for="exampleInputEmail1" class="form-label mt-4">Auteur: </label>
                        <input type="text" class="form-control is-invalid" placeholder="Auteur" name="auteur">
                        <div class="invalid-feedback"><?php echo $error_auteur ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div>
                <?php if (empty($error_categorie)) { ?>
                    <label for="exampleInputEmail1" class="form-label mt-4">Categorie: </label>
                    <input type="text" class="form-control" placeholder="Categorie" name="categorie">
                <?php } ?>
                <?php if (!empty($error_categorie)) { ?>
                    <div class="has-danger">
                        <label for="exampleInputEmail1" class="form-label mt-4">Categorie: </label>
                        <input type="text" class="form-control is-invalid" placeholder="Categorie" name="categorie">
                        <div class="invalid-feedback"><?php echo $error_categorie ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div>
                <?php if (empty($error_titre)) { ?>
                    <label for="exampleInputEmail1" class="form-label mt-4">Titre du livre: </label>
                    <input type="text" class="form-control" placeholder="Nom du livre" name="titre">
                <?php } ?>
                <?php if (!empty($error_titre)) { ?>
                    <div class="has-danger">
                        <label for="exampleInputEmail1" class="form-label mt-4">Titre du livre: </label>
                        <input type="text" class="form-control is-invalid" placeholder="Nom du livre" name="titre">
                        <div class="invalid-feedback"><?php echo $error_titre ?></p>
                        </div>
                    </div>
                <?php } ?>
                <button type="submit" class="btn btn-success mt-4" name="ajouter">Ajouter</button>
        </form>
    </div>
    </body>
<?php } else {
    echo "Vous devez vous connecter pour ajouter des livres"; ?>
    <br>
    <button type="button" class="btn btn-outline-success"><a href="connection.php">Se connecter</a></button>
<?php } ?>

</html>