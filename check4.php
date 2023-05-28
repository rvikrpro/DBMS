<!DOCTYPE html>
<html>
<head>
  <title>Flight Details</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
  .box {
      padding: 10px;
      margin-bottom: 20px;
      margin-top: 20px;
      margin-left: 20px;
      margin-right: 20px;
      background-color: #000142;

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
  <h2 style="margin-left: 25px">Airport Details</h2>

<!-- HTML Form -->

<form method="post" action="">
  <label for="airportCode">Airport Code:</label>
  <input type="text" id="airportCode" name="airportCode" required>
  <input type="submit" value="Submit">
</form>


<?php
require_once "config.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $airportCode = $_POST["airportCode"];

  // Create a database connection
  $conn = mysqli_connect($server, $user, $pass, "airline");
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Select the database
  mysqli_select_db($conn, "airline");

  // Retrieve matching records from the can_land table
  $query = "SELECT * FROM can_land WHERE Air_code = '$airportCode'";
  $result = mysqli_query($conn, $query);

  // Retrieve matching records from the employees table
  $queryEmployees = "SELECT * FROM employees WHERE Air_code = '$airportCode'";
  $resultEmployees = mysqli_query($conn, $queryEmployees);

  // Retrieve matching records from the airport table
  $queryAirport = "SELECT * FROM airport WHERE Air_code = '$airportCode'";
  $resultAirport = mysqli_query($conn, $queryAirport);

 

  // Display the results in box format
  echo "<div class='box'>";
  
  // Display can_land records
  echo "<h3>Can Land Records:</h3>";

  while ($row = mysqli_fetch_assoc($result)) {
    echo "<div style='background-color: #070035; border: 1px ; padding: 10px; margin-bottom: 10px;'>";
    echo "Air Code: " . $row['Air_code'] . "<br>";
    echo "Flight ID: " . $row['Flight_ID'] . "<br>";
    echo "</div>";
  }

  // Display employees records
  echo "<br>";
  echo "<h3>Employees Records:</h3>";
 
  while ($row = mysqli_fetch_assoc($resultEmployees)) {
    echo "<div style=' background-color: #070035; border: 1px ; padding: 10px; margin-bottom: 10px;'>";
    echo "Employee ID: " . $row['Emp_ID'] . "<br>";
    echo "Employee Name: " . $row['E_Name'] . "<br>";
    echo "</div>";
  }

  // Display airport records
  echo "<br>";
  echo "<h3>Airport Records:</h3>";

  while ($row = mysqli_fetch_assoc($resultAirport)) {
    echo "<div style='background-color: #070035; border: 1px ; padding: 10px; margin-bottom: 10px;'>";
    echo "Airport Code: " . $row['Air_code'] . "<br>";
    echo "Airport Name: " . $row['Air_Name'] . "<br>";
    echo "City: " . $row['City'] . "<br>";
    echo "State: " . $row['State'] . "<br>";
    echo "Country Code: " . $row['Country_code'] . "<br>";
    echo "</div>";
  }



  echo "</div>";

  // Close the database connection
  mysqli_close($conn);
}
?>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

