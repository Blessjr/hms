<?php
session_start();
error_reporting(0);  // Change to E_ALL & display errors = On for debugging if needed
include("dbconnection.php");

$dt = date("Y-m-d");
$tim = date("H:i:s");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>HMS - Admin</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/morrisjs/morris.css" rel="stylesheet" />
    <!-- Custom Css -->
    <link href="assets/css/main.css" rel="stylesheet" />
    <link href="assets/css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-cyan" style="background-color:#663399;">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-cyan">
                    <div class="circle-clipper left"><div class="circle"></div></div>
                    <div class="circle-clipper right"><div class="circle"></div></div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->

    <!-- Overlay For Sidebars -->
    <div class="overlay" style="background-color:#663399;"></div>
    <!-- #END# Overlay For Sidebars -->

    <!-- Top Bar -->
    <nav class="navbar clearHeader" style="background-color:#8B008B;">
        <div class="col-12">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="#">DOCTO LINK</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a data-placement="bottom" title="Logout" href="logout.php">
                        <i class="zmdi zmdi-sign-in"></i>
                    </a>
                </li>               
            </ul>
        </div>
    </nav>
    <!-- #Top Bar -->

    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <?php if (isset($_SESSION['adminid'])) { ?>
                <!-- Admin Menu -->
                <div class="menu" style="background-color:#663399;">
                    <ul class="list">
                        <li class="header">NAVIGATION PRINCIPALE</li>
                        <li class="active open"><a href="adminaccount.php"><i class="zmdi zmdi-home"></i><span>Tableau de Bord</span></a></li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-calendar-check"></i><span>Profil</span></a>
                            <ul class="ml-menu">
                                <li><a href="adminprofile.php">Profil Administrateur</a></li>
                                <li><a href="adminchangepassword.php">Changer le mot de passe</a></li>
                                <li><a href="admin.php">Ajouter un administrateur</a></li>
                                <li><a href="viewadmin.php">Voir les administrateurs</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-calendar-check"></i><span>Rendez-vous</span></a>
                            <ul class="ml-menu">
                                <li><a href="appointment.php">Nouveau Rendez-vous</a></li>
                                <li><a href="viewappointmentpending.php">Voir les rendez-vous en attente</a></li>
                                <li><a href="viewappointmentapproved.php">Voir les rendez-vous approuvés</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-add"></i><span>Médecins</span></a>
                            <ul class="ml-menu">
                                <li><a href="doctor.php">Ajouter un Médecin</a></li>
                                <li><a href="viewdoctor.php">Voir les Médecins</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-o"></i><span>Patients</span></a>
                            <ul class="ml-menu">
                                <li><a href="patient.php">Ajouter un Patient</a></li>
                                <li><a href="viewpatient.php">Voir les dossiers Patient</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-settings-square"></i><span>Service</span></a>
                            <ul class="ml-menu">
                                <li><a href="department.php">Ajouter un Département</a></li>
                                <li><a href="viewdepartment.php">Voir les Départements</a></li>
                                <li><a href="treatment.php">Ajouter un type de Traitement</a></li>
                                <li><a href="viewtreatment.php">Voir les types de Traitement</a></li>
                                <li><a href="medicine.php">Ajouter un Médicament</a></li>
                                <li><a href="viewmedicine.php">Voir les Médicaments</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- Admin Menu -->
            <?php } ?>

            <!-- Doctor Menu -->
            <?php if (isset($_SESSION['doctorid'])) { ?>
                <div class="menu" style="background-color:#663399;">
                    <ul class="list">
                        <li class="header">NAVIGATION PRINCIPALE</li>
                        <li class="active open"><a href="doctoraccount.php"><i class="zmdi zmdi-home"></i><span>Tableau de Bord</span></a></li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-calendar-check"></i><span>Profil</span></a>
                            <ul class="ml-menu">
                                <li><a href="doctorprofile.php">Profil</a></li>
                                <li><a href="doctorchangepassword.php">Changer le Mot de Passe</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-calendar-check"></i><span>Rendez-vous</span></a>
                            <ul class="ml-menu">
                                <li><a href="viewappointmentpending.php" style="width:250px;">Voir les rendez-vous en attente</a></li>
                                <li><a href="viewappointmentapproved.php" style="width:250px;">Voir les rendez-vous approuvés</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-add"></i><span>Médecins</span></a>
                            <ul class="ml-menu">
                                <li><a href="doctortimings.php">Ajouter une heure de visite</a></li>
                                <li><a href="viewdoctortimings.php">Voir les heures de visite</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-o"></i><span>Patients</span></a>
                            <ul class="ml-menu">
                                <li><a href="viewpatient.php">Voir les patients</a></li>
                            </ul>
                        </li>

                        <li><a href="viewdoctorconsultancycharge.php"><i class="zmdi zmdi-copy"></i><span>Rapport de revenus</span></a></li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-settings-square"></i><span>Service</span></a>
                            <ul class="ml-menu">
                                <li><a href="viewtreatmentrecord.php">Voir les dossiers de traitement</a></li>
                                <li><a href="viewtreatment.php">Voir les traitements</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            <?php } ?>

            <!-- Patient Menu -->
            <?php if (isset($_SESSION['patientid'])) { ?>
                <div class="menu" style="background-color:#663399;">
                    <ul class="list">
                        <li class="header">NAVIGATION PRINCIPALE</li>
                        <li class="active open"><a href="patientaccount.php"><i class="zmdi zmdi-home"></i><span>Tableau de Bord</span></a></li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-calendar-check"></i><span>Profil</span></a>
                            <ul class="ml-menu">
                                <li><a href="patientprofile.php">Voir le Profil</a></li>
                                <li><a href="patientchangepassword.php">Changer le Mot de Passe</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-calendar-check"></i><span>Rendez-vous</span></a>
                            <ul class="ml-menu">
                                <li><a href="patientappointment.php">Ajouter un rendez-vous</a></li>
                                <li><a href="viewappointment.php">Voir les rendez-vous</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-add"></i><span>Ordonnances</span></a>
                            <ul class="ml-menu">
                                <li><a href="patviewprescription.php">Voir les dossiers d’ordonnance</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-o"></i><span>Traitements</span></a>
                            <ul class="ml-menu">
                                <li><a href="viewtreatmentrecord.php">Voir les dossiers de traitement</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            <?php } ?>
        </aside>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content home">
