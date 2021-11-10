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
            if(empty($_SESSION['condicion']) && $rolsesion!="Subdirección A"){
                $_SESSION['condicion']="0";
            }
            if(empty($_SESSION['condicion']) && $rolsesion=="Subdirección A"){
                $_SESSION['condicion']="1";
            }
            if($_SESSION['condicion'] != '1'){
            $errores="";
            if(isset($_POST['cambio'])){
                $_SESSION['condicion'] = '1';
                echo "<meta http-equiv='refresh' content='0'>";
            }
            
            $query = "SELECT * FROM tipo_equipamiento";
            $tipoeq = mysqli_query($conn, $query);
            
            $querycli = "SELECT DISTINCT(id_cliente), nombre FROM cliente WHERE id_cliente < '5'";
            $rescli = mysqli_query($conn, $querycli);

            $querysuc = "SELECT * FROM sucursales";
            $ressuc = mysqli_query($conn, $querysuc);

            if(isset($_POST['confirmar'])){
                $cliente = $_POST['cliente'];
                $sucursal = $_POST['sucursal'];
                $tipo = $_POST['tipo'];
                $cantidad = $_POST['cantidad'];
                $comentarios = $_POST['comentarios'];
                $timestamp = date("Y-m-d H:i:s");

                if($errores != ""){
                    // Se muestran los errores al final del formulario
                    
                }else{
                    // Se ingresan los datos en la base de datos y refresca el formulario//
                    $query = "INSERT INTO cliente_tipo_equipamiento(subdireccion, id_cliente, id_sucursal, id_tipo_equipamiento, est_solicitud, motivo, cantidad, fecha) VALUES('A', '$cliente', '$sucursal', '$tipo', 'Pendiente', '$comentarios', '$cantidad', '$timestamp')";
                    $resultado = mysqli_query($conn, $query);

                    header('Location: Solicitudes.php');
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
                <form method="POST" action="Solicitudes.php" id="formulario-modificar" enctype="multipart/form-data">
                <button type="submit" name="cambio" class="btn btn-dark" role="button">
                    <?php if($_SESSION['idioma'] == "es"){ echo "Cambiar a Vista Sub";} ?>
                    <?php if($_SESSION['idioma'] == "en"){ echo "Change to Branch View";} ?>
                </button></form> <?php } ?>
                <div class="container">
                    <div class="px-3 py-3 pb-md-4 mx-auto text-center">
                        <h1 class="h1">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Solicitud de Equipamiento / Insumo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Equipment / Consumable Request";} ?>
                        </h1>
                    </div>
                    <form action="Solicitudes.php" method="POST" id="formulario-modificar" enctype="multipart/form-data">
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
                        <label for="tipo">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Tipo de producto";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Type of product";} ?>
                        </label>
                        <select name="tipo" id="tipo">
                            <option value="-1" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Seleccione tipo...";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Choose type..";} ?>
                            </option>
                            <?php while($cols = mysqli_fetch_array($tipoeq)):; ?>
                            <option value="<?php echo $cols[0]; ?>"><?php 
                                if($_SESSION['idioma'] == "es"){echo "$cols[0] - $cols[2]";}
                                if($_SESSION['idioma'] == "en"){echo "$cols[0] - $cols[3]";}; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <br>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Cantidad a solicitar";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Amount to request";} ?>
                        </label>
                        <input type="text" name="cantidad" id="cantidad" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){  $placeholder="Comentarios"; echo "Motivo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){  $placeholder="Comments"; echo "Reason";} ?>
                        </label>
                        <textarea class="form-control" id="comentarios" name="comentarios" rows="10" placeholder="<?php echo $placeholder?>"></textarea>
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
                <?php 
                    $numero = "";
                        if(empty($esperror)){
                            $esperror="";
                        }                
                        if(empty($engerror)){
                            $engerror="";
                        }
                        if($_SESSION['idioma'] == "es"){ 
                            $aprobar =  "Aprobar";
                            $rechazar = "Rechazar";
                        }
                        if($_SESSION['idioma'] == "en"){ 
                            $aprobar =  "Approve";
                            $rechazar = "Reject";
                        } 
                        if(isset($_POST['aprobar'])){
                            $solicitud = $_POST['nrosol'];

                            $query = mysqli_query($conn, "SELECT * FROM cliente_tipo_equipamiento WHERE nro_solicitud = '$solicitud'");
                            $resquery = mysqli_fetch_array($query);
                            $estado = $resquery['est_solicitud'];
                            
                            if($estado=="Pendiente"){
                                $query = mysqli_query($conn, "UPDATE cliente_tipo_equipamiento SET est_solicitud = 'Aprobado' WHERE nro_solicitud = '$solicitud'");
                            }
                            else{

                            }
                        }

                        if(isset($_POST['rechazar'])){
                            $solicitud = $_POST['nrosol'];

                            $query = mysqli_query($conn, "SELECT * FROM cliente_tipo_equipamiento WHERE nro_solicitud = '$solicitud'");
                            $resquery = mysqli_fetch_array($query);
                            $estado = $resquery['est_solicitud'];
                            
                            if($estado=="Pendiente"){
                                $query = mysqli_query($conn, "UPDATE cliente_tipo_equipamiento SET est_solicitud = 'Rechazado' WHERE nro_solicitud = '$solicitud'");
                            }
                            else{

                            }
                        }

                        if($rolsesion=="Informática" || $rolsesion=="Administrador"){ 
                            if(isset($_POST['cambio2'])){
                                $_SESSION['condicion'] = '0';
                                echo "<meta http-equiv='refresh' content='0'>";
                            } 
                                
                            
                    ?>
                <form method="POST" action="Solicitudes.php" id="formulario-modificar" enctype="multipart/form-data">
                <button type="submit" name="cambio2" class="btn btn-dark" role="button">
                    <?php if($_SESSION['idioma'] == "es"){ echo "Cambiar a Vista Oficina";} ?>
                    <?php if($_SESSION['idioma'] == "en"){ echo "Change to Office View";} ?>
                </button></form> <?php } ?>
                <div class="container">
                    <div class="px-3 py-3 pb-md-4 mx-auto text-center">
                        <h1 class="h1">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Solicitud de Equipamiento / Insumo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Equipment / Consumable Request";} ?>
                        </h1>
                    </div>
                    <table class="table">
                    <tr class="table-dark"><td class="px-4 fs-5">
                        <?php if($_SESSION['idioma'] == "es"){ echo "Opciones de Filtrado";} ?>
                        <?php if($_SESSION['idioma'] == "en"){ echo "Filter Options";} ?>
                    </td></tr>
                    <tr class="table-secondary"><td>
                    <form action="Solicitudes.php" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                    <label for="nombre" class="px-3">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Estado de la solicitud";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Request status";} ?>
                        </label>
                        <select name="filtro" id="filtro">
                            <option value="" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Filtrar por...";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Filter by..";} ?>
                            </option>
                            <option value="Aprobado">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Aprobado";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Approved";} ?></option>
                            <option value="Pendiente">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Pendiente";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Pending";} ?></option>
                            <option value="Rechazado">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Rechazado";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Rejected";} ?></option>
                        </select>
                        <button type="submit" name="aplicar" class="" role="button">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Aplicar Filtro";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Apply Filter";} ?>
                        </button>
                        <button type="submit" class="">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Restaurar filtro";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Restore filter";} ?>
                        </button>
                    </form></td></tr></table>
                    <table class="table">
                    <tr class="table-dark"><td class="px-4 fs-5">
                        <?php if($_SESSION['idioma'] == "es"){ echo "Opciones de búsqueda y acción";} ?>
                        <?php if($_SESSION['idioma'] == "en"){ echo "Search and action options";} ?>
                    </td></tr>
                    <tr class="table-secondary"><td>
                    <form action="Solicitudes.php" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                    <label for="nombre" class="px-3">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Número de solicitud";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Request number";} ?>
                        </label>
                        <input type="text" name="numero" id="numero" value="<?php echo $numero ?>">
                        <button type="submit" name="aplicar2" class="" role="button">
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
                                    <form action="Solicitudes.php" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                                    <label for="nombre">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Número de solicitud";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Request number";} ?>
                                    </label>
                                    <input type="text" name="nrosol" id="nrosol" class="form-control">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                <input type=submit name="aprobar" class="btn btn-md btn-success" value='<?php echo $aprobar?>'>
                                <input type=submit name="rechazar" class="btn btn-md btn-danger" value='<?php echo $rechazar?>'>
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
                            <td width="15%" scope="col"><?php if($_SESSION['idioma'] == "es"){ echo "Nro. Solicitud";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Request Number";} ?></td>
                            <td width="10%"><?php if($_SESSION['idioma'] == "es"){ echo "ID Cliente";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Client ID";} ?></td>
                            <td width="10%"><?php if($_SESSION['idioma'] == "es"){ echo "ID Sucursal";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Branch ID";} ?></td>
                            <td width="12%"><?php if($_SESSION['idioma'] == "es"){ echo "Estado Solicitud";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Request Status";} ?></td>
                            <td width="20%"><?php if($_SESSION['idioma'] == "es"){ echo "Motivo";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Reason";} ?></td>
                            <td width="10%"><?php if($_SESSION['idioma'] == "es"){ echo "Cantidad";} ?>
                                            <?php if($_SESSION['idioma'] == "en"){ echo "Amount";} ?></td>
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
                                $sql = "SELECT * FROM cliente_tipo_equipamiento WHERE subdireccion = 'A' ORDER BY nro_solicitud DESC";
                                $query = $conn-> query($sql);
                            }
                            if($filtro=="Aprobado"){
                                $sql = "SELECT * FROM cliente_tipo_equipamiento WHERE subdireccion = 'A' AND est_solicitud = 'Aprobado' ORDER BY nro_solicitud DESC";
                                $query = $conn-> query($sql);
                            }
                            if($filtro=="Rechazado"){
                                $sql = "SELECT * FROM cliente_tipo_equipamiento WHERE subdireccion = 'A' AND est_solicitud = 'Rechazado' ORDER BY nro_solicitud DESC";
                                $query = $conn-> query($sql);
                            }
                            if($filtro=="Pendiente"){
                                $sql = "SELECT * FROM cliente_tipo_equipamiento WHERE subdireccion = 'A' AND est_solicitud = 'Pendiente' ORDER BY nro_solicitud DESC";
                                $query = $conn-> query($sql);
                            }
                            if(isset($_POST['aplicar2'])){
                                $solicitud = $_POST['numero'];
    
                                $sql = "SELECT * FROM cliente_tipo_equipamiento WHERE nro_solicitud = '$solicitud' AND subdireccion = 'A'";
                                $query = $conn-> query($sql);
                            }
                            ?> <form method="POST" action="Solicitudes.php" id="formulario-modificar" enctype="multipart/form-data"><?php
                            if($query-> num_rows > 0){
                                while ($row = $query-> fetch_assoc()){
                                    $serie = $row['nro_solicitud'];
                                    $fecha = date('d-m-Y H:i:s', strtotime($row["fecha"]));
                                    ?><tr <?php if($row['est_solicitud']=='Aprobado'){echo "class=table-success";}; if($row['est_solicitud']=='Rechazado'){echo "class=table-danger";}?>><?php echo "<td>". $row["nro_solicitud"] ."</td><td>". $row["id_cliente"] ."</td><td>". $row["id_sucursal"] ."</td><td>". $row["est_solicitud"] ."</td><td>". $row["motivo"] ."</td><td>". $row["cantidad"] ."</td><td>". $fecha ."</td></tr>";
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