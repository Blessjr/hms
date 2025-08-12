<?php
session_start();
error_reporting(0);
include("dbconnection.php");

$dt = date("Y-m-d");
$tim = date("H:i:s");

if(isset($_SESSION['doctorid'])) {
    echo "<script>window.location='doctoraccount.php';</script>";
}

$err = '';
$success = '';

if(isset($_POST['register'])) {
    $doctorname = mysqli_real_escape_string($con, $_POST['doctorname']);
    $mobileno = mysqli_real_escape_string($con, $_POST['mobileno']);
    $department = mysqli_real_escape_string($con, $_POST['department']);
    $loginid = mysqli_real_escape_string($con, $_POST['loginid']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirmpassword = mysqli_real_escape_string($con, $_POST['confirmpassword']);
    $education = mysqli_real_escape_string($con, $_POST['education']);
    $experience = mysqli_real_escape_string($con, $_POST['experience']);
    $consultancy_charge = mysqli_real_escape_string($con, $_POST['consultancy_charge']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $pincode = mysqli_real_escape_string($con, $_POST['pincode']);
    
    $chkqry = "SELECT * FROM doctor WHERE loginid='$loginid'";
    $chkresult = mysqli_query($con, $chkqry);
    
    if(mysqli_num_rows($chkresult) > 0) {
        $err = "<div class='alert alert-danger'><strong>Erreur !</strong> L'identifiant existe déjà. Veuillez en choisir un autre.</div>";
    } elseif($password != $confirmpassword) {
        $err = "<div class='alert alert-danger'><strong>Erreur !</strong> Les mots de passe ne correspondent pas.</div>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO doctor (doctorname, mobileno, department, loginid, password, education, experience, consultancy_charge, address, city, pincode, status, creationdate, creationtime) 
                VALUES ('$doctorname', '$mobileno', '$department', '$loginid', '$hashed_password', '$education', '$experience', '$consultancy_charge', '$address', '$city', '$pincode', 'En attente', '$dt', '$tim')";
        
        if(mysqli_query($con, $sql)) {
            $success = "<div class='alert alert-success'><strong>Succès !</strong> Inscription soumise. Votre compte sera activé après approbation par l'administrateur.</div>";
        } else {
            $err = "<div class='alert alert-danger'><strong>Erreur !</strong> L'inscription a échoué. Veuillez réessayer.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>HMS - Inscription Médecin</title>
<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="assets/css/main.css" rel="stylesheet">
<link href="assets/css/login.css" rel="stylesheet">
<link href="assets/css/themes/all-themes.css" rel="stylesheet" />
</head>
<body class="theme-cyan login-page authentication" style="background-image:url('images/login.jpeg');background-repeat: no-repeat;background-size: 100%">

<div class="container">
    <div id="err"><?php echo $err; echo $success; ?></div>
    <div class="card-top"></div>
    <div class="card">
        <h1 class="title"><span>DOCTO LINK</span> Inscription Médecin</h1>
        <div class="col-md-12">
            <form method="post" action="" name="frmdoctorreg" id="sign_up" onSubmit="return validateform()">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="input-group"> 
                            <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                            <div class="form-line">
                                <input type="text" name="doctorname" id="doctorname" class="form-control" placeholder="Nom complet" required />
                            </div>
                        </div>
                        
                        <div class="input-group"> 
                            <span class="input-group-addon"><i class="zmdi zmdi-phone"></i></span>
                            <div class="form-line">
                                <input type="text" name="mobileno" id="mobileno" class="form-control" placeholder="Numéro de téléphone" required />
                            </div>
                        </div>
                        
                        <div class="input-group"> 
                            <span class="input-group-addon"><i class="zmdi zmdi-hospital"></i></span>
                            <div class="form-line">
                                <select name="department" id="department" class="form-control" required>
                                    <option value="">-- Sélectionnez un département --</option>
                                    <option value="Cardiologie">Cardiologie</option>
                                    <option value="Neurologie">Neurologie</option>
                                    <option value="Pédiatrie">Pédiatrie</option>
                                    <option value="Orthopédie">Orthopédie</option>
                                    <option value="Radiologie">Radiologie</option>
                                    <option value="Général">Général</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="input-group"> 
                            <span class="input-group-addon"><i class="zmdi zmdi-graduation-cap"></i></span>
                            <div class="form-line">
                                <input type="text" name="education" id="education" class="form-control" placeholder="Formation" required />
                            </div>
                        </div>
                        
                        <div class="input-group"> 
                            <span class="input-group-addon"><i class="zmdi zmdi-time"></i></span>
                            <div class="form-line">
                                <input type="text" name="experience" id="experience" class="form-control" placeholder="Expérience (en années)" required />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="input-group"> 
                            <span class="input-group-addon"><i class="zmdi zmdi-money"></i></span>
                            <div class="form-line">
                                <input type="text" name="consultancy_charge" id="consultancy_charge" class="form-control" placeholder="Frais de consultation" required />
                            </div>
                        </div>
                        
                        <div class="input-group"> 
                            <span class="input-group-addon"><i class="zmdi zmdi-home"></i></span>
                            <div class="form-line">
                                <input type="text" name="address" id="address" class="form-control" placeholder="Adresse" required />
                            </div>
                        </div>
                        
                        <div class="input-group"> 
                            <span class="input-group-addon"><i class="zmdi zmdi-city"></i></span>
                            <div class="form-line">
                                <input type="text" name="city" id="city" class="form-control" placeholder="Ville" required />
                            </div>
                        </div>
                        
                        <div class="input-group"> 
                            <span class="input-group-addon"><i class="zmdi zmdi-pin"></i></span>
                            <div class="form-line">
                                <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Code postal" required />
                            </div>
                        </div>
                        
                        <div class="input-group"> 
                            <span class="input-group-addon"><i class="zmdi zmdi-account-circle"></i></span>
                            <div class="form-line">
                                <input type="text" name="loginid" id="loginid" class="form-control" placeholder="Nom d'utilisateur" required />
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
                    </div>
                </div>
                
                <div class="text-center" style="clear: both; padding-top: 20px;">
                    <input type="submit" name="register" id="register" value="S'inscrire" class="btn btn-raised waves-effect g-bg-cyan" />
                    <a href="doctorlogin.php" class="btn btn-raised waves-effect">Déjà inscrit ? Connexion</a>
                </div>
            </form>
        </div>
    </div>    
</div>

<script src="assets/bundles/libscripts.bundle.js"></script> 
<script src="assets/bundles/vendorscripts.bundle.js"></script> 
<script src="assets/bundles/mainscripts.bundle.js"></script>

<script type="application/javascript">
var alphaExp = /^[a-zA-Z]+$/;
var alphaspaceExp = /^[a-zA-Z\s]+$/;
var numericExpression = /^[0-9]+$/;
var alphanumericExp = /^[0-9a-zA-Z]+$/;
var pinExp = /^[0-9]{4,6}$/;

function validateform() {
    if(document.frmdoctorreg.doctorname.value == "") {
        alert("Le nom du médecin ne doit pas être vide.");
        document.frmdoctorreg.doctorname.focus();
        return false;
    }
    else if(!document.frmdoctorreg.doctorname.value.match(alphaspaceExp)) {
        alert("Nom du médecin invalide.");
        document.frmdoctorreg.doctorname.focus();
        return false;
    }
    else if(document.frmdoctorreg.mobileno.value == "") {
        alert("Le numéro de téléphone ne doit pas être vide.");
        document.frmdoctorreg.mobileno.focus();
        return false;
    }
    else if(!document.frmdoctorreg.mobileno.value.match(numericExpression)) {
        alert("Le numéro de téléphone doit contenir uniquement des chiffres.");
        document.frmdoctorreg.mobileno.focus();
        return false;
    }
    else if(document.frmdoctorreg.department.value == "") {
        alert("Veuillez sélectionner un département.");
        document.frmdoctorreg.department.focus();
        return false;
    }
    else if(document.frmdoctorreg.address.value == "") {
        alert("L'adresse ne doit pas être vide.");
        document.frmdoctorreg.address.focus();
        return false;
    }
    else if(document.frmdoctorreg.city.value == "") {
        alert("La ville ne doit pas être vide.");
        document.frmdoctorreg.city.focus();
        return false;
    }
    else if(document.frmdoctorreg.pincode.value == "") {
        alert("Le code postal ne doit pas être vide.");
        document.frmdoctorreg.pincode.focus();
        return false;
    }
    else if(!document.frmdoctorreg.pincode.value.match(pinExp)) {
        alert("Code postal invalide (4-6 chiffres).");
        document.frmdoctorreg.pincode.focus();
        return false;
    }
    else if(document.frmdoctorreg.loginid.value == "") {
        alert("L'identifiant ne doit pas être vide.");
        document.frmdoctorreg.loginid.focus();
        return false;
    }
    else if(!document.frmdoctorreg.loginid.value.match(alphanumericExp)) {
        alert("Identifiant invalide.");
        document.frmdoctorreg.loginid.focus();
        return false;
    }
    else if(document.frmdoctorreg.password.value == "") {
        alert("Le mot de passe ne doit pas être vide.");
        document.frmdoctorreg.password.focus();
        return false;
    }
    else if(document.frmdoctorreg.password.value.length < 8) {
        alert("Le mot de passe doit contenir au moins 8 caractères.");
        document.frmdoctorreg.password.focus();
        return false;
    }
    else if(document.frmdoctorreg.password.value != document.frmdoctorreg.confirmpassword.value) {
        alert("Les mots de passe ne correspondent pas.");
        document.frmdoctorreg.confirmpassword.focus();
        return false;
    }
}
</script>
</body>
</html>