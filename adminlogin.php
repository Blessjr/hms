<?php 
session_start();
error_reporting(0);
include("dbconnection.php");

if (isset($_SESSION['adminid'])) {
    echo "<script>window.location='adminaccount.php';</script>";
    exit;
}

$err = '';
if (isset($_POST["submit"])) {
    $sql = "SELECT adminid, password, status FROM admin WHERE loginid = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $_POST['loginid']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if ($row['status'] === 'Active') {
            $input_password = $_POST['password'];

            // Try verifying as hashed password, if fails compare plain text
            if (password_verify($input_password, $row['password']) || $input_password === $row['password']) {
                $_SESSION['adminid'] = $row['adminid'];
                echo "<script>window.location='adminaccount.php';</script>";
                exit;
            } else {
                $err = "<div class='alert alert-danger'><strong>Oh !</strong> Nom d'utilisateur ou mot de passe incorrect.</div>";
            }
        } else {
            $err = "<div class='alert alert-danger'><strong>Oh !</strong> Compte désactivé. Contactez l'administrateur.</div>";
        }
    } else {
        $err = "<div class='alert alert-danger'><strong>Oh !</strong> Nom d'utilisateur ou mot de passe incorrect.</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>Administration de l'Hôpital</title>
<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- Custom Css -->
<link href="assets/css/main.css" rel="stylesheet">
<link href="assets/css/login.css" rel="stylesheet">
<!-- Swift Themes -->
<link href="assets/css/themes/all-themes.css" rel="stylesheet" />
</head>
<body class="theme-cyan login-page authentication" style="background-image:url('images/login.jpeg');background-repeat: no-repeat;background-size: 100%">

<div class="container">
    <div id="err"><?php echo $err; ?></div>
    <div class="card-top"></div>
    <div class="card">
        <h1 class="title"><span>DOCTO LINK</span> Connexion <span class="msg">Connectez-vous pour démarrer votre session</span></h1>
        <div class="col-md-12">

            <form method="post" action="" name="frmadminlogin" id="sign_in" onSubmit="return validateform()">
                <div class="input-group">
                    <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                    <div class="form-line">
                        <input type="text" name="loginid" id="loginid" class="form-control" placeholder="Nom d'utilisateur" />
                    </div>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                    <div class="form-line">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" />
                    </div>
                </div>
                <div>
                    <div class="text-center">
                        <input type="submit" name="submit" id="submit" value="Se connecter" class="btn btn-raised waves-effect g-bg-cyan" />
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>
<div class="clear"></div>
<div class="theme-bg"></div>

<!-- Jquery Core Js --> 
<script src="assets/bundles/libscripts.bundle.js"></script>
<script src="assets/bundles/vendorscripts.bundle.js"></script>
<script src="assets/bundles/mainscripts.bundle.js"></script>

<script type="application/javascript">
var alphanumericExp = /^[0-9a-zA-Z]+$/;

function validateform()
{
    var loginid = document.frmadminlogin.loginid.value.trim();
    var password = document.frmadminlogin.password.value;

    if(loginid == "")
    {
        document.getElementById("err").innerHTML ="<div class='alert alert-info'><strong>Attention !</strong> Veuillez entrer le nom d'utilisateur</div>";
        document.frmadminlogin.loginid.focus();
        return false;
    }
    else if(!alphanumericExp.test(loginid))
    {
        document.getElementById("err").innerHTML ="<div class='alert alert-warning'><strong>Attention !</strong> Nom d'utilisateur invalide</div>";
        document.frmadminlogin.loginid.focus();
        return false;
    }
    else if(password == "")
    {
        document.getElementById("err").innerHTML ="<div class='alert alert-info'><strong>Attention !</strong> Le mot de passe ne doit pas être vide</div>";
        document.frmadminlogin.password.focus();
        return false;
    }
    else if(password.length < 8)
    {
        document.getElementById("err").innerHTML ="<div class='alert alert-info'><strong>Attention !</strong> La longueur doit être d'au moins 8 caractères</div>";
        document.frmadminlogin.password.focus();
        return false;
    }
    else
    {
        return true;
    }
}
</script>
</body>
</html>
