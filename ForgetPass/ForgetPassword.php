<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link rel="stylesheet" href="../CSS/style1.css">
    <!-- <link rel="stylesheet" href="../CSS/sidebar.css"> -->
    <style>
        section {
            position: relative;
            width: 100%;
            height: 100vh;
            display: flex;
        }

        body {
            background-image: url(image/dummy4.jpg);
            /* Full height */
            height: 100%;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        section .contentbox .formbox {
            width: 50%;
            background-color: #00000090;
            padding: 15px;
            border-radius: 35px;
        }

        /* Popup when Error Occured in Send OTP */
        .alert {
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

        /* Popup when Send Mail on OTP */
        .alert.success {
            background-color: #04AA6D;
        }
    </style>
</head>

<?php
// Set database credetials
$servername = "Localhost";
$username = "root";
$password = "";
$dbname = "project";
// Create Connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (isset($_POST['submit'])) {
    $mail = $_POST['mail'];
    $sql = "SELECT *, COUNT(*) AS count FROM operator WHERE Email='$mail';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $_SESSION['operator-id'] = $row['operator-id'];
    $count = $row['count'];
    if ($count == 1) {

        $otp = rand(1000, 9999);
        $_SESSION["otp"] = $otp;
        $to = $mail;
        $subject = "OTP";

        $message =  "<div class=\"body\" align=\"center\" style=\"background-image:repeating-linear-gradient(rgba(0, 255, 0, 0.255),rgba(255, 0, 0, 0.318)); width: 99%;min-width: 30%; padding: 1%; border: 5px solid gray; margin: 0px;\">
                    <p style=\"font-size: larger; color: red; font-style: initial;\">Please Don't Share With Anyone!</p>
                    <hr>
                    <p style=\"font-size: large;\">Hello user Your One Time Password is </p>
                    <h1 style=\"font-size: x-large; color: #a40e00;\">$otp </h1>
                    <hr>
                </div>";
        $nl = "\r\n";
        //Header information
        $headers = "MIME-Version: 1.0" . $nl;
        $headers .= "Content-type: text/html; charset=iso-8859-1" . $nl;
        // $headers .= "To <$to>" . $nl;
        $headers .= "From:example.org" . $nl;

        if (mail($to, $subject, $message, $headers)) {
            echo "<div class=\"alert success\">
                    <span class=\"closebtn\" >&times;</span>  
                    <strong>Check Your Mail...</strong>
                </div>";
            echo "<script> location.href='OTP.php'; </script>";
            exit;
        } else {
            echo "<div class=\"alert\">
                    <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> 
                    <strong>Something Wronge!</strong> Please Check Your Network Connection or Mail ID.
                </div>";
        }
    } else {
        // email does not exist in database, show error message
        echo "<div class=\"alert\">
                <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> 
                <strong>Email not found!</strong> Please check the email address and try again.
            </div>";
    }
}
?>

<body>
    <section>
        <div class="contentbox">
            <div class="formbox">
                <h2>Forget Password</h2>
                <!-- <div class="inputbox">
                    <span>Please Enter Your Email to Receive a Verification Code</span>
                </div> -->
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="inputbox">
                        <span>E-mail Address</span>
                        <input type="email" name="mail">
                    </div>
                    <div class="inputbox">
                        <button type="submit" name="submit">Send OTP</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>