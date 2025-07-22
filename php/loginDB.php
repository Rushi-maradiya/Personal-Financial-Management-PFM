<?php

include '../uniform/Sqlconnection.php';

session_start();

$finemail = $_SESSION['email'];



$query = "SELECT * FROM users_detail WHERE email = '$finemail'";

// Execute the query
$result = $conn->query($query);

// Check if any user data was found
if ($result && $result->num_rows > 0) {

    $userData = $result->fetch_assoc();

    $User_id = $userData['user_id'];
    $username = $userData['user_name'];
    $email = $userData['email'];


    $qry1 = "INSERT INTO audit_detail (user_id, user_name, email, login_date, logout_date) VALUES ($User_id, '$username', '$email', NOW(), NULL)";
    echo ($qry1);
    if ($conn->query($qry1) === TRUE) {
        header("location:wallet.php");
    } else {
        echo "Error inserting data into audit_detail: " . $conn->error . "\n";
    }
}
?>