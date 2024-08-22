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
    echo "<p>".$ex->getTraceAsString()."</p>";
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
        <div class="col-lg-3 p-0 justify-content-center">

            <div class="profileTaps">
                <ul class="nav nav-tabs nav-justified flex-column" id="myTab" role="tablist">
                    <li class=" nav-item"><?php echo '<img class="profileImage align-self-center" src="data:image/jpeg;base64,'.base64_encode($profileImage).'"/>' ?></li>
                    <li class=" nav-item"><h3><?php echo $name;?></h3></li>
                    <li class=" nav-item" style="margin-top: 20px;"><a class="nav-link active" id="MyOrders-tab"  data-toggle="tab" href="#MyOrdersTab"  role="tab" aria-controls="MyOrders" aria-selected="true" onclick="window.location=window.location;">My Orders</a></li>
                    <li class=" nav-item" ><a class="nav-link" id="MyAOrders-tab"  data-toggle="tab" href="#MyAOrdersTab" role="tab" aria-controls="MyAOrders" aria-selected="false" onclick="window.location=window.location;">Accepted orders</a></li>
                    <li class=" nav-item" ><a class="nav-link" id="MyDOrders-tab"  data-toggle="tab" href="#MyDOrdersTab" role="tab" aria-controls="MyDOrders" aria-selected="false" onclick="window.location=window.location;">Declined Orders</a></li>
                </ul>

            </div>
        </div>
        <div class="col-lg-9 p-0"style="background-color: #F9F9F9">
            <div class="tab-content profileContentCol" id="myTabContent">
                <div class="tab-pane fade show active" id="MyOrdersTab" role="tabpanel" aria-labelledby="MyOrders-tab">
                    <div class="row profile-form">
                        <div class="col-md-12">

                                <?php //SELECT `CEmail`, `REmail`, `mealid`, `state`,`user`.`name` as `userName`,`profileImage`,`city`,`address`,`phone`,`image`, `meals`.`name` as `mealName` FROM `orders`,`user`,`meals`,`customer` WHERE `CEmail`='Ahmad@gmail.com' and `REmail`='a@gmail.com' and `user`.`Email`=`CEmail` and `mealid`=`meals`.`id` and `user`.`Email`=`customer`.`Email`;
                                try{
                                    $conn = new mysqli('localhost','root','','food4u');
                                    $qrstr="SELECT DISTINCT `REmail`,`user`.`name` as `userName`,`profileImage`  FROM `orders`,`user`,`restaurant`WHERE `CEmail`='".$_SESSION['Email']."' and `restaurant`.`Email`=`REmail` and `user`.`Email`=`restaurant`.`Email` and `state`='W'";
                                    $res=$conn->query($qrstr);
                                    for($i=0;$i<$res->num_rows;$i++) {
                                        $row = $res->fetch_object();
                                        $CName = $row->userName;
                                        $REmail = $row->REmail;
                                        $CPImage = $row->profileImage;
                                        echo '<table style="width: 100%; border-collapse: separate; border-spacing: 0 20px;">
                                            <tr class="CDiv">
                                            <td style="border-bottom: #26e07f solid 2px">
                                            <div >
                                                <img class="CImage" src="data:image/jpeg;base64,'.base64_encode($CPImage).'"/>
                                                <div class="CInfo">
                                                    <h3 class="CName">'.$CName.'</h3>
                                                </div>
                                            </div>
                                            </td>
                                            </tr>
                                            <tr><table style="width: 100%;border-collapse: separate; border-spacing: 0 10px;margin-top: -20px">
                                            ';
                                        $qrstr2="SELECT  `orders`.`id` as `orderId`,`mealid`,`image`, `meals`.`name` as `mealName`, `meals`.`price` as `mealPrice`,`orderDate` FROM `orders`,`meals`,`customer` WHERE `CEmail`='".$_SESSION['Email']."' and `REmail`='".$REmail."' and `customer`.`Email`=`CEmail` and `mealid`=`meals`.`id` and `state`='W'  ORDER BY `orderDate` DESC ;";
                                        $res2=$conn->query($qrstr2);
                                        for($j=0;$j<$res2->num_rows;$j++) {
                                            $row2 = $res2->fetch_object();
                                            $MId = $row2->mealid;
                                            $MImage = $row2->image;
                                            $MName = $row2->mealName;
                                            $MOrderDate = $row2->orderDate;
                                            $MOrderId = $row2->orderId;
                                            $MPrice = $row2->mealPrice;
                                            echo '
                                            <tr class="MDiv">
                                            <td style="border-bottom: gray solid 2px; padding-left: 50px;">
                                            <div >
                                                <img class="MImage" src="data:image/jpeg;base64,'.base64_encode($MImage).'"/>
                                                <div class="MInfo">
                                                    <h5 class="MName"><span style="color: gray">#'.$MId.'</span> - '.$MName.'</h5>
                                                    <p class="MDes" style="max-width:600px;word-break: break-all; white-space: normal;">'.$MOrderDate.'</p>
                                                    
                                                </div>
                                            </div>
                                            </td>
                                            <td>
                                                <div class="mealPrice">
                                                    <h1>₪'.$MPrice.'</h1>
                                                </div>
                                                <div>
                                                <form method="POST" action="'.$_SERVER["PHP_SELF"].'">
                                                        <input type="text" name="MOrderId" value="'.$MOrderId.'" style="display: none">
                                                        <input name="declineOrder" class="greenUnborderedButton" type="submit" value="X" >
                                                    </form>
                                                
                                                </div>
                                            </td>
                                            </tr>
                                            ';
                                        }
                                        echo '</table></tr>';
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
                <div class="tab-pane fade show" id="MyAOrdersTab" role="tabpanel" aria-labelledby="MyAOrders-tab">
                    <div class="row editProfile-form">
                        <div class="col-md-12">
                            <?php //SELECT `CEmail`, `REmail`, `mealid`, `state`,`user`.`name` as `userName`,`profileImage`,`city`,`address`,`phone`,`image`, `meals`.`name` as `mealName` FROM `orders`,`user`,`meals`,`customer` WHERE `CEmail`='Ahmad@gmail.com' and `REmail`='a@gmail.com' and `user`.`Email`=`CEmail` and `mealid`=`meals`.`id` and `user`.`Email`=`customer`.`Email`;
                            try{
                                $conn = new mysqli('localhost','root','','food4u');
                                $qrstr="SELECT DISTINCT `REmail`,`user`.`name` as `userName`,`profileImage`  FROM `orders`,`user`,`restaurant`WHERE `CEmail`='".$_SESSION['Email']."' and `restaurant`.`Email`=`REmail` and `user`.`Email`=`restaurant`.`Email` and `state`='A'";
                                $res=$conn->query($qrstr);
                                for($i=0;$i<$res->num_rows;$i++) {
                                    $row = $res->fetch_object();
                                    $CName = $row->userName;
                                    $REmail = $row->REmail;
                                    $CPImage = $row->profileImage;
                                    echo '<table style="width: 100%; border-collapse: separate; border-spacing: 0 20px;">
                                            <tr class="CDiv">
                                            <td style="border-bottom: #26e07f solid 2px">
                                            <div >
                                                <img class="CImage" src="data:image/jpeg;base64,'.base64_encode($CPImage).'"/>
                                                <div class="CInfo">
                                                    <h3 class="CName">'.$CName.'</h3>
                                                </div>
                                            </div>
                                            </td>
                                            </tr>
                                            <tr><table style="width: 100%;border-collapse: separate; border-spacing: 0 10px;margin-top: -20px">
                                            ';
                                    $qrstr2="SELECT  `orders`.`id` as `orderId`,`mealid`,`image`, `meals`.`name` as `mealName`, `meals`.`price` as `mealPrice`,`orderDate` FROM `orders`,`meals`,`customer` WHERE `CEmail`='".$_SESSION['Email']."' and `REmail`='".$REmail."' and `customer`.`Email`=`CEmail` and `mealid`=`meals`.`id` and `state`='A'  ORDER BY `orderDate` DESC ;";
                                    $res2=$conn->query($qrstr2);
                                    for($j=0;$j<$res2->num_rows;$j++) {
                                        $row2 = $res2->fetch_object();
                                        $MId = $row2->mealid;
                                        $MImage = $row2->image;
                                        $MName = $row2->mealName;
                                        $MOrderDate = $row2->orderDate;
                                        $MOrderId = $row2->orderId;
                                        $MPrice = $row2->mealPrice;
                                        echo '
                                            <tr class="MDiv">
                                            <td style="border-bottom: gray solid 2px; padding-left: 50px;">
                                            <div >
                                                <img class="MImage" src="data:image/jpeg;base64,'.base64_encode($MImage).'"/>
                                                <div class="MInfo">
                                                    <h5 class="MName"><span style="color: gray">#'.$MId.'</span> - '.$MName.'</h5>
                                                    <p class="MDes" style="max-width:600px;word-break: break-all; white-space: normal;">'.$MOrderDate.'</p>
                                                    
                                                </div>
                                            </div>
                                            </td>
                                            <td>
                                                <div class="mealPrice">
                                                    <h1>₪'.$MPrice.'</h1>
                                                </div>
                                                <div>
                                                <form method="POST" action="'.$_SERVER["PHP_SELF"].'">
                                                        <input type="text" name="MOrderId" value="'.$MOrderId.'" style="display: none">
                                                    </form>
                                                
                                                </div>
                                            </td>
                                            </tr>
                                            ';
                                    }
                                    echo '</table></tr>';
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
                <div class="tab-pane fade show" id="MyDOrdersTab" role="tabpanel" aria-labelledby="MyDOrders-tab">
                    <div class="row editProfile-form">
                        <div class="col-md-12">
                            <?php //SELECT `CEmail`, `REmail`, `mealid`, `state`,`user`.`name` as `userName`,`profileImage`,`city`,`address`,`phone`,`image`, `meals`.`name` as `mealName` FROM `orders`,`user`,`meals`,`customer` WHERE `CEmail`='Ahmad@gmail.com' and `REmail`='a@gmail.com' and `user`.`Email`=`CEmail` and `mealid`=`meals`.`id` and `user`.`Email`=`customer`.`Email`;
                            try{
                                $conn = new mysqli('localhost','root','','food4u');
                                $qrstr="SELECT DISTINCT `REmail`,`user`.`name` as `userName`,`profileImage`  FROM `orders`,`user`,`restaurant`WHERE `CEmail`='".$_SESSION['Email']."' and `restaurant`.`Email`=`REmail` and `user`.`Email`=`restaurant`.`Email` and `state`='D'";
                                $res=$conn->query($qrstr);
                                for($i=0;$i<$res->num_rows;$i++) {
                                    $row = $res->fetch_object();
                                    $CName = $row->userName;
                                    $REmail = $row->REmail;
                                    $CPImage = $row->profileImage;
                                    echo '<table style="width: 100%; border-collapse: separate; border-spacing: 0 20px;">
                                            <tr class="CDiv">
                                            <td style="border-bottom: #26e07f solid 2px">
                                            <div >
                                                <img class="CImage" src="data:image/jpeg;base64,'.base64_encode($CPImage).'"/>
                                                <div class="CInfo">
                                                    <h3 class="CName">'.$CName.'</h3>
                                                </div>
                                            </div>
                                            </td>
                                            </tr>
                                            <tr><table style="width: 100%;border-collapse: separate; border-spacing: 0 10px;margin-top: -20px">
                                            ';
                                    $qrstr2="SELECT  `orders`.`id` as `orderId`,`mealid`,`image`, `meals`.`name` as `mealName`, `meals`.`price` as `mealPrice`,`orderDate` FROM `orders`,`meals`,`customer` WHERE `CEmail`='".$_SESSION['Email']."' and `REmail`='".$REmail."' and `customer`.`Email`=`CEmail` and `mealid`=`meals`.`id` and `state`='D'  ORDER BY `orderDate` DESC ;";
                                    $res2=$conn->query($qrstr2);
                                    for($j=0;$j<$res2->num_rows;$j++) {
                                        $row2 = $res2->fetch_object();
                                        $MId = $row2->mealid;
                                        $MImage = $row2->image;
                                        $MName = $row2->mealName;
                                        $MOrderDate = $row2->orderDate;
                                        $MOrderId = $row2->orderId;
                                        $MPrice = $row2->mealPrice;
                                        echo '
                                            <tr class="MDiv">
                                            <td style="border-bottom: gray solid 2px; padding-left: 50px;">
                                            <div >
                                                <img class="MImage" src="data:image/jpeg;base64,'.base64_encode($MImage).'"/>
                                                <div class="MInfo">
                                                    <h5 class="MName"><span style="color: gray">#'.$MId.'</span> - '.$MName.'</h5>
                                                    <p class="MDes" style="max-width:600px;word-break: break-all; white-space: normal;">'.$MOrderDate.'</p>
                                                    
                                                </div>
                                            </div>
                                            </td>
                                            <td>
                                                <div class="mealPrice">
                                                    <h1>₪'.$MPrice.'</h1>
                                                </div>
                                                <div>
                                                <form method="POST" action="'.$_SERVER["PHP_SELF"].'">
                                                        <input type="text" name="MOrderId" value="'.$MOrderId.'" style="display: none">
                                                    </form>
                                                
                                                </div>
                                            </td>
                                            </tr>
                                            ';
                                    }
                                    echo '</table></tr>';
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
