<?php
include "pdo.php";
include('header.php');

?>
<h1>Votre Profile : </h1>
<div class="formulaire">
    <form action="" method="post">
        <div>
            <label for="exampleInputEmail1" class="form-label mt-4">Nom</label>
            <input type="text" class="form-control" placeholder="Nom" name="nom" value="<?php echo $_SESSION['nom'] ?>">
        </div>
        <div>
            <label for="exampleInputEmail1" class="form-label mt-4">Prenom</label>
            <input type="text" class="form-control" placeholder="prenom" name="prenom" value="<?php echo $_SESSION['prenom'] ?>">
        </div>
        <div>
            <label for="exampleInputEmail1" class="form-label mt-4">Adresse Email</label>
            <input type="text" class="form-control" placeholder="Email" name="email" value="<?php echo $_SESSION['email'] ?>">
        </div>
        <div>
            <br>
            <p>Photo de profile</p>
            <img src="./uploads/<?= $_SESSION['photo'] ?>" alt="" width="100px" height="100px">
        </div>
        <div>
            <label for="exampleInputEmail1" class="form-label mt-4">Adresse</label>
            <input type="text" class="form-control" placeholder="Adresse" name="adresse" value="<?php echo $_SESSION['adresse'] ?>">
        </div>
        <div>
            <label for="exampleInputEmail1" class="form-label mt-4">Code Postale</label>
            <input type="text" class="form-control" placeholder="Code" name="code" value="<?php echo $_SESSION['code_postal'] ?>">
        </div>
        <div>
            <label for="exampleInputEmail1" class="form-label mt-4">Ville</label>
            <input type="text" class="form-control" placeholder="Ville" name="ville" value="<?php echo $_SESSION['ville'] ?>">
        </div>
        <div>
            <label for="exampleInputEmail1" class="form-label mt-4">Date de naissance</label>
            <input type="text" class="form-control" placeholder="Date" name="date" value="<?php echo $_SESSION['date'] ?>">
        </div>
        <div>
            <label for="exampleInputEmail1" class="form-label mt-4">Numéro de téléphone</label>
            <input type="text" class="form-control" placeholder="Phone" name="phone" value="<?php echo $_SESSION['phone'] ?>">
        </div>
    </form>
</div>