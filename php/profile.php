<?php
session_start();
include("head22.php");
include("../uniform/Sqlconnection.php");

if (!isset($_SESSION['userid'])) {
    header("Location: ../Index.php");
    exit();
}

$user_id = $_SESSION['userid'];
$query = "SELECT * FROM users_detail WHERE user_id = '$user_id'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit;
}

// Fetch login history
$login_history_query = "SELECT * FROM audit_detail WHERE user_id = '$user_id' ORDER BY login_date DESC";
$login_history_result = $conn->query($login_history_query);

// Handle profile update or delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

        // Check if the new email already exists for another user
        $emailCheckQuery = "SELECT * FROM users_detail WHERE email = '$email' AND user_id != '$user_id'";
        $emailCheckResult = $conn->query($emailCheckQuery);

        if ($emailCheckResult && $emailCheckResult->num_rows > 0) {
            $emailError = "This email is already registered by another user.";
        } else {
            if ($password) {
                $update_query = "UPDATE users_detail SET user_name = '$name', email = '$email', password = '$password' WHERE user_id = '$user_id'";
            } else {
                $update_query = "UPDATE users_detail SET user_name = '$name', email = '$email' WHERE user_id = '$user_id'";
            }

            if ($conn->query($update_query) === TRUE) {
                $conn->query("UPDATE audit_detail SET user_name = '$name', email = '$email' WHERE user_id = '$user_id'");

                $_SESSION['username'] = $name;
                $_SESSION['email'] = $email;

                header("Location: profile.php?status=updated");
                exit;
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } elseif (isset($_POST['delete'])) {
        $conn->query("DELETE FROM transactions WHERE user_id = $user_id");
        $conn->query("DELETE FROM audit_detail WHERE user_id = $user_id");

        if ($conn->query("DELETE FROM users_detail WHERE user_id = $user_id") === TRUE) {
            echo "User deleted successfully.";
        } else {
            echo "Error deleting user: " . $conn->error;
        }

        $conn->close();
        header("Location: adminGUI.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #000; color: #fff; }
        .container {
            margin-top: 50px;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
        }
        .btn-primary {
            width: 100%;
            background-color: #1ab188;
            border: none;
        }
        .btn-danger { width: 100%; margin-top: 10px; }
        .login-history {
            display: none;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .login-history table {
            width: 100%;
            color: #fff;
            border-collapse: collapse;
        }
        .login-history table th, .login-history table td {
            padding: 8px;
            text-align: left;
        }
        .login-history table th { background-color: #333; }
        .login-history table tr:nth-child(even) { background-color: #444; }
        .alert-success { margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="container">
    <?php if (isset($_GET['status']) && $_GET['status'] === 'updated'): ?>
        <div class="alert alert-success text-center">
            Your profile has been updated successfully!
        </div>
    <?php endif; ?>

    <?php if (isset($emailError)): ?>
        <div class="alert alert-danger text-center">
            <?php echo htmlspecialchars($emailError); ?>
        </div>
    <?php endif; ?>

    <h2 class="text-center"><i class="bi bi-person-circle"></i> Profile</h2>

    <!-- Profile Update Form -->
    <form action="profile.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="<?php echo htmlspecialchars($user['user_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password (Leave blank to keep current password)</label>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Enter new password">
        </div>
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <button type="submit" class="btn btn-primary" name="update">Save Changes</button>
    </form>

    <!-- Delete Account Form -->
    <form action="profile.php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');">
        <button type="submit" class="btn btn-danger" name="delete">Delete Account</button>
    </form>

    <!-- Toggle Login History Button -->
    <button class="btn btn-info mt-4" id="toggleHistoryBtn">Show Login History</button>

    <!-- Login History Section -->
    <div class="login-history" id="loginHistorySection">
        <?php if ($login_history_result->num_rows > 0): ?>
            <h4 class="text-center text-white">Login History</h4>
            <table>
                <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Login Time</th>
                    <th>Logout Time</th>
                </tr>
                </thead>
                <tbody>
                <?php $sr_no = 1; ?>
                <?php while ($row = $login_history_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $sr_no++; ?></td>
                        <td><?php echo date('d-m-Y H:i:s', strtotime($row['login_date'])); ?></td>
                        <td>
                            <?php echo $row['logout_date']
                                ? date('d-m-Y H:i:s', strtotime($row['logout_date']))
                                : 'Still Logged In'; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-white">No login history available.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById('toggleHistoryBtn').addEventListener('click', function () {
        const historySection = document.getElementById('loginHistorySection');
        const showing = historySection.style.display === 'block';
        historySection.style.display = showing ? 'none' : 'block';
        this.textContent = showing ? 'Show Login History' : 'Hide Login History';
    });
</script>
</body>
</html>
