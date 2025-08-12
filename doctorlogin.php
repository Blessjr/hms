<?php
session_start();
error_reporting(0);
include("dbconnection.php");

if (isset($_SESSION['doctorid'])) {
    echo "<script>window.location='doctoraccount.php';</script>";
    exit;
}

$err = '';

if (isset($_POST['submit'])) {
    $loginid = $_POST['loginid'];
    $input_password = $_POST['password'];

    $sql = "SELECT doctorid, password, status FROM doctor WHERE loginid=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $loginid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if ($row['status'] !== 'Active') {
            $err = "<div class='alert alert-danger'><strong>Compte inactif.</strong></div>";
        } else {
            // Check hashed password first, then fallback to plain password for legacy support
            if (password_verify($input_password, $row['password']) || $input_password === $row['password']) {
                $_SESSION['doctorid'] = $row['doctorid'];
                header("Location: doctoraccount.php");
                exit;
            } else {
                $err = "<div class='alert alert-danger'><strong>Identifiants de connexion invalides.</strong></div>";
            }
        }
    } else {
        $err = "<div class='alert alert-danger'><strong>Identifiants de connexion invalides.</strong></div>";
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
<title>DOCTO LINK - Administration</title>
<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="assets/css/main.css" rel="stylesheet">
<link href="assets/css/login.css" rel="stylesheet">
<link href="assets/css/themes/all-themes.css" rel="stylesheet" />
</head>
<body class="theme-cyan login-page authentication" style="background-image:url('images/login.jpeg');background-repeat: no-repeat;background-size: 100%">

<div class="container">
    <div id="err"><?php echo $err; ?></div>
    <div class="card-top"></div>
    <div class="card">
        <h1 class="title"><span>DOCTO LINK</span> Connexion <span class="msg">Bonjour, Docteur !</span></h1>
        <div class="col-md-12">
            <form method="post" action="" name="frmdoctlogin" id="sign_in" onSubmit="return validateform()">
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
                <div class="text-center">
                    <input type="submit" name="submit" id="submit" value="Se connecter" class="btn btn-raised waves-effect g-bg-cyan" />
                </div>
            </form>
        </div>
    </div>
</div>

<div class="clear"></div>
<div class="theme-bg"></div>

<script src="assets/bundles/libscripts.bundle.js"></script>
<script src="assets/bundles/vendorscripts.bundle.js"></script>
<script src="assets/bundles/mainscripts.bundle.js"></script>

<script type="application/javascript">
function validateform() {
    var loginid = document.frmdoctlogin.loginid.value.trim();
    var password = document.frmdoctlogin.password.value.trim();
    var alphanumericExp = /^[0-9a-zA-Z]+$/;

    if (loginid === "") {
        alert("L'identifiant ne doit pas être vide.");
        document.frmdoctlogin.loginid.focus();
        return false;
    } else if (!alphanumericExp.test(loginid)) {
        alert("Identifiant invalide.");
        document.frmdoctlogin.loginid.focus();
        return false;
    } else if (password === "") {
        alert("Le mot de passe ne doit pas être vide.");
        document.frmdoctlogin.password.focus();
        return false;
    } else if (password.length < 8) {
        alert("La longueur du mot de passe doit être supérieure à 8 caractères.");
        document.frmdoctlogin.password.focus();
        return false;
    }
    return true;
}
</script>

</body>
</html>
