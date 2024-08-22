<?php
session_start();
if(isset($_SESSION['validmem'])){
    if($_SESSION['validmem']==1&&$_SESSION['level']=='M'){

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
    $qrstr="SELECT `name`, `profileImage` FROM `user` WHERE  `user`.`Email`='".$_SESSION['Email']."'";
    $res=$conn->query($qrstr);
    $row=$res->fetch_object();
    $name=$row->name;
    $profileImage=$row->profileImage;
    $conn->close();
}
catch (Exception $ex){

}




?>


<?php
$disableEditItemDiv="";
$errormsg="";
$disableSmallDiv="";



if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset($_POST['CEmailD'])) {
        $cEmail=$_POST['cEmail'];
        $conn = new mysqli('localhost', 'root', '', 'food4u');
        $qrstr="DELETE FROM `restaurantwating` WHERE `Email2`='".$cEmail."'";
        $conn->query($qrstr);
        $qrstr2="DELETE FROM `user` WHERE `Email`='".$cEmail."'";
        $conn->query($qrstr2);
    }
    if (isset($_POST['CEmailA'])) {
        $cEmail = $_POST['cEmail'];
        $conn = new mysqli('localhost', 'root', '', 'food4u');
                $qrstr2 = "UPDATE `user` SET `level`='R' WHERE `Email`='" . $cEmail . "'";
                $conn->query($qrstr2);

                #INSERT INTO restaurantphone (Email,phone)SELECT Email2,phone2 FROM restaurantphone
                $qrstr2 = "INSERT INTO restaurant (Email,coverImage,facebookLink )SELECT Email2,coverImage2,facebookLink2 FROM restaurantwating";
                $conn->query($qrstr2);
                $qrstr2 = "INSERT INTO restaurantlocation (Email,city,address )SELECT Email2,city2,address2 FROM restaurantwating";
                $conn->query($qrstr2);
                $qrstr2 = "INSERT INTO restaurantphone (Email,phone)SELECT Email2,phone2 FROM restaurantwating";
                $conn->query($qrstr2);
                $qrstr2 = "DELETE FROM `restaurantwating` WHERE `Email2`='" . $cEmail . "'";
                $conn->query($qrstr2);
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
            <a class="navbar-brand" href="Manager.php">
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
                    <li class="nav-item"><a href="Manager.php" class="  nav-link "><?php echo '<img class="navImage" src="data:image/jpeg;base64,'.base64_encode($profileImage).'"/>' ?><span id="resName" style="margin-left: 5px; font-size: 12px;font-weight: 600"><?php echo $name?></span></a></li>
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
                    <h3>Restaurants Wating your Acception</h3>
                    <div class="row profile-form">
                        <div class="col-md-12" style="border-top: gray solid 2px;border-bottom:gray solid 2px; min-height: 100px;height: fit-content;">

                                <?php //SELECT `CEmail`, `REmail`, `mealid`, `state`,`user`.`name` as `userName`,`profileImage`,`city`,`address`,`phone`,`image`, `meals`.`name` as `mealName` FROM `orders`,`user`,`meals`,`customer` WHERE `CEmail`='Ahmad@gmail.com' and `REmail`='a@gmail.com' and `user`.`Email`=`CEmail` and `mealid`=`meals`.`id` and `user`.`Email`=`customer`.`Email`;
                                try{
                                    $conn = new mysqli('localhost','root','','food4u');
                                    $qrstr="SELECT `user`.`profileImage` as `profileImage2`,`user`.`name` as `name`,  `Email2`, `coverImage2`, `facebookLink2`, `city2`, `address2`, `phone2` FROM `user`,`restaurantwating` WHERE `user`.`Email`=`restaurantwating`.`Email2`";
                                    $res=$conn->query($qrstr);
                                    for($i=0;$i<$res->num_rows;$i++) {
                                        $row = $res->fetch_object();
                                        $CName=$row->name;
                                        $CEmail = $row->Email2;
                                        $CprofileImage2 = $row->profileImage2;
                                        $CcoverImage2 = $row->coverImage2;
                                        $CfacebookLink2 = $row->facebookLink2;
                                        $Ccity2 = $row->city2;
                                        $Caddress2 = $row->address2;
                                        $Cphone2 = $row->phone2;
                                        echo '<table style="width: 100%; border-collapse: separate; border-spacing: 0 5px;">
                                            <tr class="CDiv">
                                            <td style="border-bottom: #26e07f solid 2px">
                                            <div >
                                                <img class="CImage" src="data:image/jpeg;base64,'.base64_encode($CprofileImage2).'"/>
                                                <div class="CInfo">
                                                    <form method="POST" action="' . $_SERVER["PHP_SELF"] .'"><input class="greenUnborderedButton" style="color: black;font-size: 30px;" type="text" id="cEmail"name="cEmail" value="'.$CEmail.'"><p class="CDes" style="max-width:600px;word-break: break-all; white-space: normal;">'.$CName.'</p>
                                                    <input type="submit" id="CEmailA" name="CEmailA" value="✓" class="greenUnborderedButton" ><input type="submit" style="margin-left: 50px" id="CEmailD" name="CEmailD"value="X" class="greenUnborderedButton" ></form>
                                                    ';

                                                echo '</div>
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
