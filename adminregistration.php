<?php
session_start();
error_reporting(0);
include("dbconnection.php");

$dt = date("Y-m-d");
$tim = date("H:i:s");

if (isset($_SESSION['adminid'])) {
    echo "<script>window.location='adminaccount.php';</script>";
    exit;
}

$err = '';
$success = '';

if (isset($_POST['register'])) {
    // Trim inputs to avoid accidental spaces
    $adminname = trim($_POST['adminname']);
    $mobileno = trim($_POST['mobileno']);
    $email = trim($_POST['email']);
    $loginid = trim($_POST['loginid']);
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $department = trim($_POST['department']);

    // Validate server side (you already have client-side too)
    if ($password !== $confirmpassword) {
        $err = "<div class='alert alert-danger'><strong>Erreur !</strong> Les mots de passe ne correspondent pas.</div>";
    } else {
        // Check if loginid already exists (use prepared statement)
        $stmt = $con->prepare("SELECT adminid FROM admin WHERE loginid = ?");
        $stmt->bind_param("s", $loginid);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $err = "<div class='alert alert-danger'><strong>Erreur !</strong> L'identifiant de connexion existe déjà. Veuillez en choisir un autre.</div>";
        } else {
            // Hash password securely
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new admin with prepared statement
            $insert_stmt = $con->prepare("INSERT INTO admin (adminname, mobileno, email, loginid, password, department, status, creationdate, creationtime) VALUES (?, ?, ?, ?, ?, ?, 'Actif', ?, ?)");
            $insert_stmt->bind_param("ssssssss", $adminname, $mobileno, $email, $loginid, $hashed_password, $department, $dt, $tim);

            if ($insert_stmt->execute()) {
                $success = "<div class='alert alert-success'><strong>Succès !</strong> Inscription de l'administrateur complétée.</div>";
            } else {
                $err = "<div class='alert alert-danger'><strong>Erreur !</strong> L'inscription a échoué. Veuillez réessayer.</div>";
            }
            $insert_stmt->close();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>HMS - Inscription Administrateur</title>
<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- Custom Css -->
<link href="assets/css/main.css" rel="stylesheet">
<link href="assets/css/login.css" rel="stylesheet">
<link href="assets/css/themes/all-themes.css" rel="stylesheet" />
</head>
<body class="theme-cyan login-page authentication" style="background-image:url('images/login.jpeg');background-repeat: no-repeat;background-size: 100%">

<div class="container">
    <div id="err"><?php echo $err; echo $success; ?></div>
    <div class="card-top"></div>
    <div class="card">
        <h1 class="title"><span>DOCTO LINK</span> Inscription Administrateur</h1>
        <div class="col-md-12">
<form method="post" action="" name="frmadminreg" id="sign_up" onSubmit="return validateform()" 
      style="max-width: 900px; width: 100%; margin: 0 auto; background: rgba(255, 255, 255, 0.98); padding: 25px; border-radius: 10px;">
    <style>
        /* Form container width */
        #sign_up {
            max-width: 1200px; /* wider than default */
            margin: 0 auto; /* center horizontally */
            background: rgba(255, 255, 255, 0.95); /* light background for visibility */
            padding: 25px;
            border-radius: 10px;
        }
        /* Ensure inputs are fully visible */
        .form-control {
            height: 45px;
            padding: 10px 12px;
            font-size: 15px;
            width: 100%;
        }
        select.form-control {
            height: 45px !important;
        }
        .input-group-addon {
            background-color: #f5f5f5;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 12px;
        }
        .input-group {
            margin-bottom: 20px;
            width: 100%;
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            #sign_up {
                max-width: 100%;
                padding: 15px;
            }
        }
    </style>

    <div class="row">
        <!-- Admin Name -->
        <div class="col-md-6">
            <div class="input-group"> 
                <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                <div class="form-line">
                    <input type="text" name="adminname" id="adminname" class="form-control" placeholder="Nom complet" required />
                </div>
            </div>
        </div>

        <!-- Mobile Number -->
        <div class="col-md-6">
            <div class="input-group"> 
                <span class="input-group-addon"><i class="zmdi zmdi-phone"></i></span>
                <div class="form-line">
                    <input type="text" name="mobileno" id="mobileno" class="form-control" placeholder="Numéro de téléphone" required />
                </div>
            </div>
        </div>

        <!-- Email -->
        <div class="col-md-6">
            <div class="input-group"> 
                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                <div class="form-line">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Adresse e-mail" required />
                </div>
            </div>
        </div>

        <!-- Department -->
        <div class="col-md-6">
            <div class="input-group"> 
                <span class="input-group-addon"><i class="zmdi zmdi-hospital"></i></span>
                <div class="form-line">
                    <select name="department" id="department" class="form-control" required>
                        <option value="">-- Sélectionner un département --</option>
                        <option value="Administration">Administration</option>
                        <option value="RH">Ressources Humaines</option>
                        <option value="Finance">Finance</option>
                        <option value="IT">Technologies de l'information</option>
                        <option value="Opérations">Opérations</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Login ID -->
        <div class="col-md-6">
            <div class="input-group"> 
                <span class="input-group-addon"><i class="zmdi zmdi-account-circle"></i></span>
                <div class="form-line">
                    <input type="text" name="loginid" id="loginid" class="form-control" placeholder="Nom d'utilisateur" required />
                </div>
            </div>
        </div>

        <!-- Password -->
        <div class="col-md-6">
            <div class="input-group"> 
                <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                <div class="form-line">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe (min 8 caractères)" required />
                </div>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="col-md-6">
            <div class="input-group"> 
                <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                <div class="form-line">
                    <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirmer le mot de passe" required />
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Buttons -->
    <div class="text-center" style="margin-top: 20px;">
        <input type="submit" name="register" id="register" value="S'INSCRIRE" class="btn btn-raised waves-effect g-bg-cyan" />
        <a href="adminlogin.php" class="btn btn-raised waves-effect">Déjà un compte ? Connexion</a>
    </div>
