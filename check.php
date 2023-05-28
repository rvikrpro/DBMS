<!DOCTYPE html>
<html>
<head>
  <title>Flight Search</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #000168;
      color: white;
      font-family: 'Bahnschrift SemiBold', sans-serif;
    }
    .custom-navbar {
      background-color: #000142 !important;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
    }
    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      padding-top: 20px;
    }
    .container2 {
      display: flex;
      flex-direction: column;
      margine-left: 25px;
      justify-content: flex-start;
      padding-top: 80px;
    }
    form {
      text-align: center;
    }
    label,
    input[type="text"],
    input[type="date"],
    input[type="submit"] {
      margin: 5px;
    }
    input[type="text"],
    input[type="date"] {
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
    .flight-box{
      padding: 10px;
      margin-bottom: 20px;
      margin-top: 20px;
      margin-left: 20px;
      margin-right: 20px;
      background-color: #000142;
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
  <div class="container2">
  <h2 style="margin-left: 25px">Flight Search</h2>
  </div>
  <div class="container">
  

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <label for="from">From:</label>
      <input type="text" name="from" id="from" required>
  
      <label for="to">To:</label>
      <input type="text" name="to" id="to" required>
  
      <label for="date">Date:</label>
      <input type="date" name="date" id="date" required>
  
      <input type="submit" value="Search Flights">
    </form>
  </div>

  <?php
  // Check if the form is submitted
  require_once "config.php";
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs
    $from = $_POST['from'];
    $to = $_POST['to'];
    $date = $_POST['date'];

    // Create a database connection
    $conn = mysqli_connect($server, $user, $pass);
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    // Select the database
    mysqli_select_db($conn, "airline");
    
    // Fetch flights from flights table based on the given inputs
    $query = "SELECT f.Flight_ID, a.AC_Model, a.Capacity, f.Departure, f.Arrival, af.Charge_Amount, 
    c1.Country_Name,c2.Country_Name,
    ap1.Air_Name AS Departure_Airport, ap2.Air_Name AS Arrival_Airport,
    ap1.City AS From_City, ap2.City AS To_City,c1.Country_Name AS From_Country,c2.Country_Name AS To_Country
FROM Flight f
INNER JOIN AirCraft a ON f.A_ID = a.A_ID
INNER JOIN AirFare af ON f.Flight_ID = af.Flight_ID
INNER JOIN Airport ap1 ON f.Departure = ap1.City
INNER JOIN Countries c1 ON ap1.Country_code = c1.Country_code
INNER JOIN Airport ap2 ON f.Arrival = ap2.City
INNER JOIN Countries c2 ON ap2.Country_code = c2.Country_code
WHERE f.Departure= '$from' AND f.Arrival = '$to' AND f.Flight_Date = '$date'";
    
    $result = mysqli_query($conn, $query);
    // Display flights and additional information
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="flight-box">';
            echo "<p>Flight Number: " . $row['Flight_ID'] . "</p>";
            echo "<p>Aircraft Model: " . $row['AC_Model'] . "</p>";
            echo "<p>Aircraft Capacity: " . $row['Capacity'] . "</p>";
            echo "<p>From City: " . $row['From_City'] . "</p>";
            echo "<p>From Country: " . $row['From_Country'] . "</p>";
            echo "<p>To City: " . $row['To_City'] . "</p>";
            echo "<p>To Country: " . $row['To_Country'] . "</p>";
            echo "<p>Airfare: " . $row['Charge_Amount'] . "</p>";
            echo "<p>From Airport: " . $row['Departure_Airport'] . "</p>";
            echo "<p>To Airport: " . $row['Arrival_Airport'] . "</p>";
            echo '</div>';
        }
    } else {
        echo "No flights found.";
    }
    // Close the database connection
    mysqli_close($conn);}
    ?>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>