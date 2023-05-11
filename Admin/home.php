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

function slot_check()
{
    global $conn, $occupied_slot, $Vacant;
    $sql = "SELECT * from parking";
    if ($result = mysqli_query($conn, $sql)) {
        // Return the number of rows in result set
        $occupied_slot = mysqli_num_rows($result);
        $Vacant = 300 - $occupied_slot;
    }
}
function slot_check_f0()
{
    global $conn, $occupied_slot, $Vacant;
    $sql = "SELECT * from parking WHERE floor = 0";
    if ($result = mysqli_query($conn, $sql)) {
        // Return the number of rows in result set
        $occupied_slot = mysqli_num_rows($result);
        $Vacant = 100 - $occupied_slot;
    }
}
function slot_check_f1()
{
    global $conn, $occupied_slot, $Vacant;
    $sql = "SELECT * from parking WHERE floor = 1";
    if ($result = mysqli_query($conn, $sql)) {
        // Return the number of rows in result set
        $occupied_slot = mysqli_num_rows($result);
        $Vacant = 100 - $occupied_slot;
    }
}
function slot_check_f2()
{
    global $conn, $occupied_slot, $Vacant;
    $sql = "SELECT * from parking WHERE floor = 2";
    if ($result = mysqli_query($conn, $sql)) {
        // Return the number of rows in result set
        $occupied_slot = mysqli_num_rows($result);
        $Vacant = 100 - $occupied_slot;
    }
}
?>

<body>
    <h3>Parking Status</h3>
    <div style="display: flex;flex-direction:row;">
        <div class="slot-display">
            <?php slot_check(); ?>
            <span>Occupied Slot : <?= $occupied_slot ?></span>
            <br>
            <span>Vacant Slot : <?= $Vacant ?></span>
            <p>
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#dataview" aria-expanded="false" aria-controls="dataview">Display data</button>
            </p>
        </div>
        <div style="min-height: 40px;">
            <div class="collapse collapse-horizontal" id="dataview">
                <div class="card" style="width:555px;display: flex;flex-direction: row;">
                    <div class="slot-display">
                        <h3>Floor - 0</h3>
                        <?php slot_check_f0() ?>
                        <span>Occupied Slot : <?= $occupied_slot ?></span>
                        <br>
                        <span>Vacant Slot : <?= $Vacant ?></span>
                    </div>
                    <div class="slot-display">
                        <h3>Floor - 1</h3>
                        <?php slot_check_f1() ?>
                        <span>Occupied Slot : <?= $occupied_slot ?></span>
                        <br>
                        <span>Vacant Slot : <?= $Vacant ?></span>
                    </div>
                    <div class="slot-display">
                        <h3>Floor - 2</h3>
                        <?php slot_check_f2() ?>
                        <span>Occupied Slot : <?= $occupied_slot ?></span>
                        <br>
                        <span>Vacant Slot : <?= $Vacant ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <h3>Parked Cars</h3>
    <br>
    <table class="table table-hover" id="myTable">
        <thead>
            <tr>
                <th scope="col">Operator</th>
                <th scope="col">Floor</th>
                <th scope="col">Slot no.</th>
                <th scope="col">Vehicle no.</th>
                <th scope="col">Mobile no.</th>
                <th scope="col">Email</th>
                <th scope="col">Entry Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM `parking`";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                <th scope='row'>" . $row['Operator'] . "</th>
                <th scope='row'>" . $row['floor'] . "</th>
                <th scope='row'>" . $row['slot_no'] . "</th>
                <th>" . $row['vh_no'] . "</th>
                <th>" . $row['mobile_no'] . "</th>
                <th>" . $row['mail'] . "</th>
                <td>" . $row['entrytime'] . "</td>
                </tr>";
             }
            ?>
        </tbody>
    </table>
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