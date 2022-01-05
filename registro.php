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

    <!--Estos 4 son para que me actualice css y js-->
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
</head>

<body>
    <form action="registro.php" method="post" class="form_login">
        <h1 class="texto_form_login">REGISTRO</h1>
        <input type="email" name="email" class="form_input" value="  <?php if (isset($correo)) echo $correo ?> ">
        <label for="" class="form_label">Correo</label>
        <input type="text" name="nombre" class="form_input">
        <label for="" class="form_label">Nombre</label>
        <input type="password" name="pass" id="pass" class="form_input">
        <label for="" class="form_label l1">Contraseña</label>
        <input type="checkbox" onclick="mostrar_contraseña()" name="" id="checkbox">
        <label class="checkbox_label" for="checkbox">Mostrar contraseña</label>
        <a href="login.php" style="float: right;">¿Tienes cuenta?</a>
        <button name="submit_registro" type="submit" class="form_submit">Crear cuenta</button>
        <?php
        include 'db.php';
        if (isset($_POST['submit_registro'])) { //si se hizo el envio guardo los datos
            $_POST['submit_registro'] = NULL;
            $correo = $_POST['email'];
            $password = $_POST['pass'];
            $user_name = $_POST['nombre'];
            $validacion = array();

            if ($correo == "")
                array_push($validacion, "Ingresar correo electrónico.");
            if (strlen($password) < 6 && strlen($password) > 0)
                array_push($validacion, "La contraseña debe tener más de 6 caracteres.");
            if ($user_name == "")
                array_push($validacion, "Ingresar nombre.");

            if (count($validacion) == 0) {
                $query1 = "SELECT * FROM usuarios WHERE correo='$correo'"; //reviso si existe el mail en los registros
                $query2 = "SELECT * FROM usuarios WHERE nombre='$user_name'"; //reviso si existe el nombre en los registros
                $result = mysqli_query($conn, $query1);
                $result2 = mysqli_query($conn, $query2);
                if (mysqli_num_rows($result) == 0 && mysqli_num_rows($result2) == 0) { //si no existe añado ese usuario
                    $query = "INSERT INTO usuarios(correo, nombre, password) VALUES ('$correo', '$user_name', '$password')";
                    $resultado = mysqli_query($conn, $query);
                    $query_tabla = "CREATE TABLE `tareas.$user_name` (
                        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        title VARCHAR(100) NOT NULL,
                        description VARCHAR(500) NOT NULL,
                        /*reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP*/
                        reg_date DATE NOT NULL,
                        monto INT(6) UNSIGNED
                        )";
                    $resultado_crear_tabla = mysqli_query($conn, $query_tabla); //crea una tabla por usuario, en la que guarda sus tareas
                    if (!$resultado) {
                        die("Fallo");
                    }
                    header("location:login.php");
                } else {
                    echo "<div class 'error'>";
                    echo "Usuario ya registrado";
                    echo "</div>";
                }
            } else {
                echo "<div class = 'error'>";
                for ($i = 0; $i < count($validacion); $i++)
                    echo $validacion[$i] . "<br>";
                echo "</div>";
                unset($validacion);
            }            
        }
        ?>
    </form>

    <script src="script.js"></script>
</body>

</html>