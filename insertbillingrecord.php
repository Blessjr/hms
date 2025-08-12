<?php
include("dbconnection.php");
$dt = date("Y-m-d");
$tim = date("H:i:s");
// DERNIER ID DE RENDEZ-VOUS
$sqlappointment1 = "SELECT max(appointmentid) FROM appointment WHERE patientid='$_GET[patientid]' AND (status='Active' OR status='Approved')";
$qsqlappointment1 = mysqli_query($con, $sqlappointment1);
$rsappointment1 = mysqli_fetch_array($qsqlappointment1);

// SÉLECTION DU DERNIER ENREGISTREMENT DE RENDEZ-VOUS
$sql = "SELECT * FROM billing WHERE appointmentid='$rsappointment1[0]'";
$qsql = mysqli_query($con, $sql);
$rsbill = mysqli_fetch_array($qsql);
if (mysqli_num_rows($qsql) == 0) {
    // Créer une facture pour le rendez-vous
    $sql = "INSERT INTO billing(patientid, appointmentid, billingdate, billingtime, discount, taxamount, discountreason, discharge_time, discharge_date) VALUES ('$_GET[patientid]', '$rsappointment1[0]', '$dt', '$tim', '0', '0', '', '', '')";
    $qsql = mysqli_query($con, $sql);
    $billid = mysqli_insert_id($con);
} else {
    $billid = $rsbill[0];
}

if ($billtype == "Doctor Charge" && $billtype1 = "Treatment Cost") {
    // Frais de consultation
    $sqldoctor = "SELECT * FROM doctor WHERE doctorid='$doctorid'";
    $qsqldoctor = mysqli_query($con, $sqldoctor);
    $rsdoctor = mysqli_fetch_array($qsqldoctor);

    $sqlconsu = "SELECT * FROM billing_records WHERE billingid='$billid' AND bill_type_id='$doctorid' AND bill_type='Frais de consultation'";
    $qsqlcunsu = mysqli_query($con, $sqlconsu);

    if (mysqli_affected_rows($con) == 0) {
        $sql = "INSERT INTO billing_records(billingid, bill_type_id, bill_type, bill_amount, bill_date, status) VALUES ('$billid', '$doctorid', 'Frais de consultation', '$rsdoctor[consultancy_charge]', '$dt', 'Active')";
        $qsql = mysqli_query($con, $sql);
    }

    // Coût du traitement
    $sqltreatment = "SELECT * FROM treatment WHERE treatmentid='$treatmentid'";
    $qsqltreatment = mysqli_query($con, $sqltreatment);
    $rstreatment = mysqli_fetch_array($qsqltreatment);

    $sql = "INSERT INTO billing_records(billingid, bill_type_id, bill_type, bill_amount, bill_date, status) VALUES ('$billid', '$treatmentid', 'Traitement', '$rstreatment[treatment_cost]', '$dt', 'Active')";
    $qsql = mysqli_query($con, $sql);
}

if ($billtype == "Prescription charge") {
    $sqltreatment = "SELECT * FROM treatment WHERE treatmentid='$_GET[treatmentid]'";
    $qsqltreatment = mysqli_query($con, $sqltreatment);
    $rstreatment = mysqli_fetch_array($qsqltreatment);
    // Frais de prescription
    $sql = "INSERT INTO billing_records(billingid, bill_type_id, bill_type, bill_amount, bill_date, status) VALUES ('$billid', '$prescriptionid', 'Frais de prescription', '$presamt', '$dt', 'Active')";
    $qsql = mysqli_query($con, $sql);
}

if ($billtype == "Prescription update") {
    $sqlprescription_records = "SELECT SUM(cost*unit) FROM prescription_records WHERE prescription_id='$_GET[prescriptionid]'";
    $qsqlprescription_records = mysqli_query($con, $sqlprescription_records);
    $rsprescription_records = mysqli_fetch_array($qsqlprescription_records);
    // Mise à jour des frais de prescription
    $sql = "UPDATE billing_records SET bill_amount='$rsprescription_records[0]' WHERE bill_type_id ='$_GET[prescriptionid]'";
    $qsql = mysqli_query($con, $sql);
}

if ($billtype == "Consultancy Charge") {
    // Frais de consultation
    $sql = "INSERT INTO billing_records(billingid, bill_type_id, bill_type, bill_amount, bill_date, status) VALUES ('$billid', '$doctorid', 'Frais de consultation', '$billamt', '$dt', 'Active')";
    $qsql = mysqli_query($con, $sql);
}

if ($billtype == "Service Charge") {
    $sqlservice_type = "SELECT * FROM service_type WHERE service_type_id='$servicetypeid'";
    $qsqlservice_type = mysqli_query($con, $sqlservice_type);
    $rsservice_type = mysqli_fetch_array($qsqlservice_type);
    $servicecharge = $rsservice_type['servicecharge'] + $_POST['amount'];
    // Frais de service
    $sql = "INSERT INTO billing_records(billingid, bill_type_id, bill_type, bill_amount, bill_date, status) VALUES ('$billid', '$servicetypeid', 'Frais de service', '$servicecharge', '$_POST[date]', 'Active')";
    $qsql = mysqli_query($con, $sql);
    echo "<script>alert('Frais de service ajoutés avec succès..');</script>";
}
?>
