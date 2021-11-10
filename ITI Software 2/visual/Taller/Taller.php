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
            <?php if($_SESSION['idioma'] == "es"){ echo "Taller | Altas";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Workshop | Register";} ?>
        </title>
    </head>
    
    <body>
        <?php
            $errores="";
            $query = "SELECT * FROM tipo_equipamiento";
            $tipoeq = mysqli_query($conn, $query);

            if(isset($_POST['confirmar'])){
                $errores = "";
                $serie = $_POST['serie'];
                $nombre = $_POST['nombre'];
                $tipo = $_POST['tipo'];
                $producto = $_POST['producto'];
                $marca = $_POST['marca'];
                $numero = $_POST['numero'];
                $rut = $_POST['rut'];
                $plazo = $_POST['plazo'];
                $garantia = date('Y-m-d', strtotime($_POST['garantia']));  
                $busqueda = mysqli_query($conn, "SELECT * FROM tipo_equipamiento WHERE id = '$producto'");
                $eltipo = mysqli_fetch_array($busqueda);
                $tipodeeq = $eltipo['descripcion'];
                if (empty($serie)){
                    if(!preg_match('/[A-Za-z]/', $serie)){
                        $errores = $errores . " <li>Debe ingresar un valor alfanumérico en serie</li>\n";
                    }
                    else{ 
                        $errores = $errores . " <li>Debe ingresar un valor en serie</li>\n";
                    }
                } 
                elseif(strlen($serie) != 8){
                    $errores = $errores . " <li>Debe ingresar un valor de 8 caractéres en serie</li>\n";
                }
                if (empty($nombre)){
                    $errores = $errores . " <li>Debe ingresar un valor en nombre</li>\n";
                }
                elseif(!preg_match('/[A-Za-z]/', $nombre)){
                    $errores = $errores . " <li>Debe ingresar un valor de texto en nombre</li>\n";
                }               
                if (empty($marca)){
                    $errores = $errores . " <li>Debe ingresar un valor en marca</li>\n";
                }
                elseif(!preg_match('/[A-Za-z]/', $marca)){
                    $errores = $errores . " <li>Debe ingresar un valor de texto en marca</li>\n";
                }                        
                if (empty($plazo)){
                    if(!is_numeric($plazo)){
                        $errores = $errores . " <li>Debe ingresar un valor numérico en RUT</li>\n";
                    }
                    else{ 
                        $errores = $errores . " <li>Debe ingresar un valor en RUT</li>\n";
                    }
                } 
                if (empty($numero)){
                    $errores = $errores . " <li>Debe ingresar un valor en teléfono</li>\n";
                }
                elseif(!preg_match("/^\+?[0-9]+$/",$numero)){
                    $errores = $errores . " <li>Debe ingresar un valor numerico en teléfono</li>\n";
                }
                if (empty($rut)){
                    if(!is_numeric($rut)){
                        $errores = $errores . " <li>Debe ingresar un valor numérico en RUT</li>\n";
                    }
                    else{ 
                        $errores = $errores . " <li>Debe ingresar un valor en RUT</li>\n";
                    }
                } 
                elseif(strlen($rut) != 12){
                    $errores = $errores . " <li>Debe ingresar un valor de 12 caractéres en RUT</li>\n";
                }

                if($errores != ""){
                    // Se muestran los errores al final del formulario
                    
                }
                else{
                    $queryeq = mysqli_query($conn, "SELECT * FROM tipo_equipamiento WHERE id = '$producto'");
                    $reseq = mysqli_fetch_array($queryeq);
                    $can = $reseq['cantidad'];

                    if($can>0){
                        // Se ingresan los datos en la base de datos y refresca el formulario//
                        $query = "INSERT INTO equipamiento(nro_serie, marca, tipo_equipamiento, plazo_garantia, nro_inventario, descripcion_tecnica, rut_proveedor, id_tipo_equipamiento, fecha_inicio_garantia) VALUES ('$serie', '$marca', '$tipodeeq', '$plazo', '$numero', '$nombre', '$rut', '$producto', '$garantia')";
                        $resultado = mysqli_query($conn, $query);
                        $can--;
                        if($tipo=="Equipamiento"){
                            $query = "INSERT INTO equipo(nro_serie_equipo) VALUES ('$serie')";
                            $resultado = mysqli_query($conn, $query);
                        }
                        if($tipo=="Insumo"){
                            $query = "INSERT INTO insumo(nro_serie_insumo) VALUES ('$serie')";
                            $resultado = mysqli_query($conn, $query);
                        }
                        $newquery = mysqli_query($conn, "UPDATE tipo_equipamiento SET cantidad = '$can' WHERE id = '$producto'");

                        if($rut!="100000000000"){
                        $timestamp = date("Y-m-d H:i:s");
                        $queryes = "INSERT INTO estado_equipamiento(id_estado, est_sucesor, nro_serie_equipo, fecha_inicio, fecha_fin) VALUES ('2', '1', '$serie', '$timestamp', '')";
                        $reses = mysqli_query($conn, $queryes);
                        }
                        header('Location: Taller.php');
                    }
                    else{
                        $errores = $errores . " <li>El valor del prestock del producto a altar es de 0</li>\n";
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
                            <?php if($_SESSION['idioma'] == "es"){ echo "Alta Equipamiento | Insumo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Register Equipment | Consumable";} ?>
                        </h1>
                    </div>
                    <form action="" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Nro. serie";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Serial number";} ?>
                        </label>
                        <input type="text" name="serie" id="serie" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Descripción del Equipamiento | Insumo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Equipment | Consumable description";} ?>
                        </label>
                        <input type="text" name="nombre" id="nombre" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Tipo de producto";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Type of product";} ?>
                        </label>
                        <select name="tipo" id="tipo">
                            <option value="" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Seleccione tipo...";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Choose type..";} ?>
                            </option>
                            <option value="Equipamiento">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Equipamiento";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Equipment";} ?>
                            </option>
                            <option value="Insumo">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Insumo";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Consumable";} ?>
                            </option>                        
                        </select>
                        <br>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "ID del producto";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Product's ID";} ?>
                        </label>
                        <select name="producto" id="producto">
                            <option value="" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Seleccione ID...";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Choose ID..";} ?>
                            </option>
                            <?php while($columnas = mysqli_fetch_array($tipoeq)):; ?>
                            <option value="<?php echo $columnas[0]; ?>"><?php 
                                if($_SESSION['idioma'] == "es"){ echo "$columnas[0] - $columnas[2]";} 
                                if($_SESSION['idioma'] == "en"){ echo "$columnas[0] - $columnas[3]";}?></option>
                            <?php endwhile; ?>
                        </select>
                        <br>
                        <br> 
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Marca";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Brand";} ?>
                        </label>
                        <input type="text" name="marca" id="marca" class="form-control">
                        <br> 
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Nro. de inventario";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Inventary number";} ?>
                        </label>
                        <input type="text" name="numero" id="numero" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "RUT proveedor";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Vendor's RUT";} ?>
                        </label>
                        <input type="text" name="rut" id="rut" class="form-control">
                        <br> 
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Plazo garantía (Meses)";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Warranty period (Months)";} ?>
                        </label>
                        <input type="text" name="plazo" id="plazo" class="form-control">
                        <br>                  
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Plazo inicio garantía";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Warranty start period";} ?>
                        </label>
                        <input type="date" name="garantia" id="garantia" class="form-control" max="<?php echo date("Y-m-d"); ?>">
                        <br>                    
                        <button type="submit" name="confirmar" class="btn btn-primary">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Confirmar";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Confirm";} ?>
                        </button>
                        <button type="submit" name="cancelar" class="btn btn-danger">
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
                </div>      
            </div>
        </div>
        <?php include("../../Modelos/Scripts.php") ?>
    </body>
</html>