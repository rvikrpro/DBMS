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
  <h2 style="margin-left: 25px">Flight Details</h2>
  <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="flightId">Enter Flight ID:</label>
    <input type="text" name="flightId" id="flightId" required>
    <input type="submit" value="Get Details">
  </form>

<?php
// Include the config.php file
require_once "config.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['flightId'])) {
  $flightId = $_GET['flightId'];

  // Database connection and query to retrieve data
  $conn = mysqli_connect($server, $user, $pass, "airline");
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Retrieve route details
  $query = "SELECT * FROM Routes WHERE Route_ID IN (SELECT Route_ID FROM travels_on WHERE Flight_ID = '$flightId')";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
    // Fetch the first row of route details
    $row = mysqli_fetch_assoc($result);
    $routeId = $row['Route_ID'];
    $takeOffPoint = $row['Departure'];
    $destination = $row['Arrival'];
    $rType = $row['R_type'];

    // Display route details in the first box
    echo '<div class="box">';
    echo '<h3>Route Details</h3>';
    echo '<p>Route ID: ' . $routeId . '</p>';
    echo '<p>Take Off Point: ' . $takeOffPoint . '</p>';
    echo '<p>Destination: ' . $destination . '</p>';
    echo '<p>Route Type: ' . $rType . '</p>';
    echo '</div>';
  }

  // Retrieve passenger details
  $query = "SELECT * FROM Passengers WHERE Flight_ID = '$flightId'";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $passengerId = $row['P_ID'];
      $passengerName = $row['P_Name'];
      $address = $row['Address'];
      $age = $row['Age'];
      $sex = $row['Sex'];
      $contacts = $row['Contacts'];

      // Display passenger details in a box
      echo '<div class="box">';
      echo '<h3>Passenger Details</h3>';
      echo '<p>Passenger ID: ' . $passengerId . '</p>';
      echo '<p>Name: ' . $passengerName . '</p>';
      echo '<p>Address: ' . $address . '</p>';
      echo '<p>Age: ' . $age . '</p>';
      echo '<p>Sex: ' . $sex . '</p>';
      echo '<p>Contacts: ' . $contacts . '</p>';
      echo '</div>';
    }
  }

  

  mysqli_close($conn);
}
?>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
