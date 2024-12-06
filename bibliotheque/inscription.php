<?php

include "pdo.php";
include('header.php');

function valideDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    if ($d && $d->format($format) == $date) {
        return true;
    } else {
        return false;
    }
}

$error_name = null;
$error_firstname = null;
$error_email = null;
$error_date = null;
$error_phone = null;
$error_zip_code = null;
$error_adress = null;
$error_city = null;
$error_password = null;
$error_photo = null;

@$nom = strip_tags($_POST["nom"]);
@$prenom = strip_tags($_POST["prenom"]);
@$email = strip_tags($_POST["email"]);
$password = @$_POST["password"];
@$adress = strip_tags($_POST["adresse"]);
@$zip_code = strip_tags($_POST["code-postal"]);
@$city = strip_tags($_POST["ville"]);
@$date = strip_tags($_POST["date"]);
@$phone = strip_tags($_POST["phone"]);
@$photo = strip_tags($_POST["file"]);

if (isset($_POST['envoyer'])) {
    if (empty($nom)) {
        $error_name = "<p>Le nom est obligatoire </p>";
    } elseif (strlen($nom) < 2 || strlen($nom) > 50) {
        $error_name .= "<p>Votre nom n'est pas conforme </p>";
    }
    if (empty($prenom)) {
        $error_firstname .= "<p>Le prenom est obligatoire </p>";
    } elseif (strlen($prenom) < 2 || strlen($prenom) > 30) {
        $error_firstname .= "<p>Votre prenom n'est pas conforme</p>";
    }
    if (empty($email)) {
        $error_email .= "<p>L'email est obligatoire</p>";
    } elseif (!preg_match(" /^[^\W][a-zA-Z0-9]+(.[a-zA-Z0-9]+)@[a-zA-Z0-9]+(.[a-zA-Z0-9]+).[a-zA-Z]{2,4}$/ ", $email)) {
        $error_email .= "<p>l'email n'est pas valide</p>";
    }
    if (empty($password)) {
        $error_password .= "<li>Veuillez entrer un mot de passe</li>";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
    }
    if (empty($date)) {
        $error_date .= "<p>La date doit être renseigné</p>";
    } elseif (valideDate($date) === false) {
        $error_date .= "<p>La date n'est pas conforme</p>";
    }
    if (!empty($phone)) {
        if (!preg_match("#^0[1-9]{1}\d{8}$#", $phone)) {
            $error_phone .= "<p>Le numero de téléphone n'est pas conforme</p>";
        }
    }
    if (empty($zip_code)) {
        $error_zip_code .= "<p>Votre code postal doit être renseigné</p>";
    } elseif (!preg_match("/^[0-9]{5,5}$/ ", $zip_code)) {
        $error_zip_code .= "<p>Le code postal n'est pas conforme</p>";
    }
    if (empty($adress)) {
        $error_adress .= "<p>Votre adresse doit être renseigné</p>";
    }
    if (empty($city)) {
        $error_city .= "<p>Votre ville doit être renseigné</p>";
    }
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];
        $fileError = $_FILES['file']['error'];
        $uploadDirectory = 'uploads/';
        $targetFile = $uploadDirectory . basename($fileName);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($fileType, $allowedTypes)) {
            if ($fileSize <= 2 * 1024 * 1024) {
                if (move_uploaded_file($fileTmpName, $targetFile)) {
                    $photo = $fileName;
                } else {
                    $error_photo = "<p>Une erreur est survenue lors de l'upload de la photo.</p>";
                }
            } else {
                $error_photo = "<p>Le fichier est trop volumineux (maximum 2 Mo).</p>";
            }
        } else {
            $error_photo = "<p>Seules les images (JPG, PNG, GIF) sont autorisées.</p>";
        }
    } else {
        $error_photo = "<p>Aucune photo n'a été téléchargée ou une erreur est survenue.</p>";
    }
    if (empty($error_name) && empty($error_firstname) && empty($error_email) && empty($error_date) && empty($error_zip_code) && empty($error_adress) && empty($error_city) && empty($error_password)) {
        try {
            $sql = "INSERT INTO abonne(nom, prenom, email, password, date, phone, code_postal, adresse, ville, photo) VALUES (:nom, :prenom, :email, :password, :date, :phone, :code_postal, :adresse, :ville, :photo)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                "nom" => $nom,
                "prenom" => $prenom,
                "email" => $email,
                "password" => $hash,
                "date" => $date,
                "phone" => $phone,
                "code_postal" => $zip_code,
                "adresse" => $adress,
                "ville" => $city,
                "photo" => $photo
            ]);
            header("location: connection.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>

<div class="formulaire">
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <?php if (empty($error_name)) { ?>
                <label for="exampleInputEmail1" class="form-label mt-4">Nom: </label>
                <input type="text" class="form-control" placeholder="Nom" name="nom" value="<?php echo @$_POST['nom'] ?>">
            <?php } ?>
            <?php if (!empty($error_name)) { ?>
                <div class="has-danger">
                    <label for="exampleInputEmail1" class="form-label mt-4">Nom: </label>
                    <input type="text" class="form-control is-invalid" placeholder="Nom" name="nom">
                    <div class="invalid-feedback"><?php echo $error_name ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div>
            <?php if (empty($error_firstname)) { ?>
                <label for="exampleInputEmail1" class="form-label mt-4">Prenom</label>
                <input type="text" class="form-control" placeholder="Prenom" name="prenom" value="<?php echo @$_POST['prenom'] ?>">
            <?php } ?>
            <?php if (!empty($error_firstname)) { ?>
                <div class="has-danger">
                    <label for="exampleInputEmail1" class="form-label mt-4">Prenom: </label>
                    <input type="text" class="form-control is-invalid" placeholder="Prenom" name="prenom">
                    <div class="invalid-feedback"><?php echo $error_firstname ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div>
            <?php if (empty($error_email)) { ?>
                <label for="exampleInputEmail1" class="form-label mt-4">Email</label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="email" value="<?php echo @$_POST['email'] ?>">
            <?php } ?>
            <?php if (!empty($error_email)) { ?>
                <div class="has-danger">
                    <label for="exampleInputEmail1" class="form-label mt-4">Email: </label>
                    <input type="text" class="form-control is-invalid" placeholder="Email" name="email"">
                        <div class=" invalid-feedback"><?php echo $error_email ?></p>
                </div>
            <?php } ?>
        </div>
        <div>
            <?php if (empty($error_password)) { ?>
                <label for="exampleInputPassword1" class="form-label mt-4">Mot de passe</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe" name="password">
            <?php } ?>
            <?php if (!empty($error_password)) { ?>
                <div class="has-danger">
                    <label for="exampleInputPassword1" class="form-label mt-4">Mot de passe: </label>
                    <input type="password" class="form-control is-invalid" placeholder="Mot de passe" name="password">
                    <div class=" invalid-feedback"><?php echo $error_password ?></p>
                    </div>
                <?php } ?>
                </div>
                <div>
                    <?php if (empty($error_adress)) { ?>
                        <label for="exampleInputPassword1" class="form-label mt-4">Adresse</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Adresse" name="adresse" value="<?php echo @$_POST['adresse'] ?>">
                    <?php } ?>
                    <?php if (!empty($error_adress)) { ?>
                        <div class="has-danger">
                            <label for="exampleInputEmail1" class="form-label mt-4">Adresse: </label>
                            <input type="text" class="form-control is-invalid" placeholder="Adresse" name="adresse">
                            <div class="invalid-feedback"><?php echo $error_adress ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div>
                    <?php if (empty($error_zip_code)) { ?>
                        <label for="exampleInputPassword1" class="form-label mt-4">Code postal</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Code postal" name="code-postal" value="<?php echo @$_POST['code-postal'] ?>">
                    <?php } ?>
                    <?php if (!empty($error_zip_code)) { ?>
                        <div class="has-danger">
                            <label for="exampleInputEmail1" class="form-label mt-4">Code postal: </label>
                            <input type="text" class="form-control is-invalid" placeholder="code postal" name="code-postal">
                            <div class="invalid-feedback"><?php echo $error_zip_code ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div>
                    <?php if (empty($error_city)) { ?>
                        <label for="exampleInputPassword1" class="form-label mt-4">Ville</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Ville" name="ville" value="<?php echo @$_POST['ville'] ?>">
                    <?php } ?>
                    <?php if (!empty($error_city)) { ?>
                        <div class="has-danger">
                            <label for="exampleInputEmail1" class="form-label mt-4">Ville: </label>
                            <input type="text" class="form-control is-invalid" placeholder="Ville" name="ville" value="<?php echo @$_POST['ville'] ?>">
                            <div class="invalid-feedback"><?php echo $error_city ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div>
                    <?php if (empty($error_date)) { ?>
                        <label for="" class="form-label mt-4">Date de naissance</label>
                        <input type="date" class="form-control" id="exampleInputPassword1" placeholder="date" name="date" value="<?php echo @$_POST['date'] ?>">
                    <?php } ?>
                    <?php if (!empty($error_date)) { ?>
                        <div class="has-danger">
                            <label for="exampleInputEmail1" class="form-label mt-4">Date de naissance: </label>
                            <input type="date" class="form-control is-invalid" placeholder="date de naissance" name="date">
                            <div class="invalid-feedback"><?php echo $error_date ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div>
                    <?php if (empty($error_phone)) { ?>
                        <label for="" class="form-label mt-4">Numero de téléphone</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="..-..-..-..-.." name="phone" value="<?php echo @$_POST['phone'] ?>">
                    <?php } ?>
                    <?php if (!empty($error_phone)) { ?>
                        <div class="has-danger">
                            <label for="exampleInputEmail1" class="form-label mt-4">Numero de téléphone: </label>
                            <input type="text" class="form-control is-invalid" placeholder="..-..-..-..-.." name="phone">
                            <div class="invalid-feedback"><?php echo $error_phone ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div>
                <?php if (empty($error_photo)) { ?>
                    <label for="formFile" class="form-label mt-4">Photo de profil</label>
                    <input class="form-control" type="file" id="File" name="file">
                <?php } ?>
                <?php if (!empty($error_photo)) { ?>
                    <div class="has-danger">
                        <label for="formFile" class="form-label mt-4">Photo de profil: </label>
                        <input class="form-control is-invalid" type="file" id="File" name="file">
                        <div class="invalid-feedback"><?php echo $error_photo ?></p>
                        </div>
                    </div>    
                <?php } ?>
                </div>
                <button type="submit" class="btn btn-success mt-4" name="envoyer">Envoyer</button>
    </form>
</div>
<?php include('footer.php') ?>
</body>

</html>