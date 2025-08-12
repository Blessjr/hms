<?php
include("adheader.php");
include("dbconnection.php");

if(isset($_GET['delid']))
{
    $delid = intval($_GET['delid']);
    $prescriptionid = isset($_GET['prescriptionid']) ? intval($_GET['prescriptionid']) : 0;
    $patientid = isset($_GET['patientid']) ? intval($_GET['patientid']) : 0;
    $appid = isset($_GET['appid']) ? intval($_GET['appid']) : 0;

    $sql ="DELETE FROM prescription_records WHERE prescription_record_id='$delid'";
    $qsql=mysqli_query($con,$sql);
    if(mysqli_affected_rows($con) == 1)
    {
        echo "<script>alert('Prescription supprimée avec succès.');</script>";
        echo "<script>window.location='prescriptionrecord.php?prescriptionid=$prescriptionid&patientid=$patientid&appid=$appid';</script>";
    }
}

if(isset($_POST['submit']))
{
    $prescriptionid = intval($_POST['prescriptionid']);
    $medicineid = intval($_POST['medicineid']);
    $cost = floatval($_POST['cost']);
    $unit = intval($_POST['unit']);
    $dosage = mysqli_real_escape_string($con, $_POST['select2']);
    $status = "Active"; // statut par défaut comme dans votre requête d'insertion

    if(isset($_GET['editid']))
    {
        $editid = intval($_GET['editid']);
        $sql = "UPDATE prescription_records SET 
                    prescription_id='$prescriptionid',
                    medicine_name='$medicineid',
                    cost='$cost',
                    unit='$unit',
                    dosage='$dosage',
                    status='$status'
                WHERE prescription_record_id='$editid'";
        if($qsql = mysqli_query($con,$sql))
        {
            echo "<script>alert('Enregistrement de la prescription mis à jour avec succès.');</script>";
        }
        else
        {
            echo mysqli_error($con);
        }    
    }
    else
    {
        $sql = "INSERT INTO prescription_records(prescription_id, medicine_name, cost, unit, dosage, status) 
                VALUES('$prescriptionid', '$medicineid', '$cost', '$unit', '$dosage', '$status')";
        if($qsql = mysqli_query($con,$sql))
        {    
            $presamt = $cost * $unit;
            $billtype = "Mise à jour de la prescription";
            include("insertbillingrecord.php");

            $patientid = isset($_GET['patientid']) ? intval($_GET['patientid']) : 0;
            $appid = isset($_GET['appid']) ? intval($_GET['appid']) : 0;

            echo "<script>alert('Enregistrement de la prescription inséré avec succès.');</script>";
            echo "<script>window.location='prescriptionrecord.php?prescriptionid=$prescriptionid&patientid=$patientid&appid=$appid';</script>";
        }
        else
        {
            echo mysqli_error($con);
        }
    }
}

$rsedit = null;
if(isset($_GET['editid']))
{
    $editid = intval($_GET['editid']);
    $sql="SELECT * FROM prescription_records WHERE prescription_record_id='$editid'";
    $qsql = mysqli_query($con,$sql);
    $rsedit = mysqli_fetch_array($qsql);
}
?>

