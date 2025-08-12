<?php
session_start();
?>
<style>
/* Styles du menu principal */
#mmenu, #mmenu ul {
  margin: 0;
  padding: 0;
  list-style: none;
}
#mmenu {
  width: 100%;
  border: 1px solid #222;
  background-color: #111;
  background-image: linear-gradient(#444, #111);
  border-radius: 6px;
  box-shadow: 0 1px 1px #777, 0 1px 0 #666 inset;
}
/* Autres styles pour le menu, liens, sous-menus, etc. */
</style>
<?php
if(isset($_SESSION['adminid']))
{
?>
<div id="mmenu">
<li><a href="adminaccount.php">Compte</a></li>
<li>
<a href=" ######### ">Profil</a>
    <ul>
    <li><a href="adminprofile.php">Profil Admin</a></li>
    <li><a href="adminchangepassword.php">Changer le mot de passe</a></li>
    <li><a href="admin.php" style="width:150px;">Ajouter un admin</a></li>    	
    </ul>
</li>
<li><a href=" ######### ">Patient</a>
    <ul>
   <li><a href="patient.php">Ajouter un patient</a></li>
   <li><a href="viewpatient.php">Voir les dossiers patients</a></li>
    </ul>
</li>
<li>
<a href=" ######### ">Rendez-vous</a>
    <ul>
    <li><a href="appointment.php" style="width:200px;">Nouveau rendez-vous</a></li>
    <li><a href="viewappointmentpending.php" style="width:200px;">Voir rendez-vous en attente</a></li>
    <li><a href="viewappointmentapproved.php" style="width:200px;">Voir rendez-vous approuvés</a></li>
    </ul>
</li>
<li><a href="viewtreatmentrecord.php">Traitement</a></li>
<li>
<a href=" ######### ">Médecin</a>
    <ul>
    <li><a href="doctor.php">Ajouter un médecin</a></li>
    <li><a href="Viewdoctor.php">Voir médecins</a></li>
    <li><a href="doctortimings.php">Ajouter horaires médecin</a></li>
    <li><a href="viewdoctortimings.php">Voir horaires médecin</a></li>
    </ul>
</li>
<li>
<a href=" ######### ">Paramètres</a>
    <ul>
    <li><a href="department.php" style="width:150px;">Ajouter un département</a></li>
    <li><a href="Viewdepartment.php" style="width:150px;">Voir départements</a></li>
    <li><a href="treatment.php" style="width:150px;">Ajouter type de traitement</a></li>
    <li><a href="viewtreatment.php" style="width:150px;">Voir types de traitement</a></li>
    <li><a href="medicine.php" style="width:150px;">Ajouter médicament</a></li>
    <li><a href="Viewmedicine.php" style="width:150px;">Voir médicaments</a></li>
    </ul>
</li>
<li><a href="logout.php">Se déconnecter</a></li>
</div>
<?php
}
?>

<?php
if(isset($_SESSION['doctorid']))
{
?>
<div id="mmenu">
    <li><a href="doctoraccount.php">Compte</a></li>
    <li>
    <a href=" ######### ">Paramètres</a>
        <ul>
        <li><a href="doctorprofile.php">Profil</a></li>
        <li><a href="doctorchangepassword.php">Changer le mot de passe</a></li>
        </ul>
    </li>
    <li>
    <a href=" ######### ">Rendez-vous</a>
        <ul>
        <li><a href="viewappointmentpending.php" style="width:250px;">Voir rendez-vous en attente</a></li>
        <li><a href="viewappointmentapproved.php" style="width:250px;">Voir rendez-vous approuvés</a></li>
        </ul>
    </li>
    <li><a href=" ######### ">Patient</a>
        <ul>
        <li><a href="viewpatient.php">Voir patients</a></li>
        </ul>
    </li>
    <li><a href=" ######### ">Horaires médecin</a>
        <ul>
        <li><a href="doctortimings.php">Ajouter horaires</a></li>
        <li><a href="viewdoctortimings.php">Voir horaires</a></li>
        </ul>
    </li>
    <li>
    <a href=" ######### ">Traitement</a>
        <ul>
        <li><a href="viewtreatmentrecord.php">Voir dossiers de traitement</a></li>
        <li><a href="viewtreatment.php">Voir traitement</a></li>
        </ul>
    </li>    
    <li><a href="viewdoctorconsultancycharge.php">Rapport de revenus</a></li>
    <li><a href="logout.php">Se déconnecter</a></li>       
</div>
<?php
}
?>

<?php
if(isset($_SESSION['patientid']))
{
?>
<div id="mmenu">
<li><a href="patientaccount.php">Compte</a></li>
<li>
<a href=" ######### ">Rendez-vous</a>
    <ul>
    <li><a href="patientappointment.php" style="width:200px;">Ajouter un rendez-vous</a></li>
    <li><a href="viewappointment.php" style="width:200px;">Voir rendez-vous</a></li>
    </ul>
</li>
<li>
<a href=" ######### ">Profil</a>
    <ul>
    <li><a href="patientprofile.php">Voir profil</a></li>
    <li><a href="patientchangepassword.php">Changer le mot de passe</a></li>
    </ul>
</li>
<li>
<a href=" ######### ">Ordonnance</a>
    <ul >
       <li><a style="width:200px;" href="patviewprescription.php">Voir ordonnances</a></li>
    </ul>
</li>
<li>
<a href=" ######### ">Traitement</a>
    <ul>
       <li><a href="viewtreatmentrecord.php">Voir dossiers de traitement</a></li>
    </ul>
</li>
<li><a href="logout.php">Se déconnecter</a></li>
</div>
<?php
}
?>
