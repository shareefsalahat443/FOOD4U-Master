<?php
session_start();
session_unset();
session_destroy();
$errormsg="";
$disableSmallDiv="";
if($_SERVER["REQUEST_METHOD"]=="POST") {

    if (isset($_POST['errorOkButton'])) {
        $disableSmallDiv = "";
        $errormsg = "";
    }
}
if($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (empty($email) || empty($password)) {
            $errormsg = "";
            $disableSmallDiv = "";
        } else {
            try {
                $errormsg = "";
                $disableSmallDiv = "";
                $db = new mysqli('localhost', 'root', '', 'food4u');
                $qryStr = "select * from user";
                $res = $db->query($qryStr);

                for ($i = 0; $i < $res->num_rows; $i++) {
                    $row = $res->fetch_object();
                    if ($row->Email == $email && (sha1($password) == $row->password)) {
                        session_start();
                        $_SESSION['validmem'] = 1;
                        $_SESSION['Email'] = $row->Email;
                        $_SESSION['level'] = $row->level;
                        if($row->level == 'C'){
                            header('location:CHome.php');
                        }
                        if($row->level == 'R'){
                            header('location:restaurant.php');
                        }
                        if($row->level == 'M'){
                            header('location:Manager.php');
                        }
                        $errormsg = "";
                        $disableSmallDiv = "";
                    } else {
                        $errormsg = "Email / Password is incorrect, Please Try Again";
                        $disableSmallDiv = "<div class='errorMenuItem ' >
    <div class='errorMenuItem2 container h-100' >
        <div class='row align-items-center h-100' >
            <div class='col-md-2' ></div>

            <div class='col-md-8 mx-auto'>
                <div class='errorMenuItemContent' style='align: center'>
                    <form method='POST' action=" . $_SERVER["PHP_SELF"] . ">
                        <table style='width: 100%; border-collapse: separate; border-spacing: 0 20px;'>
                            <tr><td style='text-align: center; vertical-align: middle;'><textarea class='errorTextField ' style='resize: none' disabled type='text' name='ErrorPrice' cols='4'>$errormsg</textarea></td></tr>
                            <tr><td style='text-align: center; vertical-align: middle;'><input type='submit' class='blackSquaredButton' name='errorOkButton' style='width:50%; height:50px' value='Ok'></td></tr>
                        </table>
                    </form>
                </div>
            </div>
            <div class='col-md-2' ></div>
        </div>
    </div>
</div> ";

                    }

                }
                $db->close();
            } catch (Exception $e) {

            }
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Food 4U - LogIn</title>
    <link rel="stylesheet" href="css/LoginCss.css">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link href="node_modules/aos/dist/aos.css" rel="stylesheet">

</head>
<body>
<?php echo $disableSmallDiv; ?>
<section class="login" style="overflow: hidden">
    <div class="login_box row" >
        <div class="left col-sm-6"data-aos="fade-down" data-aos-duration="1500" data-aos-delay="50">
            <div class="top_link"><a href="Index.php"><img src="icons/left.svg" alt=""></a></div>
            <div class="contact">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <h1>LOGIN</h1>
                    <table>
                        <tr>

                            <td>
                                <input type="text" name="email" placeholder="Email">
                                <div class="line"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" name="password" placeholder="PASSWORD">
                                <div class="line"></div>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a class="grayText" href="ForgotPassword.php">Forgot your Password?</a>
                                <input type="submit" class="buttonBorderd" id="login" name="login" value="Login">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h7>Dont have an account? <a class="grayText" href="Signup.php">SignUp</a></h7>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="right col-sm-6" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="50" style="overflow: hidden">
            <div class="right-text">
                <h2>Food<span  style="color: #26e07f;font-size: 50px">4</span>U</h2>
            </div>
            <div class="right-inductor"></div>
        </div>
    </div>
</section>







<script src="node_modules/aos/dist/aos.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script>
    AOS.init();
</script>
</body>
</html>
