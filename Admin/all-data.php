<?php
include('navbar.php');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        body {
            background-color: #f2f2f2 !important;
        }

        .display-data {
            display: flex;
            flex-direction: row;
            align-content: flex-end;
            justify-content: space-between;
            align-items: flex-end;
            color: whitesmoke !important;
        }

        .display-data .ticket {
            color: whitesmoke;
            background-color: #1C2541;
            padding: 20px;
            margin: 15px 5px;
            max-width: 600px;
        }

        .display-data table {
            width: 100%;
            border-collapse: collapse;
        }

        .display-data td {
            padding: 10px;
            border-bottom: 1px solid white;
        }

        .display-data h1 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .slot-display {
            margin: 5px;
            color: black;
            background-color: #00ffff0f;
            height: 150px;
            width: 200px;
            border: #1e90ffab solid 2px;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }
    </style>
</head>
<?php
//setting the timezone
$tz = 'Asia/Kolkata';
date_default_timezone_set($tz);

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

?>

<body>
    <form method="post">
        From : <input type="datetime-local" name="from">
        To : <input type="datetime-local" name="to">
        <input type="submit" value="search" name="search">
    </form>
    <hr>
    <?php
    if (isset($_POST['search'])) {
        $entry_time = date('Y-m-d H:i:s', strtotime($_POST["from"]));
        $exit_time = date('Y-m-d H:i:s', strtotime($_POST["to"]));
        $sql = "SELECT * FROM `parking_data` WHERE entrytime BETWEEN '$entry_time' AND '$exit_time' AND exittime BETWEEN '$entry_time' AND '$exit_time'";
        $result = mysqli_query($conn, $sql);
        $et = date('d-m-Y H:i:s', strtotime($entry_time));
        $ext = date('d-m-Y H:i:s', strtotime($exit_time));
        echo "<div style=\"display: flex;justify-content: space-between;\"><h5> Data Between $et to $ext </h5>";
        $totalPrice = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $price = $row['price'];
            $totalPrice += $price;
        }
    ?>
        <h5>Income : <?= $totalPrice ?></h5>
        </div>
        <hr>
        <h3>Car History </h3>
        <table class="table table-hover" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Entry Operator</th>
                    <th scope="col">Exit Operator</th>
                    <th scope="col">Slot no.</th>
                    <th scope="col">Floor</th>
                    <th scope="col">Vehicle no.</th>
                    <th scope="col">Mobile no.</th>
                    <th scope="col">Email</th>
                    <th scope="col">Entry Time</th>
                    <th scope="col">Exit Time</th>
                    <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result2 = mysqli_query($conn, $sql);
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    echo "<tr>
                            <th>" . $row2['entry_operator'] . "</th>
                            <th scope='row'>" . $row2['exit_operator'] . "</th>
                            <th>" . $row2['slot_no'] . "</th>
                            <td>" . $row2['floor'] . "</td>
                            <th>" . $row2['vh_no'] . "</th>
                            <th>" . $row2['mobile_no'] . "</th>
                            <th>" . $row2['email'] . "</th>
                            <td>" . $row2['entrytime'] . "</td>
                            <td>" . $row2['exittime'] . "</td>
                            <td>" . $row2['price'] . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    <?php   } else {
    ?>
        <h3>Car History</h3>
        <br>
        <table class="table table-hover" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Entry Operator</th>
                    <th scope="col">Exit Operator</th>
                    <th scope="col">Slot no.</th>
                    <th scope="col">Floor</th>
                    <th scope="col">Vehicle no.</th>
                    <th scope="col">Mobile no.</th>
                    <th scope="col">Email</th>
                    <th scope="col">Entry Time</th>
                    <th scope="col">Exit Time</th>
                    <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `parking_data`";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                <th>" . $row['entry_operator'] . "</th>
                <th scope='row'>" . $row['exit_operator'] . "</th>
                <th scope='row'>" . $row['slot_no'] . "</th>
                <td>" . $row['floor'] . "</td>
                <th>" . $row['vh_no'] . "</th>
                <th>" . $row['mobile_no'] . "</th>
                <th>" . $row['email'] . "</th>
                <td>" . $row['entrytime'] . "</td>
                <td>" . $row['exittime'] . "</td>
                <td>" . $row['price'] . "</td>
                </tr>";
                }
                ?>
            </tbody>
        </table>
    <?php } ?>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
</body>

</html>