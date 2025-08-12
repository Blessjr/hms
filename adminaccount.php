<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("dbconnection.php");

// Check if database connection is working
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if admin is logged in
if (!isset($_SESSION['adminid'])) {
    header("Location: adminlogin.php");
    exit();
}

include("adheader.php");
?>

<div class="container-fluid">
    <div class="block-header">
        <h2>Tableau de bord</h2>
        <small class="text-muted">Bienvenue dans le panneau d’administration</small>
    </div>

    <div class="row clearfix">
        <!-- Total Patients -->
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-male-female col-blush"></i> </div>
                <div class="content">
                    <div class="text">Nombre total de patients</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT * FROM patient WHERE status='Active'";
                        $qsql = mysqli_query($con, $sql);
                        if ($qsql) {
                            echo mysqli_num_rows($qsql);
                        } else {
                            echo "Erreur: " . mysqli_error($con);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Doctors -->
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-account-circle col-cyan"></i> </div>
                <div class="content">
                    <div class="text">Nombre total de médecins</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT * FROM doctor WHERE status='Active'";
                        $qsql = mysqli_query($con, $sql);
                        if ($qsql) {
                            echo mysqli_num_rows($qsql);
                        } else {
                            echo "Erreur: " . mysqli_error($con);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Admins -->
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-account-box-mail col-blue"></i> </div>
                <div class="content">
                    <div class="text">Nombre total d’administrateurs</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT * FROM admin WHERE status='Active'";
                        $qsql = mysqli_query($con, $sql);
                        if ($qsql) {
                            echo mysqli_num_rows($qsql);
                        } else {
                            echo "Erreur: " . mysqli_error($con);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hospital Revenue -->
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-money col-green"></i> </div>
                <div class="content">
                    <div class="text">Revenus de l’hôpital</div>
                    <div class="number">XAF
                        <?php 
                        $sql = "SELECT SUM(bill_amount) AS total FROM billing_records";
                        $qsql = mysqli_query($con, $sql);
                        if ($qsql) {
                            $row = mysqli_fetch_assoc($qsql);
                            echo $row['total'] ?? 0;
                        } else {
                            echo "Erreur: " . mysqli_error($con);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clear"></div>
</div>

<?php
include("adfooter.php");
?>
