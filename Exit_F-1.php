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

ob_start();
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
    $qs = "SELECT * FROM parking WHERE floor = 1";
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
function getPrice($time, $time1)
{
    $timeObj = new DateTime($time);
    $timeObj1 = new DateTime($time1);
    $diff = $timeObj->diff($timeObj1);

    $hours = $diff->h + $diff->days * 24; // calculate total hours
    $price = 25 + 25 * ($hours - 1); // calculate price based on formula
    if ($price == 0) {
        $price = 25;
    }
    return ($price > 500) ? 500 : $price; // cap price at 500
}

function slot_check()
{
    global $conn, $occupied_slot, $Vacant;
    $sql = "SELECT * from parking where floor = 1";
    if ($result = mysqli_query($conn, $sql)) {
        // Return the number of rows in result set
        $occupied_slot = mysqli_num_rows($result);
        $Vacant = 100 - $occupied_slot;
    }
}


?>
<html lang="en">

<head>
    <title>Operator-2</title>
    <link rel="stylesheet" href="CSS/parking.css">
    <link rel="stylesheet" href="CSS/theme.css">
    <link rel="stylesheet" href="CSS/model.css">
    <link rel="stylesheet" href="CSS/display-slot.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        body {
            color: whitesmoke;
            /* background: linear-gradient(225deg, #090045c2, #000) ; */
        }

        .occupied {
            background-color: #00000060 !important;
            color: #f5f5f590 !important;
        }

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
            position: relative;
            animation: mymove 3s;
            animation-timing-function: cubic-bezier(0, 0.72, 0, 1);
        }
    </style>
</head>
<?php
if (isset($_POST['dlt'])) {

    $slotNo = $_POST['slotno'];

    $queryOne = "SELECT * FROM parking WHERE slot_no = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $queryOne)) {
        mysqli_stmt_bind_param($stmt, "i", $slotNo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);
    } else {
        // problem with stmt or query;
    }
    $vhNo = $data["vh_no"];
    $moNo = $data["mobile_no"];
    $entryTime = $data["entrytime"];
    $entryoperator = $data["Operator"];
    $mail = $data["mail"];
    $exitTime = date("Y-m-d H:i:s");
    $floor = 1;
    $price = getPrice($entryTime, $exitTime);
    // Assign the value of the operator session variable to $operator
    $operator = $_SESSION['operator_id'];
    // Prepare the INSERT statement
    $queryTwo = "INSERT INTO parking_data (entry_operator, exit_operator, slot_no, vh_no, mobile_no, email, entrytime, exittime, floor, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $queryTwo)) {
        // Bind the variables to the prepared statement
        mysqli_stmt_bind_param($stmt, "ssisisssid", $entryoperator, $operator, $slotNo, $vhNo, $moNo, $mail, $entryTime, $exitTime, $floor, $price);

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // problem with stmt or query;
    }

    // Prepare the DELETE statement
    $queryThree = "DELETE FROM parking WHERE floor = 1 AND slot_no = ?";
    if ($stmt2 = mysqli_prepare($conn, $queryThree)) {
        mysqli_stmt_bind_param($stmt2, "i", $slotNo);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);

        // Mail
        $sql = "SELECT *, COUNT(*) AS count FROM parking_data WHERE `slot_no` = '$slotNo' and `email` = '$mail';";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Error: " . mysqli_error($conn);
            exit;
        }
        $row = mysqli_fetch_assoc($result);
        $slot_no = $row['slot_no'];
        $to = $mail;
        $subject = "Car Parked";

        $message = "<div class=\"body\"  style=\"background-image: repeating-linear-gradient(#f2f2f2,#54545433); width: 99%; min-width: 80%; padding: 1%; border: 2px solid gray; margin: 0px;\">
        <p style=\"font-size: larger; color: red; font-style: initial;\">Hello Sir/Mam</p>
        <hr>
        <p style=\"font-size: large;\">This is Your Car Parking Details.</p>
        <table align=\"center\" style=\"
        padding: 10px;
        font-size: larger;
    \">
            <tr>
                <th style=\"display: flex;margin-right: 25px;\">Floor </th>
                <td> $floor </td>
            </tr>
            <tr>
                <th style=\"display: flex;margin-right: 25px;\">Car Number </th>
                <td>$vhNo</td>
            </tr>
            <tr>
                <th style=\"display: flex;margin-right: 25px;\">Slot Number </th>
                <td>$slot_no</td>
            </tr>
            <tr>
                <th style=\"display: flex;margin-right: 25px;\">Entry Time </th>
                <td>$entryTime</td>
            </tr>
            <tr>
                <th style=\"display: flex;margin-right: 25px;\">Exit Time </th>
                <td>$exitTime</td>
            </tr>
            <tr>
                <th style=\"display: flex;margin-right: 25px;\">Price </th>
                <td>$price</td>
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
            echo "<script type=\"text/javascript>
            alert(\"Somethig wronge!\");
</script>";
        }
    } else {
        // problem with stmt or query;
    }

    header("location: ./Exit_F-1.php");
    ob_end_clean();
}
?>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="./Exit_F-0.php">Floor-0</a></li>
                <li><a href="./Exit_F-1.php" class="active">Floor-1</a></li>
                <li><a href="./Exit_F-2.php">Floor-2</a></li>
            </ul>
        </nav>
    </header>
    <div class="contain" style="display: flex; align-items: center; flex-direction: column;">
        <div class="parking" style="display: flex;flex-direction: column;align-items: center;">
            <div class="slot-display">
                <span>Occupied Slot : <?php slot_check();
                                        echo $occupied_slot; ?></span>
                <br>
                <span>Vacant Slot : <?= $Vacant ?></span>
            </div>
            <div class="parking-area">
                <?php $data = f1(); ?>
                <!-- Entry Gate -->
                <div class="entrygate gate">
                    <label>E</label>
                    <label>N</label>
                    <label>T</label>
                    <label>R</label>
                    <label>Y</label>
                </div>
                <?php
                include('./parking/exit-parking.php');
                include('./modal/exit-modal.php');
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
        include('./parking/floor1-display.php') ?>
    </div>
    <!-- <div style="display: flex;justify-content: center;">

        <div class="ticket" style="color:#242333; display: flex; justify-content: flex-start; margin: 20px 0; padding:15px; background-color:ghostwhite; width:200px; height:250px; flex-direction:column;">
            Ticket
        </div>
    </div> -->

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
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="./Script/script.js"></script>

</html>