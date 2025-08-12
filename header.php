<?php
error_reporting(0);
include("dbconnection.php");
date_default_timezone_set("Africa/Douala");
$dt = date("Y-m-d");
$tim = date("H:i:sa");
?>
<div id="clock"> </div>
<!doctype html>
<html class="no-js" lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" />
<title>DOCTO LINK</title>

<!-- Favicon -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">

<!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
<link rel="stylesheet" type="text/css" href="rs-plugin/css/settings.css" media="screen" />

<!-- StyleSheets -->
<link rel="stylesheet" href="css/ionicons.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/responsive.css">

<!-- Fonts Online -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900|Raleway:200,300,400,500,600,700,800,900" rel="stylesheet">

<style>
    /* Custom CSS for full-width nav */
    .header-style-2 {
        padding: 0;
        margin: 0;
        width: 100%;
    }
    .navbar.ownmenu {
        margin: 0;
        border-radius: 0;
        border: none;
        min-height: 60px;
    }
    .navbar.ownmenu .container {
        width: 100%;
        padding: 0;
    }
    .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 0 15px;
    }
    .logo-container {
        display: flex;
        align-items: center;
        padding: 10px 0;
    }
    .logo-img {
        height: 40px;
        margin-right: 10px;
    }
    .logo-text {
        color: black;
        font-size: 18px;
        font-weight: bold;
        white-space: nowrap;
    }
    .navbar-collapse {
        padding: 0;
    }
    .navbar-nav {
        display: flex;
        align-items: center;
        margin: 0 -15px;
    }
    .navbar-nav > li {
        padding: 0 15px;
    }
    .navbar-nav > li > a {
        padding: 20px 0;
    }
    .dropdown-menu {
        position: absolute;
    }
    /* Blue button styling */
    .btn-inscrire {
        background-color: #007bff !important;
        color: white !important;
        border-radius: 4px;
        padding: 8px 15px !important;
        margin-left: 10px;
    }
    .btn-inscrire:hover {
        background-color: #0069d9 !important;
    }
    /* Mobile menu adjustments */
    @media (max-width: 767px) {
        .nav-container {
            flex-direction: column;
            align-items: flex-start;
        }
        .navbar-header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar-collapse {
            width: 100%;
        }
    }
</style>
</head>
<body>

<!-- Header -->
<header class="header-style-2">
    <nav class="navbar ownmenu">
        <div class="container">
            <div class="nav-container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-open-btn">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="logo-container">
                        <img src="images/logo_main_white.jpeg?v=123" alt="DOCTO LINK" class="logo-img">
                        <span class="logo-text">DOCTO LINK</span>
                    </div>
                </div>
                
                <div class="collapse navbar-collapse" id="nav-open-btn">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">ACCUEIL</a></li>
                        <li><a href="about.php">APROPOS</a></li>
                        <li><a href="doctor_timings.php">HORAIRES DU MEDECIN</a></li>
                        <li><a href="patientappointment.php">RENDEZ-VOUS</a></li>
                        <li><a href="contact.php">CONTACT</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">CONNEXION</a>
                            <ul class="dropdown-menu">
                                <li><a href="adminlogin.php">Admin</a></li>
                                <li><a href="doctorlogin.php">Médecin</a></li>
                                <li><a href="patientlogin.php">Patient</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle btn-inscrire" data-toggle="dropdown">S'INSCRIRE</a>
                            <ul class="dropdown-menu">
                                <li><a href="adminregistration.php">Admin</a></li>
                                <li><a href="doctorregistration.php">Médecin</a></li>
                                <li><a href="patientregistration.php">Patient</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>