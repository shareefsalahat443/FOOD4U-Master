<?php
session_start();
$errormsg = "";
$disableSmallDiv = "";
$passwordC="";
$codeC="";
if($_SERVER["REQUEST_METHOD"]=="POST") {
    $passwordC="";
    $codeC="";
    if (isset($_POST['errorOkButton'])) {
        $disableSmallDiv="";
        $errormsg="";
    }
}
if($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_POST['changePass'])) {
    $passwordC=$_POST['passwordC'];
    $codeC=$_POST['codeC'];

    if (isset($_POST['changePass']) && !empty($passwordC)&& !empty($codeC)) {
        $errormsg = "";
        $disableSmallDiv = "";
        if($codeC==$_SESSION['code'] ){
            $errormsg = "";
            $disableSmallDiv = "";
            if(strlen($passwordC)>6){
                $errormsg = "";
                $disableSmallDiv = "";
                $conn = new mysqli('localhost', 'root', '', 'food4u');
                $qrstr="UPDATE `user` SET `password`='".sha1($passwordC)."' WHERE `Email`='".$_SESSION['email']."'";
                $conn->query($qrstr);
                $conn->close();
                header('location:login.php');
            }
            else{
                $errormsg = "Password is less than 6 digits";
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
        }else{
            $errormsg = "Wrong Inputs";
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
    }else{
        $errormsg = "Wrong Code";
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
?>
<?php echo $disableSmallDiv; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Food 4U - Change Password</title>
    <link rel="stylesheet" href="css/ChangePassword.css">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link href="node_modules/aos/dist/aos.css" rel="stylesheet">

</head>
<body>
<section class="forgot">
    <div class="forgot_box row" >
        <div class="col-md-3"></div>
        <div class="left col-sm-6">
            <div class="top_link"><a href="ForgotPassword.php"><img src="icons/left.svg" alt=""></a></div>
            <div class="contact">
                <form method='POST' action=" <?php echo$_SERVER["PHP_SELF"];?> ">
                    <div>

                    </div>
                    <table >
                        <tr class="spaceUnder">
                            <td >
                                <h1>Change Password</h1>
                                <h7 style="color: gray">Please Check Your Email For The Code</h7>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="codeC"id="codeC" placeholder="Code">
                                <div class="line"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" name="passwordC"id="passwordC" placeholder="NEW PASSWORD">
                                <div class="line"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button type="submit" name="changePass" id="changePass" class="buttonBorderd" >Change</button>
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
