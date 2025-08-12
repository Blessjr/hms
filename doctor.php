<?php
include("adheader.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
			$sql ="UPDATE doctor SET doctorname='$_POST[doctorname]',mobileno='$_POST[mobilenumber]',departmentid='$_POST[select3]',loginid='$_POST[loginid]',password='$_POST[password]',status='$_POST[select]',education='$_POST[education]',experience='$_POST[experience]',consultancy_charge='$_POST[consultancy_charge]' WHERE doctorid='$_GET[editid]'";
		if($qsql = mysqli_query($con,$sql))
		{
			echo "<script>alert('Enregistrement du médecin mis à jour avec succès...');</script>";
		}
		else
		{
			echo mysqli_error($con);
		}	
	}
	else
	{
	$sql ="INSERT INTO doctor(doctorname,mobileno,departmentid,loginid,password,status,education,experience,consultancy_charge) values('$_POST[doctorname]','$_POST[mobilenumber]','$_POST[select3]','$_POST[loginid]','$_POST[password]','Active','$_POST[education]','$_POST[experience]','$_POST[consultancy_charge]')";
	if($qsql = mysqli_query($con,$sql))
	{
		echo "<script>alert('Enregistrement du médecin ajouté avec succès...');</script>";
	}
	else
	{
		echo mysqli_error($con);
	}
}
}
if(isset($_GET['editid']))
{
	$sql="SELECT * FROM doctor WHERE doctorid='$_GET[editid]' ";
	$qsql = mysqli_query($con,$sql);
	$rsedit = mysqli_fetch_array($qsql);
	
}
?>

<div class="container-fluid">
	<div class="block-header">
		<h2 class="text-center"> Ajouter un nouveau médecin </h2>
	</div>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">

				<form method="post" action="" name="frmdoct" onSubmit="return validateform()" style="padding: 10px">

					<div class="form-group"><label>Nom du médecin</label> 
					<div class="form-line">
					<input placeholder="Entrez le nom du médecin" class="form-control" type="text" name="doctorname" id="doctorname" value="<?php echo $rsedit['doctorname']; ?>" />
				</div>
				</div>

					<div class="form-group"><label>Numéro de téléphone</label> 
					<div class="form-line">
					<input placeholder="Entrez le numéro de téléphone" class="form-control" type="text" name="mobilenumber" id="mobilenumber" value="<?php echo $rsedit['mobileno']; ?>"/>
				</div>
				</div>

					<div class="form-group"><label>Département</label> 
						<div class="form-line">
					<select name="select3" id="select3" class="form-control show-tick">
						<option value="">Sélectionner</option>
						<?php
						$sqldepartment= "SELECT * FROM department WHERE status='Active'";
						$qsqldepartment = mysqli_query($con,$sqldepartment);
						while($rsdepartment=mysqli_fetch_array($qsqldepartment))
						{
							if($rsdepartment['departmentid'] == $rsedit['departmentid'])
							{
								echo "<option value='$rsdepartment[departmentid]' selected>$rsdepartment[departmentname]</option>";
							}
							else
							{
								echo "<option value='$rsdepartment[departmentid]'>$rsdepartment[departmentname]</option>";
							}

						}
						?>
					</select>
				</div>
			</div>

					<div class="form-group"><label>Identifiant de connexion</label> 
					<div class="form-line">
					<input placeholder="Entrez l’identifiant de connexion" class="form-control" type="text" name="loginid" id="loginid" value="<?php echo $rsedit['loginid']; ?>"/>
				</div>
				</div>

					<div class="form-group"><label>Mot de passe</label> 
					<div class="form-line">
					<input placeholder="Entrez le mot de passe" class="form-control" type="password" name="password" id="password" value="<?php echo $rsedit['password']; ?>"/>
				</div>
				</div>

					<div class="form-group"><label>Confirmer le mot de passe</label> 
					<div class="form-line">
					<input placeholder="Confirmez le mot de passe" class="form-control" type="password" name="cnfirmpassword" id="cnfirmpassword" value="<?php echo $rsedit['password']; ?>"/>
				</div>
				</div>

					<div class="form-group"><label>Diplôme le plus élevé</label> 
					<div class="form-line">
					<input placeholder="Entrez le diplôme le plus élevé" class="form-control" type="text" name="education" id="education" value="<?php echo $rsedit['education']; ?>" />
				</div>
				</div>

					<div class="form-group"><label>Expérience (années)</label> 
					<div class="form-line">
					<input placeholder="Entrez les années d’expérience" class="form-control" type="text" name="experience" id="experience" value="<?php echo $rsedit['experience']; ?>"/>
				</div>
				</div>

					<div class="form-group"><label>Frais de consultation</label> 
					<div class="form-line">
					<input placeholder="Entrez les frais de consultation" class="form-control" type="text" name="consultancy_charge" id="consultancy_charge" value="<?php echo $rsedit['consultancy_charge']; ?>"/>
				</div>
				</div>

					<div class="form-group">
					<label>Statut</label> 
					<div class="form-line">
					<select class="form-control show-tick" name="select" id="select">
						<option value="" selected="" hidden>Sélectionner</option>
						<?php
						$arr= array("Actif","Inactif");
						foreach($arr as $val)
						{
							if($val == $rsedit['status'])
							{
								echo "<option value='$val' selected>$val</option>";
							}
							else
							{
								echo "<option value='$val'>$val</option>";
							}
						}
						?>
					</select>
				</div>
				</div>

					<input class="btn btn-default" type="submit" name="submit" id="submit" value="Soumettre" />

				</form>
			</div>
		</div>
	</div>
