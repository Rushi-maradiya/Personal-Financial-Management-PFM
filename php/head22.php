<?php
include("../uniform/Sqlconnection.php");
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/head22.css">


</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top shadow">
        <div class="container-fluid">

            <a class="navbar-brand" href="wallet.php">
                <img src="../uniform/logo1.png" alt="Logo" class="bg-white"
                    style=" width: 30px; height: 30px; margin-right: 10px;">
                <span class="brand-text">MoneyRush</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto"> 
                    <li class="nav-item fs-5">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'wallet.php' ? 'active' : ''; ?>"
                            href="wallet.php"><i class="bi bi-house-door-fill"></i> Home</a>
                    </li>
                    <li class="nav-item  fs-5">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>"
                            href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    </li>
                    <li class="nav-item  fs-5   ">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>"
                            href="about.php"><i class="bi bi-info-circle"></i> About</a>
                    </li>
                </ul>

                <div class="dropdown">
                    <button class="btn text-white dropdown-toggle d-flex align-items-center" type="button"
                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>&nbsp;
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end bg-light " aria-labelledby="userDropdown">
                        <li><a class="dropdown-item text-primary bg-light " href="profile.php">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="../uniform/logout.php" method="POST" style="margin: 0;">
                                <button type="submit" class="dropdown-item bg-light  text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>