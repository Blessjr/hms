<?php
include("adheader.php");
include("dbconnection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldpassword = $_POST['oldpassword'] ?? '';
    $newpassword = $_POST['newpassword'] ?? '';
    $doctorid = $_SESSION['doctorid'];

    // Step 1: Get the current hashed password from DB
    $stmt = $con->prepare("SELECT password FROM doctor WHERE doctorid = ?");
    $stmt->bind_param("i", $doctorid);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Step 2: Verify old password
    if ($hashed_password && password_verify($oldpassword, $hashed_password)) {
        // Step 3: Hash new password
        $new_hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);

        // Step 4: Update password in DB
        $stmt = $con->prepare("UPDATE doctor SET password = ? WHERE doctorid = ?");
        $stmt->bind_param("si", $new_hashed_password, $doctorid);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            echo "<script>alert('Password has been updated successfully.');</script>";
        } else {
            echo "<script>alert('Failed to update password.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Old password is incorrect.');</script>";
    }
}
?>

<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">Doctor's Password</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <form method="post" name="frmdoctchangepass" onsubmit="return validateform()" style="padding: 10px;">
                    <div class="form-group">
                        <label>Old Password</label>
                        <div class="form-line">
                            <input class="form-control" type="password" name="oldpassword" id="oldpassword" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <div class="form-line">
                            <input class="form-control" type="password" name="newpassword" id="newpassword" minlength="8" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="form-line">
                            <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" required>
                        </div>
                    </div>
                    <input class="btn btn-raised g-bg-cyan" type="submit" name="submit" value="Submit">
                </form>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>

<?php include("adfooter.php"); ?>

<script>
function validateform() {
    const oldPass = document.getElementById("oldpassword").value.trim();
    const newPass = document.getElementById("newpassword").value.trim();
    const confirmPass = document.getElementById("confirmpassword").value.trim();

    if (oldPass === "") {
        alert("Old password should not be empty.");
        return false;
    }
    if (newPass.length < 8) {
        alert("New Password length should be at least 8 characters.");
        return false;
    }
    if (newPass !== confirmPass) {
        alert("New Password and Confirm Password should match.");
        return false;
    }
    return true;
}
</script>
