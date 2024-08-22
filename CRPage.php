
<?php
session_start();
if(isset($_SESSION['validmem'])){
    if($_SESSION['validmem']==1&&$_SESSION['level']=='C'){

    }
    else{
        header('location:Index.php');
    }
    $ss=$_GET['CREmail'];
    if(!empty($ss)){

    }
    else{
        header('Location: ' . $_SERVER['HTTP_REFERER']);
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
try{
    $conn = new mysqli('localhost','root','','food4u');
    $qrstr="SELECT `name`, `profileImage`, `phone`, `gender`, `city`, `address` FROM `user`,`customer` WHERE  `user`.`Email`=`customer`.`Email` and `user`.`Email`='".$_SESSION['Email']."'";
    $res=$conn->query($qrstr);
    $row=$res->fetch_object();
    $Cname=$row->name;
    $CprofileImage=$row->profileImage;
    $Cphone=$row->phone;
    $Cgender=$row->gender;
    $Ccity=$row->city;
    $Caddress=$row->address;
    $conn->close();
    $MSelect="";
    $FSelect="";
    if($gender == 'M'){$MSelect="selected";$FSelect="";}
    else{$FSelect="selected";$MSelect="";}
}
catch (Exception $ex){
    echo "<p>".$ex->getTraceAsString()."</p>";
}
$conn = new mysqli('localhost','root','','food4u');
$qrstr="SELECT `name`,  `profileImage`,`description`, `coverImage`, `facebookLink`, `InstagramLink`, `siteLink` FROM user ,restaurant WHERE user.Email=restaurant.Email and user.Email='".$_GET['CREmail']."'";
$res=$conn->query($qrstr);
$row=$res->fetch_object();
if(mysqli_num_rows($res) > 0){

}
else{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
$name=$row->name;
$profileImage=$row->profileImage;
$description=$row->description;
$coverImage=$row->coverImage;
$facebookLink=$row->facebookLink;
$InstagramLink=$row->InstagramLink;
$siteLink=$row->siteLink;
$qrstr="SELECT `Email`, `REmail`, AVG (stars) as stars FROM `reviews`,`restaurant` WHERE reviews.REmail=restaurant.Email  and restaurant.Email='".$_GET['CREmail']."' GROUP BY REmail";
$res=$conn->query($qrstr);
$row=$res->fetch_object();
$stars=$row->stars;
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
<body>
<!-- MENU -->
<body style="overflow:hidden;">
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
                    <li class="nav-item"><a href="CProfile.php" class="  nav-link "><?php echo '<img class="navImage" src="data:image/jpeg;base64,'.base64_encode($CprofileImage).'"/>' ?><span id="resName" style="margin-left: 5px; font-size: 12px;font-weight: 600"><?php echo $Cname?></span></a></li>
                    <li class="nav-item"><a href="logOut.php" class="logoutButton nav-link "></a></li>
                </ul>
            </div>
        </div>

    </div>

</section>
<div class="mainPage">
    <div class="row" >
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
                        <p><?php echo $_GET['CREmail']?></p>
                    </div>
                    <div class="starsDiv">
                        <img src="icons/star.png" alt="stars:">
                        <p class="CDes" style="max-width:600px;word-break: break-all; white-space: normal;"> <?php echo $stars?></p>
                    </div>
                </div>
            </div>
            <div class="profileTaps">
            <ul class="nav nav-tabs nav-justified flex-row" id="myTab" role="tablist">
                    <li class=" nav-item" ><a class="nav-link active" id="MyProfile-tab"  data-toggle="tab" href="#MyProfileTab" role="tab" aria-controls="MyProfile" aria-selected="true" onclick="window.location=window.location;">Restaurant Profile</a></li>
                    <li class=" nav-item" ><a class="nav-link" id="EditMyInformation-tab"   data-toggle="tab" href="#EditMyInformationTab" role="tab" aria-controls="EditMyInformation" aria-selected="false" onclick="window.location=window.location;">Menu</a></li>
                    <li class=" nav-item" ><a class="nav-link" id="ChangePassword-tab"   data-toggle="tab" href="#ChangePasswordTab" role="tab" aria-controls="ChangePassword" aria-selected="false" onclick="window.location=window.location;">Reviews</a></li>
            </ul>
        </div>
    </div>
    <div class="row profileContent">
        <div class="col-md-1 p-0"></div>
        <div class="col-md-10 p-0">
            <div class="tab-content profileContentCol" id="myTabContent">
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
                                                            $qrstr="SELECT `phone` FROM `restaurantphone` WHERE `Email`='".$_GET['CREmail']."'";
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
                                                            $qrstr="SELECT `city`, `address` FROM `restaurantlocation` WHERE `Email`='".$_GET['CREmail']."'";
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
                <div class="tab-pane fade show" id="EditMyInformationTab" role="tabpanel" aria-labelledby="EditMyInformation-tab">
                    <div class="menuBg"></div>
                    <div class="menuDiv"></div>    
                    <div class="row editProfile-form">
                        <div class="col-md-12">
                            <table style="width: 100%; border-collapse: separate; border-spacing: 0 20px;">
                                <?php
                                try{
                                    $conn = new mysqli('localhost','root','','food4u');
                                    $qrstr="SELECT `sName` FROM `sections` WHERE `Email`='".$_GET['CREmail']."'";
                                    $res=$conn->query($qrstr);
                                    for($i=0;$i<$res->num_rows;$i++) {
                                        $row = $res->fetch_object();
                                        $sName = $row->sName;
                                        echo '<tr><td><h1 class="sectionName" style="text-align: center">'.$sName.'</h1>
                                        <form >
                                            <input type="text" name="secId" value="'.$sName.'" style="display: none;">
                                        </form>
                                        </td>
                                        ';
                                        $qrstr2="SELECT `id`, `name`, `description`, `price`, `section`, `image` FROM `meals` WHERE `Email`='".$_GET['CREmail']."' and `section`='".$sName."'";
                                        $res2=$conn->query($qrstr2);
                                        for($j=0;$j<$res2->num_rows;$j++) {
                                            $row2 = $res2->fetch_object();
                                            $mName = $row2->name;
                                            $mimage = $row2->image;
                                            $mdescription = $row2->description;
                                            $mprice = $row2->price;
                                            $mid = $row2->id;
                                            echo '
                                            <tr class="mealDiv">
                                            <td>
                                            <div >
                                                <img class="mealImage" src="data:image/jpeg;base64,'.base64_encode($mimage).'"/>
                                                <div class="mealInfo">
                                                    <h3 class="mealName">'.$mName.'</h3>
                                                    <p class="mealDes" style="max-width:600px;word-break: break-all; white-space: normal;">'.$mdescription.'</p>
                                                    <form method="post" action="addToCart.php">
                                                        <input type="text" name="MenuItemId" value="'.$mid.'" style="display: none">
                                                        <input type="text" name="CREmail" value="'.$_GET['CREmail'].'" style="display: none">
                                                        <input name="addToOrders" id="addToOrders" class="greenUnborderedButton" type="submit" value="Add To My Cart" >
                                                    </form>
                                                </div>
                                            </div>
                                            </td>
                                            <td>
                                                <div class="imagePrice">
                                                    <h1>₪'.$mprice.'</h1>
                                                </div>
                                                <div>
                                                
                                                
                                                </div>
                                            </td>
                                            </tr>
                                            ';
                                        }
                                    }
                                    $conn->close();
                                }
                                catch (Exception $ex){
                                    echo "<p>".$ex->getTraceAsString()."</p>";
                                }
                                ?>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="ChangePasswordTab" role="tabpanel" aria-labelledby="ChangePassword-tab">
                    <div class="row editProfile-form">
                        <div class="col-md-12" >

                            <table>
                                <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
                                    <tr>
                                        <td style="width: 110px;"><?php echo '<img class="navImage" style="width: 100px;height: 100px" src="data:image/jpeg;base64,'.base64_encode($CprofileImage).'"/>' ?></td>
                                        <td>
                                            <form method="post" action="addNewReview.php">
                                                <table style="width: 100%; border-collapse: separate; border-spacing: 0 30px;">
                                                    <tr>
                                                        <td>
                                                            <input type="text" style="display: none;" name="CREmail" value="<?php echo $_GET['CREmail'];?>">
                                                            <textarea placeholder="Add Review" style="border-top: gray solid 1px;border-left: gray solid 1px; border-right:gray solid 1px;float: left " name="userRev" id="userRev"  cols="5" rows="3"></textarea>
                                                        </td>
                                                        <td style="width: 10px"><select name="starsNum" id="starsNum">
                                                                <option selected value="5">5</option>
                                                                <option selected value="4">4</option>
                                                                <option selected value="3">3</option>
                                                                <option selected value="2">2</option>
                                                                <option selected value="1">1</option>
                                                            </select></td>
                                                        <td style="width: 50px">
                                                            <input type="submit" class="revButton" id="addRev" value="" name="addRev">
                                                        </td>
                                                    </tr>
                                                </table>

                                            </form>
                                        </td></tr>
                                    <?php
                                    try{
                                        $conn = new mysqli('localhost','root','','food4u');
                                        $qrstr2="SELECT  `name`,`profileImage`, `stars`, `comment` FROM `reviews`,`user` WHERE `REmail`='".$_GET['CREmail']."' and user.Email=reviews.CEmail Order by`reviews`.`id` DESC";
                                        $res2=$conn->query($qrstr2);
                                        for($j=0;$j<$res2->num_rows;$j++) {
                                            $row2 = $res2->fetch_object();
                                            $CName = $row2->name;
                                            $CStars = $row2->stars;
                                            $CComment = $row2->comment;
                                            $CImage = $row2->profileImage;
                                            echo '
                                            <tr class="reviewDiv" style="background-color: #F2F2F2;">
                                            <td></td>
                                            <td style="border-bottom: 1pt solid gray;">
                                            <div >
                                                <img class="reviewImage" src="data:image/jpeg;base64,'.base64_encode($CImage).'"/>
                                                <div class="reviewInfo">
                                                    <h3 class="mealName">'.$CName.'</h3>
                                                    <p class="mealDes" style="max-width:600px;word-break: break-all; white-space: normal;">'.$CComment.'</p>
                                                </div>
                                            </div>
                                            </td>
                                            <td>
                                                <div class="revStars">
                                                    <h1 style="color: gold">'.$CStars.'<img src="icons/star.png" alt="Star" style="width: 30px;height: 30px;"></h1>
                                                </div>
                                                <div>
                                                
                                                
                                                </div>
                                            </td>
                                            </tr>
                                            ';
                                        }

                                        $conn->close();
                                    }
                                    catch (Exception $ex){

                                    }
                                    ?>

                                </table>
                            </table>
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
