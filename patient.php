<?php
include("adformheader.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
		$sql ="UPDATE patient SET patientname='$_POST[patientname]', admissiondate='$_POST[admissiondate]', admissiontime='$_POST[admissiontme]', address='$_POST[address]', mobileno='$_POST[mobilenumber]', city='$_POST[city]', pincode='$_POST[pincode]', loginid='$_POST[loginid]', password='$_POST[password]', bloodgroup='$_POST[select2]', gender='$_POST[select3]', dob='$_POST[dateofbirth]', status='$_POST[select]' WHERE patientid='$_GET[editid]'";
		if($qsql = mysqli_query($con,$sql))
		{
			echo "<script>alert('Enregistrement du patient mis à jour avec succès...');</script>";
		}
		else
		{
			echo mysqli_error($con);
		}	
	}
	else
	{
		$sql ="INSERT INTO patient(patientname, admissiondate, admissiontime, address, mobileno, city, pincode, loginid, password, bloodgroup, gender, dob, status) values('$_POST[patientname]','$dt','$tim','$_POST[address]','$_POST[mobilenumber]','$_POST[city]','$_POST[pincode]','$_POST[loginid]','$_POST[password]','$_POST[select2]','$_POST[select3]','$_POST[dateofbirth]','Active')";
		if($qsql = mysqli_query($con,$sql))
		{
			echo "<script>alert('Enregistrement du patient inséré avec succès...');</script>";
			$insid= mysqli_insert_id($con);
			if(isset($_SESSION['adminid']))
			{
				echo "<script>window.location='appointment.php?patid=$insid';</script>";	
			}
			else
			{
				echo "<script>window.location='patientlogin.php';</script>";	
			}		
		}
		else
		{
			echo mysqli_error($con);
		}
	}
}
if(isset($_GET['editid']))
{
	$sql="SELECT * FROM patient WHERE patientid='$_GET[editid]' ";
	$qsql = mysqli_query($con,$sql);
	$rsedit = mysqli_fetch_array($qsql);
}
?>

