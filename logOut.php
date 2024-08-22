<?php
session_start();
session_unset();
session_destroy();
echo '<script>localStorage.removeItem("activeTab");</script>';
header('location:Index.php');

?>
