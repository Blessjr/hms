<?php
include("adheader.php");
include("dbconnection.php");
session_start();

if (!isset($_SESSION['adminid'])) {
    echo "<script>window.location='adminlogin.php';</script>";
    exit;
}

$msg = '';
if (isset($_POST['submit'])) {
    // Fetch current password hash for admin
    $sql = "SELECT password, password_hashed FROM admin WHERE adminid=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $_SESSION['adminid']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $old_password_input = $_POST['oldpassword'];

        // Verify old password
        if (($row['password_hashed'] && password_verify($old_password_input, $row['password'])) ||
            (!$row['password_hashed'] && $old_password_input === $row['password'])) {
            
            // Hash new password and update DB
            $new_password_hash = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
            $update_sql = "UPDATE admin SET password=?, password_hashed=1 WHERE adminid=?";
            $update_stmt = $con->prepare($update_sql);
            $update_stmt->bind_param("si", $new_password_hash, $_SESSION['adminid']);
            if ($update_stmt->execute()) {
                $msg = "<div class='alert alert-success'>Mot de passe mis à jour avec succès.</div>";
            } else {
                $msg = "<div class='alert alert-warning'>Échec de la mise à jour du mot de passe administrateur.</div>";
            }
            $update_stmt->close();
        } else {
            $msg = "<div class='alert alert-warning'>Ancien mot de passe incorrect.</div>";
        }
    }
    $stmt->close();
}
?>
<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">Mot de passe de l'administrateur</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <?php echo $msg; ?>
                <form method="post" action="" name="frmadminchange" onSubmit="return validateform1()">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-12">   
                                <div class="form-group">
                                    <div class="form-line">
                                        <input class="form-control" type="password" name="oldpassword" id="oldpassword" placeholder="Ancien mot de passe" />
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="row clearfix"> 
                            <div class="col-sm-12">                           
                                <div class="form-group">
                                    <div class="form-line">
                                        <input class="form-control" type="password" name="newpassword" id="newpassword" placeholder="Nouveau mot de passe" />
                                    </div>
                                </div>    
                            </div>                      
                        </div>  
                        <div class="row clearfix"> 
                            <div class="col-sm-12">                              
                                <div class="form-group">
                                    <div class="form-line">
                                        <input class="form-control" type="password" name="password" id="password" placeholder="Confirmer le mot de passe" />
                                    </div>
                                </div>
                            </div>                          
                        </div>                     
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-raised g-bg-cyan" name="submit" id="submit" value="Soumettre" />
                        </div>
                    </div>
                </form>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<?php include("adfooter.php"); ?>

<script type="application/javascript">
function validateform1() {
    if (document.frmadminchange.oldpassword.value == "") {
        alert("L'ancien mot de passe ne doit pas être vide.");
        document.frmadminchange.oldpassword.focus();
        return false;
    } else if (document.frmadminchange.newpassword.value == "") {
        alert("Le nouveau mot de passe ne doit pas être vide.");
        document.frmadminchange.newpassword.focus();
        return false;
    } else if (document.frmadminchange.newpassword.value.length < 8) {
        alert("Le nouveau mot de passe doit contenir au moins 8 caractères.");
        document.frmadminchange.newpassword.focus();
        return false;
    } else if (document.frmadminchange.newpassword.value != document.frmadminchange.password.value) {
        alert("Le nouveau mot de passe et la confirmation doivent être identiques.");
        document.frmadminchange.password.focus();
        return false;
    } else {
        return true;
    }
}
</script>
