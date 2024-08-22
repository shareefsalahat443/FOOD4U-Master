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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addRev'])) {
        $conn = new mysqli('localhost','root','','food4u');
        $qrstr2="SELECT `id`, `CEmail`, `REmail`, `stars`, `comment` FROM `reviews` WHERE `REmail`='".$_POST['CREmail']."' and `CEmail`='".$_SESSION['Email']."'";
        $res2=$conn->query($qrstr2);
        if(mysqli_num_rows($res2) > 0){
            $rev=$_POST['userRev'];
            if(!empty($rev)) {
                $sql = "UPDATE `reviews` SET `stars`='" . $_POST['starsNum'] . "',`comment`='" . $_POST['userRev'] . "' WHERE `REmail`='" . $_POST['CREmail'] . "' and `CEmail`='" . $_SESSION['Email'] . "'";
                $conn->query($sql);
                $conn->close();
            }
        }
        else{
            $rev=$_POST['userRev'];
            if(!empty($rev)) {
                $sql = "INSERT INTO `reviews`( `CEmail`, `REmail`, `stars`, `comment`) VALUES ('" . $_SESSION['Email'] . "','" . $_POST['CREmail'] . "','" . $_POST['starsNum'] . "','" . $_POST['userRev'] . "')";
                $conn->query($sql);
                $conn->close();
            }
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    else{
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}

?>