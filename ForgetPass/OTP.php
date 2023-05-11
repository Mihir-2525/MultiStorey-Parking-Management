<?php session_start();
ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/otp.css">
    <style>
        body {
            background-image: url(Image/dummy1.jpg);
            /* Full height */
            height: 100vh;
            overflow: hidden;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_REQUEST['submit'])) {

        if ($_REQUEST["otp"] == $_SESSION["otp"]) {
            header("location: ./NewPassword.php");
            ob_end_clean();
        } else {
            echo "<div class=\"alert danger\">
                        <span class=\"closebtn\">&times;</span>
                        <strong>Check Your Mail!</strong> Your password is wrong. If you dont have any OTP then check your Internet Connection.
                    </div>";
        }
    }
    ?>
    <section>
        <div class="contentbox">
            <div class="formbox">
                <h2>E-Mail ID displayed</h2>
                <form align="center">
                    <div class="inputbox">
                        <div>
                            <h1>OTP</h1>
                        </div>
                        <div class="inputfield">
                            <input type="text" maxlength="4" size="4" class="input" pattern="[0-9]{4}" name="otp" />
                        </div>
                    </div>
                    <div class="inputbox">
                        <button type="submit" value="varify" name="submit">Varify</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
<script>
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

</html>