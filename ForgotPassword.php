<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
session_start();
$_SESSION['email'] ="";
$_SESSION['code'] ="";
if($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST['errorOkButton'])) {
        $disableSmallDiv="";
        $errormsg="";
    }
    if (isset($_POST['forgetButton']) && isset($_POST['forgetEmail'])) {
        $emailId = $_POST['forgetEmail'];
        $_SESSION['email'] = $emailId;
        @$con = new mysqli('localhost', 'root', '', 'food4u');
        $result = "SELECT `name`, `Email`, `level` FROM `user` WHERE `Email`='" . $emailId . "' and (`level`='R' or`level`='C')";
        $res = $con->query($result);
        if ($res->num_rows == 0) {
            $flagSent = 1;
        } else {
            for ($i = 0; $i < $res->num_rows; $i++) {
                $row = $res->fetch_object();
                $code = rand(111111, 999999);
                $_SESSION['code'] =$code;
                $mail = new PHPMailer();

                $mail->CharSet = "utf-8";
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->Username = "Food4U2022F@gmail.com";
                $mail->Password = "123456789@#F";
                $mail->SMTPSecure = "ssl";
                $mail->Host = "smtp.gmail.com";
                $mail->Port = "465";
                $mail->FromName = 'Food4U';
                $mail->AddAddress($emailId);
                $mail->Subject = 'Reset Password';
                $mail->IsHTML(true);
                $mail->Body = 'Hi ,' . $row->name . '<br>
    We have received a request to reset your Food4U account password.<br>
    Enter the following code:' . $code;
                if ($mail->Send()) {
                    header('location:ChangePassword.php');
                } else {

                }
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

    <title>Food 4U - Forgot Password</title>
    <link rel="stylesheet" href="css/ForgotPassword.css">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link href="node_modules/aos/dist/aos.css" rel="stylesheet">

</head>
<body>
<section class="forgot">
    <div class="forgot_box row" >
        <div class="col-md-3"></div>
        <div class="left col-sm-6"data-aos="fade-right" data-aos-duration="1500" data-aos-delay="50">
            <div class="top_link"><a href="login.php"><img src="icons/left.svg" alt=""></a></div>
            <div class="contact">
                <form method='POST' action=" <?php echo $_SERVER['PHP_SELF'];?> ">
                    <div>

                    </div>
                    <table >
                        <tr class="spaceUnder">
                            <td >
                                <h1>Forgot Password</h1>
                                <h7 style="color: gray">Please Enter Your Email to send the code</h7>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input id="forgetEmail"name="forgetEmail" type="text" placeholder="Email">
                                <div class="line"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button type="submit" id="forgetButton"name="forgetButton" class="buttonBorderd" onclick="">Send</button>
                            </td>
                        </tr>

                    </table>
                </form>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</section>







<script src="node_modules/aos/dist/aos.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script>
    AOS.init();
</script>
</body>
</html>
