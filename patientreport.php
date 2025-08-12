<?php

include("adheader.php");
session_start();
include("dbconnection.php");
if(isset($_POST['submit']))
{
    if(isset($_GET['editid']))
    {
        $sql ="UPDATE appointment SET patientid='$_POST[select4]',departmentid='$_POST[select5]',appointmentdate='$_POST[appointmentdate]',appointmenttime='$_POST[time]',doctorid='$_POST[select6]',status='$_POST[select]' WHERE appointmentid='$_GET[editid]'";
        if($qsql = mysqli_query($con,$sql))
        {
            echo "<script>alert('Enregistrement du rendez-vous mis à jour avec succès...');</script>";
        }
        else
        {
            echo mysqli_error($con);
        }   
    }
    else
    {
        $sql ="INSERT INTO appointment(patientid,departmentid,appointmentdate,appointmenttime,doctorid,status) values('$_POST[select4]','$_POST[select5]','$_POST[appointmentdate]','$_POST[time]','$_POST[select6]','$_POST[select]')";
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
?>

<div class="wrapper col2">
  <div id="breadcrumb">
      <h1></h1>
  </div>
</div>

<div class="container-fluid">
    <div class="block-header">
            <h2>Panneau de Rapport Patient</h2>
    </div>
  <div class="card">
    <p>
    
    <!-- jQuery Library -->
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) { 

    // Trouver les toggles et cacher leur contenu
    $('.toggle').each(function(){
        $(this).find('.toggle-content').hide();
    });

    // Quand un toggle est cliqué (activé) afficher son contenu
    $('.toggle a.toggle-trigger').click(function(){
        var el = $(this), parent = el.closest('.toggle');

        if( el.hasClass('active') )
        {
            parent.find('.toggle-content').slideToggle();
            el.removeClass('active');
        }
        else
        {
            parent.find('.toggle-content').slideToggle();
            el.addClass('active');
        }
        return false;
    });

});  //Fin
</script>
<!-- Toggle CSS -->
<style type="text/css">

/* Toggle principal */
.toggle { 
    font-size: 13px;
    line-height:20px;
    font-family: "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
    background: #ffffff; /* Fond principal */
    margin-bottom: 10px;
    border: 1px solid #e5e5e5;
    -webkit-border-radius: 5px;
       -moz-border-radius: 5px;
            border-radius: 5px;  
}

/* Texte du lien toggle */
.toggle a.toggle-trigger {
    display:block;
    padding: 10px 20px 15px 20px;
    position:relative;
    text-decoration: none;
    color: #666;
}

/* Etat hover du lien toggle */
.toggle a.toggle-trigger:hover {
    opacity: .8;
    text-decoration: none;
}

/* Lien toggle quand cliqué */
.toggle a.active {
    text-decoration: none;
    border-bottom: 1px solid #e5e5e5;
    -webkit-box-shadow: 0 8px 6px -6px #ccc;
       -moz-box-shadow: 0 8px 6px -6px #ccc;
            box-shadow: 0 8px 6px -6px #ccc;
    color: #000;
}

/* Ajout d'un "-" avant le lien toggle */
.toggle a.toggle-trigger:before {
    content: "-";  /* Vous pouvez ajouter un symbole, icône ou graphique */
    margin-right: 10px;
    font-size: 1.3em;  
}

/* Quand le toggle est actif, changer "-" en "+" */
.toggle a.active.toggle-trigger:before {
    content: "+";
}

/* Contenu du toggle */
.toggle .toggle-content {
    padding: 10px 20px 15px 20px;
    color:#666;
}

</style>
<!-- Toggle #1 -->
<div class="toggle">
    <!-- Lien Toggle -->
    <a href="#" title="Profil Patient" class="toggle-trigger">Profil Patient</a>
    <!-- Contenu Toggle à afficher -->
    <div class="toggle-content">
        <p><?php include("patientdetail.php"); ?></p>
    </div><!-- .toggle-content (fin) -->
</div><!-- .toggle (fin) -->

<!-- Toggle #2 -->
<div class="toggle">
    <!-- Lien Toggle -->
    <a href="#" title="Enregistrement des rendez-vous" class="toggle-trigger">Enregistrement des rendez-vous</a>
    <!-- Contenu Toggle à afficher -->
    <div class="toggle-content">
        <p><?php include("appointmentdetail.php"); ?></p>
    </div><!-- .toggle-content (fin) -->
</div><!-- .toggle (fin) -->

<!-- Toggle #3 -->
<div class="toggle">
    <!-- Lien Toggle -->
    <a href="#" title="Enregistrement des traitements" class="toggle-trigger">Enregistrement des traitements</a>
    <!-- Contenu Toggle à afficher -->
    <div class="toggle-content">
        <p><?php include("treatmentdetail.php"); ?></p>
    </div><!-- .toggle-content (fin) -->
</div><!-- .toggle (fin) -->

<!-- Toggle #4 -->
<div class="toggle">
    <!-- Lien Toggle -->
    <a href="#" title="Enregistrement des prescriptions" class="toggle-trigger">Enregistrement des prescriptions</a>
    <!-- Contenu Toggle à afficher -->
    <div class="toggle-content">
        <p><?php include("prescriptiondetail.php"); ?></p>
    </div><!-- .toggle-content (fin) -->
</div><!-- .toggle (fin) -->

<!-- Toggle #5 -->
<div class="toggle">
    <!-- Lien Toggle -->
    <a href="#" title="Rapport de facturation" class="toggle-trigger">Rapport de facturation</a>
    <!-- Contenu Toggle à afficher -->
    <div class="toggle-content">
        <p><?php
        $billappointmentid= $rsappointment[0]; 
        include("viewbilling.php"); ?>
        </p>
    </div><!-- .toggle-content (fin) -->
</div><!-- .toggle (fin) -->

<?php
if(isset($_SESSION['patientid']) or isset($_SESSION['adminid']) or isset($_SESSION['doctorid']) )
{
?>
    <!-- Toggle #6 -->
    <div class="toggle">
        <!-- Lien Toggle -->
        <a href="#" title="Rapport de paiement" class="toggle-trigger">Rapport de paiement</a>
        <!-- Contenu Toggle à afficher -->
        <div class="toggle-content">
            <p><?php
            $billappointmentid= $rsappointment[0]; 
            include("viewpaymentreport.php"); ?>
            <?php
            if(isset($_SESSION['patientid']))
            {
                $sqlbilling_records ="SELECT * FROM billing WHERE appointmentid='$billappointmentid'";
                $qsqlbilling_records = mysqli_query($con,$sqlbilling_records);
                $rsbilling_records = mysqli_fetch_array($qsqlbilling_records);
                if($balanceamt>0){
                    ?>  
                    <a class="btn btn-raised" href="paymentdischarge.php?appointmentid=<?php echo $rsappointment[0]; ?>&patientid=<?php echo $_GET['patientid']; ?>">Effectuer un paiement</a>
                <?php
                }
            }
            ?>
            </p>
        </div><!-- .toggle-content (fin) -->
    </div><!-- .toggle (fin) -->
<?php
}
?>
    </p>
  </div>
</div>
</div>
 <div class="clear"></div>
  </div>
</div>
<?php
include("adfooter.php");
?>
