<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="icon" type="image/png" href="../uniform/logo1.png">

    <title>Document</title>
    <?php
    session_start();
    if (!isset($_SESSION['userid']))
    {
       header("Location: ../Index.php");
        exit();
    }

    include 'head22.php';
    include("../uniform/Sqlconnection.php");
    ?>  
      <style>
    body {
      background-color:black;
      color: white;
    }
    .highlight-text {
      color: #1ab188;
    }
    .about-section {
      padding: 50px 0;
    }
    .icon-circle {
      background-color: #1ab188;
      border-radius: 20px;
      padding: 15px;
      color: white;
      font-size: 20px;
      margin-bottom: 20px;
    }
    .section-title {
      font-size: 2.5rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 30px;
    }
    .section-text {
      font-size: 1.1rem;
      line-height: 1.6;
      text-align: center;
      margin-bottom: 30px;
    }
    .feature-box {
      background-color: #343a40;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      transition: transform 0.3s;
    }
    .feature-box:hover {
      transform: scale(1.05);
    }
    .feature-icon {
      font-size: 3rem;
      margin-bottom: 15px;
    }
  </style>
</head>
<body class="bg-black text-white">
<section class="about-section">
    <div class="container">
      <h2 class="section-title text-white">About <span class="highlight-text">Us</span></h2>
      <p class="section-text">Welcome to <span class="highlight-text">Money Rush</span>, the ultimate finance tracker designed to help you take control of your financial future. Whether you're looking to manage your daily spending, track your savings, or plan for long-term goals, our platform provides the tools you need to make smarter financial decisions.</p>
      
      <!-- Mission -->
      <h3 class="section-title">Our Mission</h3>
      <p class="section-text">At <span class="highlight-text">Money Rush</span>, we believe that financial freedom starts with awareness. Our mission is simple: to empower individuals and businesses to take control of their finances through easy-to-use tools and real-time insights.</p>

      <!-- Features Section -->
      <div class="row text-center">
        <div class="col-md-4">
          <div class="feature-box">
            <div class="icon-circle">
            <i class="bi bi-credit-card-2-front-fill"></i>
          </div>
            <h4 class="text-white">Track Your Expenses</h4>
            <p class="text-white">Automatically categorize your spending to see where your money goes each month.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box">
            <div class="icon-circle">
            <i class="bi bi-piggy-bank-fill"></i>
            </div>
            <h4 class="text-white">Create Budgets</h4>
            <p class="text-white">Set budgets for different categories and stay on top of your financial goals.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-box">
            <div class="icon-circle">
            <i class="bi bi-bar-chart-line-fill"></i>
          </div>
            <h4 class="text-white">Analyze Your Spending</h4>
            <p class="text-white">Gain insights into spending patterns to help you make smarter financial choices.</p>
          </div>
        </div>
      </div>

      <!-- Why Choose Us Section -->
      <h3 class="section-title">Why Choose <span class="highlight-text">Us?</span></h3>
      <ul class="list-unstyled">
        <li><i class="fa fa-check-circle"></i> <strong>User-Friendly Interface:</strong> Our platform is designed to be intuitive, so you can start tracking your finances without a steep learning curve.</li>
        <li><i class="fa fa-check-circle"></i> <strong>Real-Time Data:</strong> Get real-time updates on your spending, income, and investments – anytime, anywhere.</li>
        <li><i class="fa fa-check-circle"></i> <strong>Secure & Private:</strong> We take your privacy seriously. Your data is encrypted and stored securely, so you can track your finances with peace of mind.</li>
        <li><i class="fa fa-check-circle"></i> <strong>Customizable Features:</strong> Tailor your dashboard and tracking tools to suit your unique financial situation.</li>
      </ul>

      <!-- Call to Action -->
    
    </div>
  </section>
</body>
</html>
<?php    include ('../uniform/footer.php');?>