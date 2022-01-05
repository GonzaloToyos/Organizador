<?php
include("db.php");
include('includes/header.php');
$title = '';
$description = '';
$monto = '';
$nombre = "tareas.".$_SESSION['usuario'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM `$nombre` WHERE id=$id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $title = $row['title'];
        $description = $row['description'];
        $date = $row['reg_date'];
        $monto = $row['monto'];
    }
}

if (isset($_POST['actualizar'])) {
    $id = $_GET['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $monto = $_POST['monto'];

    $query = "UPDATE `$nombre` set title = '$title', description = '$description', reg_date = '$date', monto = $monto WHERE id=$id";
    mysqli_query($conn, $query);
    $_SESSION['mensaje'] = 'Tarea actualizada';
    $_SESSION['tipo_de_mensaje'] = 'warning';
    header('Location: index.php');
}

?>
<div class="container p-4">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body">
                <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST" class="formulario">
                    <div class="form-group" style="margin-bottom: 25px;">
                        <input name="title" type="text" class="form-control" value="<?php echo $title; ?>" placeholder="Actualizar título">
                    </div>
                    <div class="form-group" style="margin-bottom: 25px;">
                        <textarea name="description" class="form-control" cols="30" rows="10"><?php echo $description; ?></textarea>
                    </div>
                    <input type="date" name="date" value="<?php echo $date?>" class="form-control mb-3">
                    <input type="number" name="monto" class="form-control" value="<?php echo $monto?>" placeholder="$">
                    <button class="btn btn-success boton mt-3" name="actualizar">
                        Actualizar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>