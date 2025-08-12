<?php
session_start();
error_reporting(0);
include("dbconnection.php");

if(isset($_SESSION['patientid'])) {
    header("Location: patientaccount.php");
    exit;
}

$err = '';
$success = '';

if(isset($_POST['register'])) {
    // Sanitize inputs
    $patientname = mysqli_real_escape_string($con, trim($_POST['patientname']));
    $mobileno = mysqli_real_escape_string($con, trim($_POST['mobileno']));
    $gender = mysqli_real_escape_string($con, trim($_POST['gender']));
    $bloodgroup = mysqli_real_escape_string($con, trim($_POST['bloodgroup']));
    $address = mysqli_real_escape_string($con, trim($_POST['address']));
    $loginid = mysqli_real_escape_string($con, trim($_POST['loginid']));
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $email = mysqli_real_escape_string($con, trim($_POST['email']));
    $dt = date("Y-m-d");
    $tim = date("H:i:s");
    
    // Validate required fields again on server side
    if (empty($patientname) || empty($mobileno) || empty($gender) || empty($bloodgroup) || empty($address) || empty($loginid) || empty($password) || empty($confirmpassword) || empty($email)) {
        $err = "<div class='alert alert-danger'><strong>Erreur !</strong> Tous les champs sont obligatoires.</div>";
    }
    else if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM patient WHERE loginid='$loginid'")) > 0) {
        $err = "<div class='alert alert-danger'><strong>Erreur !</strong> Ce Login ID existe déjà. Veuillez en choisir un autre.</div>";
    }
    else if($password !== $confirmpassword) {
        $err = "<div class='alert alert-danger'><strong>Erreur !</strong> Les mots de passe ne correspondent pas.</div>";
    }
    else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO patient (patientname, mobileno, gender, bloodgroup, address, loginid, password, email, status, creationdate, creationtime) 
                VALUES ('$patientname', '$mobileno', '$gender', '$bloodgroup', '$address', '$loginid', '$hashed_password', '$email', 'Active', '$dt', '$tim')";
        if(mysqli_query($con, $sql)) {
            // Redirect to login page on success
            header("Location: patientlogin.php");
            exit;
        } else {
            $err = "<div class='alert alert-danger'><strong>Erreur !</strong> L'inscription a échoué. Veuillez réessayer.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>HMS - Inscription Patient</title>
<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<!-- Custom Css -->
<link href="assets/css/main.css" rel="stylesheet" />
<link href="assets/css/login.css" rel="stylesheet" />
<link href="assets/css/themes/all-themes.css" rel="stylesheet" />
</head>
<body class="theme-cyan login-page authentication" style="background-image:url('images/login.jpeg');background-repeat: no-repeat;background-size: 100%">

<div class="container">
    <div id="err"><?php echo $err . $success; ?></div>
    <div class="card-top"></div>
    <div class="card">
        <h1 class="title"><span>DOCTO LINK</span> Inscription Patient</h1>
        <div class="col-md-12">
            <form method="post" action="" name="frmpatientreg" id="frmpatientreg" onsubmit="return validateform()">
                <div class="input-group"> 
                    <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                    <div class="form-line">
                        <input type="text" name="patientname" id="patientname" class="form-control" placeholder="Nom complet" required />
                    </div>
                </div>
                <div class="input-group"> 
                    <span class="input-group-addon"><i class="zmdi zmdi-phone"></i></span>
                    <div class="form-line">
                        <input type="text" name="mobileno" id="mobileno" class="form-control" placeholder="Numéro de téléphone" required />
                    </div>
                </div>
                <div class="input-group"> 
                    <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                    <div class="form-line">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Adresse e-mail" required />
                    </div>
                </div>
                <div class="input-group"> 
                    <span class="input-group-addon"><i class="zmdi zmdi-male-female"></i></span>
                    <div class="form-line">
                        <select name="gender" id="gender" class="form-control" required>
                            <option value="">-- Sélectionner le sexe --</option>
                            <option value="Male">Homme</option>
                            <option value="Female">Femme</option>
                            <option value="Other">Autre</option>
                        </select>
                    </div>
                </div>
                <div class="input-group"> 
                    <span class="input-group-addon"><i class="zmdi zmdi-favorite"></i></span>
                    <div class="form-line">
                        <select name="bloodgroup" id="bloodgroup" class="form-control" required>
                            <option value="">-- Sélectionner le groupe sanguin --</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                </div>
                <div class="input-group"> 
                    <span class="input-group-addon"><i class="zmdi zmdi-home"></i></span>
                    <div class="form-line">
                        <textarea name="address" id="address" class="form-control" placeholder="Adresse" required></textarea>
                    </div>
                </div>
                <div class="input-group"> 
                    <span class="input-group-addon"><i class="zmdi zmdi-account-circle"></i></span>
                    <div class="form-line">
                        <input type="text" name="loginid" id="loginid" class="form-control" placeholder="Identifiant" required />
                    </div>
                </div>
                <div class="input-group"> 
                    <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                    <div class="form-line">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe (min 8 caractères)" required />
                    </div>
                </div>
                <div class="input-group"> 
                    <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                    <div class="form-line">
                        <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirmer le mot de passe" required />
                    </div>
                </div>
                <div>
                    <div class="text-center">
                        <input type="submit" name="register" id="register" value="S'inscrire" class="btn btn-raised waves-effect g-bg-cyan" />
                        <a href="patientlogin.php" class="btn btn-raised waves-effect">Déjà inscrit ? Connectez-vous</a>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>

<script type="application/javascript">
var alphaExp = /^[a-zA-Z\s]+$/; // Lettres et espaces seulement
var numericExpression = /^[0-9]+$/; // Chiffres seulement
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,4}$/; // Format email

