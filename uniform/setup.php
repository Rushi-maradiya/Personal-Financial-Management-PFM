<?php
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "Money Rush";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE `$dbname`"; 
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

$conn->select_db($dbname);

$sql = "CREATE TABLE users_detail(
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(60) NOT NULL,
    email VARCHAR(100) NOT NULL,
    Password varchar(100) not null,
    Unique(email)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully\n";

    $password1 = password_hash('123', PASSWORD_DEFAULT);
$password2 = password_hash('12', PASSWORD_DEFAULT);
$password3 = password_hash('1', PASSWORD_DEFAULT);

$qry = "INSERT INTO `users_detail` (`user_id`, `user_name`, `email`, `Password`) VALUES 
        (NULL, 'rushi', 'rushi@gmail.com', '$password1'),
        (NULL, 'vipul', 'vipul@gmail.com', '$password2'),
        (NULL, 'ridham', 'ridham@gmail.com', '$password3');";

    $work=mysqli_query($conn,$qry);

} else {
    echo "Error creating table: " . $conn->error . "\n";
}





//audit table =====================================================================

$sql1 = "CREATE TABLE audit_detail (
    record_no INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    user_name VARCHAR(60) NOT NULL,
    email VARCHAR(100) NOT NULL,
    login_date DATETIME NOT NULL,
    logout_date DATETIME NULL,
    FOREIGN KEY (user_id) REFERENCES users_detail(user_id)
)";

if ($conn->query($sql1) === TRUE) {
    echo "Table audit_detail created successfully\n";
}

$dummy_audit_records = [
    ["user_id" => 1, "user_name" => "rushi", "email" => "rushi@gmail.com", "login_date" => "2024-11-20 09:00:00", "logout_date" => "2024-11-20 17:00:00"],
    ["user_id" => 2, "user_name" => "vipul", "email" => "vipul@gmail.com", "login_date" => "2024-11-21 08:45:00", "logout_date" => "2024-11-21 16:30:00"],
    ["user_id" => 3, "user_name" => "ridham", "email" => "ridham@gmail.com", "login_date" => "2024-11-22 10:15:00", "logout_date" => "2024-11-22 18:00:00"],
    ["user_id" => 1, "user_name" => "rushi", "email" => "rushi@gmail.com", "login_date" => "2024-11-23 09:05:00", "logout_date" => "2024-11-23 10:05:00"],
    ["user_id" => 2, "user_name" => "vipul", "email" => "vipul@gmail.com", "login_date" => "2024-11-24 08:50:00", "logout_date" => "2024-11-24 17:10:00"],
    ["user_id" => 3, "user_name" => "ridham", "email" => "ridham@gmail.com", "login_date" => "2024-11-25 09:10:00", "logout_date" => "2024-11-25 17:00:00"],
    ["user_id" => 1, "user_name" => "rushi", "email" => "rushi@gmail.com", "login_date" => "2024-11-26 09:20:00", "logout_date" => "2024-11-26 17:30:00"],
    ["user_id" => 2, "user_name" => "vipul", "email" => "vipul@gmail.com", "login_date" => "2024-11-27 08:00:00", "logout_date" => "2024-11-27 16:00:00"],
    ["user_id" => 3, "user_name" => "ridham", "email" => "ridham@gmail.com", "login_date" => "2024-11-28 10:30:00", "logout_date" => "2024-11-28 18:00:00"],
    ["user_id" => 1, "user_name" => "rushi", "email" => "rushi@gmail.com", "login_date" => "2024-11-29 09:40:00", "logout_date" => "2024-11-29 17:45:00"],
    ["user_id" => 2, "user_name" => "vipul", "email" => "vipul@gmail.com", "login_date" => "2024-11-30 08:30:00", "logout_date" => "2024-11-30 16:20:00"],
    ["user_id" => 3, "user_name" => "ridham", "email" => "ridham@gmail.com", "login_date" => "2024-12-01 10:00:00", "logout_date" => "2024-12-01 18:00:00"],
    ["user_id" => 1, "user_name" => "rushi", "email" => "rushi@gmail.com", "login_date" => "2024-12-02 09:00:00", "logout_date" => "2024-12-02 17:00:00"],
    ["user_id" => 2, "user_name" => "vipul", "email" => "vipul@gmail.com", "login_date" => "2024-12-03 08:15:00", "logout_date" => "2024-12-03 16:45:00"],
];

