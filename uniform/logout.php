<?php

include '../uniform/Sqlconnection.php';
session_start();

if (isset($_SESSION['email'])) {
    $finemail = $_SESSION['email'];

    // Update the logout_date for the user's latest login entry
    $qry = "UPDATE audit_detail 
            SET logout_date = NOW() 
            WHERE email = '$finemail' 
            AND logout_date IS NULL 
            ORDER BY login_date DESC 
            LIMIT 1";

    if ($conn->query($qry) === TRUE) {
        $_SESSION = [];

        session_destroy();
        $message = urlencode("logout successfully");
        header("Location: ../Index.php?message=$message");

        exit();
    } else {
        echo "Error updating logout date: " . $conn->error . "\n";
    }
} else {
    header("Location: ../Index.php");
    exit;
}
?>