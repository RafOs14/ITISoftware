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
            <?php if($_SESSION['idioma'] == "es"){ echo "Ingreso de Proveedores";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Vendors Entries";} ?>
        </title>
    </head>

    <body>
        <?php
            //Creamos la variable $errores que guardará cualquier error que surja durante el formulario
            $errores = "";

            //En esta parte se evaluarán los datos al apretar el botón de Confirmar
            if (isset($_POST['confirmar'])){
                $rut = $_POST['rut'];     
                $razon = $_POST['razon'];       
                $nombre = $_POST['nombre'];
                $direccion = $_POST['direccion'];
                $telefono = $_POST['telefono'];
                $email = $_POST['mail'];
                

                //Procederemos a validar los campos dependiendo de si están vacíos (Serán requeridos)
                //y si deberán ser numéricos, de letras, ambos, y el largo que requerirán
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
                if (empty($razon)){
                    $errores = $errores . " <li>Debe ingresar un valor en Razón Social</li>\n";
                }
                elseif(!preg_match('/[A-Za-z]/', $razon)){
                    $errores = $errores . " <li>Debe ingresar un valor de texto en Razón Social</li>\n";
                }  
                if (empty($nombre)){
                    $errores = $errores . " <li>Debe ingresar un valor en nombre</li>\n";
                }
                elseif(!ctype_alpha($nombre)){
                    $errores = $errores . " <li>Debe ingresar un valor de texto en nombre</li>\n";
                }           
                if(empty($direccion)){
                    $errores = $errores . " <li>Debe ingresar un valor en dirección</li>\n";
                }
                elseif(!preg_match('/[A-Za-z0-9]/', $direccion)){
                    $errores = $errores . " <li>Debe ingresar una dirección válida</li>\n";
                }
                if (empty($telefono)){
                    $errores = $errores . " <li>Debe ingresar un valor en teléfono</li>\n";
                }
                elseif(!preg_match("/^\+?[0-9]+$/",$telefono)){
                    $errores = $errores . " <li>Debe ingresar un valor numerico en teléfono</li>\n";
                }
                if (empty($email)){
                    $errores = $errores . " <li>Debe ingresar un valor en email</li>\n";
                }
                elseif(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",$email)){
                    $errores = $errores . " <li>Debe ingresar un email valido</li>\n";
                }
                

                if($errores != ""){
                    // Se muestran los errores al final del formulario
                    
                }else{
                    // Se ingresan los datos en la base de datos y refresca el formulario//
                    $query = "INSERT INTO proveedores(rut, razon, direccion, telefono, nombre, mail) VALUES('$rut', '$razon', '$direccion', '$telefono', '$nombre', '$email')";
                    $resultado = mysqli_query($conn, $query);

                    header('Location: ComprasProveedores.php');
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
                            <?php if($_SESSION['idioma'] == "es"){ echo "Ingreso de Proveedores";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Vendors Entries";} ?>
                        </h1>
                    </div>
                    <form method="POST" id="formulario-modificar" enctype="multipart/form-data">
                        <label for="nombre">RUT</label>
                        <input type="text" name="rut" id="rut" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Razón social";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Business name";} ?>
                        </label>
                        <input type="text" name="razon" id="razon" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Nombre";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Name";} ?>
                        </label>
                        <input type="text" name="nombre" id="nombre" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Dirección";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Address";} ?>
                        </label>
                        <input type="direccion" name="direccion" id="direccion" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Teléfono";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Phone number";} ?>
                        </label>
                        <input type="tel" name="telefono" id="telefono" class="form-control">
                        <br> 
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Dirección mail";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Mail address";} ?>
                        </label>
                        <input type="email" name="mail" id="mail" class="form-control">
                        <br>
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