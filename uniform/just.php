<?php
// Database connection parameters
$conn = mysqli_connect("localhost", "root", "", "Money Rush");

// Check connection
if (!$conn) {
    die("<br>Database Connection Problem: " . mysqli_connect_error());
}

// Query to select all data from the table
$sql = "SELECT * FROM users_detail"; 
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC); 

    print_r($data);

    
    foreach ($data as $row) {
        
        echo "Column1: " . $row['user_id'] . " - Column2: " . $row['user_name'] . "<br>";
    }
} else {
    echo "No records found.";
}

// Free result set and close connection
mysqli_free_result($result);
mysqli_close($conn);
?>
