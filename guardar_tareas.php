<?php
include("db.php");
session_start();

if (isset($_POST['guardar_tarea'])) {
    $title = $_POST['title'];//recibe el titulo ingresado por el formulario y enviado por post. el nombre es el del atributo "name"
    $description = $_POST['description'];
    $date = $_POST['date'];
    $monto = $_POST['monto'];
    $nombre = "tareas.".$_SESSION['usuario'];
    
    $query_insert_tarea = "INSERT INTO `$nombre`(title, description, reg_date, monto) VALUES ('$title', '$description', '$date', $monto)"; //inserta la tarea en la tabla de tareas del usuario
    $result = mysqli_query($conn, $query_insert_tarea);
    if (!$result){
        die("Query failed");
    }

    $_SESSION['mensaje'] = 'Tarea guardada correctamente';
    $_SESSION['tipo_de_mensaje'] = 'success';
    $_SESSION['fecha'] = $date;

    header("Location: index.php");
}
