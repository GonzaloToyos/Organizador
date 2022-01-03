<?php
include("db.php");
session_start();

if (isset($_POST['filtro'])) {
    $date_start = $_POST['date_start'];
    $_SESSION['date_start'] = $date_start;
    $date_end = $_POST['date_end'];
    $_SESSION['date_end'] = $date_end;
    echo $date_start;
    echo $date_end;
    if ($date_end > $date_start)
        echo "Bien hecho";
    else
        echo "Mal hecho";

    $user_name = "tareas." . $_SESSION['usuario'];
    //$query_completar = "SELECT * FROM `$user_name` WHERE (reg_date BETWEEN '$date_start' and '$date_end') and title LIKE '%a%' ";
    
    //$_SESSION['filtro_fechas'] = "WHERE (reg_date BETWEEN '$date_start' and '$date_end') and title LIKE '%a%'";
    $_SESSION['filtro_fechas'] = "WHERE (reg_date BETWEEN '$date_start' and '$date_end')";
    $query_completar = "SELECT * FROM `$user_name`".$_SESSION['filtro_fechas'];
    echo $query_completar;

    /*$resultado_tareas = mysqli_query($conn, $query_completar);
    if (!$resultado_tareas){
        die("Query failed");
    }
    while ($row = mysqli_fetch_array($resultado_tareas)) {
        echo $row['title'];
        echo "       ";
        echo $row['description'];
        echo "       ";
        echo $row['reg_date'];
        echo "<br>";
    }*/


    //$_SESSION['busqueda'] = $_POST['busqueda'];
    //$_SESSION['hab'] = 1;

    header("Location: index.php");
}
