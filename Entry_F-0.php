<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator-1</title>
    <link rel="stylesheet" href="CSS/parking.css">
    <link rel="stylesheet" href="CSS/theme.css">
    <link rel="stylesheet" href="CSS/model.css">
    <link rel="stylesheet" href="CSS/display-slot.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>
        @keyframes mymove {
            from {
                left: -150px;
            }

            to {
                left: 0px;
            }
        }

        .active {
            color: black;
            animation-timing-function: cubic-bezier(0, 0.72, 0, 1);
            position: relative;
            animation: mymove 1s;
        }
    </style>
</head>
<?php
//setting the timezone
$tz = 'Asia/Kolkata';
date_default_timezone_set($tz);

// check user logged in or not 
session_start();
$operator = getOperator();
function getOperator()
{
    static $operator;
    if (!isset($operator)) {
        $operator = $_SESSION['operator_id'];
    }
    return $operator;
}
if (!isset($operator)) {
?>
    <script>
        window.location.replace("./login.php");
    </script>
    <?php
}

// Connect to the DB
$insert = false;
$servername = "localhost";
$username = "root";
$password = ""; // change pass it not connect
$database = "project";
$conn = mysqli_connect($servername, $username, $password, $database);
// echo "Connection Sucseed(>_<)";
if (!$conn) {
    die("Something Wronge --> " . mysqli_connect_error());
}

function f1()
{
    global $conn;
    $data["test"] = 0;
    $stmt = mysqli_stmt_init($conn);
    $qs = "SELECT * FROM parking WHERE floor = 0";
    if (mysqli_stmt_prepare($stmt, $qs)) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($dataTemp = mysqli_fetch_assoc($result)) {
            $data["slot_no"][] = $dataTemp["slot_no"];
        }
    }
    mysqli_stmt_close($stmt);
    return $data;
}

