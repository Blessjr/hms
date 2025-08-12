<?php
include("header.php");
include("dbconnection.php");

if(isset($_GET['delid']))
{
    $delid = intval($_GET['delid']); // sanitize input
    $sql = "DELETE FROM prescription_records WHERE prescription_record_id='$delid'";
    $qsql = mysqli_query($con, $sql);
    if(mysqli_affected_rows($con) == 1)
    {
        echo "<script>alert('Ordonnance supprimée avec succès.');</script>";
    }
}

if(isset($_POST['submit']))
{
    $prescriptionid = mysqli_real_escape_string($con, $_POST['prescriptionid']);
    $medicine = mysqli_real_escape_string($con, $_POST['medicine']);
    $cost = floatval($_POST['cost']);
    $unit = intval($_POST['unit']);
    $dosage = mysqli_real_escape_string($con, $_POST['select2']);
    $status = isset($_POST['select']) ? mysqli_real_escape_string($con, $_POST['select']) : 'Active';

    if(isset($_GET['editid']))
    {
        $editid = intval($_GET['editid']);
        $sql = "UPDATE prescription_records SET 
                    prescription_id='$prescriptionid', 
                    medicine_name='$medicine', 
                    cost='$cost', 
                    unit='$unit', 
                    dosage='$dosage', 
                    status='$status' 
                WHERE prescription_record_id='$editid'";
        if($qsql = mysqli_query($con, $sql))
        {
            echo "<script>alert('Enregistrement de l\'ordonnance mis à jour avec succès.');</script>";
        }
        else
        {
            echo mysqli_error($con);
        }
    }
    else
    {
        $sql = "INSERT INTO prescription_records(prescription_id, medicine_name, cost, unit, dosage, status) 
                VALUES('$prescriptionid', '$medicine', '$cost', '$unit', '$dosage', '$status')";
        if($qsql = mysqli_query($con, $sql))
        {
            echo "<script>alert('Enregistrement de l\'ordonnance inséré avec succès.');</script>";
        }
        else
        {
            echo mysqli_error($con);
        }
    }
}

if(isset($_GET['editid']))
{
    $editid = intval($_GET['editid']);
    $sql = "SELECT * FROM prescription_records WHERE prescription_record_id='$editid'";
    $qsql = mysqli_query($con, $sql);
    $rsedit = mysqli_fetch_array($qsql);
}
?>

<div class="wrapper col2">
  <div id="breadcrumb">
    <ul>
      <li class="first">Ajouter un nouvel enregistrement d'ordonnance</li>
    </ul>
  </div>
</div>