</form>
        </div>
    </div>    
</div>

<script src="assets/bundles/libscripts.bundle.js"></script>
<script src="assets/bundles/vendorscripts.bundle.js"></script>
<script src="assets/bundles/mainscripts.bundle.js"></script>

<script type="application/javascript">
var alphaspaceExp = /^[a-zA-Z\s]+$/;
var numericExpression = /^[0-9]+$/;
var alphanumericExp = /^[0-9a-zA-Z]+$/;
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,4}$/;

function validateform() {
    if(document.frmadminreg.adminname.value == "") {
        alert("Le nom de l'administrateur ne doit pas être vide.");
        document.frmadminreg.adminname.focus();
        return false;
    }
    else if(!document.frmadminreg.adminname.value.match(alphaspaceExp)) {
        alert("Nom de l'administrateur non valide.");
        document.frmadminreg.adminname.focus();
        return false;
    }
    else if(document.frmadminreg.mobileno.value == "") {
        alert("Le numéro de téléphone ne doit pas être vide.");
        document.frmadminreg.mobileno.focus();
        return false;
    }
    else if(!document.frmadminreg.mobileno.value.match(numericExpression)) {
        alert("Le numéro de téléphone doit contenir uniquement des chiffres.");
        document.frmadminreg.mobileno.focus();
        return false;
    }
    else if(document.frmadminreg.email.value == "") {
        alert("L'adresse e-mail ne doit pas être vide.");
        document.frmadminreg.email.focus();
        return false;
    }
    else if(!document.frmadminreg.email.value.match(emailExp)) {
        alert("Format d'e-mail invalide.");
        document.frmadminreg.email.focus();
        return false;
    }
    else if(document.frmadminreg.department.value == "") {
        alert("Veuillez sélectionner un département.");
        document.frmadminreg.department.focus();
        return false;
    }
    else if(document.frmadminreg.loginid.value == "") {
        alert("L'identifiant de connexion ne doit pas être vide.");
        document.frmadminreg.loginid.focus();
        return false;
    }
    else if(!document.frmadminreg.loginid.value.match(alphanumericExp)) {
        alert("Identifiant de connexion non valide.");
        document.frmadminreg.loginid.focus();
        return false;
    }
    else if(document.frmadminreg.password.value == "") {
        alert("Le mot de passe ne doit pas être vide.");
        document.frmadminreg.password.focus();
        return false;
    }
    else if(document.frmadminreg.password.value.length < 8) {
        alert("Le mot de passe doit comporter plus de 8 caractères.");
        document.frmadminreg.password.focus();
        return false;
    }
    else if(document.frmadminreg.password.value != document.frmadminreg.confirmpassword.value) {
        alert("Les mots de passe doivent correspondre.");
        document.frmadminreg.confirmpassword.focus();
        return false;
    }
    else {
        return true;
    }
}
</script>
</body>
</html>
