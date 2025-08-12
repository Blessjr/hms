<?php
include("adheader.php");
include("dbconnection.php");

$editid = intval($_GET['editid'] ?? 0);
$delid = intval($_GET['delid'] ?? 0);
$patientid = intval($_GET['patientid'] ?? 0);
$appid = intval($_GET['appid'] ?? 0);

if (isset($_POST['submit'])) {
    // Handle file upload safely
    $filename = "";
    if (!empty($_FILES['uploads']['name'])) {
        $filename = rand() . basename($_FILES['uploads']['name']);
        move_uploaded_file($_FILES["uploads"]["tmp_name"], "treatmentfiles/" . $filename);
    } else if ($editid) {
        // Preserve old filename if editing and no new upload
        $sqlOld = "SELECT uploads FROM treatment_records WHERE appointmentid='$editid'";
        $resOld = mysqli_query($con, $sqlOld);
        if ($rowOld = mysqli_fetch_assoc($resOld)) {
            $filename = $rowOld['uploads'];
        }
    }

    $appointmentid = intval($_POST['select2'] ?? 0);
    $treatmentid = intval($_POST['select4'] ?? 0);
    $patientidPost = intval($_POST['patientid'] ?? 0);
    $doctorid = intval($_POST['select5'] ?? 0);
    $description = mysqli_real_escape_string($con, $_POST['textarea'] ?? '');
    $treatmentdate = $_POST['treatmentdate'] ?? '';
    $treatmenttime = $_POST['treatmenttime'] ?? '';

    if ($editid) {
        $sql = "UPDATE treatment_records SET 
            appointmentid='$appointmentid',
            treatmentid='$treatmentid',
            patientid='$patientidPost',
            doctorid='$doctorid',
            treatment_description='$description',
            uploads='$filename',
            treatment_date='$treatmentdate',
            treatment_time='$treatmenttime',
            status='Active' 
            WHERE appointmentid='$editid'";
        if (mysqli_query($con, $sql)) {
            echo "<script>alert('Enregistrement du traitement mis à jour avec succès...');</script>";
        } else {
            echo mysqli_error($con);
        }
    } else {
        $sql = "INSERT INTO treatment_records 
            (appointmentid, treatmentid, patientid, doctorid, treatment_description, uploads, treatment_date, treatment_time, status) 
            VALUES 
            ('$appointmentid', '$treatmentid', '$patientidPost', '$doctorid', '$description', '$filename', '$treatmentdate', '$treatmenttime', 'Active')";
        if (mysqli_query($con, $sql)) {
            echo "<script>alert('Enregistrement du traitement inséré avec succès...');</script>";
        } else {
            echo mysqli_error($con);
        }

        // Insert billing records
        $billtype = "Frais du médecin";
        $billtype1 = "Coût du traitement";
        include("insertbillingrecord.php");
    }
}

if ($editid) {
    $sql = "SELECT * FROM treatment_records WHERE appointmentid='$editid'";
    $qsql = mysqli_query($con, $sql);
    $rsedit = mysqli_fetch_assoc($qsql);
}

if ($delid) {
    $sql = "DELETE FROM treatment_records WHERE appointmentid='$delid'";
    if (mysqli_query($con, $sql)) {
        if (mysqli_affected_rows($con) == 1) {
            echo "<script>alert('Enregistrement du rendez-vous supprimé avec succès..');</script>";
        }
    } else {
        echo mysqli_error($con);
    }
}
?>

