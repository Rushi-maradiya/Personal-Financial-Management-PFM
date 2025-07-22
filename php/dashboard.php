<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: ../Index.php");
    exit();
}

include 'head22.php';
/*include '../uniform/footer.php';*/

$user_id = $_SESSION['userid'];

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'month';

// Initialize totals within the filter logic
$totalIncome = 0;
$totalExpenses = 0;

if ($filter == 'week') {
    $startOfWeek = date('Y-m-d', strtotime('monday this week'));
    $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
    $sql = "SELECT 
                DATE(date) AS day, 
                transaction_type, 
                SUM(amount) AS total_amount
            FROM transactions 
            WHERE user_id = $user_id AND date BETWEEN '$startOfWeek' AND '$endOfWeek'
            GROUP BY DATE(date), transaction_type";
    $result = mysqli_query($conn, $sql);

    $labels = [];
    $incomeData = [];
    $expenseData = [];

    for ($i = 0; $i < 7; $i++) {
        $date = date('Y-m-d', strtotime("monday this week +$i days"));
        $labels[] = date('l', strtotime($date));
        $incomeData[] = 0;
        $expenseData[] = 0;
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $dayIndex = (int) date('N', strtotime($row['day'])) - 1;
            if ($row['transaction_type'] == 'income') {
                $incomeData[$dayIndex] += $row['total_amount'];
                $totalIncome += $row['total_amount'];
            } elseif ($row['transaction_type'] == 'expenses') {
                $expenseData[$dayIndex] += $row['total_amount'];
                $totalExpenses += $row['total_amount'];
            }
        }
    } else {
        // If no transactions are found, set a warning message
        $warningMsgweek = "No transactions found for this week.";
    }

} elseif ($filter == 'month') {
    $currentYear = date('Y');
    $currentMonth = date('m');
    $sql = "SELECT 
                DAY(date) AS day, 
                transaction_type, 
                SUM(amount) AS total_amount
            FROM transactions 
            WHERE user_id = $user_id AND YEAR(date) = $currentYear AND MONTH(date) = $currentMonth
            GROUP BY DAY(date), transaction_type";
    $result = mysqli_query($conn, $sql);

    $labels = [];
    $incomeData = [];
    $expenseData = [];

    $daysInMonth = date('t');
    for ($i = 1; $i <= $daysInMonth; $i++) {
        $labels[] = $i;
        $incomeData[] = 0;
        $expenseData[] = 0;
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $day = (int) $row['day'] - 1;
            if ($row['transaction_type'] == 'income') {
                $incomeData[$day] += $row['total_amount'];
                $totalIncome += $row['total_amount'];
            } elseif ($row['transaction_type'] == 'expenses') {
                $expenseData[$day] += $row['total_amount'];
                $totalExpenses += $row['total_amount'];
            }
        }
    } else {
        // If no transactions are found, set a warning message
        $warningMsgMonth = "No transactions found for this month.";
    }
} elseif ($filter == 'year') {
    $currentYear = date('Y');
    $sql = "SELECT 
                MONTH(date) AS month, 
                transaction_type, 
                SUM(amount) AS total_amount
            FROM transactions 
            WHERE user_id = $user_id AND YEAR(date) = $currentYear
            GROUP BY MONTH(date), transaction_type
            ORDER BY month ASC";
    $result = mysqli_query($conn, $sql);

    $labels = [];
    $incomeData = [];
    $expenseData = [];
    $monthlyData = array_fill(1, 12, ['income' => 0, 'expenses' => 0]);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $month = (int) $row['month'];
            if ($row['transaction_type'] == 'income') {
                $monthlyData[$month]['income'] += $row['total_amount'];
                $totalIncome += $row['total_amount'];
            } elseif ($row['transaction_type'] == 'expenses') {
                $monthlyData[$month]['expenses'] += $row['total_amount'];
                $totalExpenses += $row['total_amount'];
            }
        }
    } else {
        $warningMsgYear = "No transactions found for this year.";
    }

    foreach ($monthlyData as $month => $data) {
        $labels[] = date('F', mktime(0, 0, 0, $month, 10));
        $incomeData[] = $data['income'];
        $expenseData[] = $data['expenses'];
    }
} elseif ($filter == 'overall') {
    $sql = "SELECT 
                YEAR(date) AS year, 
                transaction_type, 
                SUM(amount) AS total_amount
            FROM transactions 
            WHERE user_id = $user_id
            GROUP BY YEAR(date), transaction_type
            ORDER BY year ASC";
    $result = mysqli_query($conn, $sql);

    $labels = [];
    $incomeData = [];
    $expenseData = [];
    $yearlyData = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $year = (int) $row['year'];
            if (!isset($yearlyData[$year])) {
                $yearlyData[$year] = ['income' => 0, 'expenses' => 0];
            }
            if ($row['transaction_type'] == 'income') {
                $yearlyData[$year]['income'] += $row['total_amount'];
                $totalIncome += $row['total_amount'];
            } elseif ($row['transaction_type'] == 'expenses') {
                $yearlyData[$year]['expenses'] += $row['total_amount'];
                $totalExpenses += $row['total_amount'];
            }
        }
    } else {
        $warningMsgOverall = "No transactions found for the overall period.";
    }

    foreach ($yearlyData as $year => $data) {
        $labels[] = $year;
        $incomeData[] = $data['income'];
        $expenseData[] = $data['expenses'];
    }

}

// Calculate left amount
$leftAmount = $totalIncome - $totalExpenses;

