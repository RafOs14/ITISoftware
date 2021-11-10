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
            <?php if($_SESSION['idioma'] == "es"){ echo "Auditorías | Consultas";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Audits | Query";} ?>
        </title>
    </head>

    <body>
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
                                <li class="nav-item  mb-3 active">                      
                                    <a class="btn btn-outline-primary m-1" href="Auditoria.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Compras Realizadas";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Purchases Made";} ?>
                                    </a>                                
                                </li>
                                <li class="nav-item mb-3"> 
                                    <a class="btn btn-outline-primary m-1" href="AuditoriaConsulta.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Detalles del Equipamiento";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Equipment Details";} ?>
                                    </a>
                                </li>
                                <li class="nav-item mb-3"> 
                                    <a class="btn btn-outline-primary m-1" href="ConsultasStock.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Consultas de Productos";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Products Requests";} ?>
                                    </a>
                                </li>                                                     
                            </ul>
                        </div>
                        <?php include("../../Modelos/UserInfo.php") ?>
                    </div>
                </nav>

                <div class="container">
                    <div class="px-3 py-3 pb-md-4 mx-auto text-center">
                        <h1 class="h1">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Estado del insumo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Consumable status";} ?>
                        </h1>
                        </div>
                    <form action="" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Nro. orden";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Order number";} ?>
                        </label>
                        <input type="text" name="orden" id="orden" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Proveedor";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Vendor";} ?>
                        </label>
                        <input type="text" name="proveedor" id="proveedr" class="form-control" readonly>
                        <br>
                        <label for="nombre">Total</label>
                        <input type="text" name="segundonombre" id="segundonombre-modificar" class="form-control" readonly>
                        <br>
                        <label for="tipo">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Tipo de adquisición";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Type of acquisition";} ?>
                        </label>
                        <input type="text" name="tipo" id="tipo" class="form-control" readonly>                   
                        <br>
                        <br>
                        <button type="submit" class="btn btn-primary">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Confirmar";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Confirm";} ?>
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