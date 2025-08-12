<?php
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
	
	$sql ="INSERT INTO `orders`( `patientid`, `orderdate`,  `address`, `mobileno`)  values('$_POST[select2]','$_POST[orderdate]','$_POST[address]','$_POST[mobilenumber]')";
	if($qsql = mysqli_query($con,$sql))
	{
		echo "<script>alert('Enregistrement de commande du patient inséré avec succès...');</script>";
	}
	else
	{
		echo mysqli_error($con);
	}
}

if(isset($_GET['editid']))
{
	$sql="SELECT * FROM orders WHERE orderid='$_GET[editid]' ";
	$qsql = mysqli_query($con,$sql);
	$rsedit = mysqli_fetch_array($qsql);
	
}
?>

<div class="wrapper col2">
  <div id="breadcrumb">
    <ul>
      <li class="first">Ajouter une nouvelle commande</li></ul>
  </div>
</div>
<div class="wrapper col4">
  <div id="container">
    <h1>Ajouter un nouvel enregistrement de commande</h1>
      <form method="post" action="" name="frmpatorder" onSubmit="return validateform()">
    <table width="200" border="3">
      <tbody>
        <tr>
          <td width="34%">Patient</td>
          <td width="66%"><select name="select2" id="select2">
           <option value="">Sélectionner</option>
            <?php
		  	$sqlpatient= "SELECT * FROM patient WHERE status='Active'";
			$qsqlpatient = mysqli_query($con,$sqlpatient);
			while($rspatient=mysqli_fetch_array($qsqlpatient))
			{
				if($rspatient['patientid'] == $rsedit['patientid'])
				{
				echo "<option value='$rspatient[patientid]' selected>$rspatient[patientid] - $rspatient[patientname]</option>";
				}
				else
				{
					echo "<option value='$rspatient[patientid]'>$rspatient[patientid] - $rspatient[patientname]</option>";
				}
				
			}
		  ?>
          </select></td>
        </tr>
        <tr>
          <td>Date de la commande</td>
          <td><input type="date" name="orderdate" id="orderdate" value="<?php echo $rsedit['orderdate']; ?>" /></td>
        </tr>
        <tr>
          <td>Adresse</td>
          <td><textarea name="address" id="address" cols="45" rows="5"><?php echo $rsedit['address']; ?></textarea></td>
        </tr>
        <tr>
          <td>Numéro de téléphone portable</td>
          <td><input type="text" name="mobilenumber" id="mobilenumber" value="<?php echo $rsedit['mobileno']; ?>" /></td>
        </tr>

        <tr>
          <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="Envoyer" /></td>
        </tr>
      </tbody>
    </table>
    </form>
    <p>&nbsp;</p>
  </div>
</div>
</div>
 <div class="clear"></div>
  </div>
</div>
<?php
include("footer.php");
?>
<script type="application/javascript">
var alphaExp = /^[a-zA-Z]+$/; //Variable pour valider uniquement les alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable pour valider uniquement les alphabets et espaces
var numericExpression = /^[0-9]+$/; //Variable pour valider uniquement les chiffres
var alphanumericExp = /^[0-9a-zA-Z]+$/; //Variable pour valider chiffres et alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable pour valider l'adresse email

function validateform()
{
	if(document.frmpatorder.select2.value == "")
	{
		alert("Le nom du patient ne doit pas être vide.");
		document.frmpatorder.select2.focus();
		return false;
	}
	
	else if(document.frmpatorder.orderdate.value == "")
	{
		alert("La date de la commande ne doit pas être vide.");
		document.frmpatorder.orderdate.focus();
		return false;
	}
	else if(document.frmpatorder.address.value == "")
	{
		alert("L'adresse ne doit pas être vide.");
		document.frmpatorder.address.focus();
		return false;
	}
	else if(document.frmpatorder.mobilenumber.value == "")
	{
		alert("Le numéro de téléphone portable ne doit pas être vide.");
		document.frmpatorder.mobilenumber.focus();
		return false;
	}
	else if(!document.frmpatorder.mobilenumber.value.match(numericExpression))
	{
		alert("Le numéro de téléphone portable n'est pas valide.");
		document.frmpatorder.mobilenumber.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>
