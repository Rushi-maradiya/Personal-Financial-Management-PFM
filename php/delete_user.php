<?php
include("../uniform/Sqlconnection.php");

if (isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']); // Sanitize input

    // Delete related records in transactions
    $conn->query("DELETE FROM transactions WHERE user_id = $user_id");

    // Delete related records in audit_detail
    $conn->query("DELETE FROM audit_detail WHERE user_id = $user_id");

    // Now delete the user
    $sql = "DELETE FROM users_detail WHERE user_id = $user_id";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $conn->close();

    header("Location: adminGUI.php");
    exit();
} else {
    echo "No user selected for deletion.";
}

?>
