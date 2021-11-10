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
            <?php if($_SESSION['idioma'] == "es"){ echo "Solicitudes";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Requests";} ?>
        </title>
    </head>

    <body>
        <?php             
            $query = "SELECT * FROM tipo_equipamiento";
            $tipoeq = mysqli_query($conn, $query);
            
            $queryfalla = "SELECT * FROM falla";
            $resfalla = mysqli_query($conn, $queryfalla);

            $querysuc = "SELECT * FROM sucursales";
            $ressuc = mysqli_query($conn, $querysuc);

            if(isset($_POST['confirmar'])){
                $serie = $_POST['serie'];
                $falla = $_POST['falla'];
                $reparacion = $_POST['reparacion'];
                $timestamp = date("Y-m-d H:i:s");

                if($errores != ""){
                    // Se muestran los errores al final del formulario
                    
                }else{
                    // Se ingresan los datos en la base de datos y refresca el formulario//
                    $query = "INSERT INTO reparacion(tipo, nro_serie_equipo, id_falla) VALUES('$reparacion', '$serie', '$falla')";
                    $resultado = mysqli_query($conn, $query);

                    $queryupdate = mysqli_query($conn, "UPDATE presenta_fallas SET fecha_reparacion = $timestamp WHERE id_fallas = '$falla' AND nro_serie_equipo = '$serie' AND fecha_reparacion IS NULL");

                    header('Location: Reparaciones.php');
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
                            <?php if($_SESSION['idioma'] == "es"){ echo "Reparaciones";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Repairs";} ?>
                        </h1>
                    </div>
                    <form action="Reparaciones.php" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                    <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Nro de serie";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Serial number";} ?>
                        </label>
                        <input type="text" name="serie" id="serie" class="form-control">
                        <br>
                    <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "ID de falla";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Error ID";} ?>
                        </label>
                        <select name="falla" id="falla">
                            <option value="-1" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Seleccione ID de falla...";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Choose error ID..";} ?>
                            </option>
                            <?php while($cols = mysqli_fetch_array($resfalla)):; ?>
                            <option value="<?php echo $cols[0]; ?>"><?php
                                if($_SESSION['idioma'] == "es"){ echo "$cols[0] - $cols[1]";}
                                if($_SESSION['idioma'] == "en"){ echo "$cols[0] - $cols[2]";} ?></option>
                            <?php endwhile; ?>
                        </select>
                        <br>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){  $placeholder="Descripción"; echo "Tipo de reparación";} ?>
                            <?php if($_SESSION['idioma'] == "en"){  $placeholder="Description"; echo "Type of repair";} ?>
                        </label>
                        <textarea class="form-control" id="comentarios" name="reparacion" rows="10" placeholder="<?php echo $placeholder?>"></textarea>
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
    </body>
</html>