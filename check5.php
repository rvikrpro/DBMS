<!DOCTYPE html>
<html>
<head>
  <title>Transaction Details</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .transaction-details {
      border: 1px solid #ccc;
      
    }
    .title{
      font-size: 150%;
      padding: 10px;
      margin-bottom: 20px;
      margin-top: 20px;
      padding-left: 20px;
      margin-right: 20px;
      background-color: #070035;
    }
    .box {
      padding: 10px;
      margin-bottom: 20px;
      margin-top: 20px;
      margin-left: 20px;
      padding-left: 40px;
      margin-right: 20px;
      background-color: #000142;
      font-size: 130%;
    }
    body {
      background-color: #000168;
      color: white;
      font-family: 'Bahnschrift SemiBold', sans-serif;
    }
   
    .custom-navbar {
      background-color: #000142 !important;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
    }
    form {
      text-align: center;
      margin-bottom: 20px
    }
    label,
    input[type="text"],
    input[type="submit"] {
      margin: 5px;
    }
    input[type="text"] {
      background-color: #00028e;
      color: white;
      border-radius: 5px;
      padding: 5px;
      border: none;
      outline: none;
    }
    input[type="submit"] {
      background-color: #000142;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.4);
    }
    input[type="submit"]:hover {
      background-color: #000168;
    }

  </style>
</head>
<body>
     <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top custom-navbar">
    <a class="navbar-brand" href="#">Airline Management</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="check.php">Flight Search</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="check2.php">Book/Cancel</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="check3.php">Search Flight</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="check4.php">Airport</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="check5.php">Check status</a>
        </li>
      </ul>
    </div>
  </nav>
  <br/><br/><br/>
  <h2 style="margin-left: 25px">Transaction Details</h2>

  <form action="" method="POST">
    <label for="tsId">Transaction ID:</label>
    <input type="text" name="tsId" id="tsId" required>

    <input type="submit" value="Get Details">
  </form>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form input
    $tsId = $_POST['tsId'];

    // Include the configuration file
    require_once "config.php";

    // Create a database connection
    $conn = mysqli_connect($server, $user, $pass, "airline");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Select the database
    mysqli_select_db($conn, "airline");

    // Prepare the query
    $query = "SELECT * FROM transactions WHERE TS_ID = $tsId";
    
    // Execute the query
    $result = mysqli_query($conn, $query);

    // Display transaction details
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo '<div class="box">';
        echo "<p> <div class='title'>Transaction ID: " . $row['TS_ID'] . "</div></p>";
        echo "<p>Booking Date: " . $row['Booking_Date'] . "</p>";
        echo "<p>Departure Date: " . $row['Departure_Date'] . "</p>";
        echo "<p>Transaction Type: " . $row['TS_Type'] . "</p>";
        echo "<p>Employee ID: " . $row['Emp_ID'] . "</p>";
        echo "<p>Passenger ID: " . $row['P_ID'] . "</p>";
        echo "<p>Flight ID: " . $row['Flight_ID'] . "</p>";
        echo "<p>Charge Amount: " . $row['Charge_Amount'] . "</p>";
        echo '</div>';
    } else {
        echo "Transaction not found.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

