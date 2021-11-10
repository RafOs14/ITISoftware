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
            <?php if($_SESSION['idioma'] == "es"){ echo "Consultas Productos";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Products Requests";} ?>
        </title>
    </head>

    <body>
        <?php
            $errores = "";
            $querystock = "";
            $stock = "";
            $query = "SELECT * FROM tipo_equipamiento";
            $tipoeq = mysqli_query($conn, $query);

            $query = "SELECT * FROM estado";
            $queryest = mysqli_query($conn, $query);

            if(isset($_POST['buscar'])){
                $tipo = $_POST['tipo'];
                $estado = $_POST['estado'];
                $query = mysqli_query($conn, "SELECT * FROM estado WHERE id = '$estado'");
                $resquery = mysqli_fetch_array($query);
                $estadonom = $resquery['nombre']; 
                if(empty($tipo) || empty($estado)){
                    $errores = $errores . " <li>Debe seleccionar valores en ambas listas antes de buscar</li>\n";
                }
                elseif($estado=="1"){
                    $queryprestock = mysqli_query($conn, "SELECT * FROM tipo_equipamiento WHERE id = '$tipo'");
                    $resprestock = mysqli_fetch_array($queryprestock);
                    $estadonom = "Pre-Stock";
                    $stock = $resprestock['cantidad'];
                }
                else{
                    $querystock = mysqli_query($conn, "SELECT estado.nombre, COUNT(equipamiento.nro_serie) as stock from estado_equipamiento, estado, equipamiento WHERE equipamiento.id_tipo_equipamiento = '$tipo' AND estado_equipamiento.nro_serie_equipo = equipamiento.nro_serie AND estado_equipamiento.id_estado = '$estado' AND estado_equipamiento.id_estado = estado.id");
                    $resstock = mysqli_fetch_array($querystock);
                    $estadonom = $estadonom;
                    if(!empty($resstock['stock'])){
                        $stock = $resstock['stock'];
                    }
                    else{
                        $stock = '0';
                    }

                    
                }
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
                            <?php if($_SESSION['idioma'] == "es"){ echo "Estado del producto";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Product status";} ?>
                        </h1>
                        </div>
                    <form action="ConsultasStock.php" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                        <label for="tipo">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Tipo de producto";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Type of product";} ?>
                        </label>
                        <select name="tipo" id="tipo">
                            <option value="" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Seleccione tipo...";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Choose type..";} ?>
                            </option>
                            <?php while($cols = mysqli_fetch_array($tipoeq)):; ?>
                            <option value="<?php echo $cols[0]; ?>"><?php 
                                if($_SESSION['idioma'] == "es"){echo "$cols[2]";}
                                if($_SESSION['idioma'] == "en"){echo "$cols[3]";}; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <br>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Seleccionar estado";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Select status";} ?>
                        </label>
                        <select name="estado" id="estado">
                            <option value="" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Seleccione estado...";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Choose status..";} ?>
                            </option>
                            <?php while($columnas = mysqli_fetch_array($queryest)):; ?>
                            <option value="<?php echo $columnas[0]; ?>"><?php echo "$columnas[0] - $columnas[1]"; ?></option>
                            <?php endwhile; ?>
                        </select>
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
                    <div class="px-3 py-3 pb-md-4">
                        
                        <ul><?php if(!empty($errores)){
                            ?><p><Strong>
                                <?php if($_SESSION['idioma'] == "es"){ echo "No se pudo completar el formulario debido a los siguientes errores:";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "The form failed to submit due to the following errors:";} ?>
                            </strong></p><?php
                        } echo $errores ?></ul>
                    </div>
                    <div class="px-3 py-3 pb-md-4">
                        
                        <ul><?php if($stock >= 0){
                            ?><h5>
                                <?php if($_SESSION['idioma'] == "es"){ echo "La cantidad de productos con el siguiente estado '$estadonom' es de:";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "The amount of products with the following status '$estadonom' is:";} ?>
                            </h5><?php
                        } echo $stock ?></ul>
                    </div>
                </div>
            </div>
        </div>
        <?php include("../../Modelos/Scripts.php") ?>
    </body>
</html>