<?php include("../../controladora/db.php") ?>
<?php $rolsesion = $_SESSION['rolsesion'];
$idsesion = $_SESSION['id'];
$nombresesion = $_SESSION['nombre'];
$apellidosesion = $_SESSION['apellido'];
date_default_timezone_set('America/Montevideo');
if(empty($rolsesion)){
  echo "<script>alert('No hay una sesión iniciada, vuelve a loguearte');window.location='../../Login.php'</script>";
} ?>
<!doctype html>
<html lang="en">

    <head>
        <?php include("../../Modelos/Head.php") ?>
        <title>
            <?php if($_SESSION['idioma'] == "es"){ echo "Auditorías";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Audits";} ?>
        </title>
    </head>
    
    <body>
        <?php
            $errores = "";
            $orden = "";
            $rut = "";
            $total = "";
            $tipo = "";

            if(isset($_POST['buscar'])){
                $orden = $_POST['orden'];
                $rut = $_POST['proveedor'];
                $total = $_POST['total'];
                $tipo = $_POST['tipo'];

                $query = mysqli_query($conn, "SELECT rut_proveedor, id_tipo_equipamiento, SUM(precio) AS total, tipo_compra FROM proveedor_tipo_equipamiento WHERE nro_orden = '$orden'");
                $resultado = mysqli_fetch_array($query);
                $rut = $resultado['rut_proveedor'];
                $total = $resultado['total'];
                $tipo = $resultado['tipo_compra'];

            }
        ?>
        <div class="wrapper">
            <!-- Sidebar  -->
            <?php include("../../Modelos/BarraLateral.php") ?>

            <!-- Page Content  -->
            <div id="content">
                <nav class="navbar navbar-expand-xl navbar-light bg-light">
                    <div class="container-fluid">

                        <button type="button" id="sidebarCollapse" class="btn btn-primary mb-lg-3">
                            <i class="fas fa-align-left"></i>
                            <span>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Ocultar Menú";} ?>
							    <?php if($_SESSION['idioma'] == "en"){ echo "Hide Menu";} ?>
                            </span>
                        </button>
                        <button class="btn btn-secondary d-inline-block d-xl-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-arrow-down"></i>
                        </button>
                        <button class="btn btn-info d-inline-block d-xl-none ml-auto" type="button" data-toggle="collapse" data-target="#navBarUserInfo" aria-controls="navBarUserInfo" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-user"></i>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav navbar-nav ml-auto">
                            <?php if($rolsesion == "Compras" || $rolsesion == "Informática" || $rolsesion == "Administrador"){ ?>
                                <li class="nav-item  mb-3 active">
                                    <a class="btn btn-outline-primary m-1" href="Compras.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Ingreso de Compras";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Purchases Entries";} ?>
                                    </a>
                                </li>
                                <?php } ?>
                                <?php if($rolsesion == "Informática" || $rolsesion == "Administrador"){ ?>
                                <li class="nav-item mb-3">
                                    <a class="btn btn-outline-primary m-1" href="ComprasProveedores.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Ingreso de Proveedores";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Vendors Entries";} ?>
                                    </a>
                                </li>
                                <?php } ?>
                                <?php if($rolsesion == "Compras" || $rolsesion == "Informática" || $rolsesion == "Administrador"){ ?>
                                <li class="nav-item mb-3">
                                    <a class="btn btn-outline-primary m-1" href="ComprasConsultas.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Consultas de Compras";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Purchases Queries";} ?>
                                    </a>
                                </li>
                                <?php } ?>                                                   
                            </ul>
                        </div>
                        <?php include("../../Modelos/UserInfo.php") ?>
                    </div>
                </nav>

                <div class="container">
                    <div class="px-3 py-3 pb-md-4 mx-auto text-center">
                    <h1 class="h1">
                        <?php if($_SESSION['idioma'] == "es"){ echo "Compras Realizadas";} ?>
                        <?php if($_SESSION['idioma'] == "en"){ echo "Purchases Made";} ?>
                    </h1>
                    </div>
                    <form action="" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Nro. orden";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Order number";} ?>
                        </label>
                        <input type="text" name="orden" id="orden" class="form-control" value="<?php echo $orden ?>" >
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Proveedor";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Vendor";} ?>
                        </label>
                        <input type="text" name="proveedor" id="proveedor" class="form-control" value="<?php echo $rut ?>" readonly>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Monto total";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Total amount";} ?></label>
                        <input type="text" name="total" id="total" class="form-control" value="<?php echo $total ?>" readonly>
                        <br>
                        <label for="tipo">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Tipo de adquisición";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Type of acquisition";} ?>
                        </label>
                        <input type="text" name="tipo" id="tipo" class="form-control" value="<?php echo $tipo ?>" readonly>                   
                        <br>
                        <br>
                        <button type="submit" name="buscar" class="btn btn-success">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Buscar";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Search";} ?>
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Cancelar";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Cancel";} ?>
                        </button>
                    </form>               
                </div>
            </div>
        </div>
        <?php include("../../Modelos/Scripts.php") ?>
    </body>
</html>