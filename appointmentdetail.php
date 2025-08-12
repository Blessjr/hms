<?php
session_start();
include("dbconnection.php");
if(isset($_POST['submitapp']))
{
	$sql ="INSERT INTO appointment(appointmenttype,departmentid,appointmentdate,appointmenttime,doctorid) values('En ligne','$_POST[select3]','$_POST[date]','$_POST[time]','$_POST[select5]')";
	if($qsql = mysqli_query($con,$sql))
	{
		echo "<script>alert('Enregistrement du rendez-vous effectué avec succès...');</script>";
	}
	else
	{
		echo mysqli_error($con);
	}
}

if(isset($_GET['editid']))
{
	$sql="SELECT * FROM appointment WHERE appointmentid='$_GET[editid]' ";
	$qsql = mysqli_query($con,$sql);
	$rsedit = mysqli_fetch_array($qsql);
}

$sqlappointment1 = "SELECT max(appointmentid) FROM appointment where patientid='$_GET[patientid]' AND (status='Actif' OR status='Approuvé')";
$qsqlappointment1 = mysqli_query($con,$sqlappointment1);
$rsappointment1=mysqli_fetch_array($qsqlappointment1);

$sqlappointment = "SELECT * FROM appointment where appointmentid='$rsappointment1[0]'";
$qsqlappointment = mysqli_query($con,$sqlappointment);
$rsappointment=mysqli_fetch_array($qsqlappointment);

if(mysqli_num_rows($qsqlappointment) == 0)
{
	echo "<center><h2>Aucun rendez-vous trouvé..</h2></center>";
}
else
{
	$sqlappointment = "SELECT * FROM appointment where appointmentid='$rsappointment1[0]'";
	$qsqlappointment = mysqli_query($con,$sqlappointment);
	$rsappointment=mysqli_fetch_array($qsqlappointment);
	
	$sqldepartment = "SELECT * FROM department where departmentid='$rsappointment[departmentid]'";
	$qsqldepartment = mysqli_query($con,$sqldepartment);
	$rsdepartment =mysqli_fetch_array($qsqldepartment);
	
	$sqldoctor = "SELECT * FROM doctor where doctorid='$rsappointment[doctorid]'";
	$qsqldoctor = mysqli_query($con,$sqldoctor);
	$rsdoctor =mysqli_fetch_array($qsqldoctor);
?>
<table class="table table-bordered table-striped">
  <tr>
    <td>Département</td>
    <td>&nbsp;<?php echo $rsdepartment['departmentname']; ?></td>
  </tr>
  <tr>
    <td>Médecin</td>
    <td>&nbsp;<?php echo $rsdoctor['doctorname']; ?></td>
  </tr>
  <tr>
    <td>Date du rendez-vous</td>
    <td>&nbsp;<?php echo date("d-M-Y",strtotime($rsappointment['appointmentdate'])); ?></td>
  </tr>
  <tr>
    <td>Heure du rendez-vous</td>
    <td>&nbsp;<?php echo date("h:i A",strtotime($rsappointment['appointmenttime'])); ?></td>
  </tr>
</table>
<?php
}
?>
<script type="application/javascript">
function validateform()
{
	if(document.frmappntdetail.select.value == "")
	{
		alert("Le type de rendez-vous ne doit pas être vide.");
		document.frmappntdetail.select.focus();
		return false;
	}
	else if(document.frmappntdetail.select3.value == "")
	{
		alert("Le nom du département ne doit pas être vide.");
		document.frmappntdetail.select3.focus();
		return false;
	}
	else if(document.frmappntdetail.date.value == "")
	{
		alert("La date du rendez-vous ne doit pas être vide.");
		document.frmappntdetail.date.focus();
		return false;
	}
	else if(document.frmappntdetail.time.value == "")
	{
		alert("L'heure du rendez-vous ne doit pas être vide.");
		document.frmappntdetail.time.focus();
		return false;
	}
	else if(document.frmappntdetail.select5.value == "")
	{
		alert("Le nom du médecin ne doit pas être vide.");
		document.frmappntdetail.select5.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>
