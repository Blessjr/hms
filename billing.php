<?php
include("header.php");
include("dbconnection.php");
if(isset($_POST['submit']))
{
    $servicetypeid= $_POST['servicetypeid'];
    $billtype = "Frais de service";
    include("insertbillingrecord.php");
}
?>

<div class="wrapper col2">
  <div id="breadcrumb">
    <ul>
      <li class="first">Ajouter un frais de service</li>
    </ul>
  </div>
</div>
<div class="wrapper col4">
  <div id="container">
    <h1>Ajouter un nouveau frais de service</h1>
    <form method="post" action="" name="frmbill" onSubmit="return validateform()">

      <table width="342" border="3">
        <tbody>
          <tr>
            <td width="34%">Date </td>
            <td width="66%">
              <input min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>" type="date" name="date" id="date">
            </td>
          </tr>

          <tr>
            <td>Type de service</td>
            <td>
              <select name="servicetypeid" id="servicetypeid" class="form-control">
                <option value="">Sélectionnez un type de service</option>
                <?php
                $sqlservice = "SELECT * FROM servicetype WHERE status='Active'";
                $qsqlservice = mysqli_query($con, $sqlservice);
                while($rsservice = mysqli_fetch_array($qsqlservice))
                {
                    echo "<option value='$rsservice[servicetypeid]'>$rsservice[servicetypename]</option>";
                }
                ?>
              </select>
            </td>
          </tr>

          <tr>
            <td>Frais supplémentaires</td>
            <td><input type="text" name="amount" id="amount"></td>
          </tr>

          <tr>
            <td colspan="2" align="center">
              <input type="submit" name="submit" id="submit" value="Ajouter un frais de service" />
            </td>
          </tr>
        </tbody>
      </table>
    </form>

    <?php
    $billappointmentid = $_GET['appointmentid'];
    include("viewbilling.php");
    ?>

    <table width="342" border="3">
      <thead>
        <tr>
          <td colspan="2" align="center">
            <a href='patientreport.php?patientid=<?php echo $_GET['patientid']; ?>'><strong>Voir le rapport du patient >></strong></a>
          </td>
        </tr>
      </thead>
    </table>
    <p>&nbsp;</p>
  </div>
</div>

<?php
include("footer.php");
?>

<script type="application/javascript">
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers

function validateform()
{
  if(document.frmbill.servicetypeid.value == "")
  {
    alert("Le type de service ne doit pas être vide.");
    document.frmbill.servicetypeid.focus();
    return false;
  }
  else if(document.frmbill.date.value == "")
  {
    alert("La date de facturation ne doit pas être vide.");
    document.frmbill.date.focus();
    return false;
  }
  else if(document.frmbill.amount.value == "")
  {
    alert("Le montant ne doit pas être vide.");
    document.frmbill.amount.focus();
    return false;
  }
  else if(!document.frmbill.amount.value.match(numericExpression))
  {
    alert("Montant non valide.");
    document.frmbill.amount.focus();
    return false;
  }
  else
  {
    return true;
  }
}
</script>
