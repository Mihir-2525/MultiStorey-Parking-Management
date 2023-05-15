<?php
// Start the session
session_start();

// Get the admin ID from the session
$admin_id = $_SESSION['Admin_id'];
if (!isset($admin_id)) {
  header('location:   ../login.php');
}

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'project');

// Check connection
if (!$conn) {
  die('Connection failed: ' . mysqli_connect_error());
}

// Fetch admin details from database
$sql = "SELECT * FROM admin WHERE `admin-id` = '$admin_id'";
$result = mysqli_query($conn, $sql);

// Check if query returned any rows
if (mysqli_num_rows($result) > 0) {
  // Loop through each row and fetch the data
  while ($row = mysqli_fetch_assoc($result)) {
    $admin_name = $row['name'];
  }
} else {
  echo "No admin found with ID: " . $admin_id;
}

// Close database connection
mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Admin</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- To set icon -->
  <link rel="icon" href="./images/icon.ico" type="image/x-icon">

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet" />
  <!-- include new css -->
  <link rel="stylesheet" href="./css/new.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="css/style.css" />
  <style>
    a {
      text-decoration: none !important;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    ::-webkit-scrollbar-thumb {
      background-color: #888;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background-color: #555;
    }

    ::-webkit-scrollbar-track {
      background-color: #eee;
      border-radius: 10px;
    }
  </style>
</head>

<body>
  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
      <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
      </div>
      <div class="p-4">
        <h1>
          <a class="logo"><?= $admin_name ?><span><?= $admin_id ?></span></a>
        </h1>
        <ul class="list-unstyled components mb-5">
          <li>
            <a href="./home.php"><span class="fa fa-home mr-3"></span> Home</a>
          </li>
          <li>
            <a href="./operator.php"><span class="fa fa-user mr-3"></span> Manage Operators</a>
          </li>
          <li>
            <a href="./income.php"><span class="fa fa-briefcase mr-3"></span> Income</a>
          </li>
          <!-- <li>
            <a href="#"><span class="fa fa-suitcase mr-3"></span> Gallery</a>
          </li> -->
          <li>
            <a href="./all-data.php"><span class="fa fa-cogs mr-3"></span> History</a>
          </li>
          <li>
            <a href="./blog.php"><span class="fa fa-sticky-note mr-3"></span> Blog</a>
          </li>
          <li>
            <a href="./contact.php"><span class="fa fa-paper-plane mr-3"></span> Contacts</a>
          </li>
        </ul>
    </nav>
    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">

      <!-- <div class="check">for checking css works or not</div>

    </div> -->

      <script src="js/jquery.min.js"></script>
      <script src="js/popper.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/main.js"></script>
</body>

<!-- Logout Button Display -->
<div style="position: fixed; bottom: 20px; right: 20px;background-color: #eeeeeeee;border-radius: 7px;">
  <form action="" method="post" >
    <button type="submit" class="btn btn-outline-danger" name="logout">Logout</button>
  </form>
</div>
<?php
// logout logic
if (isset($_REQUEST['logout'])) {
  session_destroy();
?>
  <script>
    window.location.replace("../login.php");
  </script>
<?php } ?>
</html>