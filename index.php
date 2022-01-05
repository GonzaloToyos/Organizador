<?php

use PhpOffice\PhpSpreadsheet\Calculation\LookupRef\Offset;

include 'db.php'; ?>
<?php include("includes/header.php") ?>

<main>
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-md-3">
                <!--alertas que aparecen al borrar, editar o enviar-->
                <?php if (isset($_SESSION['mensaje'])) : ?>

                    <div class="alert alert-<?= $_SESSION['tipo_de_mensaje']; ?> alert-dismissible fade show" role="alert">
                        <strong><?= $_SESSION['mensaje']; ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <?php $_SESSION['mensaje'] = NULL; ?>
                <?php endif ?>

                <!--form para ingresar la tarea-->
                <div class="card card-body">
                    <form action="guardar_tareas.php" method="POST">
                        <div class="form-group" style="margin-bottom: 25px;">
                            <input type="text" name="title" class="form-control" placeholder="Título" autofocus>
                        </div>
                        <div class="form-group">
                            <textarea name="description" id="" class="form-control" style="margin-bottom: 25px;" rows="2" placeholder="Descripción"></textarea>
                        </div>
                        <div class="form-group" style="margin-bottom: 25px;">
                            <input type="date" name="date" value="<?php if (isset($_SESSION['fecha'])) {
                                                                        echo ($_SESSION['fecha']);
                                                                        $_SESSION['fecha'] = NULL;
                                                                    } ?>" class="form-control">
                        </div>
                        <div class="form-group" style="margin-bottom: 25px;">
                            <input type="number" name="monto" class="form-control" placeholder="$">
                        </div>
                        <input type="submit" class="btn btn-success" style="width: 100%;" name="guardar_tarea" value="Guardar tarea">
                    </form>
                </div>

                <!--form para buscar-->
                <div class="card card-body" style="margin-top: 25px;">
                    <form action="buscar.php" method="POST">
                        <div class="input-group">
                            <input type="text" name="busqueda" class="form-control" placeholder="Búsqueda">
                            <button class="btn btn-outline-secondary" type="submit" name="buscar" id="button-addon2"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>

                <!--form para ordenar/excel-->
                <div class="card card-body mb-3" style="margin-top: 25px;">
                    <form action="ordenar.php" method="POST">
                        <input type="submit" class="btn btn-success" style="width: 100%;" name="orden" value="Ordenar por título">
                    </form><br>
                    <form action="filtrar.php" method="POST">
                        <div class="form-group" style="margin-bottom: 25px;">
                            <div class="d-flex flex-nowrap">
                                <input type="date" name="date_start" class="form-control mb-3" style="width:48%; margin-right: 4%;" >
                                <input type="date" name="date_end" class="form-control mb-3" style="width:48%;">
                            </div>
                            <input type="submit" class="btn btn-success" style="width: 100%;" name="filtro" value="Filtrar por fecha">
                        </div>
                    </form>
                    <form action="index.php" method="POST">
                        <input type="submit" class="btn btn-danger mb-3" style="width: 100%;" name="reiniciar" value="Borrar filtros">
                    </form>
                    <div class="d-flex flex-nowrap">
                        <button id="btnExportar" class="btn btn-success col-md-6" style="width:48%; margin-right: 4%;">
                            <i class="fas fa-file-excel"></i> Tabla
                        </button>
                        <button class="text-center btn btn-success col-md-6" style="width:48%">
                            <a href="excel.php" style="text-decoration: none; color: white;">
                                <i class="fas fa-file-excel"></i> Consulta
                            </a>
                        </button>
                    </div>


                </div>
            </div>

            <!--Acá empieza la tabla-->
            <div class="col-md-9">
                <?php
                if (isset($_POST['reiniciar'])) {
                    $_SESSION['busqueda'] = NULL;
                    $_SESSION['date_start'] = NULL;
                    $_SESSION['date_end'] = NULL;
                    $_SESSION['orden'] = NULL;
                    $_POST['reiniciar'] = NULL;
                }
                if (isset($_POST['buscar_cruz']))
                    $_SESSION['busqueda'] = NULL;
                if (isset($_POST['orden_cruz']))
                    $_SESSION['orden'] = NULL;
                if (isset($_POST['fecha_cruz'])) {
                    $_SESSION['date_start'] = NULL;
                    $_SESSION['date_end'] = NULL;
                }
                ?>
                <!--badges-->
                <div class="contenedor_badges">
                    <?php if (isset($_SESSION['busqueda']) && $_SESSION['busqueda'] != '') : ?>
                        <h5>
                            <div class="input-group mb-3">
                                <span class="badge bg-secondary texto_centrado_badges">
                                    <i class="fas fa-search"></i> <?php echo $_SESSION['busqueda']; ?> </span>
                                <form action="index.php" method="post">
                                    <button class="btn btn-outline-secondary" type="submit" name="buscar_cruz" id="button-addon3">
                                        <i class="fas fa-times"></i></button>
                                </form>
                            </div>
                        </h5>
                    <?php endif ?>
                    <?php if (isset($_SESSION['orden'])) : ?>
                        <h5>
                            <div class="input-group mb-3">
                                <span class="badge bg-secondary texto_centrado_badges">
                                    <i class="fas fa-sort-alpha-down"></i> Orden </span>
                                <form action="index.php" method="post">
                                    <button class="btn btn-outline-secondary" type="submit" name="orden_cruz" id="button-addon3">
                                        <i class="fas fa-times"></i></button>
                                </form>
                            </div>
                        </h5>
                    <?php endif ?>
                    <?php if (isset($_SESSION['date_start']) && isset($_SESSION['date_end'])) : ?>
                        <h5>
                            <div class="input-group mb-3">
                                <span class="badge bg-secondary texto_centrado_badges">
                                    <i class="fas fa-calendar"></i> <?php echo $_SESSION['date_start'] . " / " . $_SESSION['date_end']; ?> </span>
                                <form action="index.php" method="post">
                                    <button class="btn btn-outline-secondary" type="submit" name="fecha_cruz" id="button-addon3">
                                        <i class="fas fa-times"></i></button>
                                </form>
                            </div>
                        </h5>
                    <?php endif ?>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="tabla">
                        <thead class="table-dark">
                            <tr>
                                <th class="col-md-1">Titulo</th>
                                <th class="col-md-4">Descripción</th>
                                <th class="col-md-1">Creada</th>
                                <th class="col-md-1">Monto</th>
                                <th class="col-md-1">Acción</th>
                            </tr>
                        <tbody>
                            <?php
                            $user_name = $_SESSION['usuario'];
                            $pagina = 1;
                            if (isset($_GET["pagina"]))
                                $pagina = $_GET["pagina"];
                            $limit = 10;
                            $offset = ($pagina - 1) * 10;

                            $fin_query = "LIMIT " . $limit . " OFFSET " . "$offset";

                            $inicio_query = "SELECT * FROM `tareas.$user_name` ";

                            $query_completar = $inicio_query;
                            if (isset($_SESSION['busqueda'])) {
                                $busqueda = $_SESSION['busqueda'];
                                $busqueda_query = "WHERE (title LIKE '%$busqueda%') ";
                                $query_completar = $inicio_query . $busqueda_query;
                            } else {
                                $busqueda_query = "WHERE (title LIKE '%%') ";
                            }

                            if (isset($_SESSION['date_start']) && isset($_SESSION['date_end'])) {
                                $date_start = $_SESSION['date_start'];
                                $date_end = $_SESSION['date_end'];
                                $date_query = "AND (reg_date BETWEEN '$date_start' AND '$date_end') ";
                                $query_completar = $inicio_query . $busqueda_query . $date_query;
                            }

                            if (isset($_SESSION['orden'])) {
                                $orden_query = "ORDER BY title ASC ";
                                $query_completar = $query_completar . $orden_query;
                            }
                            $_SESSION['consulta_excel'] = $query_completar;

                            $resultado_tareas = mysqli_query($conn, $query_completar);
                            $elementos = mysqli_num_rows($resultado_tareas); //cuenta todos los elementos*/
                            $num_paginas = ceil($elementos / 10); //los guarda y redondea siempre para arriba

                            $query_completar = $query_completar . $fin_query;

                            $resultado_tareas = mysqli_query($conn, $query_completar);


                            while ($row = mysqli_fetch_array($resultado_tareas)) { ?>
                                <tr>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['description'] ?></td>
                                    <td><?php echo $row['reg_date'] ?></td>
                                    <td><?php echo "$".$row['monto'] ?></td>
                                    <td> <a href="edit.php?id=<?php echo $row['id'] ?>" class="btn btn-secondary">
                                            <i class="fas fa-edit"></i></a>
                                        <a href="delete.php?id=<?php echo $row['id'] ?>" class="btn btn-danger">
                                            <i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        </thead>
                    </table>
                </div>

                <p>Página <?php echo $pagina ?> de <?php echo $num_paginas ?> </p>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php if ($pagina > 1) { ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?pagina=<?php echo $pagina - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php for ($x = 1; $x <= $num_paginas; $x++) { ?>
                            <?php for ($y = 1; $y <= 3; $y++) { ?>
                                <?php if ($x == $pagina - $y) { ?>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?pagina=<?php echo $x ?>">
                                            <?php echo $x ?></a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($x == $pagina) { ?>
                                <li class="page-item active">
                                    <a class="page-link" href="index.php?pagina=<?php echo $x ?>">
                                        <?php echo $x ?></a>
                                </li>
                            <?php } ?>
                            <?php for ($y = 1; $y <= 3; $y++) { ?>
                                <?php if ($x == $pagina + $y) { ?>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?pagina=<?php echo $x ?>">
                                            <?php echo $x ?></a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                        <?php if ($pagina != $num_paginas && $num_paginas > 0) { ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?pagina=<?php echo $pagina + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</main>
<?php include("includes/footer.php") ?>