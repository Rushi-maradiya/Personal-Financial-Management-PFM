<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>


<?php
session_start();
 include '../uniform/links.php';
 include '../uniform/Sqlconnection.php';

$name=$_POST['Rname'];
$email=$_POST['Remail'];
$pass = password_hash($_POST['Rpass'], PASSWORD_DEFAULT); // Secure password hashing


 $qry = "INSERT INTO `users_detail` (`user_id`, `user_name`, `email`, `Password`) VALUES (NULL,'$name','$email','$pass')";
echo($qry);
 $work=mysqli_query($conn,$qry);
if($work)
{
    $mess="you are successfully Register";
    
    $query = "SELECT * FROM users_detail WHERE email = '$email'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {

        $userData = $result->fetch_assoc();
    
        $User_id = $userData['user_id'];
        $username = $userData['user_name'];
        $email = $userData['email'];
        
        $_SESSION['userid'] = $userData['user_id'];
        $_SESSION['username'] = $userData['user_name'];
        $_SESSION['email'] = $userData['email'];
    
        $qry1 = "INSERT INTO audit_detail (user_id, user_name, email, login_date, logout_date) VALUES ($User_id, '$username', '$email', NOW(), NULL)";
        echo ($qry1);
        if ($conn->query($qry1) === TRUE) {
            
            header("location:wallet.php");
        } else {
            echo "Error inserting data into audit_detail: " . $conn->error . "\n";
        }
    }
}else{
    echo"error";
}




?>




    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>