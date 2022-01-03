<?php
include("db.php");
session_start();

if(isset($_POST['buscar'])){
    $_SESSION['busqueda'] = $_POST['busqueda'];
    $_SESSION['hab'] = 1;

    header("Location: index.php");
}
?>