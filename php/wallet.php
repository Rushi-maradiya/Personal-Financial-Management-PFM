<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../uniform/logo1.png">

    <title>HOME</title>
    <?php
    include '../uniform/links.php';
    include("../uniform/Sqlconnection.php");
    ?>
    <style>
    .quote-box {
        width:50%;
        /* Half width of the screen */
        margin: 0 auto;
        /* Center horizontally */
        padding: 20px;
        /* Padding around the content */
        border: 1px solid #444;
        /* Darker border for the box */
        border-radius: 8px;
        /* Rounded corners */
        background-color: ;
        /* Dark background for the quote box */
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.4);
        /* Optional shadow for depth */
        text-align: center;
        /* Center content inside the box */
    }

    .quote {
        font-style: italic;
        font-size: 1.5rem;
        color: #f4f4f4;
        /* Light grayish color for quote */
    }

    .author {
        margin-top: 15px;
        font-weight: bold;
        font-size: 1.2rem;
        color: #d3d3d3;
        /* Lighter color for the author's name */
    }

    .photo {
        margin-top: 20px;
        width: 100px;
        /* Size of the photo */
        height: 100px;
        /* Size of the photo */
        box-shadow: 0px 0px 10px 2px white;
        border-radius: 5px;
    }
    #bookCarousel {
            width: 50%; /* Half-width carousel */
            margin: 50px auto;
            background-color: #000; /* Black background for carousel */
            border-radius: 15px;
            padding: 20px;
        }
        .carousel-item {
            text-align: center;
        }

        .book-item {
            padding: 20px;
            background-color: #222; /* Dark background for each book item */
            border-radius: 10px;
            color: #fff;
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0.1);
        }

        .book-item img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .book-image {
        width: 150px;
         height:100px;
        object-fit: cover; /* Ensures images don't stretch or distort */
        border-radius: 8px; /* Optional: adds rounded corners */
       }
        .book-name {
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
        }

        .book-summary {
            font-size: 14px;
            color: #ccc;
            margin-bottom: 15px;
        }

        .buy-link a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .buy-link a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../Index.php");
    exit();
}
include 'head22.php';

// Initialize variables with default values
$transactionType = 'income';
$amount = '';
$date = date('Y-m-d'); // Default to today's date
$category = '';
$payment = '';
$extraNote = '';

// Process form data when submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionType = $_POST['transactionType'] ?? 'income';
    $amount = $_POST['amount'] ?? '';
    $date = $_POST['date'] ?? date('Y-m-d');
    $category = $_POST['category'] ?? '';
    $payment = $_POST['payment'] ?? '';
    $extraNote = $_POST['extraNote'] ?? '';
    $user_id = $_SESSION['userid'];

    $sql = "INSERT INTO transactions (user_id, transaction_type, amount, date, category, payment_method, note) VALUES('$user_id', '$transactionType', '$amount', '$date', '$category', '$payment', '$extraNote')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = 'Transaction added successfully!';
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<?php
// Array of financial quotes and authors' names
$quotes = [
    ["quote" => "An investment in knowledge pays the best interest.", "author" => "Benjamin Franklin", "photo" => "../images/benjamin franklin.jpg"],
    ["quote" => "Do not save what is left after spending, but spend what is left after saving.", "author" => "Warren Buffett", "photo" => "../images/warren buffettt.jpg"],
    ["quote" => "The rich invest in time, the poor invest in money.", "author" => "Warren Buffett", "photo" => "../images/warren buffettt.jpg"],
    ["quote" => "It’s not your salary that makes you rich, it’s your spending habits.", "author" => "Charles A. Jaffe", "photo" => "../images/charles.jpg"],
    ["quote" => "Wealth consists not in having great possessions, but in having few wants.", "author" => "Epictetus", "photo" => "../images/epictetus.jpg"],
    ["quote" => "A penny saved is a penny earned.", "author" => "Benjamin Franklin", "photo" => "../images/benjamin franklin.jpg"],
    ["quote" => "The goal isn’t more money. The goal is living life on your terms.", "author" => "Chris Brogan", "photo" => "../images/chris.jpg"],
    ["quote" => "The stock market is a device for transferring money from the impatient to the patient.", "author" => "Warren Buffett", "photo" => "../images/warren buffettt.jpg"],
    ["quote" => "Don’t let the fear of losing be greater than the excitement of winning.", "author" => "Robert Kiyosaki", "photo" => "../images/robert.jpg"],
    ["quote" => "Investing is the intersection of economics and psychology.", "author" => "Seth Klarman", "photo" => "../images/Seth-Klarman-bw.jpg"]
];

