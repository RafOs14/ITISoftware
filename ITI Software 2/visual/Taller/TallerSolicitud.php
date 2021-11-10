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
            <?php if($_SESSION['idioma'] == "es"){ echo "Taller | Solicitud";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Workshop | Request";} ?>
        </title>
    </head>

    <body>
        <?php
            $errores="";
            $query = "SELECT * FROM estado";
            $queryest = mysqli_query($conn, $query);
            $serie = "";
            $estado ="";
            $tipo = "";
            if(isset($_POST['buscar'])){
                $serie = $_POST['serie'];
                $query = mysqli_query($conn, "SELECT * FROM estado_equipamiento, equipamiento WHERE estado_equipamiento.nro_serie_equipo = equipamiento.nro_serie AND equipamiento.nro_serie = '$serie'");
                $resultado = mysqli_fetch_array($query);
                $estado = $resultado['id_estado'];
                $tipo = $resultado['tipo_equipamiento'];

            }

            if(isset($_POST['confirmar'])){
                if(empty($_POST['serie'])){
                    $errores = $errores . " <li>Debe ingresar un valor en número de serie</li>\n";
                }
                else{
                    if($errores != ""){
                        // Se muestran los errores al final del formulario
                        
                    }
                    else{
                        $serie = $_POST['serie'];
                        $tipo = $_POST['tipo'];
                        $timestamp = date("Y-m-d H:i:s");
                        $query = "UPDATE estado_equipamiento SET fecha_fin = '$timestamp' WHERE nro_serie_equipo = '$serie'";
                        mysqli_query($conn, $query);
                        
                        $query = mysqli_query($conn, "SELECT * FROM estado_equipamiento WHERE nro_serie_equipo = '$serie'");
                        $resultado = mysqli_fetch_array($query);
                        $oldides = $resultado['id_estado'];

                        $querynew = "INSERT INTO estado_equipamiento(id_estado, est_sucesor, nro_serie_equipo, fecha_inicio) VALUES ('$tipo', '$oldides', '$serie', '$timestamp')";
                        $resultadonew = mysqli_query($conn, $querynew);

                        header('Location: TallerSolicitud.php');
                    }  
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

                <div class="container">
                    <div class="px-3 py-3 pb-md-4 mx-auto text-center">
                        <h1 class="h1">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Estado del Equipamiento / Insumo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Equipment / Consumable Status";} ?>
                        </h1>
                    </div>
                    <form action="" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Nro de serie";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Serial number";} ?>
                        </label>
                        <input type="text" name="serie" id="serie" class="form-control" value="<?php echo $serie ?>">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Equipamiento / Insumo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Equipment / Consumable";} ?>
                        </label>
                        <input type="text" name="producto" id="producto" class="form-control" value="<?php echo $tipo ?>" readonly>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Estado actual";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Present status";} ?>
                        </label>
                        <input type="text" name="estado" id="estado" class="form-control" value="<?php echo $estado ?>" readonly>
                        <br>                    
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Asignar estado";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Assign status";} ?>
                        </label>
                        <select name="tipo" id="tipo">
                            <option value="-1" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Seleccione estado...";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Choose status..";} ?>
                            </option>
                            <?php while($columnas = mysqli_fetch_array($queryest)):; ?>
                            <option value="<?php echo $columnas[0]; ?>"><?php echo "$columnas[0] - $columnas[1]"; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <br>
                        <br>                    
                        <button type="submit" name="confirmar" class="btn btn-success">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Confirmar";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Confirm";} ?>
                        </button>
                        <button type="submit" name="buscar" id="action-modificar" class="btn btn-primary">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Buscar";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Search";} ?></button>
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