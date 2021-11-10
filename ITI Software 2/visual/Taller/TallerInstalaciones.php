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
        <?php include("../../Modelos/Scripts.php") ?>
        <title>
            <?php if($_SESSION['idioma'] == "es"){ echo "Taller | Garantía";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Workshop | Warranty";} ?>
        </title>
    </head>

    <body>
        <?php 
            if(empty($_SESSION['condicion1'])){
                $_SESSION['condicion1']="0";
            }
            if($_SESSION['condicion1'] == '0'){
            $errores="";            
            if(isset($_POST['cambio'])){
                $_SESSION['condicion1'] = '0';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            if(isset($_POST['cambio2'])){
                $_SESSION['condicion1'] = '1';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            if($_SESSION['condicion1'] == '0'){
            $querycli = "SELECT DISTINCT(id_cliente), nombre FROM cliente WHERE id_cliente < '5'";
            $rescli = mysqli_query($conn, $querycli);

            $querysuc = "SELECT * FROM sucursales";
            $ressuc = mysqli_query($conn, $querysuc);

            $querystock = "SELECT * FROM estado_equipamiento WHERE id_estado = '2'";
            $resstock = mysqli_query($conn, $querystock);

            if(isset($_POST['confirmar'])){
                $serie = $_POST['serie'];
                $cliente = $_POST['cliente'];
                $sucursal = $_POST['sucursal'];                    
                $timestamp = date("Y-m-d H:i:s");
                $queryserie = mysqli_query($conn, "SELECT * FROM estado_equipamiento WHERE id_estado = '2' AND nro_serie_equipo = '$serie'");
                $estser = mysqli_fetch_array($queryserie);
                $estado = $estser['id_estado'];
                if($estado=="2"){
                    $queryinstal = "INSERT INTO cliente_equipo(id_cliente, id_sucursal, nro_serie_equipo, fecha) VALUES('$cliente', '$sucursal', '$serie', '$timestamp')";
                    $resquery = mysqli_query($conn, $queryinstal);

                    $queryupdate = mysqli_query($conn, "UPDATE estado_equipamiento SET fecha_fin = '$timestamp' WHERE nro_serie_equipo = '$serie' AND id_estado = '2'");

                    $queryinstal = mysqli_query($conn, "INSERT INTO estado_equipamiento(id_estado, est_sucesor, nro_serie_equipo, fecha_inicio, fecha_fin) VALUES ('4', '$estado', '$serie', '$timestamp', '')");
                }
                else{

                }
            }
        ?>
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
                            <li class="nav-item  mb-3 active">                      
                                    <a class="btn btn-outline-primary m-1" href="Taller.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Alta Equipamiento | Insumo";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Register Equipment | Consumables";} ?>
                                    </a>                                
                                </li>
                                <li class="nav-item mb-3"> 
                                    <a class="btn btn-outline-primary m-1" href="TallerInstalaciones.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Instalaciones";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Installations";} ?>
                                    </a>
                                </li>
                                <li class="nav-item mb-3">
                                    <a class="btn btn-outline-primary m-1" href="TallerSolicitud.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Estado del Equipamiento";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Equipment Status";} ?>
                                    </a>
                                </li> 
                                <li class="nav-item mb-3">
                                    <a class="btn btn-outline-primary m-1" href="Reparaciones.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Reparaciones";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Repairs";} ?>
                                    </a>
                                </li>                          
                            </ul>
                        </div>
                        <?php include("../../Modelos/UserInfo.php") ?>
                    </div>
                </nav>    
                <form method="POST" action="TallerInstalaciones.php" id="formulario-modificar" enctype="multipart/form-data">
                <button type="submit" name="cambio" class="btn btn-dark" role="button">
                    <?php if($_SESSION['idioma'] == "es"){ echo "Instalación en clientes";} ?>
                    <?php if($_SESSION['idioma'] == "en"){ echo "Clients installation";} ?>
                </button>
                <button type="submit" name="cambio2" class="btn btn-dark" role="button">
                    <?php if($_SESSION['idioma'] == "es"){ echo "Instalación de insumos";} ?>
                    <?php if($_SESSION['idioma'] == "en"){ echo "Consumable installation";} ?>
                </button></form> <?php } ?>
                <div class="container">
                    <div class="px-3 py-3 pb-md-4 mx-auto text-center">
                        <h1 class="h1">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Instalación en clientes";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Clients installation";} ?>
                        </h1>
                    </div>
                    <form action="TallerInstalaciones.php" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                    <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "ID Cliente";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Client ID";} ?>
                        </label>
                        <select name="cliente" id="cliente">
                            <option value="-1" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Seleccione ID del cliente...";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Choose Client ID..";} ?>
                            </option>
                            <?php while($cols = mysqli_fetch_array($rescli)):; ?>
                            <option value="<?php  echo $cols[0]; ?>"><?php echo "$cols[0] - $cols[1]"; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <br>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "ID Sucursal";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Branch ID";} ?>
                        </label>
                        <select name="sucursal" id="sucursal">
                            <option value="-1" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Seleccione ID de sucursal...";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Choose Branch ID..";} ?>
                            </option>
                            <?php while($cols = mysqli_fetch_array($ressuc)):; ?>
                            <option value="<?php echo $cols[0]; ?>"><?php echo "$cols[0] - $cols[2]"; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <br>
                        <br>
                        <label for="exampleDataList" class="form-label"><?php if($_SESSION['idioma'] == "es"){ echo "Nro. serie";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Serial number";} ?></label>
                        <input list="datalistOptions" name="serie" id="exampleDataList" placeholder="Type to search...">
                        <datalist id="datalistOptions">
                        <option value="" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Seleccione ID...";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Choose ID..";} ?>
                            </option>
                            <?php while($columnas = mysqli_fetch_array($resstock)):; ?>
                            <option value="<?php echo $columnas[2]; ?>"></option>
                            <?php endwhile; ?>
                        </datalist>
                        <br>
                        <br>
                        <button type="submit" name="confirmar" class="btn btn-primary">
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
        <?php } else{  
            if($_SESSION['condicion1'] == '1'){
            $errores="";            
            if(isset($_POST['cambio'])){
                $_SESSION['condicion1'] = '0';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            if(isset($_POST['cambio2'])){
                $_SESSION['condicion1'] = '1';
                echo "<meta http-equiv='refresh' content='0'>";
            }

            $querysuc = "SELECT * FROM sucursales";
            $ressuc = mysqli_query($conn, $querysuc);

            $querystock = "SELECT * FROM estado_equipamiento WHERE id_estado = '2' AND fecha_fin IS NULL";
            $resstock = mysqli_query($conn, $querystock);

            $queryins = "SELECT * FROM estado_equipamiento, insumo WHERE id_estado = '2' AND fecha_fin IS NULL AND estado_equipamiento.nro_serie_equipo = insumo.nro_serie_insumo";
            $resins = mysqli_query($conn, $queryins);

            if(isset($_POST['confirmar1'])){
                $serie = $_POST['serie1'];
                $insumo = $_POST['insumo'];                   
                $timestamp = date("Y-m-d H:i:s");
                $queryserie = mysqli_query($conn, "SELECT * FROM estado_equipamiento, insumo WHERE id_estado = '2' AND estado_equipamiento.nro_serie_equipo = '$serie' AND insumo.nro_serie_insumo = '$insumo'");
                $estser = mysqli_fetch_array($queryserie);
                $estado = $estser['id_estado'];
                if($estado=="2"){
                    $queryinstal = "INSERT INTO equipo_insumo(serie_equipo, serie_insumo, fecha) VALUES('$serie', '$insumo', '$timestamp')";
                    $resquery = mysqli_query($conn, $queryinstal);

                    $queryupdate = mysqli_query($conn, "UPDATE estado_equipamiento SET fecha_fin = '$timestamp' WHERE nro_serie_equipo = '$serie' AND id_estado = '2'");
                    $queryupdate2 = mysqli_query($conn, "UPDATE estado_equipamiento SET fecha_fin = '$timestamp' WHERE nro_serie_equipo = '$insumo' AND id_estado = '2'");

                    $queryinstal = mysqli_query($conn, "INSERT INTO estado_equipamiento(id_estado, est_sucesor, nro_serie_equipo, fecha_inicio, fecha_fin) VALUES ('4', '$estado', '$serie', '$timestamp', NULL)");
                }
                else{
                    
                }
            }
        ?>
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
                            <li class="nav-item  mb-3 active">                      
                                    <a class="btn btn-outline-primary m-1" href="Taller.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Alta Equipamiento | Insumo";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Register Equipment | Consumables";} ?>
                                    </a>                                
                                </li>
                                <li class="nav-item mb-3"> 
                                    <a class="btn btn-outline-primary m-1" href="TallerInstalaciones.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Instalaciones";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Installations";} ?>
                                    </a>
                                </li>
                                <li class="nav-item mb-3">
                                    <a class="btn btn-outline-primary m-1" href="TallerSolicitud.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Estado del Equipamiento";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Equipment Status";} ?>
                                    </a>
                                </li> 
                                <li class="nav-item mb-3">
                                    <a class="btn btn-outline-primary m-1" href="Reparaciones.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Reparaciones";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Repairs";} ?>
                                    </a>
                                </li>                        
                            </ul>
                        </div>
                        <?php include("../../Modelos/UserInfo.php") ?>
                    </div>
                </nav>    
                <form method="POST" action="TallerInstalaciones.php" id="formulario-modificar" enctype="multipart/form-data">
                <button type="submit" name="cambio" class="btn btn-dark" role="button">
                    <?php if($_SESSION['idioma'] == "es"){ echo "Instalación en clientes";} ?>
                    <?php if($_SESSION['idioma'] == "en"){ echo "Clients installation";} ?>
                </button>
                <button type="submit" name="cambio2" class="btn btn-dark" role="button">
                    <?php if($_SESSION['idioma'] == "es"){ echo "Instalación de insumos";} ?>
                    <?php if($_SESSION['idioma'] == "en"){ echo "Consumable installation";} ?>
                </button></form> <?php } ?>
                <div class="container">
                    <div class="px-3 py-3 pb-md-4 mx-auto text-center">
                        <h1 class="h1">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Instalación de insumos";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Consumables installation";} ?>
                        </h1>
                    </div>
                    <form action="TallerInstalaciones.php" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                        <label for="exampleDataList" class="form-label">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Nro. serie de equipamiento";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Equipment serial number";} ?></label>
                        <input list="datalistOptions" name="serie1" id="exampleDataList" placeholder="Type to search...">
                        <datalist id="datalistOptions">
                            <?php while($columnas = mysqli_fetch_array($resstock)):; ?>
                            <option value="<?php echo $columnas[2]; ?>"></option>
                            <?php endwhile; ?>
                        </datalist>
                        <br>
                        <br>
                        <label for="exampleDataList" class="form-label">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Nro. serie de insumo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Consumable serial number";} ?></label>  
                            <input list="datalistOptions1" name="insumo" id="exampleDataList1" placeholder="Type to search...">                          
                            <datalist id="datalistOptions1">
                            <?php while($cols = mysqli_fetch_array($resins)):; ?>
                            <option value="<?php echo $cols[2]; ?>"></option>
                            <?php endwhile; ?>
                        </datalist>
                        <br>
                        <br>
                        <button type="submit" name="confirmar1" class="btn btn-primary">
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
            <?php } ?>
    </body>
</html>