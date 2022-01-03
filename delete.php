<?php
include("db.php");
session_start();

if(isset($_GET['id'])){
    $nombre = "tareas.".$_SESSION['usuario'];
    $id = $_GET['id'];
    $query = "DELETE FROM `$nombre` WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if(!$result){
        die("Query failed");
    }
    $_SESSION['mensaje'] = 'Tarea borrada correctamente';
    $_SESSION['tipo_de_mensaje'] = 'danger';

    header("Location: index.php");
}
?>