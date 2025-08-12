<?php 
include("adheader.php");
include("dbconnection.php");

$rsedit = [];

if(isset($_POST['submit'])) {
    $treatmenttype = mysqli_real_escape_string($con, trim($_POST['treatmenttype']));
    $treatmentcost = floatval($_POST['treatmentcost']);
    $note = mysqli_real_escape_string($con, trim($_POST['textarea']));
    $status = mysqli_real_escape_string($con, $_POST['select']);

    if(isset($_GET['editid'])) {
        $editid = intval($_GET['editid']);
        $sql = "UPDATE treatment SET 
                    treatmenttype='$treatmenttype',
                    treatment_cost='$treatmentcost',
                    note='$note',
                    status='$status' 
                WHERE treatmentid='$editid'";
        if(mysqli_query($con, $sql)) {
            echo "<script>alert('Enregistrement du traitement mis à jour avec succès.');</script>";
        } else {
            echo mysqli_error($con);
        }
    } else {
        $sql = "INSERT INTO treatment (treatmenttype, treatment_cost, note, status) VALUES
                ('$treatmenttype', '$treatmentcost', '$note', '$status')";
        if(mysqli_query($con, $sql)) {
            echo "<script>alert('Enregistrement du traitement inséré avec succès.');</script>";
        } else {
            echo mysqli_error($con);
        }
    }
}

if(isset($_GET['editid'])) {
    $editid = intval($_GET['editid']);
    $sql = "SELECT * FROM treatment WHERE treatmentid='$editid'";
    $qsql = mysqli_query($con, $sql);
    $rsedit = mysqli_fetch_array($qsql);
}
?>

<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">Ajouter un nouveau traitement</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <form method="post" action="" name="frmtreat" onsubmit="return validateform()">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="treatmenttype">Type de traitement</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="treatmenttype" id="treatmenttype" 
                                        value="<?php echo isset($rsedit['treatmenttype']) ? htmlspecialchars($rsedit['treatmenttype']) : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="treatmentcost">Coût du traitement</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="treatmentcost" id="treatmentcost" 
                                        value="<?php echo isset($rsedit['treatment_cost']) ? htmlspecialchars($rsedit['treatment_cost']) : ''; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Statut</label>
                                <div class="form-line">
                                    <select name="select" id="select" class="form-control show-tick">
                                        <option value="">Sélectionner</option>
                                        <?php
                                        $arr = array("Active","Inactive");
                                        foreach($arr as $val) {
                                            $selected = (isset($rsedit['status']) && $rsedit['status'] == $val) ? "selected" : "";
                                            // Translate status options too:
                                            $statusFr = ($val == "Active") ? "Actif" : "Inactif";
                                            echo "<option value='$val' $selected>$statusFr</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="textarea">Note</label>
                            <div class="form-line">
                                <textarea name="textarea" class="form-control no-resize" id="textarea" cols="45" rows="5"><?php echo isset($rsedit['note']) ? htmlspecialchars($rsedit['note']) : ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <input type="submit" name="submit" id="submit" value="Envoyer" class="btn btn-raised" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("adfooter.php"); ?>

<script type="application/javascript">
var alphaspaceExp = /^[a-zA-Z\s]+$/; // alphabets and space

function validateform() {
    var form = document.frmtreat;
    if(form.treatmenttype.value.trim() === "") {
        alert("Le type de traitement ne doit pas être vide.");
        form.treatmenttype.focus();
        return false;
    } else if(!form.treatmenttype.value.match(alphaspaceExp)) {
        alert("Le type de traitement n'est pas valide. Seules les lettres et les espaces sont autorisés.");
        form.treatmenttype.focus();
        return false;
    }
    if(form.treatmentcost.value.trim() === "" || isNaN(form.treatmentcost.value) || parseFloat(form.treatmentcost.value) < 0) {
        alert("Le coût du traitement doit être un nombre positif valide.");
        form.treatmentcost.focus();
        return false;
    }
    if(form.select.value === "") {
        alert("Veuillez sélectionner le statut.");
        form.select.focus();
        return false;
    }
    return true;
}
</script>
