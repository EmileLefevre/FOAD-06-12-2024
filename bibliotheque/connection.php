<?php

include "pdo.php";
include('header.php');

$error = null;
if (isset($_POST['connexion'])) {
    $sql = "select * from  abonne where email = :email";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'email' => $_POST['email']
    ]);
    $abonne = $statement->fetch();
    if (password_verify($_POST['password'], $abonne['password'])) {
        header("location:list_livre.php");
        $_SESSION['connection'] = true;
        $_SESSION['nom'] = $abonne['nom'];
        $_SESSION['prenom'] = $abonne['prenom'];
        $_SESSION['email'] = $abonne['email'];
        $_SESSION['date'] = $abonne['date'];
        $_SESSION['phone'] = $abonne['phone'];
        $_SESSION['code_postal'] = $abonne['code_postal'];
        $_SESSION['adresse'] = $abonne['adresse'];
        $_SESSION['ville'] = $abonne['ville'];
        $_SESSION['photo'] = $abonne['photo'];
    } else {
        $error = "Email ou mot de passe incorrect";
        $_SESSION['connection'] = false;
    }
}
?>
<h1>Connection</h1>
<div class="formulaire">
    <form action="" method="post">
        <?php if (empty($error)) { ?>
            <div>
            <label for="exampleInputEmail1" class="form-label mt-4">Email:</label>
            <input type="email" class="form-control" placeholder="email" name="email">
        </div>
                    <?php } ?>
        <?php if (!empty($error)) { ?>
            <div class="has-danger">
                <label for="exampleInputEmail1" class="form-label mt-4">Email: </label>
                <input type="text" class="form-control is-invalid" placeholder="Email" name="email">
                <div class="invalid-feedback"><?php echo $error ?></p>
                </div>
            </div>
        <?php } ?>
        <div>
            <label for="exampleInputEmail1" class="form-label mt-4">Mot de passe:</label>
            <input type="password" class="form-control" placeholder="password" name="password">
        </div>
        <button type="submit" class="btn btn-success mt-4" name="connexion">Connexion</button>
        <button type="button" class="btn btn-outline-success mt-4"><a href="inscription.php">Vous n'avez pas de compte ?</a></button>
    </form>
</div>
</body>
</html>