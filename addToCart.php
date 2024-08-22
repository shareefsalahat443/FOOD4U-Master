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
    if (isset($_POST['addToOrders'])) {
        date_default_timezone_set('Asia/Hebron');
        $date = date('Y-d-m');
        $conn = new mysqli('localhost', 'root', '', 'food4u');
        $sql="INSERT INTO `orders`( `CEmail`, `REmail`, `mealid`, `state`, `orderDate`) VALUES ('".$_SESSION['Email']."','".$_POST['CREmail']."','" . $_POST['MenuItemId'] . "','W','".$date."')";
        $conn->query($sql);
        $conn->close();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}

?>