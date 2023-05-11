<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Password</title>
    <link rel="stylesheet" href="../CSS/style1.css">
    <style>
        section {
            position: relative;
            width: 100%;
            height: 100vh;
            display: flex;
        }

        body {
            background-image: url(Image/dummy1.jpg);
            /* Full height */
            height: 100%;
            overflow: hidden;
            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        section .contentbox .formbox {
            width: 50%;
            background-color: #00000050;
            padding: 15px;
            border-radius: 35px;
        }

        .viewpass {
            width: 100%;
            padding: 10px;
            min-width: 35px;
            font-size: 16px;
            color: #22b5ff;
            font-weight: 400;
            letter-spacing: 1px;

        }

        /* Alert */
        .danger {
            padding: 20px;
            background-color: #f44336;
            color: white;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>
</head>

<body>
    <?php
    $sessId = $_SESSION['operator-id'];
    if (isset($_POST['submit'])) {
        $Npass = $_POST['Newpass'];
        $Conpass = $_POST['Conpass'];
        $Pass = md5($Npass);
        $id = $_POST['ID'];
        if ($id == $sessId) {
            if ($Npass != $Conpass) {
                echo "Password Do not Match!";
            }
            $servername = "Localhost";
            $username = "root";
            $password = "";
            $dbname = "project";
            // Create Connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            $sql1 = "UPDATE `operator` SET `Password`='$Pass' WHERE `operator-id`='" . $id . "'";
            // $sql = "UPDATE `operator` SET `Password`= '$Npass' WHERE `operator-id`='$id'";
            $result = mysqli_query($conn, $sql1);
            if ($result === FALSE) {
                die(mysqli_error($connect));
            } else {
                header('location:../login.php');
            }
        } else {
            echo "<div class=\"alert danger\">
            <span class=\"closebtn\">&times;</span>
            <strong>Enter Valid ID</strong> Your Email and ID doesn't match
        </div>";
        }
    }
    ?>
    <section>
        <div class="contentbox">
            <div class="formbox">
                <h2>Create New Password</h2>
                <form method="POST" action="">
                    <div class="inputbox">
                        <span>Enter Operator-ID</span>
                        <input type="text" value="" name="ID">
                    </div>
                    <div class="inputbox">
                        <span>New Password</span>
                        <input type="password" value="FakePSW" id="myInput1" name="Newpass">
                    </div>
                    <div class="inputbox">
                        <span>Confirm Password</span>
                        <input type="password" value="FakePSW" id="myInput2" name="Conpass">
                    </div>
                    <div class="viewpass">
                        <input type="checkbox" onclick="myFunction()">
                        <span>Show Password</span>
                    </div>
                    <div class="inputbox">
                        <button type="submit" name="submit"><a href="login.php">Save</a></button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        function myFunction() {
            var x = document.getElementById("myInput1");
            var y = document.getElementById("myInput2");
            if (x.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
        var close = document.getElementsByClassName("closebtn");
        var i;
        for (i = 0; i < close.length; i++) {
            close[i].onclick = function() {
                var div = this.parentElement;
                div.style.opacity = "0";
                setTimeout(function() {
                    div.style.display = "none";
                }, 600);
            }
        }
    </script>
</body>

</html>