</div>
<?php
include("adfooter.php");
?>
<script type="application/javascript">
var alphaExp = /^[a-zA-Z]+$/;
var alphaspaceExp = /^[a-zA-Z\s]+$/;
var numericExpression = /^[0-9]+$/;
var alphanumericExp = /^[0-9a-zA-Z]+$/;
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;

function validateform()
{
	if(document.frmdoct.doctorname.value == "")
	{
		alert("Le nom du médecin ne doit pas être vide.");
		document.frmdoct.doctorname.focus();
		return false;
	}
	else if(!document.frmdoct.doctorname.value.match(alphaspaceExp))
	{
		alert("Nom du médecin invalide.");
		document.frmdoct.doctorname.focus();
		return false;
	}
	else if(document.frmdoct.mobilenumber.value == "")
	{
		alert("Le numéro de téléphone ne doit pas être vide.");
		document.frmdoct.mobilenumber.focus();
		return false;
	}
	else if(!document.frmdoct.mobilenumber.value.match(numericExpression))
	{
		alert("Numéro de téléphone invalide.");
		document.frmdoct.mobilenumber.focus();
		return false;
	}
	else if(document.frmdoct.select3.value == "")
	{
		alert("L'identifiant du département ne doit pas être vide.");
		document.frmdoct.select3.focus();
		return false;
	}
	else if(document.frmdoct.loginid.value == "")
	{
		alert("L'identifiant de connexion ne doit pas être vide.");
		document.frmdoct.loginid.focus();
		return false;
	}
	else if(!document.frmdoct.loginid.value.match(alphanumericExp))
	{
		alert("Identifiant de connexion invalide.");
		document.frmdoct.loginid.focus();
		return false;
	}
	else if(document.frmdoct.password.value == "")
	{
		alert("Le mot de passe ne doit pas être vide.");
		document.frmdoct.password.focus();
		return false;
	}
	else if(document.frmdoct.password.value.length < 8)
	{
		alert("Le mot de passe doit comporter plus de 8 caractères.");
		document.frmdoct.password.focus();
		return false;
	}
	else if(document.frmdoct.password.value != document.frmdoct.cnfirmpassword.value )
	{
		alert("Le mot de passe et la confirmation doivent être identiques.");
		document.frmdoct.password.focus();
		return false;
	}
	else if(document.frmdoct.education.value == "")
	{
		alert("Le champ diplôme ne doit pas être vide.");
		document.frmdoct.education.focus();
		return false;
	}
	else if(!document.frmdoct.education.value.match(alphaExp))
	{
		alert("Diplôme invalide.");
		document.frmdoct.education.focus();
		return false;
	}
	else if(document.frmdoct.experience.value == "")
	{
		alert("Le champ expérience ne doit pas être vide.");
		document.frmdoct.experience.focus();
		return false;
	}
	else if(!document.frmdoct.experience.value.match(numericExpression))
	{
		alert("Expérience invalide.");
		document.frmdoct.experience.focus();
		return false;
	}
	else if(document.frmdoct.select.value == "" )
	{
		alert("Veuillez sélectionner le statut.");
		document.frmdoct.select.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>
