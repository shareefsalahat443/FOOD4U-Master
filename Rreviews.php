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


$mName = "";
$mimage ="";
$mdescription = "";
$mprice = "";
$mid = "";
try{
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
    $conn->close();
}
catch (Exception $ex){
    echo "<p>".$ex->getTraceAsString()."</p>";
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
<!-- MENU -->
<body style="overflow: hidden">
<section class="nd-flex justify-content-end custom-navbar navbar-fixed-top navbarStyle fixed-top " role="navigation">
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
        <div class="col-md-12 p-0 justify-content-center">
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
                <ul class="nav nav-tabs nav-justified flex-column" id="myTab" role="tablist">
                    <li class=" nav-item" ><a class="nav-link active" id="MyReviews-tab"  data-toggle="tab" href="#MyReviewsTab" role="tab" aria-controls="MyMenu" aria-selected="true" onclick="window.location=window.location;">My Reviews</a></li>
                    
                </ul>

            </div>
        </div>
        <div class="col-lg-12 p-0"style="background-color: #F9F9F9">
            <div class="tab-content profileContentCol" id="myTabContent">
                <div class="tab-pane fade show active" id="MyReviewsTab" role="tabpanel" aria-labelledby="MyReviews-tab">
                    <div class="row profile-form">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <table>
                                <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
                                    <?php
                                    try{
                                        $conn = new mysqli('localhost','root','','food4u');
                                        $qrstr2="SELECT  `name`,`profileImage`, `stars`, `comment` FROM `reviews`,`user` WHERE `REmail`='".$_SESSION['Email']."' and user.Email=reviews.CEmail order by `id` desc";
                                        $res2=$conn->query($qrstr2);
                                            for($j=0;$j<$res2->num_rows;$j++) {
                                                $row2 = $res2->fetch_object();
                                                $CName = $row2->name;
                                                $CStars = $row2->stars;
                                                $CComment = $row2->comment;
                                                $CImage = $row2->profileImage;
                                                echo '
                                            <tr class="reviewDiv">
                                            <td style="border-bottom: 1pt solid gray; width:95%;">
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
                        <div class="col-md-1"></div>
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
