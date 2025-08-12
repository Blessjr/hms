<?php
include("adheader.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_SESSION['doctorid']))
	{
		$sql ="UPDATE doctor SET doctorname='$_POST[doctorname]',mobileno='$_POST[mobilenumber]',departmentid='$_POST[select3]',loginid='$_POST[loginid]',education='$_POST[education]',experience='$_POST[experience]',consultancy_charge='$_POST[consultancy_charge]' WHERE doctorid='$_SESSION[doctorid]'";
		if($qsql = mysqli_query($con,$sql))
		{
			echo "<script>alert('Profil du médecin mis à jour avec succès...');</script>";
		}
		else
		{
			echo mysqli_error($con);
		}	
	}
	else
	{
		$sql ="INSERT INTO doctor(doctorname,mobileno,departmentid,loginid,password,status,education,experience) values('$_POST[doctorname]','$_POST[mobilenumber]','$_POST[select3]','$_POST[loginid]','$_POST[password]','$_POST[select]','$_POST[education]','$_POST[experience]')";
		if($qsql = mysqli_query($con,$sql))
		{
			echo "<script>alert('Enregistrement du médecin inséré avec succès...');</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
}
if(isset($_SESSION['doctorid']))
{
	$sql="SELECT * FROM doctor WHERE doctorid='$_SESSION[doctorid]' ";
	$qsql = mysqli_query($con,$sql);
	$rsedit = mysqli_fetch_array($qsql);
	
}
?>
<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">Profil du Médecin</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">

                <form method="post" action="" name="frmdoctprfl" onSubmit="return validateform()" style="padding: 10px">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Nom du médecin</label>
                                <div class="form-line">
                                    <input class="form-control" type="text" name="doctorname" id="doctorname"
                                        value="<?php echo $rsedit['doctorname']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Numéro de portable</label>
                                <div class="form-line">
                                    <input class="form-control" type="text" name="mobilenumber" id="mobilenumber"
                                        value="<?php echo $rsedit['mobileno']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Département</label>
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>ID de connexion</label>
                                <div class="form-line">
                                    <input class="form-control" type="text" name="loginid" id="loginid"
                                        value="<?php echo $rsedit['loginid']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Formation</label>
                                <div class="form-line">
                                    <input class="form-control" type="text" name="education" id="education"
                                        value="<?php echo $rsedit['education']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Expérience</label>
                                <div class="form-line">
                                    <input class="form-control" type="text" name="experience" id="experience"
                                        value="<?php echo $rsedit['experience']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Frais de consultation</label>
                                <div class="form-line">

                                    <input class="form-control" type="text" name="consultancy_charge"
                                        id="consultancy_charge" value="<?php echo $rsedit['consultancy_charge']; ?>" />
                                </div>
                            </div>

                            <input class="btn btn-raised" type="submit" name="submit" id="submit" value="Envoyer" />
                        </div>
                    </div>

                </form>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
</div>
<?php
												include("adfooter.php");
												?>
<script type="application/javascript">
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphanumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 

function validateform() {
    if (document.frmdoctprfl.doctorname.value == "") {
        alert("Le nom du médecin ne doit pas être vide.");
        document.frmdoctprfl.doctorname.focus();
        return false;
    } else if (!document.frmdoctprfl.doctorname.value.match(alphaspaceExp)) {
        alert("Nom du médecin non valide.");
        document.frmdoctprfl.doctorname.focus();
        return false;
    } else if (document.frmdoctprfl.mobilenumber.value == "") {
        alert("Le numéro de portable ne doit pas être vide.");
        document.frmdoctprfl.mobilenumber.focus();
        return false;
    } else if (!document.frmdoctprfl.mobilenumber.value.match(numericExpression)) {
        alert("Numéro de portable non valide.");
        document.frmdoctprfl.mobilenumber.focus();
        return false;
    } else if (document.frmdoctprfl.select3.value == "") {
        alert("L'identifiant du département ne doit pas être vide.");
        document.frmdoctprfl.select3.focus();
        return false;
    } else if (document.frmdoctprfl.loginid.value == "") {
        alert("L'identifiant de connexion ne doit pas être vide.");
        document.frmdoctprfl.loginid.focus();
        return false;
    } else if (!document.frmdoctprfl.loginid.value.match(alphanumericExp)) {
        alert("Identifiant de connexion non valide.");
        document.frmdoctprfl.loginid.focus();
        return false;
    } else if (document.frmdoctprfl.password.value == "") {
        alert("Le mot de passe ne doit pas être vide.");
        document.frmdoctprfl.password.focus();
        return false;
    } else if (document.frmdoctprfl.password.value.length < 8) {
        alert("Le mot de passe doit contenir plus de 8 caractères.");
        document.frmdoctprfl.password.focus();
        return false;
    } else if (document.frmdoctprfl.password.value != document.frmdoctprfl.cnfirmpassword.value) {
        alert("Le mot de passe et la confirmation doivent être identiques.");
        document.frmdoctprfl.password.focus();
        return false;
    } else if (document.frmdoctprfl.education.value == "") {
        alert("La formation ne doit pas être vide.");
        document.frmdoctprfl.education.focus();
        return false;
    } else if (!document.frmdoctprfl.education.value.match(alphaExp)) {
        alert("Formation non valide.");
        document.frmdoctprfl.education.focus();
        return false;
    } else if (document.frmdoctprfl.experience.value == "") {
        alert("L'expérience ne doit pas être vide.");
        document.frmdoctprfl.experience.focus();
        return false;
    } else if (!document.frmdoctprfl.experience.value.match(numericExpression)) {
        alert("Expérience non valide.");
        document.frmdoctprfl.experience.focus();
        return false;
    } else if (document.frmdoctprfl.select.value == "") {
        alert("Veuillez sélectionner le statut.");
        document.frmdoctprfl.select.focus();
        return false;
    } else {
        return true;
    }
}
</script>