<div class="wrapper col4">
  <div id="container">
    <table width="100%" border="3">
      <tbody>
        <tr>
          <td><strong>Médecin</strong></td>
          <td><strong>Patient</strong></td>
          <td><strong>Date de l'ordonnance</strong></td>
          <td><strong>Statut</strong></td>
        </tr>
        <?php
        if(isset($_GET['prescriptionid']))
        {
            $prescriptionid = intval($_GET['prescriptionid']);
            $sql = "SELECT * FROM prescription WHERE prescriptionid='$prescriptionid'";
            $qsql = mysqli_query($con, $sql);
            while($rs = mysqli_fetch_array($qsql))
            {
                $sqlpatient = "SELECT patientname FROM patient WHERE patientid='$rs[patientid]'";
                $qsqlpatient = mysqli_query($con, $sqlpatient);
                $rspatient = mysqli_fetch_array($qsqlpatient);

                $sqldoctor = "SELECT doctorname FROM doctor WHERE doctorid='$rs[doctorid]'";
                $qsqldoctor = mysqli_query($con, $sqldoctor);
                $rsdoctor = mysqli_fetch_array($qsqldoctor);

                echo "<tr>
                        <td>&nbsp;" . htmlspecialchars($rsdoctor['doctorname']) . "</td>
                        <td>&nbsp;" . htmlspecialchars($rspatient['patientname']) . "</td>
                        <td>&nbsp;" . htmlspecialchars($rs['prescriptiondate']) . "</td>
                        <td>&nbsp;" . htmlspecialchars($rs['status']) . "</td>
                      </tr>";
            }
        }
        ?>
      </tbody>
    </table>

    <h1>Voir les enregistrements de l'ordonnance</h1>
    <table width="100%" border="3">
      <tbody>
        <tr>
          <td><strong>Médicament</strong></td>
          <td><strong>Coût</strong></td>
          <td><strong>Unité</strong></td>
          <td><strong>Dosage</strong></td>
          <?php if(!isset($_SESSION['patientid'])) { ?>
          <td><strong>Action</strong></td>
          <?php } ?>
        </tr>
        <?php
        if(isset($_GET['prescriptionid']))
        {
            $prescriptionid = intval($_GET['prescriptionid']);
            $sql = "SELECT * FROM prescription_records WHERE prescription_id='$prescriptionid'";
            $qsql = mysqli_query($con, $sql);
            while($rs = mysqli_fetch_array($qsql))
            {
                echo "<tr>
                        <td>" . htmlspecialchars($rs['medicine_name']) . "</td>
                        <td>Rs. " . htmlspecialchars($rs['cost']) . "</td>
                        <td>" . htmlspecialchars($rs['unit']) . "</td>
                        <td>" . htmlspecialchars($rs['dosage']) . "</td>";
                if(!isset($_SESSION['patientid']))
                {
                    echo "<td><a href='prescriptionrecord.php?delid=" . intval($rs['prescription_record_id']) . "&prescriptionid=$prescriptionid' onclick=\"return confirm('Voulez-vous vraiment supprimer cet enregistrement ?');\">Supprimer</a></td>";
                }
                echo "</tr>";
            }
        }
        ?>
        <tr>
          <td colspan="5">
            <div align="center">
              <input type="button" name="print" id="print" value="Imprimer" onclick="window.print();" />
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <?php if(!isset($_SESSION['patientid'])) { ?>
    <form method="post" action="" name="frmpresrecord" onsubmit="return validateform();"> 
      <input type="hidden" name="prescriptionid" value="<?php echo isset($_GET['prescriptionid']) ? intval($_GET['prescriptionid']) : ''; ?>" />
      <table width="100%" border="3">
        <tbody>
          <tr>
            <td width="34%">Médicament</td>
            <td width="66%"><input type="text" name="medicine" id="medicine" value="<?php echo isset($rsedit['medicine_name']) ? htmlspecialchars($rsedit['medicine_name']) : ''; ?>" /></td>
          </tr>
          <tr>
            <td>Coût</td>
            <td><input type="text" name="cost" id="cost" value="<?php echo isset($rsedit['cost']) ? htmlspecialchars($rsedit['cost']) : ''; ?>" /></td>
          </tr>
          <tr>
            <td>Unité</td>
            <td><input type="number" min="1" name="unit" id="unit" value="<?php echo isset($rsedit['unit']) ? intval($rsedit['unit']) : '1'; ?>" /></td>
          </tr>
          <tr>
            <td>Dosage</td>
            <td>
              <select name="select2" id="select2">
                <option value="">Sélectionner</option>
                <?php
                $arr = array("1-0-1","1-1-1","1-1-0","0-1-1","0-1-0","0-0-1","1-0-0");
                foreach($arr as $val)
                {
                    $selected = (isset($rsedit['dosage']) && $rsedit['dosage'] == $val) ? "selected" : "";
                    echo "<option value='$val' $selected>$val</option>";
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input type="submit" name="submit" id="submit" value="Soumettre" />
            </td>
          </tr>
        </tbody>
      </table>
    </form>
    <?php } ?>

    <p>&nbsp;</p>
  </div>
</div>

<?php include("footer.php"); ?>

<script type="application/javascript">
function validateform()
{
    var form = document.frmpresrecord;
    if(form.prescriptionid.value == "")
    {
        alert("L'ID de l'ordonnance ne doit pas être vide.");
        form.prescriptionid.focus();
        return false;
    }
    else if(form.medicine.value.trim() == "")
    {
        alert("Le champ Médicament ne doit pas être vide.");
        form.medicine.focus();
        return false;
    }
    else if(form.cost.value.trim() == "" || isNaN(form.cost.value) || Number(form.cost.value) < 0)
    {
        alert("Le coût doit être un nombre valide et ne doit pas être vide.");
        form.cost.focus();
        return false;
    }
    else if(form.unit.value.trim() == "" || isNaN(form.unit.value) || Number(form.unit.value) < 1)
    {
        alert("L'unité doit être un nombre entier positif.");
        form.unit.focus();
        return false;
    }
    else if(form.select2.value == "")
    {
        alert("Le dosage ne doit pas être vide.");
        form.select2.focus();
        return false;
    }
    else
    {
        return true;
    }
}
</script>
