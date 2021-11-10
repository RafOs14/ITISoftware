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
            <?php if($_SESSION['idioma'] == "es"){ echo "Solicitudes de fallas";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Error requests";} ?>
        </title>
    </head>

    <body>
        <?php            
            if(empty($_SESSION['condicion2']) && $rolsesion !="Taller"){
                $_SESSION['condicion2']="0";
            }
            if(empty($_SESSION['condicion2'])&& $rolsesion =="Taller"){
                $_SESSION['condicion2']="1";
            }
            if($_SESSION['condicion2'] != '1'){
            $errores="";
            if(isset($_POST['cambio'])){
                $_SESSION['condicion2'] = '1';
                echo "<meta http-equiv='refresh' content='0'>";
            }
                        
            $querycli = "SELECT DISTINCT(id_cliente), nombre FROM cliente";
            $rescli = mysqli_query($conn, $querycli);

            $queryfalla = "SELECT * FROM falla";
            $resfalla = mysqli_query($conn, $queryfalla);

            if(isset($_POST['confirmar'])){
                $falla = $_POST['falla'];
                $cliente = $_POST['cliente'];
                $serie = $_POST['serie'];
                $timestamp = date("Y-m-d H:i:s");

                if($errores != ""){
                    // Se muestran los errores al final del formulario
                    
                }else{
                    // Se ingresan los datos en la base de datos y refresca el formulario//
                    $query = "INSERT INTO presenta_fallas(id_fallas, id_cliente, nro_serie_equipo, fecha) VALUES('$falla', '$cliente', '$serie', '$timestamp')";
                    $resultado = mysqli_query($conn, $query);

                    $queryest = mysqli_query($conn, "SELECT * FROM `estado_equipamiento` WHERE nro_serie_equipo = 'hhhhhhhh' ORDER BY fecha_inicio DESC LIMIT 1");
                    $resest = mysqli_fetch_array($queryest);
                    $estado = $resest['id_estado'];

                    $queryupdate = mysqli_query($conn, "UPDATE estado_equipamiento SET fecha_fin = '$timestamp' WHERE nro_serie_equipo = '$serie' AND id_estado = '$estado' ORDER BY fecha_inicio DESC LIMIT 1");

                    $queryinstal = mysqli_query($conn, "INSERT INTO estado_equipamiento(id_estado, est_sucesor, nro_serie_equipo, fecha_inicio, fecha_fin) VALUES ('3', '$estado', '$serie', '$timestamp', NULL)");

                    header('Location: SolicitudesFallas.php');
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
                <?php if($rolsesion=="Informática" || $rolsesion=="Administrador"){ ?>
                <form method="POST" action="SolicitudesFallas.php" id="formulario-modificar" enctype="multipart/form-data">
                <button type="submit" name="cambio" class="btn btn-dark" role="button">
                    <?php if($_SESSION['idioma'] == "es"){ echo "Cambiar vista";} ?>
                    <?php if($_SESSION['idioma'] == "en"){ echo "Change View";} ?>
                </button></form> <?php } ?>
                <div class="container">
                    <div class="px-3 py-3 pb-md-4 mx-auto text-center">
                        <h1 class="h1">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Solicitud de fallas";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Error request";} ?>
                        </h1>
                    </div>
                    <form action="SolicitudesFallas.php" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "ID falla";} ?>
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
                            <?php if($_SESSION['idioma'] == "es"){ echo "ID Cliente";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Client ID";} ?>
                        </label>
                        <select name="cliente" id="cliente">
                            <option value="-1" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Seleccione ID del cliente...";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Choose Client ID..";} ?>
                            </option>
                            <?php while($cols = mysqli_fetch_array($rescli)):; ?>
                            <option value="<?php echo $cols[0]; ?>"><?php echo "$cols[0] - $cols[1]"; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <br>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Nro. serie";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Serial number";} ?>
                        </label>
                        <input type="text" name="serie" id="serie" class="form-control">
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
        <?php } else{ ?>     
        
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
                <?php if($rolsesion=="Informática" || $rolsesion=="Administrador" || $rolsesion=="Taller"){ ?>
                    <?php 
                        if(isset($_POST['cambio2'])){
                            $_SESSION['condicion2'] = '0';
                            echo "<meta http-equiv='refresh' content='0'>";
                        } 
                        $numero = "";
                        if(empty($esperror)){
                            $esperror="";
                        }                
                        if(empty($engerror)){
                            $engerror="";
                        }
                        if($_SESSION['idioma'] == "es"){ 
                            $confirmar =  "Confirmar";
                        }
                        if($_SESSION['idioma'] == "en"){ 
                            $confirmar =  "Confirm";
                        } 
                        if(isset($_POST['confirmar'])){
                            $error = $_POST['error'];
                            $cliente = $_POST['cliente'];
                            $numero = $_POST['serie'];
                            $timestamp = date("Y-m-d H:i:s"); 
                            
                            if($errores!=""){
                                
                            }
                            else{
                                $queryupdate = mysqli_query($conn, "UPDATE estado_equipamiento SET fecha_fin = '$timestamp' WHERE nro_serie_equipo = '$numero' AND id_estado = '3' AND fecha_fin IS NULL");
                                $queryupdate2 = mysqli_query($conn, "UPDATE presenta_fallas SET fecha_reparacion = '$timestamp' WHERE nro_serie_equipo = '$numero' AND id_fallas = '$error' AND id_cliente = '$cliente' AND fecha_reparacion IS NULL");

                                $queryinsert = mysqli_query($conn, "INSERT INTO estado_equipamiento(id_estado, est_sucesor, nro_serie_equipo, fecha_inicio) VALUES('$error', '3', '$numero', '$timestamp')");

                                echo "<meta http-equiv='refresh' content='0'>";
                            }
                        }
                            
                    }
                    if ($rolsesion == 'Informática' || $rolsesion == 'Administrador') {
                    ?>
                <form method="POST" action="SolicitudesFallas.php" id="formulario-modificar" enctype="multipart/form-data">
                <button type="submit" name="cambio2" class="btn btn-dark" role="button">
                    <?php if($_SESSION['idioma'] == "es"){ echo "Cambiar a Vista Oficina";} ?>
                    <?php if($_SESSION['idioma'] == "en"){ echo "Change to Office View";} ?>
                </button></form> <?php } ?>
                <div class="container">
                    <div class="px-3 py-3 pb-md-4 mx-auto text-center">
                        <h1 class="h1">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Listado de solicitudes de fallas";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "List of error requests";} ?>
                        </h1>
                    </div>
                    <table class="table">
                    <tr class="table-dark"><td class="px-4 fs-5">
                        <?php if($_SESSION['idioma'] == "es"){ echo "Opciones de Filtrado";} ?>
                        <?php if($_SESSION['idioma'] == "en"){ echo "Filter Options";} ?>
                    </td></tr>
                    <tr class="table-secondary"><td>
                    <form action="SolicitudesFallas.php" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                    <label for="nombre" class="px-3">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Estado de la solicitud";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Request status";} ?>
                        </label>                        
                        <select name="filtro" id="filtro">
                            <option value="" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Filtrar por...";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Filter by..";} ?>
                            </option>
                            <option value="Stock">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Stock";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Stock";} ?></option>
                            <option value="Taller">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Taller";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Workshop";} ?></option>
                            <option value="Instalado">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Instalado";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Installed";} ?></option>
                            <option value="Garantía">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Garantía";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Warranty";} ?></option>
                            <option value="Desaparecido">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Desaparecido";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Missing";} ?></option>
                            <option value="Desguazado">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Desguazado";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Scrapped";} ?></option>
                        </select>
                        <button type="submit" name="aplicar" class="" role="button">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Aplicar Filtro";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Apply Filter";} ?>
                        </button>
                        <button type="submit" class="">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Restaurar filtro";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Restore filter";} ?>
                        </button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Destino de solicitud";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Request destiny";} ?>
                        </button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Destino de solicitudes";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Requests destiny";} ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="SolicitudesFallas.php" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                                    <label for="nombre">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "ID de falla";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Error number";} ?>
                                    </label>
                                    <input type="text" name="error" id="error" class="form-control">
                                    <label for="nombre">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "ID de cliente";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Client ID";} ?>
                                    </label>
                                    <input type="text" name="cliente" id="cliente" class="form-control">
                                    <label for="nombre">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Número de serie";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Serial number";} ?>
                                    </label>
                                    <input type="text" name="serie" id="serie" class="form-control"><br>
                                    <select name="nombre" id="filtro" class="form-select">
                                        <option value="" selected>
                                            <?php if($_SESSION['idioma'] == "es"){ echo "Escoger destino...";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Choose destiny..";} ?>
                                        </option>
                                        <option value="Stock">
                                            <?php if($_SESSION['idioma'] == "es"){ echo "Stock";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Stock";} ?></option>
                                        <option value="Reinstalado">
                                            <?php if($_SESSION['idioma'] == "es"){ echo "Instalado";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Installed";} ?></option>
                                        <option value="Garantía">
                                            <?php if($_SESSION['idioma'] == "es"){ echo "Garantía";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Warranty";} ?></option>
                                        <option value="Desaparecido">
                                            <?php if($_SESSION['idioma'] == "es"){ echo "Desaparecido";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Missing";} ?></option>
                                        <option value="Desguazado">
                                            <?php if($_SESSION['idioma'] == "es"){ echo "Desguazado";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Scrapped";} ?></option>
                                    </select>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                <input type=submit name="confirmar" class="btn btn-md btn-success" value='<?php echo $confirmar?>'>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <?php if($_SESSION['idioma'] == "es"){ echo "Cerrar";} ?>
                                    <?php if($_SESSION['idioma'] == "en"){ echo "Close";} ?></button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </form></td></tr></table>
                    <table class="table table-dark table-hover table-striped table-bordered">
                        <thead>
                        <tr class="center">
                            <td width="15%" scope="col"><?php if($_SESSION['idioma'] == "es"){ echo "Error de fallas";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Error ID";} ?></td>
                            <td width="15%"><?php if($_SESSION['idioma'] == "es"){ echo "ID Cliente";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Client ID";} ?></td>
                            <td width="15%"><?php if($_SESSION['idioma'] == "es"){ echo "Nro. de serie";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Client ID";} ?></td>
                            <td width="30%"><?php if($_SESSION['idioma'] == "es"){ echo "Estado de la solicitud";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Request status";} ?></td>
                            <td width="25%"><?php if($_SESSION['idioma'] == "es"){ echo "Fecha";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Date";} ?></td>
                        </tr>
                    </thead>
                    <tbody class="table-secondary">
                        <?php 
                            if(isset($_POST['aplicar'])){
                                $filtro=$_POST['filtro'];
                            }                
                            if(empty($filtro)){
                                $filtro="";
                            }                            
                            if($filtro==""){
                                $sql = "SELECT * FROM presenta_fallas as p, estado_equipamiento as e, estado as es WHERE e.nro_serie_equipo = p.nro_serie_equipo AND e.id_estado = es.id AND e.fecha_fin IS NULL ORDER BY p.fecha, e.fecha_inicio DESC";
                                $query = $conn-> query($sql);
                            }
                            if($filtro=="Stock"){
                                $sql = "SELECT * FROM presenta_fallas as p, estado_equipamiento as e, estado as es WHERE e.nro_serie_equipo = p.nro_serie_equipo AND e.id_estado = es.id AND es.nombre = 'Stock' AND e.fecha_fin IS NULL ORDER BY p.fecha, e.fecha_inicio DESC";
                                $query = $conn-> query($sql);
                            }
                            if($filtro=="Taller"){
                                $sql = "SELECT * FROM presenta_fallas as p, estado_equipamiento as e, estado as es WHERE e.nro_serie_equipo = p.nro_serie_equipo AND e.id_estado = es.id AND es.nombre = 'Taller' AND e.fecha_fin IS NULL ORDER BY p.fecha, e.fecha_inicio DESC";
                                $query = $conn-> query($sql);
                            }
                            if($filtro=="Reinstalado"){
                                $sql = "SELECT * FROM presenta_fallas as p, estado_equipamiento as e, estado as es WHERE e.nro_serie_equipo = p.nro_serie_equipo AND e.id_estado = es.id AND es.nombre = 'Reinstalado' AND e.fecha_fin IS NULL ORDER BY p.fecha, e.fecha_inicio DESC";
                                $query = $conn-> query($sql);
                            }
                            if($filtro=="Garantía"){
                                $sql = "SELECT * FROM presenta_fallas as p, estado_equipamiento as e, estado as es WHERE e.nro_serie_equipo = p.nro_serie_equipo AND e.id_estado = es.id AND es.nombre = 'Garantía' AND e.fecha_fin IS NULL ORDER BY p.fecha, e.fecha_inicio DESC";
                                $query = $conn-> query($sql);
                            }
                            if($filtro=="Desaparecido"){
                                $sql = "SELECT * FROM presenta_fallas as p, estado_equipamiento as e, estado as es WHERE e.nro_serie_equipo = p.nro_serie_equipo AND e.id_estado = es.id AND es.nombre = 'Desaparecido' AND e.fecha_fin IS NULL ORDER BY p.fecha, e.fecha_inicio DESC";
                                $query = $conn-> query($sql);
                            }
                            if($filtro=="Desguazado"){
                                $sql = "SELECT * FROM presenta_fallas as p, estado_equipamiento as e, estado as es WHERE e.nro_serie_equipo = p.nro_serie_equipo AND e.id_estado = es.id AND es.nombre = 'Desguazado' AND e.fecha_fin IS NULL ORDER BY p.fecha, e.fecha_inicio DESC";
                                $query = $conn-> query($sql);
                            }
                            ?> <form method="POST" action="SolicitudesFallas.php" id="formulario-modificar" enctype="multipart/form-data"><?php
                            if($query-> num_rows > 0){
                                while ($row = $query-> fetch_assoc()){
                                    $estado = $row['id_estado'];
                                    if($estado=='3'){
                                        $status = "Taller";
                                    }
                                    elseif($estado=='2'){
                                        $status = "Stock";
                                    }
                                    elseif($estado=='4'){
                                        $status = "Instalado";
                                    }
                                    elseif($estado=='5'){
                                        $status = "Garantía";
                                    }
                                    elseif($estado=='6'){
                                        $status = "Desaparecido";
                                    }
                                    elseif($estado=='7'){
                                        $status = "Desguazado";
                                    }
                                    $fecha = date('d-m-Y H:i:s', strtotime($row["fecha"]));
                                    echo "<tr><td>". $row["id_fallas"] ."</td><td>". $row["id_cliente"] ."</td><td>". $row["nro_serie_equipo"] ."</td><td>". $status ."</td><td>". $fecha ."</td></tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                            }
                            else{
                                $esperror = "No se encontraron resultados";
                                $engerror = "No results encountered";
                            }
                            ?></form><?php
                            $conn-> close(); 
                        ?>
                    </table>  
                    <?php if($_SESSION['idioma'] == "es"){ echo $esperror;};
                            if($_SESSION['idioma'] == "en"){ echo $engerror;};?>         
                </div>
            </div>
        </div>
        <?php } ?>
    </body>
</html>