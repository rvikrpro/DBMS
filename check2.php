<!DOCTYPE html>
<html>
<head>
  <title>Passenger Management</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #000168;
      color: white;
      font-family: 'Bahnschrift SemiBold', sans-serif;
    }
    #b1, #b2 {
      margin: 5px;
      background-color: #000142;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.4);
    }

    #b1:hover, #b2:hover {
      background-color: #000168;
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
      height: 100vh;
      padding-top: 100px;
    }
    form {
      text-align: center;
    }
    label,
    input[type="text"],
    input[type="number"],
    input[type="date"],
    input[type="submit"] {
      margin: 5px;
    }
    input[type="text"],
    input[type="number"],
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
    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
      background-color: #000142;
      color: white;
    }
    th, td {
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #000168;
    }
    tr {
      background-color: #00028e;
    }
    tr:hover {
      background-color: #000142;
    }
    .passenger-form{
        margin-left: 25px;
    }
    .form-container {
      margin-left: 30px;     
      margin-bottom: 20px;

    }
    .form-container h3 {
      margin-bottom: 10px;
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
  <script>
    function f1(){
        document.getElementById("ins").style.display="block";
        document.getElementById("del").style.display="none";
        document.getElementById("b1").style.border="2px solid green";
        document.getElementById("b2").style.border="none";
    }
    function f2(){
        document.getElementById("ins").style.display="none";
        document.getElementById("del").style.display="block";
        document.getElementById("b2").style.border="2px solid green";
        document.getElementById("b1").style.border="none";
    }
  </script>
  <h2 style="margin-left: 25px">Passenger Management</h2>
  <div class="form-container">
    <button id="b1" onclick="f1()">Book</button>
    <button id="b2" onclick="f2()">Cancel</button>
  </div>
  
  <!-- Insert Passenger Form -->
  <div class="passenger-form" id="ins" style="display:block;">
    <h3>Book a Flight</h3>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <label for="name">Name:</label>
      <input type="text" name="name" id="name" required>

      <label for="address">Address:</label>
      <input type="text" name="address" id="address" required>

      <label for="age">Age:</label>
      <input type="number" name="age" id="age" required>

      <label for="sex">Sex:</label>
      <select name="sex" id="sex" required>
        <option value="M">Male</option>
        <option value="F">Female</option>
      </select>

      <label for="contacts">Contacts:</label>
      <input type="text" name="contacts" id="contacts" required>

      <label for="flight">Flight ID:</label>
      <input type="text" name="flight" id="flight" required>

      <input id="b1" type="submit" name="book" value="Book">
    </form>
  </div>

  <!-- Delete Passenger Form -->
  <div class="passenger-form" id="del" style="display:none;">
    <h3>Cancel Booking</h3>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <label for="passengerId">Passenger ID:</label>
      <input type="text" name="passengerId" id="passengerId" required>
      <label for="passengerPhone">Passenger Phone:</label>
      <input type="text" name="passengerPhone" id="passengerPhone" required>
      <input type="submit" name="cancel" value="Cancel">
    </form>
  </div>

  <?php
  // Check if the form is submitted
  require_once "config.php";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create a database connection
    $conn = mysqli_connect($server, $user, $pass, "airline");
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    // Select the database
    mysqli_select_db($conn, "airline");

    // Process Book form
    if (isset($_POST['book'])) {
      // Get the form inputs
      $name = $_POST['name'];
      $address = $_POST['address'];
      $age = $_POST['age'];
      $sex = $_POST['sex'];
      $contacts = $_POST['contacts'];
      $flightId = $_POST['flight'];

      // Prepare the SQL statement
      $stmt = mysqli_prepare($conn, "INSERT INTO Passengers (P_Name, Address, Age, Sex, Contacts, Flight_ID) VALUES (?, ?, ?, ?, ?, ?)");
      mysqli_stmt_bind_param($stmt, "ssisss", $name, $address, $age, $sex, $contacts, $flightId);

      // Execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        echo "Passenger booked successfully.";
      } else {
        echo "Error: " . mysqli_error($conn);
      }

      // Close the statement
      mysqli_stmt_close($stmt);
    }

    // Process Cancel form
    if (isset($_POST['cancel'])) {
      // Get the passenger ID
      $passengerId = $_POST['passengerId'];
      $passengerPhone = isset($_POST['passengerPhone']) ? $_POST['passengerPhone'] : '';

      // Prepare the SQL statement
      $stmt = mysqli_prepare($conn, "DELETE FROM Passengers WHERE P_ID = ? AND Contacts = ?");
      mysqli_stmt_bind_param($stmt, "ii", $passengerId, $passengerPhone);

      // Execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        if (mysqli_stmt_affected_rows($stmt) > 0) {
          echo "Booking canceled successfully.";
        } else {
          echo "No booking found matching the provided ID and phone.";
        }
      } else {
        echo "Error: " . mysqli_error($conn);
      }

      // Close the statement
      mysqli_stmt_close($stmt);
    }

    // Close the database connection
    mysqli_close($conn);
  }
  ?>

  <!-- Display Passengers -->
  <h3 style="margin-left: 25px; margin-bottom: 10px; margin-top: 20px">Passengers</h3>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Address</th>
      <th>Age</th>
      <th>Sex</th>
      <th>Contacts</th>
      <th>Flight ID</th>
    </tr>
    <?php
    // Create a database connection
    $conn = mysqli_connect($server, $user, $pass, "airline");
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    // Select the database
    mysqli_select_db($conn, "airline");

    // Fetch passengers from the Passengers table
    $query = "SELECT * FROM Passengers";
    $result = mysqli_query($conn, $query);

    // Display passengers
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $row['P_ID'] . "</td>";
      echo "<td>" . $row['P_Name'] . "</td>";
      echo "<td>" . $row['Address'] . "</td>";
      echo "<td>" . $row['Age'] . "</td>";
      echo "<td>" . $row['Sex'] . "</td>";
      echo "<td>" . $row['Contacts'] . "</td>";
      echo "<td>" . $row['Flight_ID'] . "</td>";
      echo "</tr>";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
  </table>
</body>
</html>
