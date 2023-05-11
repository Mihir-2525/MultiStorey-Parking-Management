<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        body {
            overflow: hidden;
        }
    </style>
</head>

<body><?php
        session_start();
        $showAlert = false;
        $showError = false;

        // Set database credetials
        $servername = "Localhost";
        $username = "root";
        $password = "";
        $dbname = "project";
        // Create Connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        //Check Connection
        if (!$conn) {
            die("Connection Failed!:" . mysqli_connect_error());
        }
        //Get Entered Username and Password
        if (isset($_POST['submit'])) {
            $user_id = $_POST['OperatorID'];
            $password = $_POST['OperatorPass'];
            $user_password = md5($password);;
            $_SESSION['operator_id'] = $user_id;

            if (preg_match("/^AD/", $user_id)) {
                $sql = "SELECT * FROM `admin` WHERE `admin-id`='$user_id' AND `password`='$user_password'";
                $result = mysqli_query($conn, $sql);
                $_SESSION['Admin_id'] = $user_id;
                if (mysqli_num_rows($result) > 0) {
                    header('location: ./Admin/home.php');
                } else { ?>
                <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                    Oops <strong>Admin ID and Password Doesn't Matched.</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" require></button>
                </div>
            <?php
                }
            } elseif (preg_match("/^OP/", $user_id)) {
                $sql = "SELECT * FROM `operator` WHERE `operator-id`='$user_id' AND `Password`='$user_password'";

                //Query Database for matching user
                $result = mysqli_query($conn, $sql);

                // Check if there is a matching user 
                if (mysqli_num_rows($result) > 0) {
                    // check operator id for login
                    preg_match_all('/(\d+)/', $user_id, $matches);
                    $number = implode('', $matches[0]);
                    if (($number % 2) == 1) {
                        header('location:./Entry_F-0.php');
                    } else {
                        header('location:./Exit_F-0.php');
                    }
                } else {
                    //Invalid Login 
            ?>
                <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                    Oops <strong>Operator ID and Password Doesn't Matched.</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" require></button>
                </div>
            <?php
                }
            } else { ?>
            <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                Oops! <strong>Operator ID Doesn't Exist.</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" require></button>
            </div>
    <?php }
            //Close Connection
            mysqli_close($conn);
        }
    ?>
    <section>

        <!-- <div class="display"></div> -->
        <div class="imgbox">
            <img src="Image/img.png" alt="Background Image">
        </div>
        <div class="contentbox">
            <div class="formbox">
                <h2>Login</h2>
                <form method="POST" action="">

                    <div class="inputbox">
                        <span>ID</span>
                        <input type="text" pattern="^(AD|OP)\d{2}$" name="OperatorID" required>
                    </div>
                    <div class="inputbox">
                        <span>Password</span>
                        <input type="Password" name="OperatorPass" required>
                    </div>
                    <div class="ForgetPass">
                        <a href="./ForgetPass/ForgetPassword.php">Forget Password?</a>
                        <!-- <label><input type="checkbox" name="" id="">Remember me</label> -->
                    </div>
                    <div class="inputbox">
                        <button type="submit" name="submit">Login</button>
                        <!-- <input type="login" value="Login" id="Login"> -->
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>