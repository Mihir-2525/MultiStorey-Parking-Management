<?php
include('navbar.php');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/operator.css">
    <style>
        .hidden {
            display: none;
        }

        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        label {
            display: inline-block;
            margin-right: 10px;
        }

        input[type="text"],
        input[type="date"] {
            padding: 5px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 5px 15px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>

<body>
    <?php
    $id_error = "";
    $mo_error = "";
    $pass_error = "";
    $showAlert = false;
    $showError = false;
    // Set database credentials
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'project';
    // Create Connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if (isset($_POST['opcreate'])) {

        //Get Entered Username and Password
        $operator_id = $_POST['operator_id'];
        $user_name = $_POST['Name'];
        $user_no = $_POST['pnumber'];
        $user_email = $_POST['email'];
        $user_pass = $_POST['password'];
        $user_conpass = $_POST['conpassword'];

        // check if the OperatorID already exists in the 'operator' table
        $query = "SELECT * FROM `operator` WHERE `operator-id` ='$operator_id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // display an error message to the user
            $id_error = "This ID already used.";
        } else {
            // check if the Mobile_no already exists in the 'operator' table
            $query = "SELECT * FROM `operator` WHERE `Mobile_no` = '$user_no'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                // display an error message to the user
                $mo_error = "This Mobile Number already used.";
            } else {
                if ($user_pass != $user_conpass) {
                    // display an error message to the user
                    $pass_error = "Password Doesn't match";
                } else {
                    // Add Operator
                    $pass = md5($user_pass);
                    $sql = "INSERT INTO `operator` (`operator-id`,`Name`, `Mobile_no`, `Email`, `Password`) VALUES ('$operator_id','$user_name', '$user_no', '$user_email', '$pass')";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        // display an error message to the user
                        $showError = "Failed to create account, please try again.";
                    } else {
                        $showAlert = "Account created successfully!";
                    }
                }
            }
        }
        //Close Connection
        
    }
    ?>
    <?php
    if (isset($_POST['opdelete'])) {
        // Get the operator ID and password from the form
        $id = $_POST['id'];
        $pass = md5($_POST['password']);

        // Set database credentials
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'project';

        // Create Connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check Connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the operator exists in the database
        $sql = "SELECT * FROM operator WHERE `operator-id`='$id' AND `Password`='$pass'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Delete the operator data from the database
            $sql = "DELETE FROM operator WHERE `operator-id`='$id' AND `Password`='$pass'";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                // Display an error message to the user
                $showError = "Failed to delete operator data, please try again.";
            } else {
                $showAlert = "Operator data deleted successfully!";
            }
        } else {
            // Display an error message to the user
            $showError = "Operator data not found, please try again.";
        }

        //Close Connection
        
    }
    ?>
    <?php
    if (isset($_POST['opupdate'])) {
        // Get the operator ID and new data from the form
        $id = $_POST['id'];
        $name = $_POST['name'];
        $mobile_no = $_POST['mobile_no'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        // Check if the operator exists in the database
        $sql = "SELECT * FROM operator WHERE `operator-id`='$id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Validate name
            if (empty($name)) {
                $showUpdateError = "Please enter the operator name";
            } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                $showUpdateError = "Name should only contain letters and white space";
            }

            if (!isset($showUpdateError)) {
                // Set database credentials
                $servername = 'localhost';
                $username = 'root';
                $password1 = '';
                $dbname = 'project';

                // Create Connection
                $conn = new mysqli($servername, $username, $password1, $dbname);

                // Check Connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Update the operator data in the database
                $sql = "UPDATE operator SET Name='$name', Mobile_no='$mobile_no', Email='$email', Password='$password' WHERE `operator-id`='$id'";

                if (mysqli_query($conn, $sql)) {
                    $showUpdateAlert = "Operator data updated successfully!";
                } else {
                    $showUpdateError = "Error updating operator data: " . mysqli_error($conn);
                }

                //Close Connection
                
            }
        } else {
            // Display an error message to the user
            $showUpdateError = "Operator data not found, please try again.";
        }
    }
    ?>
    <div class="operator-data">
        <table class="table table-hover" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Operator ID</th>
                    <th scope="col">Operator Name</th>
                    <th scope="col">Mobile no.</th>
                    <th scope="col">Email</th>
                    <!-- <th scope="col">Password</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `operator`";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                <th>" . $row['operator-id'] . "</th>
                <th scope='row'>" . $row['Name'] . "</th>
                <th scope='row'>" . $row['Mobile_no'] . "</th>
                <td>" . $row['Email'] . "</td>
                </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="body">

        <form style="display: flex;flex-direction: row;justify-content: space-evenly;">
            <div class="form-check">
                <input class="form-check-input" type="radio" id="radio1" name="radio" onclick="InsertDiv()">
                <label class="form-check-label" for="radio1">Insert</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="radio2" name="radio" onclick="UpdateDiv()">
                <label class="form-check-label" for="radio2">Update</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="radio3" name="radio" onclick="deleteDiv()">
                <label class="form-check-label" for="radio3">Delete</label>
            </div>
        </form>

        <div id="Insert" class="<?php if ($id_error || $mo_error || $pass_error) {
                                    echo "";
                                } else {
                                    echo "hidden";
                                } ?>">
            <h1>Create New Operator</h1>
            <form method="post" >
                <label>Operator ID</label>
                <input type="text" name="operator_id" pattern="^(OP)\d{2}" required>
                <?php if (isset($id_error)) { ?>
                    <!-- <p style="color: red;"><?php echo $id_error; ?></p> -->
                    <span style="color: red; "><?php echo $id_error; ?></span>
                <?php } ?>
                <br>
                <label>Name</label>
                <input type="text" name="Name" required>
                <br>
                <label>Mobile No.</label>
                <input type="text" pattern="[0-9]{10}" maxlength="10" size="10" class="input" name="pnumber" required>
                <?php if (isset($mo_error)) { ?>
                    <span style="color: red;"><?php echo $mo_error; ?></span>
                <?php } ?>
                <br>
                <label>E-mail</label>
                <input type="email" name="email" required>
                <br>
                <label>Password</label>
                <input type="password" name="password" required>
                <br>
                <label>Confirm Password</label>
                <input type="password" name="conpassword" required>
                <?php if (isset($pass_error)) { ?>
                    <span style="color: red;"><?php echo $pass_error; ?></span>
                <?php } ?>
                <br>
                <input type="submit" name="opcreate" value="Create">
            </form>
        </div>

        <!-- UPDATE -->
        <div id="Update" class="hidden">
            <h1>Update Operator Data</h1>
            <form method="post">
                <label for="id">Operator ID:</label>
                <input type="text" name="id" pattern="^(OP)\d{2}" required>
                <br>
                <label for="name">Name:</label>
                <input type="text" name="name" required>
                <br>
                <label for="mobile_no">Mobile Number:</label>
                <input type="text" pattern="[0-9]{10}" maxlength="10" size="10" name="mobile_no" required>
                <br>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" name="password" required>
                <br>
                <?php if (isset($showUpdateError)) { ?>
                    <span style="color: red;"><?php echo $showUpdateError; ?></span>
                <?php } ?>
                <?php if (isset($showUpdateAlert)) { ?>
                    <span style="color: green;"><?php echo $showUpdateAlert; ?></span>
                <?php } ?>
                <br>
                <input type="submit" name="opupdate" value="Update">
            </form>
        </div>

        <!-- DELETE -->
        <div id="Delete" class="hidden">
            <h1>Delete Operator Data</h1>
            <form method="post" action="">
                <label for="id">Operator ID:</label>
                <input type="text" pattern="^(OP)\d{2}" name="id" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" name="password" required>
                <br>
                <?php if (isset($showError)) { ?>
                    <span style="color: red;"><?php echo $showError; ?></span>
                <?php } ?>
                <?php if (isset($showAlert)) { ?>
                    <span style="color: green;"><?php echo $showAlert; ?></span>
                <?php } ?>
                <br>
                <input type="submit" name="opdelete" value="Delete">
            </form>
        </div>
    </div>
    <script>
        function InsertDiv() {
            document.getElementById("Insert").classList.remove("hidden");
            document.getElementById("Delete").classList.add("hidden");
            document.getElementById("Update").classList.add("hidden");
        }

        function UpdateDiv() {
            document.getElementById("Update").classList.remove("hidden");
            document.getElementById("Insert").classList.add("hidden");
            document.getElementById("Delete").classList.add("hidden");
        }

        function deleteDiv() {
            document.getElementById("Delete").classList.remove("hidden");
            document.getElementById("Insert").classList.add("hidden");
            document.getElementById("Update").classList.add("hidden");
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>