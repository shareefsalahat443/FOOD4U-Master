<?php
session_start();
if(isset($_SESSION['validmem'])){
    if($_SESSION['validmem']==1&&$_SESSION['level']=='C'){

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
$phone="";
$gender="";
$city="";
$address="";
$disableSmallDiv="";
$errormsg="";
try{
    $conn = new mysqli('localhost','root','','food4u');
    $qrstr="SELECT `name`, `profileImage`, `phone`, `gender`, `city`, `address` FROM `user`,`customer` WHERE  `user`.`Email`=`customer`.`Email` and `user`.`Email`='".$_SESSION['Email']."'";
    $res=$conn->query($qrstr);
    $row=$res->fetch_object();
    $name=$row->name;
    $profileImage=$row->profileImage;
    $phone=$row->phone;
    $gender=$row->gender;
    $city=$row->city;
    $address=$row->address;
    //  $conn->close();
    $MSelect="";
    $FSelect="";
    if($gender == 'M'){$MSelect="selected";$FSelect="";}
    else{$FSelect="selected";$MSelect="";}
    $j="";$N="";$Tu="";$Tul="";$Q="";$S="";$R="";$jeri="";$jeru="";$B="";$H="";
    if($city == "Jenin")$j="selected";
    elseif ($city == "Nablus")$N="selected";
    elseif ($city == "Tubas")$Tu="selected";
    elseif ($city == "Tulkarm")$Tul="selected";
    elseif ($city == "Qalqilya")$Q="selected";
    elseif ($city == "Salfit")$S="selected";
    elseif ($city == "Ramallah")$R="selected";
    elseif ($city == "Jericho")$jeri="selected";
    elseif ($city == "Jerusalem")$jeru="selected";
    elseif ($city == "Bethlehem")$B="selected";
    elseif ($city == "Hebron")$H="selected";
}
catch (Exception $ex){
    echo "<p>".$ex->getTraceAsString()."</p>";
}


if (isset($_POST['errorOkButton'])) {
    $disableSmallDiv="";
    $errormsg="";
}
if(isset($_POST['savec'])) {
    $namec = $_POST['namec'];
    $emailc= $_POST['emailc'];
    $genderc = $_POST['genderc'];
    $phonec = $_POST['phonec'];
    $addressc = $_POST['addressc'];
    //  $profileimage = $_POST['profimage'];
    $cityc = $_POST['cityc'];
    $disableSmallDiv="";
    $errormsg="";
    if (!empty($namec)&&!empty($emailc)&&!empty($genderc)&&!empty($phonec)&&!empty($addressc)&&!empty($cityc)&&strpos($emailc, '@')&&strpos($emailc, '.')&&!strpos($emailc, ' ')) {

        //$conn0 = new mysqli('localhost', 'root', '', 'food4u');

        //   $qrstr0="SELECT `Email` FROM `user`,`customer` WHERE `user`.`Email`=`customer`.`Email` and `user`.`Email`='".$emailc."'";
        $qrstr0="SELECT * FROM `user`,`customer` WHERE  `user`.`Email`=`customer`.`Email` and `user`.`Email`='".$emailc."'";
        $res =  $conn->query($qrstr0);
        $e = true;
        for ($i = 0; $i < $res->num_rows; $i++) {
            $row = $res->fetch_object();

            if ($row->Email == $emailc && $_SESSION['Email'] != $emailc)
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
        if(isset($_FILES['profimgc']['name']) && !empty($_FILES['profimgc']['name'])) {
            $fileName = $_FILES['profimgc']['name'];
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowTypes = array('jpg','png','jpeg');
            if(in_array($fileType, $allowTypes) && $_FILES['profimgc']['size'] < 200000){
                $conn = new mysqli('localhost', 'root', '', 'food4u');
                $image = $_FILES['profimgc']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));
                $qrstr = "UPDATE user SET `profileImage`='".$imgContent."' WHERE `Email`='" . $_SESSION['Email'] . "'";
                $conn->query($qrstr);
                if ($res->num_rows == 0) {

                    $query = "UPDATE user SET name ='" . $namec . "' ,Email ='" . $emailc ."'WHERE `Email`='" . $_SESSION['Email'] . "'";
                    $query1= "UPDATE customer SET Email ='" . $emailc ."',phone ='" . $phonec ."',gender ='" . $genderc ."',Email ='" . $emailc ."',city ='" . $cityc ."',address ='" . $addressc ."' WHERE `Email`='" . $_SESSION['Email'] . "'";
                    $conn->query($query);
                    $conn->query($query1);
                    $_SESSION['Email']=$emailc;
                    header("Refresh:0");

                }else{
                    $query = "UPDATE user SET name ='" . $namec . "' WHERE `Email`='" . $_SESSION['Email'] . "'";
                    $query1= "UPDATE customer SET phone ='" . $phonec ."',gender ='" . $genderc ."',city ='" . $cityc ."',address ='" . $addressc ."' WHERE `Email`='" . $_SESSION['Email'] . "'";
                    $conn->query($query);
                    $conn->query($query1);
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
            $query = "UPDATE user SET name ='" . $namec . "' ,Email ='" . $emailc ."'WHERE `Email`='" . $_SESSION['Email'] . "'";
            $query1= "UPDATE customer SET Email ='" . $emailc ."',phone ='" . $phonec ."',gender ='" . $genderc ."',Email ='" . $emailc ."',city ='" . $cityc ."',address ='" . $addressc ."' WHERE `Email`='" . $_SESSION['Email'] . "'";
            $conn->query($query);
            $conn->query($query1);
            $_SESSION['Email']=$emailc;
            header("Refresh:0");

        }else{
            $query = "UPDATE user SET name ='" . $namec . "' WHERE `Email`='" . $_SESSION['Email'] . "'";
            $query1= "UPDATE customer SET phone ='" . $phonec ."',gender ='" . $genderc ."',city ='" . $cityc ."',address ='" . $addressc ."' WHERE `Email`='" . $_SESSION['Email'] . "'";
            $conn->query($query);
            $conn->query($query1);

            header("Refresh:0");
        }
        }

}

    }
}
$errormsg="";
$disableSmallDiv="";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
if(isset($_POST['change'])) {

    $opass = $_POST['OPassword'];
    $npass = $_POST['NPassword'];
    $cpass = $_POST['CPassword'];
    $errormsg = "";
    $disableSmallDiv = "";

    $qrstr0 = "SELECT * FROM `user` WHERE `password`='" . sha1($opass) . "' and `Email`='" . $_SESSION['Email'] . "'";
    $res = $conn->query($qrstr0);
    $row = $res->fetch_object();
    $dbPass = $row->password;
    if (isset($opass) &&isset($dbPass) && $dbPass == sha1($opass)) {
        if ($npass == $cpass) {
            if(strlen($npass)>=6) {
                $errormsg = "";
                $disableSmallDiv = "";
                $qrstr0 = "UPDATE user SET password ='" . sha1($npass) . "' WHERE `Email`='" . $_SESSION['Email'] . "'";
                $res = $conn->query($qrstr0);
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


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Food 4U</title>
    <link rel="stylesheet" href="css/Customer.css">
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
            <a class="navbar-brand" href="CHome.php">
                Food<span style="color: #26e07f;font-size: 30px">4</span>U
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainMenu">
                <ul class="nav navbar-nav navbar-center align-items-center">
                    <li class="nav-item"><form  method="GET" action="CSearch.php"><input class="SearchTextField" name="searchTextFeild" type="text" placeholder="Search For Restaurants"><input  type="submit" class="SearchButton" value=""></form></li>
                </ul>
                <ul class="nav navbar-nav navbar-right text-uppercase align-items-center">
                    <li class="nav-item"><a href="CHome.php" class="nav-link ">Home</a></li>
                    <li class="nav-item"><a href="CCart.php" class="nav-link ">My cart</a></li>
                    <li class="nav-item"><a href="CProfile.php" class="  nav-link "><?php echo '<img class="navImage" src="data:image/jpeg;base64,'.base64_encode($profileImage).'"/>' ?><span id="resName" style="margin-left: 5px; font-size: 12px;font-weight: 600"><?php echo $name?></span></a></li>
                    <li class="nav-item"><a href="logOut.php" class="logoutButton nav-link "></a></li>
                </ul>
            </div>
        </div>

    </div>

</section>
<div class="mainPage">
    <div class="row">
        <div class="col-lg-3 p-0 justify-content-center" >
            <!-- side profile nav -->
            <div class="profileTaps">
                <ul class="nav nav-tabs nav-justified flex-column" id="myTab" role="tablist">
                    <li class=" nav-item"><?php echo '<img class="profileImage align-self-center" src="data:image/jpeg;base64,'.base64_encode($profileImage).'"/>' ?></li>
                    <li class=" nav-item" style="margin-top: 20px;"><a class="nav-link active" id="MyProfile-tab"  data-toggle="tab" href="#MyProfileTab" role="tab" aria-controls="MyProfile" aria-selected="true" onclick="window.location=window.location;">My Profile</a></li>
                    <li class=" nav-item"                           ><a class="nav-link" id="EditMyInformation-tab"   data-toggle="tab" href="#EditMyInformationTab" role="tab" aria-controls="EditMyInformation" aria-selected="false" onclick="window.location=window.location;">Edit My Information</a></li>
                    <li class=" nav-item"                           ><a class="nav-link" id="ChangePassword-tab"   data-toggle="tab" href="#ChangePasswordTab" role="tab" aria-controls="ChangePassword" aria-selected="false" onclick="window.location=window.location;">Change Password</a></li>
                </ul>

            </div>
        </div>
        <div class="col-lg-9 p-0" style="background-color: #F9F9F9">
            <div class="tab-content profileContentCol" id="myTabContent">
                <!-- show user info pane -->
                <div class="tab-pane fade show active" id="MyProfileTab" role="tabpanel" aria-labelledby="MyProfile-tab">
                    <div class="row profile-form">
                        <div class="col-md-12">
                            <table style="width: 100%; border-collapse: separate; border-spacing: 0 20px;">
                                <tr>
                                    <td><label for="Name">Name:</label></td>
                                    <td><input id="Name" type="text" placeholder="Name *" value="<?php echo $name?>" disabled/></td>
                                    <td><label for="Email">Email:</label></td>
                                    <td><input id="Email" type="text" placeholder="Email *" value="<?php echo $_SESSION['Email']?>" disabled/></td>
                                </tr>
                                <tr>
                                    <td><label for="Gender">Gender:</label></td>
                                    <td><input id="Gender" type="text" placeholder="Gender *" value="<?php echo $gender?>" disabled/></td>
                                    <td><label for="Phone">Phone:</label></td>
                                    <td><input id="Phone" type="text" placeholder="Phone *" value="<?php echo $phone?>" disabled/></td>
                                </tr>
                                <tr>
                                    <td><label for="City">City:</label></td>
                                    <td><input id="City" type="text" placeholder="City *" value="<?php echo $city?>" disabled/></td>
                                    <td><label for="Address">Address:</label></td>
                                    <td><input id="Address" type="text" placeholder="Address *" value="<?php echo $address?>" disabled/></td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="EditMyInformationTab" role="tabpanel" aria-labelledby="EditMyInformation-tab">
                    <div class="row editProfile-form">
                        <div class="col-md-12">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"enctype='multipart/form-data'>
                                <table style="width: 100%; border-collapse: separate; border-spacing: 0 20px;">
                                    <tr>
                                        <td><label for="Name">Name:</label></td>
                                        <td><input id="Name" name="namec" type="text" placeholder="Name *" value="<?php echo $name?>" /></td>
                                    </tr>
                                    <tr>
                                        <td><label for="Email">Email:</label></td>
                                        <td><input id="Email"  name="emailc"  type="text" placeholder="Email *" value="<?php echo $_SESSION['Email']?>" /></td>
                                    </tr>
                                    <tr>
                                        <td><label for="Gender">Gender:</label></td>
                                        <td><select  name="genderc" class="selectInput" >
                                                <option <?php echo $MSelect ?> value ="M">Male</option>
                                                <option <?php echo $FSelect ?> value="F">Female</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td><label for="Phone">Phone:</label></td>
                                        <td><input id="Phone" name="phonec"  type="text" placeholder="Phone *" value="<?php echo $phone?>" /></td>
                                    </tr>
                                    <tr>
                                        <td><label for="City">City:</label></td>
                                        <td>
                                            <select  name="cityc"  class="selectInput" >
                                                <option <?php echo $j ?> value="Jenin">Jenin</option>
                                                <option <?php echo $N ?> value="Nablus">Nablus</option>
                                                <option <?php echo $Tu ?> value="Tubas">Tubas</option>
                                                <option <?php echo $Tul ?> value="Tulkarm">Tulkarm</option>
                                                <option <?php echo $Q?> value="Qalqilya">Qalqilya</option>
                                                <option <?php echo $S?> value="Salfit">Salfit</option>
                                                <option <?php echo $R?> value="Ramallah">Ramallah</option>
                                                <option <?php echo$jeri?> value="Jericho">Jericho</option>
                                                <option <?php echo $jeru?> value="Jerusalem">Jerusalem</option>
                                                <option <?php echo $B?> value="Bethlehem">Bethlehem</option>
                                                <option <?php echo $H?> value="Hebron">Hebron</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="Address">Address:</label></td>
                                        <td><input id="Address" name="addressc" type="text" placeholder="Address *" value="<?php echo $address?>" /></td>
                                    </tr>
                                    <tr>
                                        <td><label >Profile Image:</label></td>
                                        <td><input type="file" name="profimgc" id="profimgc" accept=".jpg,.jpeg,.png"><h6 style='color: gray'>image must be less than 200KB</h6></td>
                                    </tr>

                                </table>

                                <input type="submit" id="savec" name="savec" value="Save" class="blackSquaredButtonBorderd" style="width: 50%;margin-left: auto;margin-right: auto">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="ChangePasswordTab" role="tabpanel" aria-labelledby="ChangePassword-tab">
                    <div class="row editProfile-form">
                        <div class="col-md-12">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"enctype='multipart/form-data'>
                                <table style="width: 100%; border-collapse: separate; border-spacing: 0 20px;">
                                    <tr>
                                        <td><label for="OPassword">Old Password: </label></td>
                                        <td><input id="OPassword" name="OPassword" type="password" placeholder="Old Password *" /></td>
                                    </tr>
                                    <tr>
                                        <td><label for="NPassword">New Password:</label></td>
                                        <td><input id="NPassword" name="NPassword"type="password" placeholder="New Password *" /></td>
                                    </tr>
                                    <tr>
                                        <td><label for="CPassword">Confirm the password:</label></td>
                                        <td><input type="password" id="CPassword"name="CPassword"  placeholder="Confirm the password *" ></td>
                                    </tr>

                                </table>
                                <input type="submit" name="change" id="change" value="Change" class="blackSquaredButtonBorderd" style="width: 50%;margin-left: auto;margin-right: auto">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="node_modules/aos/dist/aos.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script>
    AOS.init();
</script>
</body>
</html>
