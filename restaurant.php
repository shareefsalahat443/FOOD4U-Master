<?php
session_start();
if(isset($_SESSION['validmem'])){
    if($_SESSION['validmem']==1&&$_SESSION['level']=='R'){

    }
    else{
        header('location:Index.php');
    }
}
else{
    header('location:Index.php');
}
$name="";
$profileImage="";
$description="";
$coverImage="";
$facebookLink="";
$InstagramLink="";
$siteLink="";
$disableSmallDiv="";
$errormsg="";
$stars="";
try{
    /*
        $conn = new mysqli('localhost','root','','food4u');
    $qrstr="SELECT `Email`, `REmail`, AVG (stars) FROM `reviews`,`restaurant` WHERE reviews.REmail=restaurant.Email  and restaurant.Email="aaaa@gmail.com" GROUP BY REmail";
    $res=$conn->query($qrstr);

    */
    $conn = new mysqli('localhost','root','','food4u');
    $qrstr="SELECT `name`, `level`, `profileImage`,`description`, `coverImage`, `facebookLink`, `InstagramLink`, `siteLink` FROM user ,restaurant WHERE user.Email=restaurant.Email and user.Email='".$_SESSION['Email']."'";
    $res=$conn->query($qrstr);
    $row=$res->fetch_object();
    $name=$row->name;
    $profileImage=$row->profileImage;
    $description=$row->description;
    $coverImage=$row->coverImage;
    $facebookLink=$row->facebookLink;
    $InstagramLink=$row->InstagramLink;
    $siteLink=$row->siteLink;
    $qrstr="SELECT `Email`, `REmail`, AVG (stars) as stars FROM `reviews`,`restaurant` WHERE reviews.REmail=restaurant.Email  and restaurant.Email='".$_SESSION['Email']."' GROUP BY REmail";
    $res=$conn->query($qrstr);
    $row=$res->fetch_object();
    $stars=$row->stars;
}
catch (Exception $ex){
    echo "<p>".$ex->getTraceAsString()."</p>";
}
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $disableSmallDiv="";
    $errormsg="";
    if (isset($_POST['errorOkButton'])) {
        $disableSmallDiv="";
        $errormsg="";
    }
    if(isset($_POST['changer'])) {

    $opass = $_POST['OPassword'];
    $npass = $_POST['NPassword'];
    $cpass = $_POST['CPassword'];
    $errormsg = "";
    $disableSmallDiv = "";
        $errormsg="";
    $qrstr0="SELECT * FROM `user` WHERE `password`='".sha1($opass)."' and `Email`='" . $_SESSION['Email'] . "'";
    $res =  $conn->query($qrstr0);
    $res = $conn->query($qrstr0);
    $row = $res->fetch_object();
    $dbPass = $row->password;
    if (isset($opass) &&isset($dbPass) && $dbPass == sha1($opass)) {
        if ($npass == $cpass) {
            if(strlen($npass)>=6) {
                $errormsg = "";
                $disableSmallDiv = "";
                $qrstr0="UPDATE user SET password ='" .sha1($npass) . "' WHERE `Email`='" . $_SESSION['Email'] . "'";
                $res =  $conn->query($qrstr0);
            }
            else{
                $errormsg = "New Password is Less than 6 Digits";
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
        } else {
            $errormsg = "New Passwords Doesnt Match!!";
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

    } else {
        $errormsg = "Your Old Password Is Wrong !!";
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

if(isset($_POST['saver'])) {
    $namer = $_POST['namer'];
    $emailr= $_POST['emailr'];
    $descrr= $_POST['descr'];
    $phoner = $_POST['phoner'];
    $fbre = $_POST['Fbr'];
    $instare = $_POST['instr'];
    $siter = $_POST['sitr'];
    $locationr = $_POST['locr'];
    //$profileimage = $_POST['profimage'];

    if (!empty($namer)&&!empty($emailr)&&!empty($phoner)&&!empty($locationr)&&strpos($emailr, '@')&&strpos($emailr, '.')&&!strpos($emailr, ' ')) {
        //$conn0 = new mysqli('localhost', 'root', '', 'food4u');
        //   $qrstr0="SELECT `Email` FROM `user`,`customer` WHERE `user`.`Email`=`customer`.`Email` and `user`.`Email`='".$emailc."'";
        $qrstr0="SELECT * FROM `user`,`customer` WHERE  `user`.`Email`=`customer`.`Email` and `user`.`Email`='".$emailr."'";
        $res =  $conn->query($qrstr0);
        $e = true;
        for ($i = 0; $i < $res->num_rows; $i++) {
            $row = $res->fetch_object();

            if ($row->Email == $emailr && $_SESSION['Email'] != $emailr)
            {
                $errormsg="Please Enater Valid Email";
                $disableSmallDiv="<div class='errorMenuItem ' >
    <div class='errorMenuItem2 container h-100' >
        <div class='row align-items-center h-100' >
            <div class='col-md-2' ></div>

            <div class='col-md-8 mx-auto'>
                <div class='errorMenuItemContent' style='align: center'>
                    <form method='POST' action=".$_SERVER["PHP_SELF"].">
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
</div> " ;
                $e = false;
            }
            else {

            }

        }
        if($e){
            $errormsg="";
            $disableSmallDiv="";
            if(isset($_FILES['Coverimage']['name']) && !empty($_FILES['Coverimage']['name'])) {
                $fileName = $_FILES['Coverimage']['name'];
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                $allowTypes = array('jpg', 'png', 'jpeg');
                if (in_array($fileType, $allowTypes) && $_FILES['Coverimage']['size'] < 200000) {
                    $conn = new mysqli('localhost', 'root', '', 'food4u');
                    $image = $_FILES['Coverimage']['tmp_name'];
                    $imgContent = addslashes(file_get_contents($image));
                    $qrstr = "UPDATE `restaurant` SET `coverImage`='" . $imgContent . "' WHERE `Email`='" . $_SESSION['Email'] . "'";
                    $conn->query($qrstr);
                }
                else{
                    $errormsg="Please Enater Valid Image (Less Than 200KB)";
                    $disableSmallDiv="<div class='errorMenuItem ' >
    <div class='errorMenuItem2 container h-100' >
        <div class='row align-items-center h-100' >
            <div class='col-md-2' ></div>

            <div class='col-md-8 mx-auto'>
                <div class='errorMenuItemContent' style='align: center'>
                    <form method='POST' action=".$_SERVER["PHP_SELF"].">
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
</div> " ;
                }
            }

            if(isset($_FILES['Profileimage']['name']) && !empty($_FILES['Profileimage']['name'])) {
                $fileName = $_FILES['Profileimage']['name'];
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                $allowTypes = array('jpg','png','jpeg');
                if(in_array($fileType, $allowTypes) && $_FILES['Profileimage']['size'] < 200000){
                    $conn = new mysqli('localhost', 'root', '', 'food4u');
                    $image = $_FILES['Profileimage']['tmp_name'];
                    $imgContent = addslashes(file_get_contents($image));
                    $qrstr = "UPDATE user SET `profileImage`='".$imgContent."' WHERE `Email`='" . $_SESSION['Email'] . "'";
                    $conn->query($qrstr);
                    if ($res->num_rows == 0) {

                        $query = "UPDATE user SET name ='" . $namer . "' ,Email ='" . $emailr ."'WHERE `Email`='" . $_SESSION['Email'] . "'";
                        $query1= "UPDATE restaurant SET Email ='" . $emailr ."',description ='" . $descrr ."',facebooklink ='" . $fbre ."',InstagramLink ='" . $instare ."',siteLink ='" . $siter ."', WHERE `Email`='" . $_SESSION['Email'] . "'";
                        $conn->query($query);
                        $conn->query($query1);
                        $_SESSION['Email']=$emailr;
                        $query3="DELETE FROM `restaurantphone` WHERE Email='". $_SESSION['Email']."'";
                        $conn->query($query3);
                        $pphone=explode(",",$phoner);

                        for($k=0;$k<sizeof($pphone);$k++){
                            if(is_numeric($pphone[$k])&&strlen($pphone[$k])==10){
                                $query2="INSERT INTO `restaurantphone`(`Email`, `phone`) VALUES ('". $_SESSION['Email']."','".$pphone[$k]."')";
                                $conn->query($query2);
                            }

                        }
                        $query3="DELETE FROM `restaurantlocation` WHERE Email='". $_SESSION['Email']."'";
                        $conn->query($query3);
                        if(substr($locationr, -1)!=","){
                            $locationr.="-";
                        }
                        $ll=explode(",",$locationr);

                        for($k=0;$k<sizeof($ll);$k++){
                            if(strpos($ll[$k], '/')){
                                $ca=explode("/",$ll[$k]);
                                if(sizeof($ca)==2){
                                    $query2="INSERT INTO `restaurantlocation`(`Email`, `city`, `address`) VALUES ('". $_SESSION['Email']."','".$ca[0]."','".$ca[1]."')";
                                    $conn->query($query2);
                                }
                            }

                        }



                        header("Refresh:0");

                    }else{
                        $query = "UPDATE user SET name ='" . $namer . "' WHERE `Email`='" . $_SESSION['Email'] . "'";
                        $query1= "UPDATE restaurant SET description ='" . $descrr ."',facebooklink ='" . $fbre ."',InstagramLink ='" . $instare ."',siteLink ='" . $siter ."' WHERE `Email`='" . $_SESSION['Email'] . "'";
                        $pphone="";
                        $conn->query($query);
                        $conn->query($query1);
                        $query3="DELETE FROM `restaurantphone` WHERE Email='". $_SESSION['Email']."'";
                        $conn->query($query3);
                        $pphone=explode(",",$phoner);

                        for($k=0;$k<sizeof($pphone);$k++){
                            if(is_numeric($pphone[$k])&&strlen($pphone[$k])==10){
                                $query2="INSERT INTO `restaurantphone`(`Email`, `phone`) VALUES ('". $_SESSION['Email']."','".$pphone[$k]."')";
                                $conn->query($query2);
                            }

                        }
                        $query3="DELETE FROM `restaurantlocation` WHERE Email='". $_SESSION['Email']."'";
                        $conn->query($query3);
                        if(substr($locationr, -1)!=","){
                            $locationr.="-";
                        }
                        $ll=explode(",",$locationr);

                        for($k=0;$k<sizeof($ll);$k++){
                            if(strpos($ll[$k], '/')){
                                $ca=explode("/",$ll[$k]);
                                if(sizeof($ca)==2){
                                    $query2="INSERT INTO `restaurantlocation`(`Email`, `city`, `address`) VALUES ('". $_SESSION['Email']."','".$ca[0]."','".$ca[1]."')";
                                    $conn->query($query2);
                                }
                            }

                        }

                        header("Refresh:0");
                    }
                }
                else{
                    $errormsg="Please Enater Valid Image (Less Than 200KB)";
                    $disableSmallDiv="<div class='errorMenuItem ' >
    <div class='errorMenuItem2 container h-100' >
        <div class='row align-items-center h-100' >
            <div class='col-md-2' ></div>

            <div class='col-md-8 mx-auto'>
                <div class='errorMenuItemContent' style='align: center'>
                    <form method='POST' action=".$_SERVER["PHP_SELF"].">
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
</div> " ;
                }
            }
            else{
                if ($res->num_rows == 0) {
                    $query = "UPDATE user SET name ='" . $namer . "' ,Email ='" . $emailr ."'WHERE `Email`='" . $_SESSION['Email'] . "'";
                    $query1= "UPDATE restaurant SET Email ='" . $emailr ."',description ='" . $descrr ."',facebooklink ='" . $fbre ."',InstagramLink ='" . $instare ."',siteLink ='" . $siter ."' WHERE `Email`='" . $_SESSION['Email'] . "'";
                    $conn->query($query);
                    $conn->query($query1);
                    $_SESSION['Email']=$emailr;
                    $query3="DELETE FROM `restaurantphone` WHERE Email='". $_SESSION['Email']."'";
                    $conn->query($query3);
                    $pphone=explode(",",$phoner);

                    for($k=0;$k<sizeof($pphone);$k++){
                        if(is_numeric($pphone[$k])&&strlen($pphone[$k])==10){
                            $query2="INSERT INTO `restaurantphone`(`Email`, `phone`) VALUES ('". $_SESSION['Email']."','".$pphone[$k]."')";
                            $conn->query($query2);
                        }

                    }
                    $query3="DELETE FROM `restaurantlocation` WHERE Email='". $_SESSION['Email']."'";
                    $conn->query($query3);
                    if(substr($locationr, -1)!=","){
                        $locationr.=",";
                    }
                    $ll=explode(",",$locationr);

                    for($k=0;$k<sizeof($ll);$k++){
                        if(strpos($ll[$k], '/')){
                            $ca=explode("/",$ll[$k]);
                            if(sizeof($ca)==2){
                                $query2="INSERT INTO `restaurantlocation`(`Email`, `city`, `address`) VALUES ('". $_SESSION['Email']."','".$ca[0]."','".$ca[1]."')";
                                $conn->query($query2);
                            }
                        }

                    }

                    header("Refresh:0");

                }else{
                    $query = "UPDATE user SET name ='" . $namer . "' WHERE `Email`='" . $_SESSION['Email'] . "'";
                    $query1= "UPDATE restaurant SET description ='" . $descrr ."',facebooklink ='" . $fbre ."',InstagramLink ='" . $instare ."',siteLink ='" . $siter ."' WHERE `Email`='" . $_SESSION['Email'] . "'";
                    $conn->query($query);
                    $conn->query($query1);
                    $query3="DELETE FROM `restaurantphone` WHERE Email='". $_SESSION['Email']."'";
                    $conn->query($query3);
                    $pphone=explode(",",$phoner);

                    for($k=0;$k<sizeof($pphone);$k++){
                            if(is_numeric($pphone[$k])&&strlen($pphone[$k])==10){
                                $query2="INSERT INTO `restaurantphone`(`Email`, `phone`) VALUES ('". $_SESSION['Email']."','".$pphone[$k]."')";
                                $conn->query($query2);
                            }

                    }
                    $query3="DELETE FROM `restaurantlocation` WHERE Email='". $_SESSION['Email']."'";
                    $conn->query($query3);
                    if(substr($locationr, -1)!=","){
                        $locationr.=",";
                    }
                    $ll=explode(",",$locationr);

                    for($k=0;$k<sizeof($ll);$k++){
                        if(strpos($ll[$k], '/')){
                            $ca=explode("/",$ll[$k]);
                            if(sizeof($ca)==2){
                                $query2="INSERT INTO `restaurantlocation`(`Email`, `city`, `address`) VALUES ('". $_SESSION['Email']."','".$ca[0]."','".$ca[1]."')";
                                $conn->query($query2);
                            }
                        }

                    }

                    header("Refresh:0");
                }
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

    <title>Food 4U</title>
    <link rel="stylesheet" href="css/Restaurant.css">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link href="node_modules/aos/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
                $('#myTab a[href="' + activeTab + '"]').tab('show');
            }
        });
    </script>
</head>
<body style="overflow: hidden">
<?php echo $disableSmallDiv; ?>
<!-- MENU -->
<section class="nd-flex justify-content-end avbar custom-navbar navbar-fixed-top navbarStyle fixed-top " role="navigation">
    <div  class="navbar navbar-expand-lg main-nav px-0 ">
        <div class="container-fluid">
            <a class="navbar-brand" href="Restaurant.php">
                Food<span style="color: #26e07f;font-size: 30px">4</span>U
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainMenu">
                <ul class="nav navbar-nav navbar-center align-items-center">
                    <li class="nav-item"></li>
                </ul>
                <ul class="nav navbar-nav navbar-right text-uppercase align-items-center">
                    <li class="nav-item"><a href="RMenu.php" class="nav-link ">Menu</a></li>
                    <li class="nav-item"><a href="ROrders.php" class="nav-link ">Orders</a></li>
                    <li class="nav-item"><a href="Rreviews.php" class="nav-link ">Reviews</a></li>
                    <li class="nav-item"><a href="restaurant.php" class="  nav-link "><?php echo '<img class="navImage" src="data:image/jpeg;base64,'.base64_encode($profileImage).'"/>' ?><span id="resName" style="margin-left: 5px; font-size: 12px;font-weight: 600"><?php echo $name?></span></a></li>
                    <li class="nav-item"><a href="logOut.php" class="logoutButton nav-link "></a></li>
                </ul>
            </div>
        </div>

    </div>

</section>
<div class="mainPage">
    <div class="row">
        <div class="col-md-12">
            <?php echo '<img class="coverImage" src="data:image/jpeg;base64,'.base64_encode($coverImage).'"/>' ?>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 p-0 justify-content-center">
            <div class="profileInfoBar">
                <div class=" container nav-item profileItem d-flex flex-row">
                    <?php echo '<img class="profileImage " src="data:image/jpeg;base64,'.base64_encode($profileImage).'"/>' ?>
                    <div class="profileInfo "  >
                        <h2><?php echo $name?></h2>
                        <p><?php echo $_SESSION['Email']?></p>
                    </div>
                    <div class="starsDiv">
                        <img src="icons/star.png" alt="stars:">
                        <p class="CDes" style="max-width:600px;word-break: break-all; white-space: normal;"> <?php echo $stars?></p>
                    </div>
                </div>
            </div>
            <div class="profileTaps">
            <ul class="nav nav-tabs nav-justified flex-row" id="myTab" role="tablist">
                    <li class=" nav-item" ><a class="nav-link active" id="MyProfile-tab"  data-toggle="tab" href="#MyProfileTab" role="tab" aria-controls="MyProfile" aria-selected="true" onclick="window.location=window.location;">My Profile</a></li>
                    <li class=" nav-item" ><a class="nav-link" id="EditMyInformation-tab"   data-toggle="tab" href="#EditMyInformationTab" role="tab" aria-controls="EditMyInformation" aria-selected="false" onclick="window.location=window.location;">Edit My Information</a></li>
                    <li class=" nav-item" ><a class="nav-link" id="ChangePassword-tab"   data-toggle="tab" href="#ChangePasswordTab" role="tab" aria-controls="ChangePassword" aria-selected="false" onclick="window.location=window.location;">Change Password</a></li>
            </ul>
        </div>
    </div>
    <div class="row profileContent">
        <div class="col-md-1 p-0"></div>
        <div class="col-md-10 p-0">
            <div class="tab-content profileContentCol" id="myTabContent">
                <!-- show user info -->
                <div class="tab-pane fade show active" id="MyProfileTab" role="tabpanel" aria-labelledby="MyProfile-tab">
                    <div class="row profile-form">
                        <div class="col-md-12">
                            <div class="row" >
                                <div class="col-md-6  profileContentBlock">
                                    <div>
                                        <h5>Description</h5>
                                        <hr>
                                        <p><?php echo $description?></p>
                                    </div>
                                </div>
                                <div class="col-md-6 profileContentBlock">
                                    <div>
                                        <h5>Contact Us</h5>
                                        <hr>
                                        <table>
                                            <tr>
                                                <td style="width: 15%;"><h6>Phone:</h6></td>
                                                <td>
                                                    <table>
                                                        <?php
                                                        try{
                                                            $conn = new mysqli('localhost','root','','food4u');
                                                            $qrstr="SELECT `phone` FROM `restaurantphone` WHERE `Email`='".$_SESSION['Email']."'";
                                                            $res=$conn->query($qrstr);
                                                            for($i=0;$i<$res->num_rows;$i++) {
                                                                $row = $res->fetch_object();
                                                                $phone = $row->phone;
                                                                echo '<tr><td><h7> '.$phone.'</h7></td></tr>';
                                                            }
                                                            $conn->close();
                                                        }
                                                        catch (Exception $ex){
                                                            echo "<p>".$ex->getTraceAsString()."</p>";
                                                        }
                                                        ?>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 15%;"><h6>Location:</h6></td>
                                                <td>
                                                    <table>
                                                        <?php
                                                        try{
                                                            $conn = new mysqli('localhost','root','','food4u');
                                                            $qrstr="SELECT `city`, `address` FROM `restaurantlocation` WHERE `Email`='".$_SESSION['Email']."'";
                                                            $res=$conn->query($qrstr);
                                                            for($i=0;$i<$res->num_rows;$i++) {
                                                                $row = $res->fetch_object();
                                                                $city = $row->city;
                                                                $address = $row->address;
                                                                echo '<tr>
                                                                        <td style=" white-space: nowrap; width:20%;"><h7> '.$city.',</h7></td>
                                                                        <td style=" white-space: nowrap;"><h7>'.$address.'</h7></td>
                                                                        </tr>';
                                                            }
                                                            $conn->close();
                                                        }
                                                        catch (Exception $ex){
                                                            echo "<p>".$ex->getTraceAsString()."</p>";
                                                        }
                                                        ?>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 profileSocialBlock ">
                                    <div>
                                        <h5>Follow Us</h5>
                                        <hr>
                                        <div class="iconsContainer">
                                            <div>
                                                <a href="<?php echo $facebookLink?>" class="ResIcon"id="facebookIconRes"></a>
                                                <a href="<?php echo $InstagramLink?>" class="ResIcon"id="instagramIconRes"></a>
                                                <a href="<?php echo $siteLink?>" class="ResIcon"id="siteIconRes"></a>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- Edit user info -->
                <div class="tab-pane fade show" id="EditMyInformationTab" role="tabpanel" aria-labelledby="EditMyInformation-tab">
                    <div class="row editProfile-form">
                        <div class="col-md-1"></div>
                        <div class="col-md-10 editProfileContent">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"enctype='multipart/form-data'>
                                <table>
                                    <tr>
                                        <td><label for="Name">Name:</label></td>
                                        <td><input id="Name"name="namer" type="text" placeholder="Name *" value="<?php echo $name?>"/></td>
                                    </tr>
                                    <tr>
                                        <td><label for="Email">Email:</label></td>
                                        <td><input id="Email" name="emailr" type="text" placeholder="Email *" value="<?php echo $_SESSION['Email']?>"/></td>
                                    </tr>
                                    <tr>
                                        <td><label for="Description">Description:</label></td>
                                        <td><textarea type="text" name="descr" id="Description" placeholder="Description *" cols="30" rows="5" ><?php echo $description?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td><label for="FbLink">Facebook Link:</label></td>
                                        <td><input id="FbLink" name="Fbr" type="text" placeholder="Facebook Link *" value="<?php echo $facebookLink?>" /></td>
                                    </tr>
                                    <tr>
                                        <td><label for="InstaLink">Instagram Link:</label></td>
                                        <td><input id="InstaLink"  name="instr" type="text" placeholder="Instagram Link *" value="<?php echo $InstagramLink?>" /></td>
                                    </tr>
                                    <tr>
                                        <td><label for="SiteLink">Site Link:</label></td>
                                        <td><input id="SiteLink" name ="sitr" type="text" placeholder="FbLink Link *" value="<?php echo $siteLink?>" /></td>
                                    </tr>
                                    <tr>
                                        <td><label>Phone:</label></td>
                                        <td>
                                            <?php
                                            try{
                                                $conn = new mysqli('localhost','root','','food4u');
                                                $qrstr="SELECT `phone` FROM `restaurantphone` WHERE `Email`='".$_SESSION['Email']."'";
                                                $res=$conn->query($qrstr);
                                                $phones="";
                                                for($i=0;$i<$res->num_rows;$i++) {
                                                    $row = $res->fetch_object();
                                                    $phone = $row->phone;
                                                    $phones.=$phone.",";
                                                }
                                                echo '<tr><td></td><td><textarea type="text" name ="phoner" id ="phoner" placeholder="Phone *" >'.$phones.'</textarea></td></tr>';
                                                $conn->close();
                                            }
                                            catch (Exception $ex){
                                                echo "<p>".$ex->getTraceAsString()."</p>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Location:</label></td>
                                        <td>
                                            <?php
                                            try{
                                                $conn = new mysqli('localhost','root','','food4u');
                                                $qrstr="SELECT `city`, `address` FROM `restaurantlocation` WHERE `Email`='".$_SESSION['Email']."'";
                                                $res=$conn->query($qrstr);
                                                $citys="";
                                                for($i=0;$i<$res->num_rows;$i++) {
                                                    $row = $res->fetch_object();
                                                    $city = $row->city;
                                                    $address = $row->address;
                                                    $citys.=$city."/".$address.",";

                                                }
                                                echo '<tr><td></td><td><textarea type="text" name ="locr" placeholder="location *" >'.$citys.'</textarea></td></tr>';
                                                $conn->close();
                                            }
                                            catch (Exception $ex){
                                                echo "<p>".$ex->getTraceAsString()."</p>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label >Profile Image:</label></td>
                                        <td><input type="file" id ="Profileimage" name="Profileimage" accept=".jpg,.jpeg,.png"></td>
                                    </tr>
                                    <tr>
                                        <td><label >Cover Image:</label></td>
                                        <td><input  type="file" id ="Coverimage" name="Coverimage" accept=".jpg,.jpeg,.png"></td>
                                    </tr>
                                </table>

                                <input type="submit" id="saver" name="saver" value="Save" class="blackSquaredButtonBorderd" >
                            </form>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <!-- Change user Password -->
                <div class="tab-pane fade show" id="ChangePasswordTab" role="tabpanel" aria-labelledby="ChangePassword-tab">
                    <div class="row editProfile-form">
                        <div class="col-md-1"></div>
                        <div class="col-md-10 editProfileContent">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">

                                <table>
                                    <tr>
                                        <td><label for="OPassword">Old Password: </label></td>
                                        <td><input id="OPassword" name ="OPassword" type="password" placeholder="Old Password *" /></td>
                                    </tr>
                                    <tr>
                                        <td><label for="NPassword">New Password:</label></td>
                                        <td><input id="NPassword" name="NPassword" type="password" placeholder="New Password *" /></td>
                                    </tr>
                                    <tr>
                                        <td><label for="CPassword">Confirm the password:</label></td>
                                        <td><input type="password" name="CPassword"  id="CPassword" placeholder="Confirm the password *" ></td>
                                    </tr>

                                </table>
                                <button  class="blackSquaredButtonBorderd" name="changer">Change</button>
                            </form>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1 p-0"></div>
    </div>
</div>

<script src="node_modules/aos/dist/aos.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script>
    AOS.init();
</script>
</body>
</html>