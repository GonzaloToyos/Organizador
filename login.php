<?php
session_start();
#validar datos
include 'db.php';
if (isset($_POST['submit_login'])) {
    $correo = $_POST['email']; //correo ingresado
    $password = $_POST['pass']; //contraseña ingresada

    $query1 = "SELECT * FROM usuarios WHERE correo='$correo'"; //selecciona los datos del usuario con dicho correo
    $result = mysqli_query($conn, $query1);
    //echo (mysqli_num_rows($result));
    if (mysqli_num_rows($result) == 1) { //si es 1 significa que existe ese unico usuario
        $row = mysqli_fetch_array($result); //guardo los datos
        $contraseña = $row['password']; //guardo la contraseña
        if ($password == $contraseña) { //veo si la contra guardada es igual a la ingresada
            $_SESSION['usuario'] = $row['nombre']; //registro el nombre en una variable de sesión
            header("location:index.php"); //lo mando al index            
        } else {
            echo '<script> alert("Contraseña incorrecta.")</script>';
        }
    } else {
        echo '<script> alert("Correo incorrecto.")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="estilos_login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <form action="login.php" method="post" class="form_login">
        <h1 class="texto_form_login">INGRESAR</h1>
        <input type="email" name="email" class="form_input">
        <label for="" class="form_label">Correo</label>
        <input type="password" name="pass" id="pass" class="form_input">
        <label for="" class="form_label l1">Contraseña</label>
        <input type="checkbox" onclick="mostrar_contraseña()" name="" id="checkbox">
        <label class="checkbox_label" for="checkbox">Mostrar contraseña</label>
        <a href="registro.php" style="float: right;">¿No tienes cuenta?</a>
        <button type="submit" name="submit_login" class="form_submit">Entrar</button>
    </form>
    <script src="script.js"></script>
</body>

</html>