<?php
session_start();
error_reporting(0);
include("dbconnection.php");
$dt = date("Y-m-d");
$tim = date("H:i:s");

if (isset($_SESSION['patientid'])) {
    echo "<script>window.location='patientaccount.php';</script>";
    exit;
}

$err = '';
if (isset($_POST['submit'])) {
    $loginid = $_POST['loginid'];
    $input_password = $_POST['password'];

    $sql = "SELECT patientid, password, status FROM patient WHERE loginid = ? AND status = 'Active'";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $loginid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Check hashed password, fallback to plain for legacy
        if (password_verify($input_password, $row['password']) || $input_password === $row['password']) {
            $_SESSION['patientid'] = $row['patientid'];
            echo "<script>window.location='patientaccount.php';</script>";
            exit;
        } else {
            $err = "<div class='alert alert-danger'><strong>Erreur :</strong> Identifiants incorrects.</div>";
        }
    } else {
        $err = "<div class='alert alert-danger'><strong>Erreur :</strong> Identifiants incorrects.</div>";
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
<title>HMS - Connexion Patient</title>
<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- CSS personnalisé -->
<link href="assets/css/main.css" rel="stylesheet">
<link href="assets/css/login.css" rel="stylesheet">
<link href="assets/css/themes/all-themes.css" rel="stylesheet" />
</head>
<body class="theme-cyan login-page authentication" style="background-image:url('images/login.jpeg');background-repeat: no-repeat;background-size: 100%">

<div class="container">
    <div id="err"><?php echo $err; ?></div>
    <div class="card-top"></div>
    <div class="card">
        <h1 class="title"><span>DOCTO LINK</span> Connexion <span class="msg">Bonjour, Patient !</span></h1>
        <div class="col-md-12">
            <form method="post" action="" name="frmPatientLogin" id="frmPatientLogin" onsubmit="return validateform()">
                <div class="input-group">
                    <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                    <div class="form-line">
                        <input type="text" name="loginid" id="loginid" class="form-control" placeholder="Identifiant de connexion" />
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

<script type="application/javascript">
function validateform() {
    const form = document.forms['frmPatientLogin'];
    if(form.loginid.value.trim() === "") {
        alert("L'identifiant de connexion ne doit pas être vide.");
        form.loginid.focus();
        return false;
    }
    if(form.password.value.trim() === "") {
        alert("Le mot de passe ne doit pas être vide.");
        form.password.focus();
        return false;
    }
    if(form.password.value.length < 8) {
        alert("Le mot de passe doit contenir au moins 8 caractères.");
        form.password.focus();
        return false;
    }
    return true;
}
</script>
</body>
</html>
