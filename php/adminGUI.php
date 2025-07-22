<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['adminid'])) {
    header("Location: ../Index.php");
    exit();
}
?>

<head>
    <?php include '../uniform/links.php'; ?>
    <?php include("../uniform/Sqlconnection.php"); ?>
    <link rel="stylesheet" href="../css/adminGUI.css">
    <title>admin page</title>
</head>
<style>
    .logout-btn {
    background-color: red;
    color: white;
    text-align: center;
    width: 80%; /* Adjust width for centering */
    margin: 20px auto; /* Center horizontally */
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}

.logo {
    padding: 20px;
    text-align: center;
    background: rgba(255, 255, 255, 0.1); /* Semi-transparent background */
    border-bottom: 1px solid rgba(255, 255, 255, 0.2); /* Subtle divider line */
}

.logo h4 {
    margin: 10px 0;
    color: #f1c40f; /* Bright yellow color */
    font-weight: bold;
}
.logout-btn:hover {
    background-color: darkred; /* Optional hover effect */
}
    .custom-logo-shadow {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow on the entire div */
    border-radius: 10px; /* Optional for rounded corners */
}

</style>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Logo Section -->
        <div class="logo text-center py-3 custom-logo-shadow">
        <h4 class="text-warning">Welcome Admin</h4>

    <img src="../uniform/logo1.png" alt="Logo" class="bg-white"
        style="width: 50px; height: 50px; margin-bottom: 10px; border-radius: 5px; border: 2px solid white; padding: 5px;">
</div>


        <!-- Sidebar Links -->
        <ul class="nav flex-column">
            <li class="nav-item d-flex align-items-center justify-content-center">
                <a class="nav-link active" href="javascript:void(0);" onclick="showContent('auditTable')">
                    <i class="bi bi-house-door-fill"></i> User Login History
                </a>
            </li>

            <li class="nav-item  d-flex align-items-center justify-content-center">
                <a class="nav-link" href="javascript:void(0);" onclick="showContent('userListTable')">
                    <i class="bi bi-speedometer2"></i> User List
                </a>
            </li>
            <li class="nav-item  d-flex align-items-center justify-content-center" style="margin-top:150%">
                <form action="../uniform/adminlogout.php" method="POST">
                    <button type="submit" class="logout-btn m-4 ">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>                 
            </li>
          
        </ul>

        <!-- Logout Button at the Bottom -->
        
    </div>

    <!-- Main Content Area -->
    <div class="main-content" style="margin-left: 250px; padding: 20px;">
        <!-- User Login History Content -->
        <div id="auditTable" class="content-section">
            <h2 class="text-center">User Login History</h2>
            <?php
            $sqlFetch = "SELECT * FROM audit_detail";
            $result = $conn->query($sqlFetch);

            if ($result->num_rows > 0) {
                echo "<div class='table-responsive'>                 
                    <table class='table table-bordered table-striped text-center'>                     
                        <thead class='table-light'>                         
                            <tr>                             
                                <th>Record No</th>                             
                                <th>User ID</th>                             
                                <th>User Name</th>                             
                                <th>Email</th>                             
                                <th>login Date</th>
                                <th>Logout Date</th> 
                            </tr>                     
                        </thead>                     
                        <tbody>";
                while ($row = $result->fetch_assoc()) {
                    // Format date to dd-mm-yyyy, HH:MM:SS
                    $formattedDate = date("d-m-Y, H:i:s", strtotime($row['login_date']));
                    $formattedLogout = $row['logout_date'] ? date("d-m-Y, H:i:s", strtotime($row['logout_date'])) : "N/A";

                    echo "<tr>                 
                        <td>" . ($row['record_no']) . "</td>                 
                        <td>" . ($row['user_id']) . "</td>                 
                        <td>" . ($row['user_name']) . "</td>                 
                        <td>" . ($row['email']) . "</td>                 
                        <td>" . $formattedDate . "</td> 
                        <td>" . $formattedLogout . "</td>             
                    </tr>";
                }
                echo "</tbody>           
                </table>           
                </div>";
            } else {
                echo "<p class='text-center'>No login history found.</p>";
            }
            ?>
        </div>

        <!-- User List Content -->
        <div id="userListTable" class="content-section" style="display:none;">
            <h2 class="text-center">User List</h2>
            <?php
            // Fetch the users from the 'users_detail' table
            $sqlFetchUsers = "SELECT * FROM users_detail";
            $resultUsers = $conn->query($sqlFetchUsers);

            if ($resultUsers->num_rows > 0) {
                echo "<div class='table-responsive'>                 
                    <table class='table table-bordered table-striped text-center'>                     
                        <thead class='table-light'>                         
                            <tr>                             
                                <th>User ID</th>                             
                                <th>Username</th>                             
                                <th>Email</th>                             
                                <th>Action</th>                         
                            </tr>                     
                        </thead>                     
                        <tbody>";
                while ($row = $resultUsers->fetch_assoc()) {
                    echo "<tr>                 
                        <td>" . ($row['user_id']) . "</td>                 
                        <td>" . ($row['user_name']) . "</td>                 
                        <td>" . ($row['email']) . "</td>                 
                        <td><form method='POST' action='delete_user.php'>
                    <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
                    <button type='submit' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</button>
                </form></td>               
                    </tr>";
                }
                echo "</tbody>           
                </table>           
                </div>";
            } else {
                echo "<p class='text-center'>No users found.</p>";
            }
            ?>
        </div>

        </div>

    </div>

    <!-- JavaScript Includes -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../js/adminGUI.js"></script>

    <!-- Custom JavaScript to Show/Hide Content -->
    <script>
        // Custom JavaScript to Show/Hide Content

    </script>
</body>

</html>