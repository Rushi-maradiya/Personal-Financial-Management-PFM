<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include '../uniform/links.php';
    include("../uniform/Sqlconnection.php");

 ?>
    <link rel="stylesheet" href="../css/admin.css">
    <title>Admin</title>
</head>

<body>
<div style="background: url('../uniform/2.jpg') no-repeat center center / cover; height: 100vh;">


    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="form-container w-auto">
        <?php
if (isset($_GET['message'])) {
    $messagee = urldecode($_GET['message']);
    echo "<div class='alert alert-success text-center' role='alert'>$messagee</div>";
}
?>
            <div class="form-content d-flex">
                
                            <!-- ----------Login Form---------- -->
                <form id="login-form" class="form active" method="post">
                    <h1 class="text-center mb-4">welome admin</h1>
 
                    <!--email-->
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" style="width: 300px;" id="floatingEmail"
                            name="adminemail" placeholder="name@example.com" required />
                        <label for="floatingEmail">Email address</label>
                    </div>
                    <!--pass-->
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" style="width: 300px;" id="floatingPassword"
                            name="adminpass" placeholder="Password" required />
                        <label for="floatingPassword">Password</label>
                    </div>
                    <?php
                    if (isset($_POST['adminemail']) && isset($_POST['adminpass'])) {

                        $adminemail = $_POST['adminemail'];
                        $adminpass = $_POST['adminpass'];
                        // Query to fetch data
                    
                        $sql = "SELECT * FROM admin_detail WHERE admin_email = '$adminemail' AND admin_password = '$adminpass'";
                        $result = mysqli_query($conn, $sql);
                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            session_start();
                            $_SESSION['adminid'] = $row['admin_id'];
                            $_SESSION['adminname'] = $row['admin_name'];
                            header("Location: adminGUI.php");
                            exit();

                        } else {
                            $loginError = "Invalid email or password";
                             if (isset($loginError)) { ?>
                                <div class="alert alert-danger text-center" role="alert">
                                    <?php echo htmlspecialchars($loginError); ?>
                                </div>
                            <?php }
                        }
                    }

                    ?>

                    <!--submit-->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn custom-btn-secondary">Login</button>
                    </div>

                </form>

            </div>
        </div>
        <div class="text-center fixed-bottom mb-3">
            <label class="text-white">Are you an user?</label>
            <a href="../Index.php"><button class="btn btn-success m-3" id="admin-btn">USER</button></a>
        </div>
    </div>
</div>

</body>

</html>