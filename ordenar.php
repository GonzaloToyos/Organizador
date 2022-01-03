<?php
include("db.php");
session_start();

if(isset($_POST['orden'])){
    $_SESSION['orden'] = 1;
    $_SESSION['hab'] = 2;

    header("Location: index.php");
}
?>