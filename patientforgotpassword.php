<?php
session_start();
include("header.php");
include("dbconnection.php");

if(isset($_SESSION['patientid']))
{
	echo "<script>window.location='patientaccount.php';</script>";
}

if(isset($_POST['submit']))
{
	$sql = "SELECT * FROM patient WHERE loginid='$_POST[loginid]' AND status='Active'";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_num_rows($qsql) >= 1)
	{
		$rslogin = mysqli_fetch_array($qsql);
		
		$msg = "Veuillez utiliser ce Login ID : $rslogin[loginid] et ce mot de passe : $rslogin[password] pour vous connecter au système HMS..";
		?>
		<iframe style="visibility:hidden" src="http://login.smsgatewayhub.com/api/mt/SendSMS?APIKey=qyQgcDu3EEiw1VfItgv1tA&senderid=WEBSMS&channel=1&DCS=0&flashsms=0&number=<?php echo $rslogin['mobileno']; ?>&text=<?php echo urlencode($msg); ?>&route=1"></iframe>	
		<?php	
		echo "<script>alert('Les informations de connexion ont été envoyées sur votre numéro de mobile enregistré...'); </script>";
		echo "<script>window.location='patientlogin.php';</script>";
	}
	else
	{
		echo "<script>alert('Login ID invalide saisi..'); </script>";
	}
}
?>

<div class="wrapper col2">
  <div id="breadcrumb">
    <ul>
      <li class="first">Récupération de mot de passe</li>
    </ul>
  </div>
</div>

<div class="wrapper col4">
  <div id="container">
    <h1>Veuillez saisir votre Login ID pour récupérer le mot de passe..</h1>
    <form method="post" action="" name="frmpatlogin" onsubmit="return validateform()">
      <table width="200" border="3">
        <tbody>
          <tr>
            <td width="34%">Login ID</td>
            <td width="66%"><input type="text" name="loginid" id="loginid" /></td>
          </tr>
          <tr>
            <td height="36" colspan="2" align="center">
              <input type="submit" name="submit" id="submit" value="Récupérer le mot de passe" />
            </td>
          </tr>
        </tbody>
      </table>
    </form>
    <p>&nbsp;</p>
  </div>
</div>

<?php
include("footer.php");
?>

<script type="application/javascript">
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,4}$/;

function validateform()
{
	if(document.frmpatlogin.loginid.value == "")
	{
		alert("Le Login ID ne doit pas être vide.");
		document.frmpatlogin.loginid.focus();
		return false;
	}
	else if(!document.frmpatlogin.loginid.value.match(emailExp))
	{
		alert("Le Login ID n'est pas valide.");
		document.frmpatlogin.loginid.focus();
		return false;
	}
	return true;
}
</script>