// Get the current day of the year (1 to 365)
$dayOfYear =date("z");

// Calculate the index for the quote based on the day of the year
$quoteIndex = $dayOfYear % count($quotes);

// Get the selected quote and author information
$quote = $quotes[$quoteIndex]["quote"];
$author = $quotes[$quoteIndex]["author"];
$photo = $quotes[$quoteIndex]["photo"];

?>



<body class="bg-black">

<?php if (!empty($successMessage)): ?>
    <div class="p-3 text-success rounded w-50 mx-auto text-center">
        <?php echo $successMessage; ?>
    </div>
    <?php endif; ?>

    <div class="container mt-5">
    <h1 class="text-center text-white m-5 mb-0">Welcome to the <span class="text-success">Money Rush</span>.</h1>
    <p class="text-center text-white m-5 mt-0">The journey to financial success starts with understanding how to manage and grow your wealth.<p>

        <h2 class="text-center mb-4 text-white text-decoration-underline">Add Transaction here</h2>
        <h2 class="text-center mb-4 text-white ">↓</h2>


        <!-- Button to show the modal -->
        <div class="text-center">
            <button id="addTransactionBtn" class="btn btn-outline-success btn-lg mb-5 shadow-lg px-4 py-2 "
                data-bs-toggle="modal" data-bs-target="#transactionModal">Add Transaction</button>
        </div>

        <!-- Transaction Modal -->
        <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transactionModalLabel">Add Transaction</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <!-- Transaction Type (Radio Buttons) -->
                            <div class="form-group mb-4">
                                <label for="transactionType" class="form-label fs-4">Transaction Type</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="transactionType" id="incomeRadio"
                                        value="income" <?php echo $transactionType === 'income' ? 'checked' : ''; ?>>
                                    <label class="form-check-label text-success fs-5" for="incomeRadio">Income</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="transactionType"
                                        id="expensesRadio" value="expenses"
                                        <?php echo $transactionType === 'expenses' ? 'checked' : ''; ?>>
                                    <label class="form-check-label text-danger fs-5"
                                        for="expensesRadio">Expenses</label>
                                </div>
                            </div>

                            <!-- Amount -->
                            <div class="form-group mb-4">
                                <label for="amount" class="form-label fs-4">Amount</label>
                                <input type="number" class="form-control fs-5" id="amount" name="amount"
                                    value="<?php echo htmlspecialchars($amount); ?>" placeholder="Enter amount" required
                                    min="0">
                            </div>

                            <!-- Date -->
                            <div class="form-group mb-4">
                                <label for="date" class="form-label fs-4">Date</label>
                                <input type="date" class="form-control fs-5" id="date" name="date"
                                    value="<?php echo htmlspecialchars($date);?>"
                                    max="<?php echo htmlspecialchars($date); ?>"  required>
                            </div>

                            <!-- Category -->
                            <div class="form-group mb-4">
                                <label for="category" class="form-label fs-4">Category</label>
                                <select class="form-select fs-5" id="category" name="category" required>
                                    <?php
                                    // Categories for Income and Expenses
                                    $categories = [
                                        'income' => ['Salary', 'Freelance', 'Investments', 'Pocket Money', 'Other'],
                                        'expenses' => ['Food', 'Transport', 'Entertainment', 'Education', 'Bills', 'Utilities', 'Other']
                                    ];

                                    // Populate the category options based on the selected transaction type
                                    $categoryList = $categories[$transactionType];
                                    foreach ($categoryList as $cat) {
                                        echo "<option value='" . strtolower($cat) . "' " . ($category === strtolower($cat) ? 'selected' : '') . ">$cat</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Payment Method (Dropdown) -->
                            <div class="form-group mb-4">
                                <label for="payment" class="form-label fs-4">Payment Method</label>
                                <select class="form-select fs-5" id="payment" name="payment" required>
                                    <option value="online" <?php echo $payment === 'online' ? 'selected' : ''; ?>>Online
                                    </option>
                                    <option value="cash" <?php echo $payment === 'cash' ? 'selected' : ''; ?>>Cash
                                    </option>
                                    <option value="card" <?php echo $payment === 'card' ? 'selected' : ''; ?>>Card
                                    </option>
                                </select>
                            </div>

                            <!-- Extra Note -->
                            <div class="form-group mb-4">
                                <label for="extraNote" class="form-label fs-4">Extra Note</label>
                                <textarea class="form-control fs-5" id="extraNote" name="extraNote" rows="3"
                                    placeholder="Add any additional notes here..."><?php echo htmlspecialchars($extraNote); ?></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-center">
                                <button type="submit"
                                    class="btn btn-primary btn-lg rounded-pill px-4 py-2 shadow-sm">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container ">
            <div class="quote-box">
                <div>
                <h4 class="text-white text-decoration-underline">daily quotes</h4>
                    <div class="quote">
                        "<?php echo $quote; ?>"
                    </div>
                    <div>
                    <img src="<?php echo $photo; ?>" alt="<?php echo $author; ?>" class="photo">
                </div>      
                    <div class="author">
                        - <?php echo $author; ?>
                    </div>
                </div>
               
            </div>
        </div>


    </div>

    <p id="activeTransactionTypeDisplay" hidden>Active Transaction Type: <?php echo ucfirst($transactionType); ?></p>

    <h2 class="text-center text-white mt-5 mb-0">Book Recommendations to Increase Your Financial Knowledge</h2>
    <div id="bookCarousel" class="carousel slide mt-0" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
      $books = [
        ["name" => "Rich Dad Poor Dad", "summary" => "A classic guide on wealth building.", "image" => "../images/Rich dad.jpg", "link" => "https://www.amazon.com/dp/1612680194"],
        ["name" => "The Intelligent Investor", "summary" => "A must-read for value investing.", "image" => "../images/the intelligent investor.jpg", "link" => "https://www.amazon.com/dp/0060555661"],
        ["name" => "Think and Grow Rich", "summary" => "A motivational finance classic.", "image" => "../images/think and grow rich.jpg", "link" => "https://www.amazon.com/dp/0449214923"],
        ["name" => "The Richest Man in Babylon", "summary" => "Timeless advice on wealth through ancient parables.", "image" => "../images/the rich man in babylon.jpg", "link" => "https://www.amazon.com/dp/0451205367"],
        ["name" => "Your Money or Your Life", "summary" => "Transform your relationship with money.", "image" => "../images/Your Money or Your Life.jpg", "link" => "https://www.amazon.com/dp/0143115766"],
        ["name" => "The Total Money Makeover", "summary" => "A practical plan for financial fitness and debt elimination.", "image" => "../images/The Total Money Makeover.jpg", "link" => "https://www.amazon.com/dp/0785289089"],
        ["name" => "The Little Book of Common Sense Investing", "summary" => "The power of index funds for passive investing.", "image" => "../images/The Little Book of Common Sense Investing.jpg", "link" => "https://www.amazon.com/dp/1119404509"],
        ["name" => "The Millionaire Next Door", "summary" => "Discover the habits of everyday millionaires.", "image" => "../images/The Millionaire Next Door.jpg", "link" => "https://www.amazon.com/dp/1589795474"],
        ["name" => "One Up on Wall Street", "summary" => "Investing in what you know to gain an edge.", "image" => "../images/One Up on Wall Street.jpg", "link" => "https://www.amazon.com/dp/0743200403"],
        ["name" => "The Psychology of Money", "summary" => "Insights into the psychology behind financial decisions.", "image" => "../images/The Psychology of Money.jpg", "link" => "https://www.amazon.com/dp/0857197681"]
    ];
    

    $activeClass = 'active';
    foreach ($books as $book) {
        echo '<div class="carousel-item ' . $activeClass . '">';
        echo '<div class="book-item">';
        echo '<img src="' . $book['image'] . '" alt="' . $book['name'] . '" class="book-image">';
        echo '<div class="book-name">' . $book['name'] . '</div>';
        echo '<div class="book-summary">' . $book['summary'] . '</div>';
        echo '<div class="buy-link"><a href="' . $book['link'] . '">Buy Now</a></div>';
        echo '</div>';  
        echo '</div>';  
        $activeClass = ''; // Reset active class after first item
    }
    
        ?>
    </div>

    <!-- Carousel controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#bookCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bookCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
    <script src="../js/wallet.js"></script>
    <!-- Bootstrap JS (make sure to include this for the modal to work) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php    include '../uniform/footer.php';
?>
</body>

</html>