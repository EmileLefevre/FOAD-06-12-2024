<?php
include "pdo.php";

try {
    $sql = 'SELECT * FROM livre';
    $statement = $pdo->query($sql);
    $livres = $statement->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/5/solar/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Liste des livres</title>
</head>

<body>
    <?php include('header.php') ?>
    <main>
        <h1 class="TitrePage">Liste des livres</h1>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Id du livre</th>
                    <th scope="col">Auteur</th>
                    <th scope="col">Titre</th>
                    <th scope="col">Catégorie</th>
                    <th scope="col">Editer</th>
                    <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($livres as $livre) { ?>
                    <tr class="table-active">
                        <td> <?= $livre['id_livre']; ?></td>
                        <td><?= $livre['auteur']; ?></td>
                        <td><?= $livre['titre']; ?></td>
                        <td><?= $livre['categorie']; ?></td>
                        <td><a href="modifier.php?id_livre=<?= $livre['id_livre'] ?>">Editer</a></td>
                        <td><a href="supprimer.php?id_livre=<?= $livre['id_livre'] ?>">Supprimer</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>

</html>