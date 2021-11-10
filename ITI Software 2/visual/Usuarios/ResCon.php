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
            <?php if($_SESSION['idioma'] == "es"){ echo "Restablecer Contraseña";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Restore Password";} ?>
        </title>
    </head>

    <body>

        <?php
            $ced = "";
            $nombre = "";
            $errores = "";

            //Acá se mostrará el nombre del usuario cuya contraseña fue ingresada
            if(isset($_POST['mostrar'])){
                $ced = $_POST['cedula'];
                $id = "";
                $nombre = "";
                $errores = "";

                if (empty($ced)){
                    $errores = $errores . " <li>Debe ingresar un valor en cédula</li>\n";
                } 
                elseif(!is_numeric($ced)){
                    $errores = $errores . " <li>Debe ingresar un valor numérico en \"Ingrese la cédula\"</li>\n";
                }                    
                elseif(strlen($ced) != 8){
                    $errores = $errores . " <li>Debe ingresar un valor de 8 caractéres en cédula</li>\n";
                }

                if($errores != ""){
                    // Se muestran los errores al final del formulario
                    
                }
                else{
                    $query = "SELECT * FROM usuarios WHERE cedula = $ced";
                    $resultado = mysqli_query($conn, $query);
                    if(mysqli_num_rows($resultado) == 1){
                        $row = mysqli_fetch_array($resultado);
                        $id = $row['id'];
                        $nombre = $row['nombre'];                    
                    }
                    else{
                        $errores = " <li>La cédula no existe en la base de datos</li>\n";
                        $ced = "";
                    }
                }
                
            }
            
            if(isset($_POST['confirmar'])){
                if(empty($_POST['cedula'])){
                    $errores = $errores . " <li>Debe ingresar un valor en cédula</li>\n";
                }
                else{
                $ced = $_POST['cedula'];
                $pass = $_POST['pass'];
                $passenc = password_hash($pass,PASSWORD_DEFAULT);
                $errores = "";
                
                if(empty($pass)){
                    $errores = $errores . " <li>Debe ingresar un valor en contraseña</li>\n";
                }
                elseif(!preg_match('/[A-Za-z0-9]/', $pass)){
                    $errores = $errores . " <li>Debe ingresar un valor en alfanumérico en contraseña</li>\n";
                }
                elseif(strlen($pass) < 6){
                    $errores = $errores . " <li>Debe ingresar un valor de 6 caractéres o más en contraseña</li>\n";
                }
                
                if($errores != ""){
                    // Se muestran los errores al final del formulario
                    
                }
                else{
                    $query = "UPDATE usuarios SET pass = '$passenc' WHERE cedula = $ced";
                    mysqli_query($conn, $query);

                    header('Location: ResCon.php');
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
                            <?php if($_SESSION['idioma'] == "es"){ echo "Restablecer Contraseña";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Restore Password";} ?>
                        </h1>
                    </div>
                    <form method="POST" id="formulario-modificar" enctype="multipart/form-data">
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Ingrese la cédula";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Register ID card";} ?>
                        </label>
                        <input type="text" name="cedula" id="cedula" class="form-control" value="<?php echo $ced ?>">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Nombre";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Name";} ?>
                        </label>
                        <input type="text" name="nombre" id="nombre" class="form-control" readonly value="<?php echo $nombre ?>">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Nueva contraseña";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "New password";} ?>
                        </label>
                        <input type="text" name="pass" id="contrasena" class="form-control">
                        <br>
                        <br>
                        <br>
                        <button type="submit" name="confirmar" class="btn btn-primary">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Confirmar";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Confirm";} ?>
                        </button>
                        <input type="hidden" name="ced" id="act-cedula" class)="form-control">
                        <button type="submit" name="mostrar" id="action-modificar" class="btn btn-primary">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Mostrar";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Show";} ?></button>
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
                    
                </div>
            </div>
        </div>
        <?php include("../../Modelos/Scripts.php") ?>
    </body>
</html>