<?php
#inicializamos variables de sesion 
session_start();
#si esta logueado lo dejo trabajar y sino lo mando al login de nuevo 
if (!isset($_SESSION['usuario'])) {
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Estos 4 son para que me actualice css y js-->
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <title>Organizador</title>

    <link rel="stylesheet" href="estilos1.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--FONT AWESOME-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- links para exportar a excel -->
    <script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
    <script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
</head>

<body>
    <header>
        <!-- Navegador -->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark me-auto">
            <div class="container-fluid">
                <a class="navbar-brand ms-5 size_24" href="#">
                    <img src="imagenes/logo.png" alt="" width="100" height="56" class="d-inline-block align-text-center">
                    Organizador
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link size_18 text-light" href="#"> <i class="fas fa-user"></i> <span id="Nombre_usuario"> <?php echo ($_SESSION['usuario']) ?> </span>  </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link size_18 text-light" href="#">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link size_18 text-light" href="cerrar.php">Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>