<div class="container-fluid">
  <div class="block-header">
    <h2>Ajouter de nouveaux enregistrements de traitement</h2>
  </div>

  <div class="card" style="padding: 10px">
    <form method="post" action="" name="frmtreatrec" onsubmit="return validateform()" enctype="multipart/form-data">
      <table class="table table-bordered table-striped">
        <tbody>
          <tr>
            <td width="40%">Rendez-vous</td>
            <td width="60%">
              <input class="form-control" type="text" readonly name="select2" value="<?php echo htmlspecialchars($appid); ?>" />
            </td>
          </tr>
          <tr>
            <td>Patient</td>
            <td>
              <input type="hidden" name="patientid" value="<?php echo htmlspecialchars($patientid); ?>" />
              <?php
              $sqlpatient = "SELECT * FROM patient WHERE status='Active' AND patientid='$patientid'";
              $qsqlpatient = mysqli_query($con, $sqlpatient);
              $rspatient = mysqli_fetch_assoc($qsqlpatient);
              ?>
              <input class="form-control" type="text" readonly name="select3" value="<?php echo htmlspecialchars($rspatient['patientname'] ?? ''); ?>" />
            </td>
          </tr>
          <tr>
            <td>Sélectionnez le type de traitement</td>
            <td>
              <select name="select4" id="select4" class="form-control show-tick">
                <option value="">Sélectionner</option>
                <?php
                $sqltreatment = "SELECT * FROM treatment WHERE status='Active'";
                $qsqltreatment = mysqli_query($con, $sqltreatment);
                while ($rstreatment = mysqli_fetch_assoc($qsqltreatment)) {
                    $selected = ($rstreatment['treatmentid'] == ($rsedit['treatmentid'] ?? 0)) ? "selected" : "";
                    echo "<option value='" . intval($rstreatment['treatmentid']) . "' $selected>" . 
                        htmlspecialchars($rstreatment['treatmenttype']) . " - (₹ " . htmlspecialchars($rstreatment['treatment_cost']) . ")</option>";
                }
                ?>
              </select>
            </td>
          </tr>
          <?php if (isset($_SESSION['doctorid'])): ?>
          <tr>
            <td>Médecin</td>
            <td>
              <?php
              $sqldoctor = "SELECT * FROM doctor INNER JOIN department ON department.departmentid = doctor.departmentid WHERE doctor.status='Active' AND doctor.doctorid='" . intval($_SESSION['doctorid']) . "'";
              $qsqldoctor = mysqli_query($con, $sqldoctor);
              while ($rsdoctor = mysqli_fetch_assoc($qsqldoctor)) {
                  echo htmlspecialchars($rsdoctor['doctorname']) . " (" . htmlspecialchars($rsdoctor['departmentname']) . ")";
              }
              ?>
              <input type="hidden" name="select5" value="<?php echo intval($_SESSION['doctorid']); ?>" />
            </td>
          </tr>
          <?php else: ?>
          <tr>
            <td>Médecin</td>
            <td>
              <select name="select5" id="select5" class="form-control show-tick">
                <option value="">Sélectionner</option>
                <?php
                $sqldoctor = "SELECT * FROM doctor INNER JOIN department ON department.departmentid = doctor.departmentid WHERE doctor.status='Active'";
                $qsqldoctor = mysqli_query($con, $sqldoctor);
                while ($rsdoctor = mysqli_fetch_assoc($qsqldoctor)) {
                    $selected = ($rsdoctor['doctorid'] == ($rsedit['doctorid'] ?? 0)) ? "selected" : "";
                    echo "<option value='" . intval($rsdoctor['doctorid']) . "' $selected>" . 
                        htmlspecialchars($rsdoctor['doctorname']) . " (" . htmlspecialchars($rsdoctor['departmentname']) . ")</option>";
                }
                ?>
              </select>
            </td>
          </tr>
          <?php endif; ?>
          <tr>
            <td>Description du traitement</td>
            <td>
              <textarea class="form-control" name="textarea" id="textarea" cols="45" rows="5"><?php echo htmlspecialchars($rsedit['treatment_description'] ?? ''); ?></textarea>
            </td>
          </tr>
          <tr>
            <td>Fichiers de traitement</td>
            <td>
              <input class="form-control" type="file" name="uploads" id="uploads" />
              <?php
              if (!empty($rsedit['uploads']) && file_exists("treatmentfiles/" . $rsedit['uploads'])) {
                  echo "<br><a href='treatmentfiles/" . urlencode($rsedit['uploads']) . "' download>Télécharger le fichier existant</a>";
              }
              ?>
            </td>
          </tr>
          <tr>
            <td>Date du traitement</td>
            <td>
              <input class="form-control" type="date" max="<?php echo date("Y-m-d"); ?>" name="treatmentdate" id="treatmentdate" value="<?php echo htmlspecialchars($rsedit['treatment_date'] ?? ''); ?>" />
            </td>
          </tr>
          <tr>
            <td>Heure du traitement</td>
            <td>
              <input class="form-control" type="time" name="treatmenttime" id="treatmenttime" value="<?php echo htmlspecialchars($rsedit['treatment_time'] ?? ''); ?>" />
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input class="btn btn-primary" type="submit" name="submit" id="submit" value="Envoyer" /> | 
              <a href="patientreport.php?patientid=<?php echo $patientid; ?>&appointmentid=<?php echo $appid; ?>"><strong>Voir le rapport du patient >></strong></a>
            </td>
          </tr>
        </tbody>
      </table>
    </form>

    <p>&nbsp;</p>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Type de traitement</th>
          <th>Médecin</th>
          <th>Description du traitement</th>
          <th>Fichiers</th>
          <th>Date du traitement</th>
          <th>Heure du traitement</th>
          <th>Statut</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM treatment_records WHERE patientid='$patientid' AND appointmentid='$appid'";
        $qsql = mysqli_query($con, $sql);
        while ($rs = mysqli_fetch_assoc($qsql)) {
            $sqltreatment = "SELECT treatmenttype FROM treatment WHERE treatmentid='" . intval($rs['treatmentid']) . "'";
            $rstreatment = mysqli_fetch_assoc(mysqli_query($con, $sqltreatment));
            
            $sqldoc = "SELECT doctorname FROM doctor WHERE doctorid='" . intval($rs['doctorid']) . "'";
            $rsdoc = mysqli_fetch_assoc(mysqli_query($con, $sqldoc));
            
            echo "<tr>";
            echo "<td>" . htmlspecialchars($rstreatment['treatmenttype'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($rsdoc['doctorname'] ?? '') . "</td>";
            echo "<td>" . nl2br(htmlspecialchars($rs['treatment_description'])) . "</td>";
            if (!empty($rs['uploads']) && file_exists("treatmentfiles/" . $rs['uploads'])) {
                echo "<td><a href='treatmentfiles/" . urlencode($rs['uploads']) . "' download>Télécharger</a></td>";
            } else {
                echo "<td></td>";
            }
            echo "<td>" . htmlspecialchars($rs['treatment_date']) . "</td>";
            echo "<td>" . htmlspecialchars($rs['treatment_time']) . "</td>";
            echo "<td>" . htmlspecialchars($rs['status']) . "</td>";
            echo "<td>
                    <a href='treatmentrecord.php?editid=" . intval($rs['appointmentid']) . "&patientid=$patientid&appid=$appid'>Modifier</a> | 
                    <a href='treatmentrecord.php?delid=" . intval($rs['appointmentid']) . "&patientid=$patientid&appointmentid=$appid' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?');\">Supprimer</a>
                  </td>";
            echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<?php
include("adfooter.php");
?>

<script type="application/javascript">
function validateform() {
    let form = document.forms['frmtreatrec'];

    if (form.select2.value.trim() === "") {
        alert("L'identifiant du rendez-vous ne doit pas être vide.");
        form.select2.focus();
        return false;
    }
    if (form.select4.value.trim() === "") {
        alert("L'identifiant du traitement ne doit pas être vide.");
        form.select4.focus();
        return false;
    }
    if (form.patientid.value.trim() === "") {
        alert("L'identifiant du patient ne doit pas être vide.");
        form.patientid.focus();
        return false;
    }
    if (form.select5.value.trim() === "") {
        alert("L'identifiant du médecin ne doit pas être vide.");
        form.select5.focus();
        return false;
    }
    if (form.textarea.value.trim() === "") {
        alert("La description du traitement ne doit pas être vide.");
        form.textarea.focus();
        return false;
    }
    if (form.treatmentdate.value.trim() === "") {
        alert("La date du traitement ne doit pas être vide.");
        form.treatmentdate.focus();
        return false;
    }
    if (form.treatmenttime.value.trim() === "") {
        alert("L'heure du traitement ne doit pas être vide.");
        form.treatmenttime.focus();
        return false;
    }
    return true;
}
</script>
