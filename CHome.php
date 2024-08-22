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
    $conn->close();
    $MSelect="";
    $FSelect="";
    if($gender == 'M'){$MSelect="selected";$FSelect="";}
    else{$FSelect="selected";$MSelect="";}
}
catch (Exception $ex){

}




?>


<?php
$disableEditItemDiv="";
$errormsg="";
$disableSmallDiv="";



if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset($_POST['declineOrder'])) {
        $dSecId=$_POST['MOrderId'];
        $conn = new mysqli('localhost', 'root', '', 'food4u');
        $qrstr="DELETE FROM `orders` WHERE `id`='".$dSecId."'";
        $conn->query($qrstr);
        $conn->close();
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
<!-- MENU -->
<body style="overflow: hidden">
<section class="nd-flex justify-content-end custom-navbar navbar-fixed-top navbarStyle fixed-top " role="navigation">
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
                    <li class="nav-item"><form method="GET" action="CSearch.php"><input class="SearchTextField" name="searchTextFeild" type="text" placeholder="Search For Restaurants"><input type="submit" class="SearchButton" value=""></form></li>
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
<div class="mainPage" style="background-color: #F2F2F2">

    <div class="row">

        <div class="col-lg-12 p-0">
            <div class="tab-content profileContentCol" id="myTabContent">
                <div class="tab-pane fade show active" id="MyOrdersTab" role="tabpanel" aria-labelledby="MyOrders-tab">
                    <h3 style="width:100%; text-align:center;">Restaurants from Your area</h3>
                    <div class="row profile-form">
                        <div class="col-md-12" style="border-top: gray solid 2px;border-bottom:gray solid 2px; min-height: 100px;height: fit-content;">

                                <?php //SELECT `CEmail`, `REmail`, `mealid`, `state`,`user`.`name` as `userName`,`profileImage`,`city`,`address`,`phone`,`image`, `meals`.`name` as `mealName` FROM `orders`,`user`,`meals`,`customer` WHERE `CEmail`='Ahmad@gmail.com' and `REmail`='a@gmail.com' and `user`.`Email`=`CEmail` and `mealid`=`meals`.`id` and `user`.`Email`=`customer`.`Email`;
                                try{
                                    $conn = new mysqli('localhost','root','','food4u');
                                    $qrstr="SELECT DISTINCT `user`.`name` as `userName`,`user`.`Email` as `userEmail`, `profileImage`,`coverImage`, `description`,`city` FROM `user`,`restaurant`,`restaurantlocation` WHERE `user`.`Email`=`restaurant`.`Email` and (`city` LIKE '%".$city."%' )LIMIT 0,5;";
                                    $res=$conn->query($qrstr);
                                    for($i=0;$i<$res->num_rows;$i++) {
                                        $row = $res->fetch_object();
                                        $CName = $row->userName;
                                        $CEmail = $row->userEmail;
                                        $RDescription = $row->description;
                                        $CPImage = $row->profileImage;
                                        $CPCImage = $row->coverImage;
                                        echo '<table style="width: 100%; border-collapse: separate; border-spacing: 0 5px;">
                                            <tr class="CDiv">
                                            <td style="border-bottom: #26e07f solid 2px">
                                            <div >
                                                <img class="CCImage" src="data:image/jpeg;base64,'.base64_encode($CPCImage).'"/>
                                                <img class="CImage" src="data:image/jpeg;base64,'.base64_encode($CPImage).'"/>
                                                <div class="CInfo">
                                                    <form method="GET" action="CRPage.php"><input class="greenUnborderedButton" style="color: black;font-size: 30px;" type="submit" value="'.$CName.'"><input name="CREmail" type="text"style="display: none" value="'.$CEmail.'"></form>
                                                    <div class="row">
                                                    <div class="col-md-6 p-1" style="padding:5px;"><div>
                                                    <p class="CDes" style="max-width:600px;word-break: break-all; white-space: normal;">'.$RDescription.'</p></div></div>';
                                                        $conn2 = new mysqli('localhost','root','','food4u');
                                                        $qrstr2="SELECT `city`, `address` FROM `restaurantlocation` WHERE `Email`='".$CEmail."'";
                                                        $res2=$conn2->query($qrstr2);
                                                        echo '<div class="col-md-6 p-1" style="padding:5px;"> <div >';
                                                        for($j=0;$j<$res2->num_rows;$j++) {
                                                            $row2 = $res2->fetch_object();
                                                            $RCity=$row2->city;
                                                            $RAddress=$row2->address;
                                                            echo '<p class="CDes" style="max-width:600px;word-break: break-all; white-space: normal;">'.$RCity.' - '.$RAddress.'</p>';
                                                        }
                                                        $conn2->close();
                                                echo '</div></div>
                                                    </div>
                                                </div>
                                            </div>
                                            </td>
                                            </tr>
                                            
                                            ';
                                        echo '</table></tr>';
                                    }
                                    $conn->close();
                                }
                                catch (Exception $ex){

                                }
                                ?>

                            </table>
                        </div>
                    </div>
                    <h3 style="width:100%; text-align:center;">Top Restaurants</h3>
                    <div class="row profile-form">
                        <div class="col-md-12" style="border-top: gray solid 2px;border-bottom:gray solid 2px;  min-height: 100px;height: fit-content;">

                            <?php //SELECT `CEmail`, `REmail`, `mealid`, `state`,`user`.`name` as `userName`,`profileImage`,`city`,`address`,`phone`,`image`, `meals`.`name` as `mealName` FROM `orders`,`user`,`meals`,`customer` WHERE `CEmail`='Ahmad@gmail.com' and `REmail`='a@gmail.com' and `user`.`Email`=`CEmail` and `mealid`=`meals`.`id` and `user`.`Email`=`customer`.`Email`;
                            try{
                                $conn = new mysqli('localhost','root','','food4u');
                                $qrstr="SELECT DISTINCT `user`.`name` AS `userName`,`coverImage`, `user`.`Email` AS `userEmail`, `description`,`profileImage`, AVG(stars) AS avgStars FROM USER, reviews, restaurant WHERE REmail = `user`.`Email` AND `restaurant`.`Email` = REmail GROUP BY `userName`, `userEmail`, `description`LIMIT 0,5;";
                                $res=$conn->query($qrstr);
                                for($i=0;$i<$res->num_rows;$i++) {
                                    $row = $res->fetch_object();
                                    $CName = $row->userName;
                                    $CEmail = $row->userEmail;
                                    $RDescription = $row->description;
                                    $CPImage = $row->profileImage;
                                    $CPStars= $row->avgStars;
                                    $CPCImage = $row->coverImage;
                                    echo '<table style="width: 100%; border-collapse: separate; border-spacing: 0 5px;">
                                            <tr class="CDiv">
                                            <td style="border-bottom: #26e07f solid 2px">
                                            <div >
                                            <img class="CCImage" src="data:image/jpeg;base64,'.base64_encode($CPCImage).'"/>
                                                <img class="CImage" src="data:image/jpeg;base64,'.base64_encode($CPImage).'"/>
                                                <div class="CInfo">
                                                    <form method="GET" action="CRPage.php"><input class="greenUnborderedButton" style="color: black;font-size: 30px;" type="submit" value="'.$CName.'"><input name="CREmail" type="text"style="display: none" value="'.$CEmail.'"></form>
                                                    <div class="row">
                                                    <div class="col-md-6 p-1" style="padding:5px;"><div>
                                                    <img src="icons/star.png" style="width: 20px;height: 20px;float:left;margin-top: 10px" alt="stars:"><p class="CDes" style="max-width:600px;word-break: break-all; white-space: normal;">'.$CPStars.'</p>
                                                    <p class="CDes" style="max-width:600px;word-break: break-all; white-space: normal;">'.$RDescription.'</p></div></div>';
                                    $conn2 = new mysqli('localhost','root','','food4u');
                                    $qrstr2="SELECT `city`, `address` FROM `restaurantlocation` WHERE `Email`='".$CEmail."'";
                                    $res2=$conn2->query($qrstr2);
                                    echo '<div class="col-md-6 p-1" style="padding:5px;"> <div >';
                                    for($j=0;$j<$res2->num_rows;$j++) {
                                        $row2 = $res2->fetch_object();
                                        $RCity=$row2->city;
                                        $RAddress=$row2->address;
                                        echo '<p class="CDes" style="max-width:600px;word-break: break-all; white-space: normal;">'.$RCity.' - '.$RAddress.'</p>';
                                    }
                                    $conn2->close();
                                    echo '</div></div></div>
                                    </div>
                                            </div>
                                            </td>
                                            </tr>
                                            
                                            ';
                                    echo '</table></tr>';
                                }
                                $conn->close();
                            }
                            catch (Exception $ex){

                            }
                            ?>

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
