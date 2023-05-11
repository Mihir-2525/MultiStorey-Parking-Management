<?php
include('navbar.php');

// Set database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define the price rates
$dailyRate = 10.00;
$weeklyRate = 60.00;
$monthlyRate = 200.00;

// Calculate daily income
$today = date('Y-m-d');
$sql = "SELECT SUM(price) AS daily_income FROM parking_data WHERE entrytime >= '$today'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$dailyIncome = $row['daily_income'] ?? 0;
// echo "Today's income: " . $dailyIncome . "<br>";

// Calculate weekly income
$weekAgo = date('Y-m-d', strtotime('-7 days'));
$sql = "SELECT SUM(price) AS weekly_income FROM parking_data WHERE entrytime >= '$weekAgo'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$weeklyIncome = $row['weekly_income'] ?? 0;
// echo "This week's income: " . $weeklyIncome . "<br>";

// Calculate monthly income
$monthly = date('Y-m-d', strtotime('-1 month'));
$sql = "SELECT SUM(price) AS monthlyIncome FROM parking_data WHERE entrytime >= '$monthly'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$monthlyIncome = $row['monthlyIncome'] ?? 0;
// echo "This month's income: " . $monthlyIncome . "<br>";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Income</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
            padding: 0;
            /* font-family: Arial, sans-serif; */
            /* background: linear-gradient(270deg, #f2f2f2, #adb5bd); */
            background: #f2f2f2;
            background-size: 100% 200%;
            color: whitesmoke;
            color: #ecf0f1;
            /* accent color: #3498db; */
        }

        .table {
            border: 3px solid black;
            border-radius: 10px;
            padding: 10px;
            /* width: 75vw; */
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: Arial, sans-serif;
            font-size: 18px;
            margin: 10px;
            color: black;
        }

        /* Style the table headers */
        .table .row {
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>

<body >
    <div class="table">
        <div class="row">
            Today Income
        </div>
        <div class="value"><?= "₹ " . number_format($dailyIncome, 2) ?></div>
        <hr>
        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#dailyincome" aria-expanded="false" aria-controls="dailyincome" style="border: 2px solid;">Data</button>
        <div style="min-height: 120px;">
            <br>
            <div class="collapse collapse-horizontal" id="dailyincome">
                <div class="card card-body" style="width: 75vh-50px;">
                    <?php
                    $today = date('Y-m-d');
                    $sql = "SELECT * FROM parking_data WHERE entrytime >= '$today'";
                    $result = mysqli_query($conn, $sql);
                    ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Entry Operator</th>
                                <th>Exit Operator</th>
                                <th>floor</th>
                                <th>Slot no.</th>
                                <th>Vehicle no.</th>
                                <th>Mobile no.</th>
                                <th>Email</th>
                                <th>Entry Time</th>
                                <th>Exit Time</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?= $row['entry_operator'] ?></td>
                                    <td><?= $row['exit_operator'] ?></td>
                                    <td><?= $row['floor'] ?></td>
                                    <td><?= $row['slot_no'] ?></td>
                                    <td><?= $row['vh_no'] ?></td>
                                    <td><?= $row['mobile_no'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['entrytime'] ?></td>
                                    <td><?= $row['exittime'] ?></td>
                                    <td><?= $row['price'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="table">
        <div class="row">Weekly Income</div>
        <div class="value"><?= "₹ " . number_format($weeklyIncome, 2) ?></div>
        <br>
        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#weeklyincome" aria-expanded="false" aria-controls="weeklyincome" style="border: 2px solid;">Data</button>
        <div style="min-height: 120px;">
            <br>
            <div class="collapse collapse-horizontal" id="weeklyincome">
                <div class="card card-body" style="width: 75vh-50px;">
                    <?php
                    $weekAgo = date('Y-m-d', strtotime('-7 days'));
                    $sql = "SELECT * FROM parking_data WHERE entrytime >= '$weekAgo'";
                    $result = mysqli_query($conn, $sql);
                    ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Entry Operator</th>
                                <th>Exit Operator</th>
                                <th>floor</th>
                                <th>Slot no.</th>
                                <th>Vehicle no.</th>
                                <th>Mobile no.</th>
                                <th>Email</th>
                                <th>Entry Time</th>
                                <th>Exit Time</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?= $row['entry_operator'] ?></td>
                                    <td><?= $row['exit_operator'] ?></td>
                                    <td><?= $row['floor'] ?></td>
                                    <td><?= $row['slot_no'] ?></td>
                                    <td><?= $row['vh_no'] ?></td>
                                    <td><?= $row['mobile_no'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['entrytime'] ?></td>
                                    <td><?= $row['exittime'] ?></td>
                                    <td><?= $row['price'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="table">
        <div class="row">
            Monthly Income
        </div>
        <div class="value"><?= "₹ " . number_format($monthlyIncome, 2) ?></div>
        <br>
        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#monthlyincome" aria-expanded="false" aria-controls="monthlyincome" style="border: 2px solid;">Data</button>
        <div style="min-height: 120px;">
            <br>
            <div class="collapse collapse-horizontal" id="monthlyincome">
                <div class="card card-body" style="width: 75vh-50px;">
                    <?php
                    $monthly = date('Y-m-d', strtotime('-1 month'));
                    $sql = "SELECT * FROM parking_data WHERE entrytime >= '$monthly'";
                    $result = mysqli_query($conn, $sql);
                    ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Entry Operator</th>
                                <th>Exit Operator</th>
                                <th>floor</th>
                                <th>Slot no.</th>
                                <th>Vehicle no.</th>
                                <th>Mobile no.</th>
                                <th>Email</th>
                                <th>Entry Time</th>
                                <th>Exit Time</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?= $row['entry_operator'] ?></td>
                                    <td><?= $row['exit_operator'] ?></td>
                                    <td><?= $row['floor'] ?></td>
                                    <td><?= $row['slot_no'] ?></td>
                                    <td><?= $row['vh_no'] ?></td>
                                    <td><?= $row['mobile_no'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['entrytime'] ?></td>
                                    <td><?= $row['exittime'] ?></td>
                                    <td><?= $row['price'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>