<?php
include "header.php";
include "pdo.php";

if (isset($_POST["envoyer"])) {
    try {
        $sql = "DELETE FROM livre WHERE id_livre = :id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            "id" => $_GET["id_livre"]
        ]);
        header("location:list_livre.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
<?php if (isset($_SESSION['connection']) && $_SESSION['connection'] === true) { ?>
<form action="" method="post">
    <button type="submit" class="btn btn-outline-success" name="envoyer">Valider la Suppression</button>
    <button type="button" class="btn btn-outline-success"><a href="list_livre.php">Annuler la suppression</a></button>
</form>
<?php if (!empty($error)) {
    echo $error;
} ?>
<?php } else { echo "Vous devez vous connecter pour supprimer des livres"; ?>
<br>
<button type="button" class="btn btn-outline-success"><a href="connection.php">Se connecter</a></button>
<?php } ?>