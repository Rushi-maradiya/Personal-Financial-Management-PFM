<?php
  include("uniform/Sqlconnection.php");
session_start();
if (isset($_POST['action']) && $_POST['action'] === 'check_email') {
    $email = mysqli_real_escape_string($conn, $_POST['email']); // Sanitize input
    $sql = "SELECT * FROM users_detail WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "exists"; // Email already exists
    } else {
        echo "available"; // Email is available
    }
    exit();
}

// Handle login logic when form is submitted
if (isset($_POST['Lemail']) && isset($_POST['Lpass'])) {
    $Lemail = mysqli_real_escape_string($conn, $_POST['Lemail']);  // Sanitize the email
    $Lpass = $_POST['Lpass']; // Password needs to be verified, no escaping required

    $sql = "SELECT * FROM users_detail WHERE email = '$Lemail'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($Lpass, $row['Password'])) {
            $_SESSION['userid'] = $row['user_id'];
            $_SESSION['username'] = $row['user_name'];
            $_SESSION['email'] = $row['email'];

            header("Location: php/loginDB.php");
            exit();
        } else {
            $loginError = "Invalid password";
        }
    } else {
        $loginError = "Invalid email";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<div style="background: url('uniform/1.jpg') no-repeat center center / cover; height: 100vh;">

    <?php include 'uniform/links.php'; ?>
    <link rel="stylesheet" href="css/Index.css">
    <title>Login or Register in Money Rush</title>
</head>
<body>


    <!-- Centered login/register container -->
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="form-container w-auto">
        <?php
if (isset($_GET['message'])) {
    $message = urldecode($_GET['message']);
    echo "<div class='alert alert-success text-center' role='alert'>$message</div>";
}
?>
            <!-- Form toggle buttons -->
            <div class="form-toggle text-center mb-4">
                <button class="btn custom-btn toggle-btn active" id="login-btn">Login</button>
                <button class="btn custom-btn toggle-btn" id="signup-btn">Register</button>
            </div>
            <div class="form-content d-flex">
                
                <!-- Login Form -->
                <form id="login-form" class="form active" action="Index.php" method="post">
                    <h1 class="text-center mb-4">Login</h1>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control shadow-none" style="width:300px;" id="floatingEmail"
                            placeholder="name@example.com" name="Lemail" required />
                        <label for="floatingEmail">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control shadow-none" id="floatingPassword"
                            placeholder="Password" name="Lpass" required />
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div>
        <?php if (isset($loginError)) { ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo htmlspecialchars($loginError); ?>
            </div>
        <?php } ?>
    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn custom-btn-secondary">Login</button>
                    </div>
                </form>

                <!-- Register Form -->
                <form id="signup-form" class="form hidden" style="display:none;" action="php/RegisterDB.php" method="post">
                    <h1 class="text-center mb-4">Register</h1>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control shadow-none" id="floatingName" style="width:300px;"
                            placeholder="Full Name" name="Rname" required />
                        <label for="floatingName">Full Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control shadow-none" id="floatingEmailReg"
                            placeholder="name@example.com" name="Remail" required />
                        <label for="floatingEmailReg">Email</label>
                        <span id="emailStatus"></span>
                        <div id="email-warning" class="text-danger mt-2" style="display:none;"></div>
                    </div>
                    <div class="form-floating mb-3" id="passs">
                        <input type="password" class="form-control shadow-none" id="floatingPasswordReg"
                            placeholder="Password" name="Rpass" required />
                        <label for="floatingPasswordReg">Password</label>
                    </div>
                    <div class="form-floating mb-3" id="repasss">
                        <input type="password" class="form-control shadow-none" id="floatingRePassword"
                            placeholder="Re-Password" name="Rrepass" required />
                        <label for="floatingRePassword">Re-Password</label>
                        <div id="password-warning" class="text-danger mt-2" style="display:none;"></div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn custom-btn-secondary" id="Registerbutton">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Admin button at the bottom -->
    <div class="text-center fixed-bottom mb-3">
        <label class="text-black">Are you an admin?</label>
        <a href="php/admin.php"><button class="btn btn-success m-3" id="admin-btn">Admin</button></a>
    </div>

    <!-- Include JavaScript for email check -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/Index.js"></script>
    </div>
</body>
</html>