<div class="container-fluid">
    <div class="block-header"><h2>Ajouter un nouvel enregistrement de prescription</h2></div>
    <div class="card" style="padding:10px">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <td><strong>Médecin</strong></td>
                    <td><strong>Patient</strong></td>
                    <td><strong>Date de prescription</strong></td>
                    <td><strong>Statut</strong></td>
                </tr>
                <?php
                if(isset($_GET['prescriptionid']))
                {
                    $prescriptionid = intval($_GET['prescriptionid']);
                    $sql = "SELECT * FROM prescription WHERE prescriptionid='$prescriptionid'";
                    $qsql = mysqli_query($con,$sql);
                    while($rs = mysqli_fetch_array($qsql))
                    {
                        $sqlpatient = "SELECT patientname FROM patient WHERE patientid='".intval($rs['patientid'])."'";
                        $qsqlpatient = mysqli_query($con,$sqlpatient);
                        $rspatient = mysqli_fetch_array($qsqlpatient);

                        $sqldoctor = "SELECT doctorname FROM doctor WHERE doctorid='".intval($rs['doctorid'])."'";
                        $qsqldoctor = mysqli_query($con,$sqldoctor);
                        $rsdoctor = mysqli_fetch_array($qsqldoctor);

                        echo "<tr>
                                <td>" . htmlspecialchars($rsdoctor['doctorname']) . "</td>
                                <td>" . htmlspecialchars($rspatient['patientname']) . "</td>
                                <td>" . htmlspecialchars($rs['prescriptiondate']) . "</td>
                                <td>" . htmlspecialchars($rs['status']) . "</td>
                              </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <?php if(!isset($_SESSION['patientid'])) { ?>
    <div class="card" style="padding:10px">
        <form method="post" action="" name="frmpresrecord" onsubmit="return validateform();">
            <input type="hidden" name="prescriptionid" value="<?php echo isset($_GET['prescriptionid']) ? intval($_GET['prescriptionid']) : ''; ?>" />
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td width="34%">Médicament</td>
                        <td width="66%">
                            <select class="form-control show-tick" name="medicineid" id="medicineid" onchange="loadmedicine(this.value)">
                                <option value="">Sélectionner un médicament</option>
                                <?php
                                $sqlmedicine = "SELECT * FROM medicine WHERE status='Active'";
                                $qsqlmedicine = mysqli_query($con,$sqlmedicine);
                                while($rsmedicine = mysqli_fetch_array($qsqlmedicine))
                                {
                                    $selected = (isset($rsedit['medicine_name']) && $rsedit['medicine_name'] == $rsmedicine['medicineid']) ? "selected" : "";
                                    echo "<option value='" . intval($rsmedicine['medicineid']) . "' $selected>" . htmlspecialchars($rsmedicine['medicinename']) . " ( ₹ " . htmlspecialchars($rsmedicine['medicinecost']) . " )</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Coût</td>
                        <td><input class="form-control" type="text" name="cost" id="cost" value="<?php echo isset($rsedit['cost']) ? htmlspecialchars($rsedit['cost']) : ''; ?>" readonly style="background-color:pink;" /></td>
                    </tr>
                    <tr>
                        <td>Quantité</td>
                        <td><input class="form-control" type="number" min="1" name="unit" id="unit" value="<?php echo isset($rsedit['unit']) ? intval($rsedit['unit']) : '1'; ?>" onkeyup="calctotalcost(cost.value,this.value)" onchange="calctotalcost(cost.value,this.value)" /></td>
                    </tr>
                    <tr>
                        <td>Coût total</td>
                        <td><input class="form-control" type="text" name="totcost" id="totcost" value="<?php echo isset($rsedit['cost']) && isset($rsedit['unit']) ? htmlspecialchars($rsedit['cost'] * $rsedit['unit']) : ''; ?>" readonly style="background-color:pink;" /></td>
                    </tr>
                    <tr>
                        <td>Dosage</td>
                        <td>
                            <select class="form-control show-tick" name="select2" id="select2">
                                <option value="">Sélectionner</option>
                                <?php
                                $arr = array("0-0-1","0-1-1","1-0-1","1-1-1","1-1-0","0-1-0","1-0-0");
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
                        <td colspan="2" align="center"><input class="btn btn-default" type="submit" name="submit" id="submit" value="Envoyer" /></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <?php } ?>
    
    <div class="block-header"><h2>Voir les enregistrements de prescription</h2></div>
    <div class="card" style="padding:10px">
        <table class="table table-hover table-striped">
            <tbody>
                <tr>
                    <td><strong>Médicament</strong></td>
                    <td><strong>Dosage</strong></td>
                    <td><strong>Coût</strong></td>
                    <td><strong>Quantité</strong></td>
                    <td><strong>Total</strong></td>
                    <?php if(!isset($_SESSION['patientid'])) { ?>
                    <td><strong>Action</strong></td>
                    <?php } ?>
                </tr>
                <?php
                $gtotal = 0;
                if(isset($_GET['prescriptionid']))
                {
                    $prescriptionid = intval($_GET['prescriptionid']);
                    $sql = "SELECT prescription_records.*, medicine.medicinename FROM prescription_records 
                            LEFT JOIN medicine ON prescription_records.medicine_name = medicine.medicineid 
                            WHERE prescription_id='$prescriptionid'";
                    $qsql = mysqli_query($con,$sql);
                    while($rs = mysqli_fetch_array($qsql))
                    {
                        $total = $rs['cost'] * $rs['unit'];
                        $gtotal += $total;
                        echo "<tr>
                                <td>" . htmlspecialchars($rs['medicinename']) . "</td>
                                <td>" . htmlspecialchars($rs['dosage']) . "</td>
                                <td>₹" . htmlspecialchars($rs['cost']) . "</td>
                                <td>" . htmlspecialchars($rs['unit']) . "</td>
                                <td>₹" . htmlspecialchars($total) . "</td>";
                        if(!isset($_SESSION['patientid']))
                        {
                            $presrecid = intval($rs['prescription_record_id']);
                            echo "<td><a href='prescriptionrecord.php?delid=$presrecid&prescriptionid=$prescriptionid' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?');\">Supprimer</a></td>";
                        }
                        echo "</tr>";
                    }
                }
                ?>
                <tr>
                    <th colspan="4" align="right">Total général</th>
                    <th align="right">₹<?php echo htmlspecialchars($gtotal); ?></th>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="6" align="center">
                        <input class="btn btn-default" type="button" name="print" id="print" value="Imprimer" onclick="window.print();" />
                    </td>
                </tr>
            </tbody>
        </table>
        
        <table>
            <tr><td>
                <center><a href='patientreport.php?patientid=<?php echo isset($_GET['patientid']) ? intval($_GET['patientid']) : 0; ?>&appointmentid=<?php echo isset($_GET['appid']) ? intval($_GET['appid']) : 0; ?>'><strong>Voir le rapport du patient >></strong></a></center>
            </td></tr>
        </table>
    </div>
</div>

<?php
include("adfooter.php");
?>

<script type="application/javascript">
function loadmedicine(medicineid)
{
    if (medicineid == "") {
        document.getElementById("cost").value = "";
        document.getElementById("totcost").value = "";
        document.getElementById("unit").value = 1;
        return;
    }
    var xmlhttp;
    if (window.XMLHttpRequest) 
    {
        xmlhttp = new XMLHttpRequest();
    } 
    else 
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("cost").value = this.responseText;
            document.getElementById("totcost").value = this.responseText;
            document.getElementById("unit").value = 1;
        }
    };
    xmlhttp.open("GET","ajaxmedicine.php?medicineid="+medicineid,true);
    xmlhttp.send();
}

function calctotalcost(cost,qty)
{
    var total = parseFloat(cost) * parseFloat(qty);
    if (!isNaN(total)) {
        document.getElementById("totcost").value = total.toFixed(2);
    }
}

function validateform()
{
    var form = document.frmpresrecord;
    if(form.prescriptionid.value == "")
    {
        alert("L'ID de la prescription ne doit pas être vide.");
        form.prescriptionid.focus();
        return false;
    }
    if(form.medicineid.value == "")
    {
        alert("Le champ Médicament ne doit pas être vide.");
        form.medicineid.focus();
        return false;
    }
    if(form.cost.value == "" || isNaN(form.cost.value) || parseFloat(form.cost.value) <= 0)
    {
        alert("Le coût doit être un nombre positif valide.");
        form.cost.focus();
        return false;
    }
    if(form.unit.value == "" || isNaN(form.unit.value) || parseInt(form.unit.value) <= 0)
    {
        alert("La quantité doit être un nombre entier positif valide.");
        form.unit.focus();
        return false;
    }
    if(form.select2.value == "")
    {
        alert("Le dosage ne doit pas être vide.");
        form.select2.focus();
        return false;
    }
    return true;
}
</script>
