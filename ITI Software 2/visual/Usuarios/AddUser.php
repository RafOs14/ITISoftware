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
            <?php if($_SESSION['idioma'] == "es"){ echo "Crear Usuario";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Add User";} ?>
        </title>
    </head>

    <body>
        <?php
            //Creamos la variable $errores que guardará cualquier error que surja durante el formulario
            $errores = "";
            $ced = "";

            //En esta parte se evaluarán los datos al apretar el botón de Confirmar
            if (isset($_POST['confirmar'])){
                $ced = $_POST['cedula'];
                $pass = $_POST['pass'];
                //Aquí se encriptará la contraseña ingresada y se guardará en una nueva variable llamada $passenc
                $passenc = password_hash($pass,PASSWORD_DEFAULT);
                $nombre = $_POST['nombre'];
                $segundonombre = $_POST['segundonombre'];
                $apellido = $_POST['apellido'];
                $rol = $_POST['rol'];
                
                if(empty($ced)){
                    $ced = "0";
                }

                $query = "SELECT * FROM usuarios WHERE cedula = $ced";
                $resultado = mysqli_query($conn, $query);
                if(mysqli_num_rows($resultado) == 1){
                    echo "<script>alert('La cédula introducida ya existe')</script>";
                }
                else{
                   //Procederemos a validar los campos dependiendo de si están vacíos (Serán requeridos)
                //y si deberán ser numéricos, de letras, ambos, y el largo que requerirán
                if (empty($ced)){
                    if(!is_numeric($ced)){
                        $errores = $errores . " <li>Debe ingresar un valor numérico en cédula</li>\n";
                    }
                    else{ 
                        $errores = $errores . " <li>Debe ingresar un valor en cédula</li>\n";
                    }
                } 
                elseif(strlen($ced) != 8){
                    $errores = $errores . " <li>Debe ingresar un valor de 8 caractéres en cédula</li>\n";
                }
                if(empty($pass)){
                    $errores = $errores . " <li>Debe ingresar un valor en contraseña</li>\n";
                }
                elseif(!preg_match('/[A-Za-z0-9]/', $pass)){
                    $errores = $errores . " <li>Debe ingresar un valor en alfanumérico en contraseña</li>\n";
                }
                elseif(strlen($pass) < 6){
                    $errores = $errores . " <li>Debe ingresar un valor de 6 caractéres o más en contraseña</li>\n";
                }
                if (empty($nombre)){
                    $errores = $errores . " <li>Debe ingresar un valor en nombre</li>\n";
                }
                elseif(!ctype_alpha($nombre)){
                    $errores = $errores . " <li>Debe ingresar un valor de texto en nombre</li>\n";
                }
                //El segundo nombre se valida a la inversa, si el campo tiene algún valor en vez de si estuviera vacío
                //debido a que el segundo nombre no es un campo obligatorio, si hay algún valor, se valida que hayan solo letras
                if (!empty($segundonombre)){
                    if(!ctype_alpha($segundonombre)){
                    $errores = $errores . " <li>Debe ingresar un valor de texto en segundo nombre</li>\n";
                    }
                }
                if (empty($apellido)){
                    $errores = $errores . " <li>Debe ingresar un valor en apellidos</li>\n";
                }
                elseif(!preg_match("/^[a-zA-Z\s]+$/",$apellido)){
                    $errores = $errores . " <li>Debe ingresar un valor de texto en apellidos</li>\n";
                }
                if(empty($rol)){
                    $errores = $errores . " <li>Debe seleccionar un rol</li>\n";
                }

                if($errores != ""){
                    // Se muestran los errores al final del formulario
                    
                }else{
                    // Se ingresan los datos en la base de datos y refresca el formulario//
                    $query = "INSERT INTO usuarios(rol, cedula, pass, nombre, segundo_nombre, apellido) VALUES('$rol', '$ced', '$passenc', '$nombre', '$segundonombre', '$apellido')";
                    $resultado = mysqli_query($conn, $query);

                    header('Location: AddUser.php');
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
                                    <a class="btn btn-outline-primary m-1" href="AddUser.php" role="button">
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Crear Usuario";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Add User";} ?>
                                    </a>
                                </li>
                                <li class="nav-item mb-3"> 
                                <a class="btn btn-outline-primary m-1" href="ModUser.php" role="button">
                                    <?php if($_SESSION['idioma'] == "es"){ echo "Modificar Usuario";} ?>
                                    <?php if($_SESSION['idioma'] == "en"){ echo "Modify User";} ?>
                                </a>
                                </li>
                                <li class="nav-item mb-3">                               
                                <a class="btn btn-outline-primary m-1" href="ResCon.php" role="button">
                                    <?php if($_SESSION['idioma'] == "es"){ echo "Restablecer Contraseña";} ?>
                                    <?php if($_SESSION['idioma'] == "en"){ echo "Restore Password";} ?>
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
                            <?php if($_SESSION['idioma'] == "es"){ echo "Crear Usuario";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Add User";} ?>
                        </h1>
                    </div>
                    <form action="AddUser.php" method="POST" id="formulario-crear" enctype="multipart/form-data">
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Ingrese la cédula";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Register ID card";} ?>
                        </label>
                        <input type="text" name="cedula" id="cedula" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Ingrese la contraseña";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Register password";} ?>
                        </label>
                        <input type="password" name="pass" id="pass" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Nombre";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Name";} ?>
                        </label>
                        <input type="text" name="nombre" id="nombre" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Segundo nombre";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Secondary name";} ?>
                        </label>
                        <input type="text" name="segundonombre" id="segundonombre" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Apellido";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Last name";} ?>
                        </label>
                        <input type="text" name="apellido" id="apellido" class="form-control">
                        <br>
                        <label for="nombre">ROL</label>
                        <select name="rol" id="rol">
                            <option value="" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Seleccione ROL...";} ?>
							    <?php if($_SESSION['idioma'] == "en"){ echo "Choose a ROL..";} ?>
                            </option>
                            <option value="Informática">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Informática";} ?>
							    <?php if($_SESSION['idioma'] == "en"){ echo "Computing";} ?>
                            </option>
                            <option value="Compras">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Compras";} ?>
							    <?php if($_SESSION['idioma'] == "en"){ echo "Purchases";} ?>
                            </option>
                            <option value="Taller">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Taller";} ?>
							    <?php if($_SESSION['idioma'] == "en"){ echo "Workshop";} ?>
                            </option>
                            <option value="Auditoría">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Auditoría";} ?>
							    <?php if($_SESSION['idioma'] == "en"){ echo "Audit";} ?>
                            </option>
                            <option value="Oficina">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Oficina";} ?>
							    <?php if($_SESSION['idioma'] == "en"){ echo "Office";} ?>
                            </option>
                            <option value="Subdirección A">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Subdirección A";} ?>
							    <?php if($_SESSION['idioma'] == "en"){ echo "Supervisory A";} ?>
                            </option>
                            <option value="Subdirección B">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Subdirección B";} ?>
							    <?php if($_SESSION['idioma'] == "en"){ echo "Supervisory B";} ?>
                            </option>                            
                        </select>
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