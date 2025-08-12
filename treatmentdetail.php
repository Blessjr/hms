<?php
session_start();
include("dbconnection.php");

$patientid = intval($_GET['patientid'] ?? 0);
$appointmentid = intval($_GET['appointmentid'] ?? 0);

$sql = "
SELECT tr.*, t.treatmenttype, t.treatment_cost, d.doctorname 
FROM treatment_records tr
LEFT JOIN treatment t ON tr.treatmentid = t.treatmentid
LEFT JOIN doctor d ON tr.doctorid = d.doctorid
WHERE tr.patientid = $patientid AND tr.appointmentid = $appointmentid";

$qsql = mysqli_query($con, $sql);
?>

<table class="table table-bordered table-striped">
    <tr>
        <td><strong>Type de traitement</strong></td>
        <td><strong>Date et heure du traitement</strong></td>
        <td><strong>Médecin</strong></td>
        <td><strong>Description du traitement</strong></td>
        <td><strong>Coût du traitement</strong></td>
    </tr>
    <?php
    while ($rs = mysqli_fetch_assoc($qsql)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($rs['treatmenttype']) . "</td>";
        echo "<td>" . date("d-m-Y", strtotime($rs['treatment_date'])) . " " . date("h:i A", strtotime($rs['treatment_time'])) . "</td>";
        echo "<td>" . htmlspecialchars($rs['doctorname']) . "</td>";
        echo "<td>" . nl2br(htmlspecialchars($rs['treatment_description']));
        
        if (!empty($rs['uploads']) && file_exists("treatmentfiles/" . $rs['uploads'])) {
            echo "<br><a href='treatmentfiles/" . urlencode($rs['uploads']) . "' download>Télécharger</a>";
        }
        
        echo "</td>";
        echo "<td>₹" . htmlspecialchars($rs['treatment_cost']) . "</td>";
        echo "</tr>";
    }
    ?>
</table>

<?php if (isset($_SESSION['doctorid'])): ?>
<hr>
<div style="text-align:center;">
    <strong><a href="treatmentrecord.php?patientid=<?php echo $patientid; ?>&appid=<?php echo $appointmentid; ?>">Ajouter des enregistrements de traitement</a></strong>
</div>
<?php endif; ?>

<script type="application/javascript">
function validateform() {
    let form = document.frmtreatdetail;

    if (form.select.value === "") {
        alert("Le nom du traitement ne doit pas être vide.");
        form.select.focus();
        return false;
    }
    if (form.select2.value === "") {
        alert("Le nom du médecin ne doit pas être vide.");
        form.select2.focus();
        return false;
    }
    if (form.textarea.value.trim() === "") {
        alert("La description du traitement ne doit pas être vide.");
        form.textarea.focus();
        return false;
    }
    if (form.treatmentfile.value === "") {
        alert("Le fichier à télécharger ne doit pas être vide.");
        form.treatmentfile.focus();
        return false;
    }
    if (form.date.value === "") {
        alert("La date du traitement ne doit pas être vide.");
        form.date.focus();
        return false;
    }
    if (form.time.value === "") {
        alert("L'heure du traitement ne doit pas être vide.");
        form.time.focus();
        return false;
    }
    return true;
}
</script>
