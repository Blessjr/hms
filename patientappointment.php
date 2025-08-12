<?php
include("header.php");
include("dbconnection.php");
session_start();
if(isset($_POST['submit']))
{  
	if(isset($_SESSION['patientid']))
	{
		$lastinsid = $_SESSION['patientid'];
	}
	else
	{
		$dt = date("Y-m-d");
		$tim = date("H:i:s");
		$sql ="INSERT INTO patient(patientname,admissiondate,admissiontime,address,city,mobileno,loginid,password,gender,dob,status) values('$_POST[patiente]','$dt','$tim','$_POST[textarea]','$_POST[city]','$_POST[mobileno]','$_POST[loginid]','$_POST[password]','$_POST[select6]','$_POST[dob]','Active')";
		if($qsql = mysqli_query($con,$sql))
		{
			 echo "<script>alert('Enregistrement du patient inséré avec succès...');</script>"; 
		}
		else
		{
			echo mysqli_error($con);
		}
		$lastinsid = mysqli_insert_id($con);
	}
	
	$sqlappointment="SELECT * FROM appointment WHERE appointmentdate='$_POST[appointmentdate]' AND appointmenttime='$_POST[appointmenttime]' AND doctorid='$_POST[doct]' AND status='Approved'";
	$qsqlappointment = mysqli_query($con,$sqlappointment);
	if(mysqli_num_rows($qsqlappointment) >= 1)
	{
		echo "<script>alert('Un rendez-vous est déjà programmé à cette heure..');</script>";
	}
	else
	{
		$sql ="INSERT INTO appointment(appointmenttype,patientid,appointmentdate,appointmenttime,app_reason,status,departmentid,doctorid) values('ONLINE','$lastinsid','$_POST[appointmentdate]','$_POST[appointmenttime]','$_POST[app_reason]','Pending','$_POST[department]','$_POST[doct]')";
		if($qsql = mysqli_query($con,$sql))
		{
			echo "<script>alert('Enregistrement du rendez-vous inséré avec succès...');</script>";
		}
		else
		{
			echo mysqli_error($con);
		}
	}
}
if(isset($_GET['editid']))
{
	$sql="SELECT * FROM appointment WHERE appointmentid='$_GET[editid]' ";
	$qsql = mysqli_query($con,$sql);
	$rsedit = mysqli_fetch_array($qsql);
	
}
if(isset($_SESSION['patientid']))
{
    $sqlpatient = "SELECT * FROM patient WHERE patientid=18 ";
    $qsqlpatient = mysqli_query($con,$sqlpatient);
    $rspatient = mysqli_fetch_array($qsqlpatient);
    $readonly = " readonly";
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<div class="wrapper col4">
    <div id="container">

        <?php
        if(isset($_POST['submit']))
        {
           if(mysqli_num_rows($qsqlappointment) >= 1)
           {		
             echo "<h2>Un rendez-vous est déjà programmé pour le ". date("d-M-Y", strtotime($_POST['appointmentdate'])) . " à " . date("H:i A", strtotime($_POST['appointmenttime'])) . " .. </h2>";
         }
         else
         {
          if(isset($_SESSION['patientid']))
          {
             echo "<h2 class='text-center'>Rendez-vous pris avec succès.. </h2>";
             echo "<p class='text-center'>Le dossier du rendez-vous est en attente de traitement. Veuillez vérifier le statut du rendez-vous. </p>";
             echo "<p class='text-center'> <a href='viewappointment.php'>Voir le dossier du rendez-vous</a>. </p>";			
         }
         else
         {
             echo "<h2 class='text-center'>Rendez-vous pris avec succès.. </h2>";
             echo "<p class='text-center'>Le dossier du rendez-vous est en attente de traitement. Veuillez patienter pour le message de confirmation.. </p>";
             echo "<p class='text-center'> <a href='patientlogin.php'>Cliquez ici pour vous connecter</a>. </p>";	
         }
     }
 }
 else
 {
   ?>
        <!-- Contenu -->
        <div id="content">

            <!-- Prendre rendez-vous -->
            <section class="main-oppoiment" style="background-image:url('images/appointment.jpg');background-repeat: no-repeat;background-size: 75%;" >
                <div class="container">
                    <div class="row">

                        <!-- Formulaire rendez-vous -->
                        <div class="col-lg-7">
                            <div class="appointment">

                                <!-- Titre -->
                                <div class="heading-block head-left margin-bottom-50">
                                    <h4 style="color:black;font-weight:500;">Prendre un rendez-vous</h4>
                                </div>
                                <form method="post" action="" name="frmpatapp" onSubmit="return validateform()"
                                    class="appointment-form">
                                    <ul class="row">
                                        <li class="col-sm-6">
                                            <label>
                                                <input placeholder="Nom du patient" type="text" class="form-control"
                                                    name="patiente" id="patiente"
                                                    value="<?php echo $rspatient['patientname'];  ?>"
                                                    <?php echo $readonly; ?>>
                                                <i class="icon-user"></i>
                                            </label>
                                        </li>

                                        <li class="col-sm-6">
                                            <label>
                                                <input placeholder="Adresse" type="text" class="form-control"
                                                    name="textarea" id="textarea"
                                                    value="<?php echo $rspatient['address'];  ?>"
                                                    <?php echo $readonly; ?>>
                                                <i class="icon-compass"></i>
                                            </label>
                                        </li>
                                        <li class="col-sm-6">
                                            <label>
                                                <input placeholder="Ville" type="text" class="form-control"
                                                    name="city" id="city" value="<?php echo $rspatient['city'];  ?>"
                                                    <?php echo $readonly; ?>>
                                                <i class="icon-pin"></i>
                                            </label>
                                        </li>
                                        <li class="col-sm-6">
                                            <label>
                                                <input placeholder="Numéro de contact" type="text" class="form-control"
                                                    name="mobileno" id="mobileno"
                                                    value="<?php echo $rspatient['mobileno'];  ?>"
                                                    <?php echo $readonly; ?>>
                                                <i class="icon-phone"></i>
                                            </label>
                                        </li>
                                        <?php
                                        if(!isset($_SESSION['patientid']))
                                        {        
                                            ?>
                                        <li class="col-sm-6">
                                            <label>
                                                <input placeholder="Identifiant (email)" type="email" class="form-control"
                                                    name="loginid" id="loginid"
                                                    value="<?php echo $rspatient['loginid'];  ?>"
                                                    <?php echo $readonly; ?>>
                                                <i class="icon-login"></i>
                                            </label>
                                        </li>
                                        <li class="col-sm-6">
                                            <label>
                                                <input placeholder="Mot de passe" type="password" class="form-control"
                                                    name="password" id="password"
                                                    value="<?php echo $rspatient['password'];  ?>"
                                                    <?php echo $readonly; ?>>
                                                <i class="icon-lock"></i>
                                            </label>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                        <li class="col-sm-6">
                                            <label>
                                                <?php 
                                                if(isset($_SESSION['patientid']))
                                                {
                                                   echo $rspatient['gender'];
                                               }
                                               else
                                               {
                                                ?>
                                                <select name="select6" id="select6" class="selectpicker">
                                                    <option value="" selected="" hidden="" value="<?php echo $rspatient['gender']?>">Sélectionnez le sexe</option>
                                                    <?php
                                                    $arr = array("Male","Female");
                                                    foreach($arr as $val)
                                                    {
                                                        echo "<option value='$val'>$val</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <?php
                                            }
                                            ?>
                                            </label>
                                        </li>
                                        <li class="col-sm-6">
                                            <label>
                                                <input placeholder="Date de naissance" type="text" class="form-control"
                                                    name="dob" id="dob" onfocus="(this.type='date')"
                                                    value="<?php echo $rspatient['dob']; ?>" <?php echo $readonly; ?> max="<?php echo date("Y-m-d"); ?>">
                                                <i class="ion-calendar"></i>
                                            </label>
                                        </li>
                                        <li class="col-sm-6">
                                            <label>
                                                <input placeholder="Date du rendez-vous" type="text" class="form-control"
                                                    min="<?php echo date("Y-m-d"); ?>" name="appointmentdate"
                                                    onfocus="(this.type='date')" id="appointmentdate">
                                                <i class="ion-calendar"></i>
                                            </label>
                                        </li>
                                        <li class="col-sm-6">
                                            <label>
                                                <input placeholder="Heure du rendez-vous" type="text"
                                                    onfocus="(this.type='time')" class="form-control"
                                                    name="appointmenttime" id="appointmenttime">
                                                <i class="ion-ios-clock"></i>
                                            </label>
                                        </li>
                                        <li class="col-sm-6">
                                            <label>
                                                <select name="department" class="selectpicker" id="department">
                                                    <option value="">Sélectionnez le département</option>
                                                    <?php
                                                    $sqldept = "SELECT * FROM department WHERE status='Active'";
                                                    $qsqldept = mysqli_query($con,$sqldept);
                                                    while($rsdept = mysqli_fetch_array($qsqldept))
                                                    {
                                                     echo "<option value='$rsdept[departmentid]'>$rsdept[departmentname]</option>";
                                                 }
                                                 ?>
                                                </select>
                                                <i class="ion-university"></i>
                                            </label>
                                        </li>
                                        <li class="col-sm-6">
                                            <label>
                                                <select name="doct" class="selectpicker" id="department">
                                                    <option value="">Sélectionnez le médecin</option>
                                                    <?php
                                                    $sqldept = "SELECT * FROM doctor WHERE status='Active'";
                                                    $qsqldept = mysqli_query($con,$sqldept);
                                                    while($rsdept = mysqli_fetch_array($qsqldept))
                                                    {
                                                        echo "<option value='$rsdept[doctorid]'>$rsdept[doctorname] (";
                                                        $sqldept = "SELECT * FROM department WHERE departmentid='$rsdept[departmentid]'";
                                                        $qsqldepta = mysqli_query($con,$sqldept);
                                                        $rsdept = mysqli_fetch_array($qsqldepta);
                                                        echo $rsdept['departmentname'];
                                                        echo ")</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <i class="ion-medkit"></i>
                                            </label>
                                        </li>
                                        <li class="col-sm-12">
                                            <label>
                                                <textarea class="form-control" name="app_reason"
                                                    placeholder="Motif du rendez-vous"></textarea>
                                            </label>
                                        </li>
                                        <li class="col-sm-12">
                                            <button type="submit" class="btn" name="submit" id="submit">Prendre rendez-vous</button>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                }
                ?>

        </div>
    </div>
</div>
</section>
</div>

<?php
include("footer.php");
?>
<script type="application/javascript">
var alphaExp = /^[a-zA-Z]+$/; //Variable pour valider uniquement les alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable pour valider alphabets et espaces
var numericExpression = /^[0-9]+$/; //Variable pour valider uniquement les nombres
var alphanumericExp = /^[0-9a-zA-Z]+$/; //Variable pour valider chiffres et lettres
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,4}$/; //Variable pour valider un email

function validateform() {
    if (document.frmpatapp.patiente.value == "") {
        alert("Le nom du patient ne doit pas être vide.");
        document.frmpatapp.patiente.focus();
        return false;
    } else if (!document.frmpatapp.patiente.value.match(alphaspaceExp)) {
        alert("Nom du patient non valide.");
        document.frmpatapp.patiente.focus();
        return false;
    } else if (document.frmpatapp.textarea.value == "") {
        alert("L'adresse ne doit pas être vide.");
        document.frmpatapp.textarea.focus();
        return false;
    } else if (document.frmpatapp.city.value == "") {
        alert("La ville ne doit pas être vide.");
        document.frmpatapp.city.focus();
        return false;
    } else if (!document.frmpatapp.city.value.match(alphaspaceExp)) {
        alert("Nom de la ville non valide.");
        document.frmpatapp.city.focus();
        return false;
    } else if (document.frmpatapp.mobileno.value == "") {
        alert("Le numéro de téléphone ne doit pas être vide.");
        document.frmpatapp.mobileno.focus();
        return false;
    } else if (!document.frmpatapp.mobileno.value.match(numericExpression)) {
        alert("Numéro de téléphone non valide.");
        document.frmpatapp.mobileno.focus();
        return false;
    } else if (document.frmpatapp.loginid.value == "") {
        alert("L'identifiant (email) ne doit pas être vide.");
        document.frmpatapp.loginid.focus();
        return false;
    } else if (!document.frmpatapp.loginid.value.match(emailExp)) {
        alert("Identifiant (email) non valide.");
        document.frmpatapp.loginid.focus();
        return false;
    } else if (document.frmpatapp.password.value == "") {
        alert("Le mot de passe ne doit pas être vide.");
        document.frmpatapp.password.focus();
        return false;
    } else if (document.frmpatapp.password.value.length < 8) {
        alert("Le mot de passe doit contenir plus de 8 caractères.");
        document.frmpatapp.password.focus();
        return false;
    } else if (document.frmpatapp.select6.value == "") {
        alert("Le sexe doit être sélectionné.");
        document.frmpatapp.select6.focus();
        return false;
    } else if (document.frmpatapp.dob.value == "") {
        alert("La date de naissance ne doit pas être vide.");
        document.frmpatapp.dob.focus();
        return false;
    } else if (document.frmpatapp.appointmentdate.value == "") {
        alert("La date du rendez-vous ne doit pas être vide.");
        document.frmpatapp.appointmentdate.focus();
        return false;
    } else if (document.frmpatapp.appointmenttime.value == "") {
        alert("L'heure du rendez-vous ne doit pas être vide.");
        document.frmpatapp.appointmenttime.focus();
        return false;
    } else {
        return true;
    }
}

function loaddoctor(deptid) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("divdoc").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "departmentDoctor.php?deptid=" + deptid, true);
    xmlhttp.send();
}
</script>