foreach ($dummy_audit_records as $audit) {
    $logout_date = $audit['logout_date'] ? "'" . $audit['logout_date'] . "'" : "NULL"; 
    
    $sql = "INSERT INTO audit_detail (user_id, user_name, email, login_date, logout_date) 
            VALUES ('" . $audit['user_id'] . "', '" . $audit['user_name'] . "', '" . $audit['email'] . "', '" . $audit['login_date'] . "', $logout_date)";
    
    if ($conn->query($sql) === TRUE) {
        echo "Dummy audit record inserted successfully.\n";
    } else {
        echo "Error inserting dummy audit record: " . $conn->error . "\n";
    }
}




//=========admin table=============================================================

$sql2 = "CREATE TABLE admin_detail(
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_name VARCHAR(60) NOT NULL,
    admin_email VARCHAR(100) NOT NULL,
    admin_password VARCHAR(100) NOT NULL
)";

if ($conn->query($sql2) === TRUE) {
    echo "Table admin_detail created successfully\n";

    $qry2 = "INSERT INTO admin_detail (admin_id, admin_name,admin_email,admin_password) VALUES(001, 'vasu','vasu@gmail.com','123'),(002, 'savan','savan@gmail.com','123')";
  
  if ($conn->query($qry2) === TRUE) {
    echo "Sample data inserted into admin_detail\n";
} else {
    echo "Error inserting data into admin_detail: " . $conn->error . "\n";
}
} else {
echo "Error creating table: " . $conn->error . "\n";
}

//=============================transaction track ==================================================================

$sql = "CREATE TABLE IF NOT EXISTS transactions (
   
    user_id INT,
    transaction_id BIGINT AUTO_INCREMENT PRIMARY KEY,
    transaction_type VARCHAR(10) NOT NULL,
    amount BIGINT NOT NULL,
    date DATE NOT NULL,
    category VARCHAR(20) NOT NULL,         
    payment_method VARCHAR(10) NOT NULL,     
    note VARCHAR(1000),                   
    FOREIGN KEY (user_id) REFERENCES users_detail(user_id)
) ";

if ($conn->query($sql) === TRUE) {
    echo "*Table 'transactions' created successfully.*";
} else {
    echo "Error creating table: " . $conn->error;
}



$sqll = "INSERT INTO transactions (`user_id`,`date`, `transaction_type`, `amount`, `category`, `payment_method`, `note`) VALUES
    (1,'2024-12-10', 'income', 2000.00, 'investments', 'online', 'sale 6 share of wipro'),
    (1,'2024-12-09', 'expenses', 1400.00, 'utilities', 'cash', 'shoes'),
    (1,'2024-12-01', 'income', 60000.00, 'salary', 'online', 'job salary'),
    (1,'2024-02-10', 'income', 60000.00, 'salary', 'online', 'job salary'),
    (1,'2023-12-10', 'income', 3045000.00, 'salary', 'online', 'overall income of 2023'),
    (1,'2023-12-10', 'expenses', 2208700.00, 'other', 'online', 'overall expenses of 2023'),
    (1,'2024-12-08', 'income', 5000.00, 'freelance', 'online', 'freelance project payment'),
    (1,'2024-12-07', 'expenses', 1200.00, 'entertainment', 'credit card', 'movie and dinner'),
    (1,'2024-12-06', 'income', 2500.00, 'investments', 'online', 'dividend income'),
    (1,'2024-12-05', 'expenses', 800.00, 'utilities', 'cash', 'electricity bill'),
    (1,'2024-12-04', 'income', 1500.00, 'consulting', 'online', 'consulting fee payment'),
    (1,'2024-12-03', 'expenses', 1500.00, 'groceries', 'debit card', 'grocery shopping'),
    (1,'2024-11-30', 'income', 10000.00, 'salary', 'online', 'November salary'),
    (1,'2024-11-25', 'expenses', 2000.00, 'healthcare', 'cash', 'doctor visit'),
    (1,'2024-10-15', 'income', 3000.00, 'side hustle', 'online', 'side project earnings'),
    (1,'2024-09-18', 'expenses', 2500.00, 'travel', 'credit card', 'flight ticket for vacation')";

if ($conn->query($sqll) === TRUE) {
    echo "*Table 'transactions' created successfully.*";
} else {
    echo "Error creating table: " . $conn->error;
}   
?>