function validateform() {
    const form = document.forms['frmpatientreg'];
    if(form.patientname.value.trim() === "") {
        alert("Le nom du patient ne doit pas être vide.");
        form.patientname.focus();
        return false;
    }
    if(!form.patientname.value.match(alphaExp)) {
        alert("Le nom du patient n'est pas valide.");
        form.patientname.focus();
        return false;
    }
    if(form.mobileno.value.trim() === "") {
        alert("Le numéro de téléphone ne doit pas être vide.");
        form.mobileno.focus();
        return false;
    }
    if(!form.mobileno.value.match(numericExpression)) {
        alert("Le numéro de téléphone doit contenir uniquement des chiffres.");
        form.mobileno.focus();
        return false;
    }
    if(form.email.value.trim() === "") {
        alert("L'adresse e-mail ne doit pas être vide.");
        form.email.focus();
        return false;
    }
    if(!form.email.value.match(emailExp)) {
        alert("Le format de l'adresse e-mail est invalide.");
        form.email.focus();
        return false;
    }
    if(form.gender.value === "") {
        alert("Le sexe doit être sélectionné.");
        form.gender.focus();
        return false;
    }
    if(form.bloodgroup.value === "") {
        alert("Le groupe sanguin doit être sélectionné.");
        form.bloodgroup.focus();
        return false;
    }
    if(form.address.value.trim() === "") {
        alert("L'adresse ne doit pas être vide.");
        form.address.focus();
        return false;
    }
    if(form.loginid.value.trim() === "") {
        alert("L'identifiant ne doit pas être vide.");
        form.loginid.focus();
        return false;
    }
    if(!form.loginid.value.match(/^[0-9a-zA-Z]+$/)) {
        alert("L'identifiant n'est pas valide.");
        form.loginid.focus();
        return false;
    }
    if(form.password.value === "") {
        alert("Le mot de passe ne doit pas être vide.");
        form.password.focus();
        return false;
    }
    if(form.password.value.length < 8) {
        alert("Le mot de passe doit contenir au moins 8 caractères.");
        form.password.focus();
        return false;
    }
    if(form.password.value !== form.confirmpassword.value) {
        alert("Le mot de passe et la confirmation doivent correspondre.");
        form.confirmpassword.focus();
        return false;
    }
    return true;
}
</script>
</body>
</html>