<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">Panneau d'inscription du patient</h2>
    </div>
    <div class="card">

        <form method="post" action="" name="frmpatient" onSubmit="return validateform()" style="padding: 10px">

            <div class="form-group"><label>Nom du patient</label>
                <div class="form-line">
                    <input class="form-control" type="text" name="patientname" id="patientname"
                        value="<?php echo $rsedit['patientname']; ?>" />
                </div>
            </div>

            <?php
			if(isset($_GET['editid']))
			{
			?>

            <div class="form-group"><label>Date d'admission</label>
                <div class="form-line">
                    <input class="form-control" type="date" name="admissiondate" id="admissiondate"
                        value="<?php echo $rsedit['admissiondate']; ?>" readonly />
                </div>
            </div>

            <div class="form-group"><label>Heure d'admission</label>
                <div class="form-line">
                    <input class="form-control" type="time" name="admissiontme" id="admissiontme"
                        value="<?php echo $rsedit['admissiontime']; ?>" readonly />
                </div>
            </div>

            <?php
			}
			?>

            <div class="form-group">
                <label>Adresse</label>
                <div class="form-line">
                    <input class="form-control " name="address" id="tinymce" value="<?php echo $rsedit['address']; ?>">
                </div>
            </div>

            <div class="form-group"><label>Numéro de téléphone</label>
                <div class="form-line">
                    <input class="form-control" type="text" name="mobilenumber" id="mobilenumber"
                        value="<?php echo $rsedit['mobileno']; ?>" />
                </div>
            </div>

            <div class="form-group"><label>Ville</label>
                <div class="form-line">
                    <input class="form-control" type="text" name="city" id="city"
                        value="<?php echo $rsedit['city']; ?>" />
                </div>
            </div>

            <div class="form-group"><label>Code postal</label>
                <div class="form-line">
                    <input class="form-control" type="text" name="pincode" id="pincode"
                        value="<?php echo $rsedit['pincode']; ?>" />
                </div>
            </div>

            <div class="form-group"><label>ID de connexion</label>
                <div class="form-line">
                    <input class="form-control" type="text" name="loginid" id="loginid"
                        value="<?php echo $rsedit['loginid']; ?>" />
                </div>
            </div>

            <div class="form-group"><label>Mot de passe</label>
                <div class="form-line">
                    <input class="form-control" type="password" name="password" id="password"
                        value="<?php echo $rsedit['password']; ?>" />
                </div>
            </div>

            <div class="form-group"><label>Confirmer le mot de passe</label>
                <div class="form-line">
                    <input class="form-control" type="password" name="confirmpassword" id="confirmpassword"
                        value="<?php echo $rsedit['confirmpassword']; ?>" />
                </div>
            </div>

            <div class="form-group"><label>Groupe sanguin</label>
                <div class="form-line"><select class="form-control show-tick" name="select2" id="select2">
                        <option value="">Sélectionner</option>
                        <?php
					$arr = array("A+","A-","B+","B-","O+","O-","AB+","AB-");
					foreach($arr as $val)
					{
						if($val == $rsedit['bloodgroup'])
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

            <div class="form-group"><label>Genre</label>
                <div class="form-line"><select class="form-control show-tick" name="select3" id="select3">
                        <option value="">Sélectionner</option>
                        <?php
				$arr = array("MALE","FEMALE");
				foreach($arr as $val)
				{
					if($val == $rsedit['gender'])
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

            <div class="form-group"><label>Date de naissance</label>
                <div class="form-line">
                    <input class="form-control" type="date" name="dateofbirth" max="<?php echo date("Y-m-d"); ?>"
                        id="dateofbirth" value="<?php echo $rsedit['dob']; ?>" />
                </div>
            </div>

            <input class="btn btn-default" type="submit" name="submit" id="submit" value="Envoyer" />

        </form>
        <p>&nbsp;</p>
    </div>
</div>
</div>
<div class="clear"></div>
</div>
</div>
<?php
include("adformfooter.php");
?>

<script type="application/javascript">
var alphaExp = /^[a-zA-Z]+$/; // Validation alphabets uniquement
var alphaspaceExp = /^[a-zA-Z\s]+$/; // Validation alphabets + espaces
var numericExpression = /^[0-9]+$/; // Validation nombres uniquement
var alphanumericExp = /^[0-9a-zA-Z]+$/; // Validation alphanumérique
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; // Validation Email

function validateform() {
    if (document.frmpatient.patientname.value == "") {
        alert("Le nom du patient ne doit pas être vide.");
        document.frmpatient.patientname.focus();
        return false;
    } else if (!document.frmpatient.patientname.value.match(alphaspaceExp)) {
        alert("Nom du patient non valide.");
        document.frmpatient.patientname.focus();
        return false;
    } else if (document.frmpatient.admissiondate.value == "") {
        alert("La date d'admission ne doit pas être vide.");
        document.frmpatient.admissiondate.focus();
        return false;
    } else if (document.frmpatient.admissiontme.value == "") {
        alert("L'heure d'admission ne doit pas être vide.");
        document.frmpatient.admissiontme.focus();
        return false;
    } else if (document.frmpatient.address.value == "") {
        alert("L'adresse ne doit pas être vide.");
        document.frmpatient.address.focus();
        return false;
    } else if (document.frmpatient.mobilenumber.value == "") {
        alert("Le numéro de téléphone ne doit pas être vide.");
        document.frmpatient.mobilenumber.focus();
        return false;
    } else if (!document.frmpatient.mobilenumber.value.match(numericExpression)) {
        alert("Numéro de téléphone non valide.");
        document.frmpatient.mobilenumber.focus();
        return false;
    } else if (document.frmpatient.city.value == "") {
        alert("La ville ne doit pas être vide.");
        document.frmpatient.city.focus();
        return false;
    } else if (!document.frmpatient.city.value.match(alphaspaceExp)) {
        alert("Ville non valide.");
        document.frmpatient.city.focus();
        return false;
    } else if (document.frmpatient.pincode.value == "") {
        alert("Le code postal ne doit pas être vide.");
        document.frmpatient.pincode.focus();
        return false;
    } else if (!document.frmpatient.pincode.value.match(numericExpression)) {
        alert("Code postal non valide.");
        document.frmpatient.pincode.focus();
        return false;
    } else if (document.frmpatient.loginid.value == "") {
        alert("L'identifiant de connexion ne doit pas être vide.");
        document.frmpatient.loginid.focus();
        return false;
    } else if (!document.frmpatient.loginid.value.match(alphanumericExp)) {
        alert("Identifiant de connexion non valide.");
        document.frmpatient.loginid.focus();
        return false;
    } else if (document.frmpatient.password.value == "") {
        alert("Le mot de passe ne doit pas être vide.");
        document.frmpatient.password.focus();
        return false;
    } else if (document.frmpatient.password.value.length < 8) {
        alert("Le mot de passe doit contenir au moins 8 caractères.");
        document.frmpatient.password.focus();
        return false;
    } else if (document.frmpatient.password.value != document.frmpatient.confirmpassword.value) {
        alert("Le mot de passe et la confirmation doivent être identiques.");
        document.frmpatient.confirmpassword.focus();
        return false;
    } else if (document.frmpatient.select2.value == "") {
        alert("Le groupe sanguin ne doit pas être vide.");
        document.frmpatient.select2.focus();
        return false;
    } else if (document.frmpatient.select3.value == "") {
        alert("Le genre ne doit pas être vide.");
        document.frmpatient.select3.focus();
        return false;
    } else if (document.frmpatient.dateofbirth.value == "") {
        alert("La date de naissance ne doit pas être vide.");
        document.frmpatient.dateofbirth.focus();
        return false;
    } else if (document.frmpatient.select.value == "") {
        alert("Veuillez sélectionner le statut.");
        document.frmpatient.select.focus();
        return false;
    } else {
        return true;
    }
}
</script>
