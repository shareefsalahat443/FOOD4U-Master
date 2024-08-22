<?php
session_start();
session_unset();
session_destroy();
$disableSmallDiv="";
$errormsg="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['errorOkButton'])) {
        $disableSmallDiv = "";
        $errormsg = "";
    }
    if(isset($_POST['newR'])){
        $level ="R";
        $resName="";
        $fblink="";
        $email = "";
        $password = "";
        $city = "";
        $address = "";
        $phone = "";
        $disableSmallDiv = "";
        $errormsg = "";

        if (isset($_REQUEST['RestaurantName']) &&isset($_REQUEST['RestaurantFacebookLink']) && isset($_REQUEST['RestaurantEmail']) && isset($_REQUEST['RestaurantPassword']) && isset($_REQUEST['RestaurantCity']) && isset($_REQUEST['RestaurantAddress']) && isset($_REQUEST['RestaurantPhone'])) {
            $resName = $_REQUEST['RestaurantName'];
            $fblink = $_REQUEST['RestaurantFacebookLink'];
            $email = $_REQUEST['RestaurantEmail'];
            $password = $_REQUEST['RestaurantPassword'];
            $city = $_REQUEST['RestaurantCity'];
            $address = $_REQUEST['RestaurantAddress'];
            $phone = $_REQUEST['RestaurantPhone'];
            $conn = new mysqli('localhost', 'root', '', 'food4u');

            if (!$conn) {
                die('error connection to DataBase!');
            }

            if (empty($resName)  || empty($fblink) || empty($email) || empty ($password) || empty($city) || empty($address) || empty($phone)|| !strpos($email, '@')|| !strpos($email, '.')|| strpos($email, ' ')||strlen($password)<6 ) {
                $errormsg = "Can not leave any field blank,Please make sure you entered All feilds Correctly";
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
            } else {
                $conn2 = new mysqli('localhost', 'root', '', 'food4u');
                $qrstr2 = "SELECT `Email`FROM `user` WHERE 1";
                $res2 = $conn2->query($qrstr2);
                $e = true;
                for ($i = 0; $i < $res2->num_rows; $i++) {
                    $row = $res2->fetch_object();
                    if ($row->Email == $email) {
                        $errormsg = "Email is already exists, Please Enter New Email";
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
                        $e = false;
                    } else {

                    }
                }
                if ($e){
                    if (isset($_FILES['cimager']['name'])&&isset($_FILES['pimager']['name'])) {
                        $fileName = $_FILES['cimager']['name'];
                        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                        $fileName2 = $_FILES['pimager']['name'];
                        $fileType2 = pathinfo($fileName2, PATHINFO_EXTENSION);
                        $allowTypes = array('jpg', 'png', 'jpeg');
                        if (in_array($fileType, $allowTypes) && $_FILES['cimager']['size'] < 200000 && in_array($fileType2, $allowTypes) && $_FILES['pimager']['size'] < 200000) {
                            $conn = new mysqli('localhost', 'root', '', 'food4u');
                            $image = $_FILES['cimager']['tmp_name'];
                            $imgContent = addslashes(file_get_contents($image));
                            $image2 = $_FILES['pimager']['tmp_name'];
                            $imgContent2 = addslashes(file_get_contents($image2));
                            $qrystr = "INSERT INTO user (name ,Email,password,level,profileimage)" . "VALUES('$resName','$email','".sha1($password)."','W','$imgContent2')";
                            $result = mysqli_query($conn, $qrystr);
                            $qr="INSERT INTO `restaurantwating`( `Email2`,`coverImage2`, `facebookLink2`, `city2`, `address2`, `phone2`) VALUES ('$email','$imgContent','$fblink','$city','$address','$phone')";
                            $result = mysqli_query($conn, $qr);


                            #$qrystr1 = "INSERT INTO restaurant(Email,description,facebookLink,InstagramLink,siteLink,coverImage)" . "VALUES('$email','','$fblink','','','$imgContent')";
                            #$result = mysqli_query($conn, $qrystr1);

                            #$qrystr2 = "INSERT INTO restaurantlocation(Email,city,address)" . "VALUES('$email','$city','$address')";
                            #$result = mysqli_query($conn, $qrystr2);

                            #$qrystr3 = "INSERT INTO restaurantphone(Email,phone)" . "VALUES('$email','$phone')";
                            #$result = mysqli_query($conn, $qrystr3);
                            mysqli_close($conn);
                            header('location:login.php');

                        } else {
                            $errormsg = "Please Upload your profile Image (Less Than 200KB)";
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
            }
            mysqli_commit($conn);
            mysqli_close($conn);

        }
    }
    if (isset($_POST['newC'])) {
        $disableSmallDiv="";
        $errormsg="";
        $level ="C";
        $lastname = "";
        $firstname = "";
        $email = "";
        $password = "";
        $city = "";
        $address = "";
        $phone = "";
        $gender = "";
        if (isset($_REQUEST['firstname']) && isset($_REQUEST['lastname']) && isset($_REQUEST['email']) && isset($_REQUEST['password']) && isset($_REQUEST['city']) && isset($_REQUEST['address']) && isset($_REQUEST['phone']) && isset($_REQUEST['gender'])) {
            $firstname = $_REQUEST['firstname'];
            $lastname = $_REQUEST['lastname'];
            $email = trim($_REQUEST['email']," ");
            $password = $_REQUEST['password'];
            $city = $_REQUEST['city'];
            $address = $_REQUEST['address'];
            $phone = $_REQUEST['phone'];
            $gender =& $_REQUEST['gender'];
            $fullname = $firstname . " " . $lastname;
            $conn = new mysqli('localhost', 'root', '', 'food4u');

            if (!$conn) {
                die('error connection to DataBase!');
            }
            if (empty($firstname) || empty($lastname) || empty($email) || empty ($password) || empty($city) || empty($address) || empty($phone) || empty($gender) || !strpos($email, '@')|| !strpos($email, '.')|| strpos($email, ' ')||strlen($password)<6 ) {
                $errormsg = "Can not leave any field blank,Please make sure you entered All feilds Correctly";
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
            } else {
                $conn2 = new mysqli('localhost', 'root', '', 'food4u');
                $qrstr2 = "SELECT `Email`FROM `user` WHERE 1";
                $res2 = $conn2->query($qrstr2);
                $e = true;
                for ($i = 0; $i < $res2->num_rows; $i++) {
                    $row = $res2->fetch_object();
                    if ($row->Email == $email) {
                        $errormsg = "Email is already exists, Please Enter New Email";
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
                        $e = false;
                    } else {

                    }
                }
                if ($e){
                    if (isset($_FILES['image']['name'])) {
                        $fileName = $_FILES['image']['name'];
                        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                        $allowTypes = array('jpg', 'png', 'jpeg');
                        if (in_array($fileType, $allowTypes) && $_FILES['image']['size'] < 200000) {
                            $conn = new mysqli('localhost', 'root', '', 'food4u');
                            $image = $_FILES['image']['tmp_name'];
                            $imgContent = addslashes(file_get_contents($image));
                            $qrystr = "INSERT INTO user (name ,email,password,level,profileimage)" . "VALUES('$fullname','$email','".sha1($password)."','$level','$imgContent')";
                            $qrystr1 = "INSERT INTO customer(email,phone,gender,city,address)" . "VALUES('$email','$phone','$gender','$city','$address')";

                            $result = mysqli_query($conn, $qrystr);
                            $result = mysqli_query($conn, $qrystr1);
                            mysqli_close($conn);
                            header('location:login.php');

                        } else {
                            $errormsg = "Please Upload your profile Image (Less Than 200KB)";
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
            }

        }

    }
}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Food 4U - SignUp</title>
    <link rel="stylesheet" href="css/Signup.css">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link href="node_modules/aos/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>


<body style="height: 100%;min-height: 100vh">
<?php echo $disableSmallDiv; ?>
<div class="register " >
    <div class="row register-left h-100 d-inline-block" >
        <div class="col-md-12 ">
            <div class="top_link"><a href="Index.php"><img src="icons/left.svg" alt=""></a></div>
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-tab" data-toggle="tab" href="#user" role="tab" aria-controls="home" aria-selected="true">User</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-tab" data-toggle="tab" href="#Resteurent" role="tab" aria-controls="profile" aria-selected="false">Restaurant</a></li>
            </ul>
            <div class="tab-content" id="myTabContent">




                <div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="home-tab">
                    <form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>"enctype='multipart/form-data'>

                        <h3 class="register-heading">User SignUp</h3>
                        <div class="row register-form">
                            <div class="col-md-6">

                                <div class="form-group"style="margin: 0;">
                                    <input type="text" name="firstname" placeholder="First Name *" value="" />
                                    <div class="line"></div>
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <input type="text" name="email" placeholder="Email *" value="" />
                                    <div class="line"></div>
                                </div>
                                <div class="form-group"style="margin: 0; height: 60px;">
                                    <select name="city" class="selectInput" >
                                        <option selected value="Jenin">Jenin</option>
                                        <option value="Nablus">Nablus</option>
                                        <option value="Tubas">Tubas</option>
                                        <option value="Tulkarm">Tulkarm</option>
                                        <option value="Qalqilya">Qalqilya</option>
                                        <option value="Salfit">Salfit</option>
                                        <option value="Ramallah">Ramallah</option>
                                        <option value="Jericho">Jericho</option>
                                        <option value="Jerusalem">Jerusalem</option>
                                        <option value="Bethlehem">Bethlehem</option>
                                        <option value="Hebron">Hebron</option>
                                    </select>
                                </div>
                                <div class="form-group"style="margin: 0;">
                                    <input type="text"   minlength="10" maxlength="10" name="phone" placeholder="phone *" value="" />
                                    <div class="line"></div>
                                </div>
                                <div class="form-group"style="margin: 0;">
                                    <table >
                                        <tr>
                                            <td><label>Gender:</label></td>
                                            <td><input type="radio" name="gender" id="male" value="male" checked> <label for="male"> Male </label></td>
                                            <td><input type="radio" name="gender" id="female" value="female"><label for="female">Female </label></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>



                            <div class="col-md-6">
                                <div class="form-group"style="margin: 0;">
                                    <input type="text" name="lastname" placeholder="Last Name *" value="" />
                                    <div class="line"></div>
                                </div>
                                <div class="form-group"style="margin: 0;">
                                    <input type="password"   name="password" placeholder="Password(6 digits AT LEAST) *" value="" />
                                    <div class="line"></div>
                                </div>
                                <div class="form-group"style="margin: 0;">
                                    <input type="text"        name="address"     placeholder="Address *" value="" />
                                    <div class="line"></div>
                                </div>

                                <div class="form-group"style="margin: 0;">
                                    <input type="file" name="image" id="image"  accept='.jpg,.jpeg,.png'><h6 style='color: gray'>image must be less than 200KB</h6>

                                    <div class="line"></div>
                                </div>

                                <div class="form-group"style="margin: 0;">
                                    <!--                                <input type="text" placeholder="Enter Your Answer *" value="" />-->
                                    <!--                                <div class="line"></div>-->
                                </div>
                            </div>
                            <input type="submit" id="newC" name="newC" value="Register" class="buttonBorderd" style="width: 50%;margin-left: auto;margin-right: auto">

                        </div>
                    </form>
                </div>














                <div class="tab-pane fade show" id="Resteurent" role="tabpanel" aria-labelledby="profile-tab">
                    <form lang="en" method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>" enctype='multipart/form-data'>

                        <h3 class="register-heading">Restaurant SignUp</h3>
                        <div class="row register-form">
                            <div class="col-md-6">
                                <div class="form-group"style="margin: 0;">
                                    <input type="text" name="RestaurantName" placeholder="Name *" value="" />
                                    <div class="line"></div>
                                </div>
                                <div class="form-group"style="margin: 0;">
                                    <input type="text"  name="RestaurantEmail" placeholder="Email *" value="" />
                                    <div class="line"></div>
                                </div>
                                <div class="form-group"style="margin: 0; height: 60px;">
                                    <select name="RestaurantCity" class="selectInput" >
                                        <option selected value="Jenin">Jenin</option>
                                        <option value="Nablus">Nablus</option>
                                        <option value="Tubas">Tubas</option>
                                        <option value="Tulkarm">Tulkarm</option>
                                        <option value="Qalqilya">Qalqilya</option>
                                        <option value="Salfit">Salfit</option>
                                        <option value="Ramallah">Ramallah</option>
                                        <option value="Jericho">Jericho</option>
                                        <option value="Jerusalem">Jerusalem</option>
                                        <option value="Bethlehem">Bethlehem</option>
                                        <option value="Hebron">Hebron</option>
                                    </select>
                                </div>
                                <div class="form-group"style="margin: 0;">
                                    <input type="text" maxlength="10" minlength="10" name="RestaurantPhone" placeholder="Phone *" value="" />
                                    <div class="line"></div>
                                </div>
                            </div>




                            <div class="col-md-6">
                                <div class="form-group"style="margin: 0;">
                                    <input type="text" name="RestaurantFacebookLink" placeholder="Facebook Link *" value="" />
                                    <div class="line"></div>
                                </div>
                                <div class="form-group"style="margin: 0;">
                                    <input type="password"  name="RestaurantPassword" placeholder="Password *" value="" />
                                    <div class="line"></div>
                                </div>
                                <div class="form-group"style="margin: 0;">
                                    <input type="text" name="RestaurantAddress" placeholder="Address *" value="" />
                                    <div class="line"></div>
                                </div>
                                <div class="form-group"style="margin: 0;">
                                    <label for="">Profile Image:</label>
                                    <input type="file" name="pimager" id="pimager"  accept='.jpg,.jpeg,.png'><h6 style='color: gray'>image must be less than 200KB</h6>
                                    <div class="line"></div>
                                </div>
                                <div class="form-group"style="margin: 0;">
                                    <label for="">Cover Image:</label>
                                    <input type="file" name="cimager" id="cimager"   accept='.jpg,.jpeg,.png'><h6 style='color: gray'>image must be less than 200KB</h6>

                                    <div class="line"></div>
                                </div>
                                <div class="form-group"style="margin: 0;">
                                    <!--                                <input type="text"  placeholder="`Answer *" value="" />-->
                                    <!--                                <div class="line"></div>-->
                                </div>

                            </div>
                            <input type="submit" id="newR" name="newR" value="Register" class="buttonBorderd" style="width: 50%;margin-left: auto;margin-right: auto">
                            <h6 style="max-width:800px;height:50px;word-break: break-all; white-space: normal;color: gray">you have to wait for manager aprovement to log in using your resturant Email</h6>


                        </div>
                    </form>


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
