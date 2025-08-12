<table class="table table-bordered table-striped">
  <tbody>
    <tr>
      <th>Médecin</th>
      <th>Patient</th>
      <th>Date de l'ordonnance</th>
      <th>Voir</th>              
    </tr>
<?php
include("dbconnection.php");
$sql ="SELECT * FROM prescription WHERE patientid='$_GET[patientid]' AND appointmentid='$_GET[appointmentid]'";
$qsql = mysqli_query($con,$sql);
while($rs = mysqli_fetch_array($qsql))
{
	$sqlpatient = "SELECT * FROM patient WHERE patientid='$rs[patientid]'";
	$qsqlpatient = mysqli_query($con,$sqlpatient);
	$rspatient = mysqli_fetch_array($qsqlpatient);
	
	$sqldoctor = "SELECT * FROM doctor WHERE doctorid='$rs[doctorid]'";
	$qsqldoctor = mysqli_query($con,$sqldoctor);
	$rsdoctor = mysqli_fetch_array($qsqldoctor);

            echo "<tr>
              		<td>&nbsp;$rsdoctor[doctorname]</td>
              		<td>&nbsp;$rspatient[patientname]</td>
               		<td>&nbsp;$rs[prescriptiondate]</td>
					<td><a href='prescriptionrecord.php?prescriptionid=$rs[0]&patientid=$rs[patientid]' >Voir</a></td>
            </tr>";
}
?>    
  </tbody>
</table>
<?php
if(isset($_SESSION['doctorid']))
{
$tidsql ="SELECT treatment_records_id FROM treatment_records WHERE patientid='$_GET[patientid]' AND appointmentid='$_GET[appointmentid]'";
$tqsql = mysqli_query($con,$tidsql);
$trs = mysqli_fetch_array($tqsql);
?>  
<hr>
	<table>
		<tr>
			<td>
			<div align="center"><a href="prescription.php?patientid=<?php echo $_GET['patientid']; ?>&appid=<?php echo $rsappointment['appointmentid']; ?>&treatmentid=<?php echo $trs['treatment_records_id']; ?>">Ajouter des dossiers d'ordonnance</a></div>
			</td>
		</tr>
	</table>
<?php
}
?>
