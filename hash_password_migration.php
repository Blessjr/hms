<?php
include("dbconnection.php");

// Function to hash passwords in a given table
function hashPasswords($con, $tableName, $idColumn) {
    echo "Processing $tableName...\n";

    // Select rows with plaintext passwords (password_hashed = 0)
    $sql = "SELECT $idColumn, password FROM $tableName WHERE password_hashed = 0";
    $result = $con->query($sql);

    if (!$result) {
        echo "Error fetching from $tableName: " . $con->error . "\n";
        return;
    }

    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $id = $row[$idColumn];
        $plainPassword = $row['password'];

        // Hash password
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        // Update with hashed password and mark password_hashed = 1
        $updateSql = "UPDATE $tableName SET password = ?, password_hashed = 1 WHERE $idColumn = ?";
        $stmt = $con->prepare($updateSql);
        $stmt->bind_param("si", $hashedPassword, $id);
        if ($stmt->execute()) {
            $count++;
        } else {
            echo "Failed to update $tableName $id: " . $stmt->error . "\n";
        }
        $stmt->close();
    }

    echo "Updated $count password(s) in $tableName.\n";
}

// Run for admin and doctor tables
hashPasswords($con, "admin", "adminid");
hashPasswords($con, "doctor", "doctorid");

echo "Password hashing completed.\n";
?>