// Check if left amount is negative
$warningMessage = "";
if ($leftAmount < 0) {
    $warningMessage = "Left amount is in negative. Make sure that you are not forgetting any income transaction.";
}

// Query for total transactions
$sql = "SELECT COUNT(*) AS total_transactions FROM transactions WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$totalTransactions = $row['total_transactions'];

// Query for transaction history
$sqlTransactions = "SELECT * FROM transactions WHERE user_id = $user_id ORDER BY date DESC";
$resultTransactions = mysqli_query($conn, $sqlTransactions);
$hasTransactions = mysqli_num_rows($resultTransactions) > 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Overview</title>
    <link rel="icon" type="image/png" href="../uniform/logo1.png">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../css/dashboard.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   </head>

<body class="bg-black">

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h3>Transaction Overview</h3>
            <div class="btn-group" role="group">
                <input type="radio" class="btn-check" name="btnradio" id="weekFilter" autocomplete="off" 
                    <?php echo $filter == 'week' ? 'checked' : ''; ?>>
                <label class="btn btn-outline-success" for="weekFilter">Week</label>

                <input type="radio" class="btn-check" name="btnradio" id="monthFilter" autocomplete="off" 
                    <?php echo $filter == 'month' ? 'checked' : ''; ?>>
                <label class="btn btn-outline-success" for="monthFilter">Month</label>

                <input type="radio" class="btn-check" name="btnradio" id="yearFilter" autocomplete="off" 
                    <?php echo $filter == 'year' ? 'checked' : ''; ?>>
                <label class="btn btn-outline-success" for="yearFilter">Year</label>

                <input type="radio" class="btn-check" name="btnradio" id="overallFilter" autocomplete="off" 
                    <?php echo $filter == 'overall' ? 'checked' : ''; ?>>
                <label class="btn btn-outline-success" for="overallFilter">Overall</label>
            </div>
            
        </div>
        <?php if (isset($warningMsgweek) && $warningMsgweek): ?>
    <div class="alert alert-danger text-center">
        <?php echo $warningMsgweek; ?>
    </div>
<?php endif; ?>

<?php if (isset($warningMsgMonth) && $warningMsgMonth): ?>
    <div class="alert alert-danger text-center">
        <?php echo $warningMsgMonth; ?>
    </div>
<?php endif; ?>

<?php if (isset($warningMsgYear) && $warningMsgYear): ?>
    <div class="alert alert-danger text-center">
        <?php echo $warningMsgYear; ?>
    </div>
<?php endif; ?>

<?php if (isset($warningMsgOverall) && $warningMsgOverall): ?>
    <div class="alert alert-danger text-center">
        <?php echo $warningMsgOverall; ?>
    </div>
<?php endif; ?>
v

    </div>

    <?php if ($warningMessage): ?>
        <div class="alert alert-warning text-center">
            <?php echo $warningMessage; ?>
        </div>
    <?php endif; ?>

    <div class="row mb-4">
        <!-- Chart Column -->
        <div class="col-md-8">
            <canvas id="transactionChart"></canvas>
        </div>

        <!-- Data Cards Column -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-3 border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"> Income</h5>
                </div>
                <div class="card-body text-center">
                    <h3 class="card-title text-success" id="totalIncome"><?php echo '₹' . number_format($totalIncome, 2); ?></h3>
                </div>
            </div>

            <div class="card shadow-sm mb-3 border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Expenses</h5>
                </div>
                <div class="card-body text-center">
                    <h3 class="card-title text-danger" id="totalExpenses"><?php echo '₹' . number_format($totalExpenses, 2); ?></h3>
                </div>
            </div>

            <div class="card shadow-sm mb-3 border-warning">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Left Amount</h5>
                </div>
                <div class="card-body text-center">
                    <h3 class="card-title text-warning" id="totalAmount"><?php echo '₹' . number_format($leftAmount, 2); ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div id="transactionHistory" class="row mt-5 mb-4">
    <div class="col-12">
        <h4 class="text-center text-success mt-5 mb-5">Transaction History</h4>
        <?php if ($hasTransactions): ?>
            <table class="table table-striped table-dark text-center">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Category</th>
                        <th>Payment Method</th>
                        <th>note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($rowTransaction = mysqli_fetch_assoc($resultTransactions)) {
                        $rowClass = $rowTransaction['transaction_type'] === 'income' ? 'table-success' : 'table-danger';
                        $formattedDate = date('d-m-Y', strtotime($rowTransaction['date']));

                        echo "<tr class='{$rowClass}'>
                                <td>{$formattedDate}</td>
                                <td>{$rowTransaction['transaction_type']}</td>
                                <td>₹" . number_format($rowTransaction['amount'], 2) . "</td>
                                <td>{$rowTransaction['category']}</td>
                                <td>{$rowTransaction['payment_method']}</td>
                                <td>{$rowTransaction['note']}</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-danger text-center">
                No transactions found.
            </div>
        <?php endif; ?>
    </div>
</div>


<script>
    var labels = <?php echo json_encode($labels); ?>;
    var incomeData = <?php echo json_encode($incomeData); ?>;
    var expenseData = <?php echo json_encode($expenseData); ?>;
    var totalTransactions = <?php echo $totalTransactions; ?>;
    var totalIncome = <?php echo $totalIncome; ?>;
    var totalExpenses = <?php echo $totalExpenses; ?>;
</script>
<?php    include '../uniform/footer.php';
?>
<script src="../js/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-jWHJ5I8CUOqWhlOQKbfy60INnsbKBuXjHwiHjZ4OwCT50P59tHI5IaHClqs8e1V5" crossorigin="anonymous"></script>

</body>
</html>
