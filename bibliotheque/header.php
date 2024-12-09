<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://bootswatch.com/5/solar/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <title>Bibliothèque</title>
</head>
<?php 
session_start();
if (isset($_SESSION['connection']) && $_SESSION['connection'] === true) { ?>
<body>
  <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Bibliothèque</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
          </li>
          <li class="nav-item">
            <a class="nav-link" href="list_livre.php">Liste des livre</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="livre.php">Ajouter un livres</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profil.php">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="deconnection.php">Se deconnecter de : <?php echo $_SESSION['email'] ?></a>
          </li>
          <img src="./uploads/<?= $_SESSION['photo']?>" alt="" width="50px" height="50px">
        </ul>
      </div>
    </div>
  </nav>
</body>
<?php }else { ?>

<body>
  <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Bibliothèque</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
          </li>
          <li class="nav-item">
            <a class="nav-link" href="list_livre.php">Liste des livre</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="livre.php">Ajouter un livres</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="inscription.php">S'inscrire</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="connection.php">Se connecter</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</body>
<?php } ?>
</html>