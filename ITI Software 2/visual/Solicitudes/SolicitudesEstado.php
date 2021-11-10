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
            <?php if($_SESSION['idioma'] == "es"){ echo "Solicitudes | Estado";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Requests | Status";} ?>
        </title>
    </head>

    <body>
        <div class="wrapper">
            <!-- Sidebar  -->
            <?php include("../../Modelos/BarraLateral.php") ?>

            <!-- Page Content  -->
            <div id="content">
                <nav class="navbar navbar-expand-xxl navbar-light bg-light">
                    <div class="container-fluid">

                        <button type="button" id="sidebarCollapse" class="btn btn-primary mb-lg-3">
                            <i class="fas fa-align-left"></i>
                            <span>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Ocultar Menú";} ?>
							    <?php if($_SESSION['idioma'] == "en"){ echo "Hide Menu";} ?>
                            </span>
                        </button>
                        <button class="btn btn-secondary d-inline-block d-xxl-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-arrow-down"></i>
                        </button>
                        <button class="btn btn-info d-inline-block d-xxl-none ml-auto" type="button" data-toggle="collapse" data-target="#navBarUserInfo" aria-controls="navBarUserInfo" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-user"></i>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav navbar-nav ml-auto">
                            <?php if($rolsesion == "Subdirección A" || $rolsesion == "Informática" || $rolsesion == "Administrador" || $rolsesion == "Oficina"){ ?>
                                <li class="nav-item  mb-3 active">
                                    <a class="btn btn-outline-primary m-1" href="Solicitudes.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Solicitud de Insumos";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Consumables Requests";} ?>
                                    </a>
                                </li>
                                <?php } ?> 
                                <?php if($rolsesion == "Subdirección B" || $rolsesion == "Informática" || $rolsesion == "Administrador" || $rolsesion == "Compras"){ ?>
                                <li class="nav-item  mb-3 active">
                                    <a class="btn btn-outline-primary m-1" href="SolicitudesCompras.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Solicitudes de Compras";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Purchases Requests";} ?>
                                    </a>
                                </li>
                                <?php } ?> 
                                <li class="nav-item mb-3">
                                    <a class="btn btn-outline-primary m-1" href="SolicitudesFallas.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Solicitudes de fallas";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Error requests";} ?>
                                    </a>
                                </li> 
                                <?php if($rolsesion == "Oficina" || $rolsesion == "Informática" || $rolsesion == "Administrador"){ ?>
                                <li class="nav-item mb-3">
                                    <a class="btn btn-outline-primary m-1" href="SolicitudesEstado.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Consultas de Estado";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Status Queries";} ?>
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
                        <?php if($_SESSION['idioma'] == "es"){ echo "Consulta de Estado";} ?>
                        <?php if($_SESSION['idioma'] == "en"){ echo "Status Query";} ?>
                    </h1>
                    </div>
                    <form action="" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "ID de solicitud";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Request ID";} ?>
                        </label>
                        <input type="text" name="id" id="id" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Estado";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Status";} ?>
                        </label>
                        <input type="text" name="estado" id="estado" class="form-control" readonly>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo $placeholder="Comentarios";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo $placeholder="Comments";} ?>
                        </label>
                        <textarea class="form-control" id="comentarios" name="comentarios" rows="10" placeholder="<?php echo $placeholder?>" required readonly></textarea>
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