if (isset($_POST["submit_btn"])) {
    $vhno = strval($_POST["vno"]);
    $mono = $_POST["mno"];
    $slot_no = $_POST["slot_no"];
    $mail = $_POST['email'];
    // VALIDATIONS
    $query = "SELECT * FROM `parking` WHERE `vh_no` = '$vhno'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // display an error message to the user
    ?>
        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
            Oops <strong>This Vehicle Already Parked.</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    } else {
        if ($vhno !== "" && $mail !== "") {
            if (preg_match('/^[A-Z]{2}[0-9]{2}[A-Z]{2}[0-9]{4}$/', $vhno)) {
                if (preg_match('/^[0-9]{10}$/', $mono)) {
                    // Insert Data into DB
                    // INSERT INTO `parking` (`Operator`, `floor`, `slot_no`, `vh_no`, `mobile_no`, `mail`, `entrytime`) VALUES ('OP01', '1', '1', 'AA1111', '9898989898', 'mihirathod25@gmail.com', current_timestamp());
                    $sql = "INSERT INTO `parking` (`Operator`,`floor`,`slot_no`,`vh_no`,`mobile_no`,`mail`,`entrytime`) VALUES ('$operator','0','$slot_no', '$vhno','$mono','$mail', current_timestamp());";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        echo "Error: " . mysqli_error($conn);
                        exit;
                    }
                    $sql = "SELECT *, COUNT(*) AS count FROM parking WHERE `slot_no` = '$slot_no' and `mail` = '$mail';";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        echo "Error: " . mysqli_error($conn);
                        exit;
                    }
                    $row = mysqli_fetch_assoc($result);
                    $floor = $row['floor'];
                    $carno = $row['vh_no'];
                    $slotno = $row['slot_no'];
                    $entry_time = $row['entrytime'];
                    $to = $mail;
                    $subject = "Car Parked";

                    $message = "<div class=\"body\" style=\"background-image: repeating-linear-gradient(#f2f2f2,#54545433); width: 99%; min-width: 80%; padding: 1%; border: 2px solid gray; margin: 0px;\">
                    <p style=\"font-size: larger; color: red; font-style: initial;\">Hello Sir/Mam</p>
                    <hr>
                    <p style=\"font-size: large;\">This is Your Car Parking Details.</p>
                    <table align=\"center\" >
                        <tr>
                            <th style=\"display: flex;margin-right: 25px;\">Floor </th>
                            <td> $floor </td>
                        </tr>
                        <tr>
                            <th style=\"display: flex;margin-right: 25px;\">Car Number </th>
                            <td>$carno</td>
                        </tr>
                        <tr>
                            <th style=\"display: flex;margin-right: 25px;\">Slot Number </th>
                            <td>$slotno</td>
                        </tr>
                        <tr>
                            <th style=\"display: flex;margin-right: 25px;\">Entry Time </th>
                            <td>$entry_time</td>
                        </tr>
                    </table>
                    <h1 style=\"font-size: x-large; color: #a40e00;\" align=\"center\">Thank you for Parking.</h1>
                    <hr>
                </div>";
                    $nl = "\r\n";
                    //Header information
                    $headers = "MIME-Version: 1.0" . $nl;
                    $headers .= "Content-type: text/html; charset=iso-8859-1" . $nl;
                    // $headers .= "To <$to>" . $nl;
                    $headers .= "From:example.org" . $nl;

                    if (!mail($to, $subject, $message, $headers)) {
                        echo "<div class=\"alert\">
                                <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> 
                                <strong>Something Wrong!</strong> Please Check Your Network Connection or Mail ID.
                            </div>";
                    }

                    if (!$result) {
                        printf("Error: %s\n", mysqli_error($conn));
                        exit();
                    }
                    header('location: ./Entry_F-0.php');
                    return;
                } else {
        ?>
                    <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                        Please Enter valid <strong>Mobile Number</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" require></button>
                    </div>
                <?php }
            } else { ?>
                <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                    Please Enter valid <strong>Vehicle Number</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
<?php }
        }
    }
}
function slot_check()
{
    global $conn, $occupied_slot, $Vacant;
    $sql = "SELECT * from parking where floor = 0";
    if ($result = mysqli_query($conn, $sql)) {
        // Return the number of rows in result set
        $occupied_slot = mysqli_num_rows($result);
        $Vacant = 100 - $occupied_slot;
    }
}
?>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="./Entry_F-0.php" class="active">Floor-0</a></li>
                <li><a href="./Entry_F-1.php">Floor-1</a></li>
                <li><a href="./Entry_F-2.php">Floor-2</a></li>
            </ul>
        </nav>
    </header>
    <div class="contain" style="display: flex; align-items: center; flex-direction: column;">
        <div class="parking" style="display: flex;flex-direction: column;align-items: center;">
            <div class="slot-display">
                <?php slot_check(); ?>
                <span>Occupied Slot : <?= $occupied_slot ?></span>
                <br>
                <span>Vacant Slot : <?= $Vacant ?></span>
            </div>
            <div class="parking-area">
                <!-- Entry Gate -->
                <div class="entrygate gate">
                    <label>E</label>
                    <label>N</label>
                    <label>T</label>
                    <label>R</label>
                    <label>Y</label>
                </div>
                <?php $data = f1();
                // Parking Slots File 1 to 100
                include('./parking/entry-parking.php');
                // Modal File 1 to 100
                include('./modal/entry-modal.php');
                ?>
                <!-- Exit Gate -->
                <div class="exitgate gate">
                    <label>E</label>
                    <label>X</label>
                    <label>I</label>
                    <label>T</label>
                </div>
            </div>
        </div>
        <?php
        // display last 3 entry and exit
        include('./parking/floor0-display.php') ?>
    </div>
    <!-- Logout Button Display -->
    <div style="position: fixed; bottom: 20px; right: 20px;">
        <form action="" method="post">
            <button type="submit" class="btn btn-outline-danger" name="logout">Logout</button>
        </form>
    </div>
    <?php
    // logout logic
    if (isset($_REQUEST['logout'])) {
        session_destroy();
    ?>
        <script>
            window.location.replace("./login.php");
        </script>
    <?php
    }
    ?>
    <script src="./Script/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>