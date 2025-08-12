<?php
include("adformheader.php");
include("dbconnection.php");

$delid = intval($_GET['delid'] ?? 0);
if ($delid > 0) {
    $sql = "DELETE FROM admin WHERE adminid='$delid'";
    $qsql = mysqli_query($con, $sql);
    if (mysqli_affected_rows($con) == 1) {
        echo "<script>alert('Enregistrement de l'administrateur supprimé avec succès.');</script>";
    } else {
        echo "<script>alert('Erreur lors de la suppression de l'enregistrement.');</script>";
    }
}
?>

<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">Voir les administrateurs</h2>
    </div>
</div>
<div class="card">
    <section class="container">
        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
            <thead>
                <tr>
                    <th width="12%" height="40">Nom de l'administrateur</th>
                    <th width="11%">Identifiant de connexion</th>
                    <th width="12%">Statut</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM admin";
                $qsql = mysqli_query($con, $sql);
                while ($rs = mysqli_fetch_assoc($qsql)) {
                    echo "<tr>
                        <td>" . htmlspecialchars($rs['adminname']) . "</td>
                        <td>" . htmlspecialchars($rs['loginid']) . "</td>
                        <td>" . htmlspecialchars($rs['status']) . "</td>
                        <td>
                            <a href='admin.php?editid=" . intval($rs['adminid']) . "' class='btn btn-raised g-bg-cyan'>Modifier</a> 
                            <a href='viewadmin.php?delid=" . intval($rs['adminid']) . "' class='btn btn-raised g-bg-blush2' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?');\">Supprimer</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</div>

<?php
include("adformfooter.php");
?>
