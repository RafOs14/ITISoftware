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
            <?php if($_SESSION['idioma'] == "es"){ echo "Modificar Usuario";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Modify User";} ?>
        </title>
    </head>

    <body>

        <?php
            //Estas variables son para generar los campos vacíos en los datos que buscaremos y mostraremos de la tabla usuarios
            $ced="";
            $oldced="";
            $oldnombre="";
            $oldsegundonombre="";
            $oldapellido="";
            $oldrol="";
            $errores = "";

            //Se pretende mostrar los datos actuales previo a la modificación
            if(isset($_POST['buscar'])){
                $ced = $_POST['cedula'];
                $oldced = $_POST['old-cedula'];
                $oldnombre = $_POST['old-nombre'];
                $oldsegundonombre = $_POST['old-segundonombre'];
                $oldapellido = $_POST['old-apellido'];
                $oldrol = $_POST['old-rol'];
                $errores = "";

                if (empty($ced)){
                    if(!is_numeric($ced)){
                        $errores = $errores . " <li>Debe ingresar un valor numérico en \"Ingrese la cédula\"</li>\n";
                    }
                    else{ 
                        $errores = $errores . " <li>Debe ingresar un valor en cédula</li>\n";
                    }
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
                        $oldced = $row['cedula'];
                        $oldnombre = $row['nombre'];
                        $oldsegundonombre = $row['segundo_nombre'];
                        $oldapellido = $row['apellido'];
                        $oldrol = $row['rol'];
                        
                    }
                    else{
                        //En caso de ingresar una cédula errónea se mostrará al final del formulario el siguiente mensaje y el campo de cédula se vaciará
                        $errores = "<li>La cédula no existe en la base de datos</li>\n";
                        $ced = "";
                    }
                }
            }

            //En esta parte se evaluarán los datos al apretar el botón de Confirmar
            
            //La modificación de datos se realiza acá
            if(isset($_POST['confirmar'])){
                $newced = $_POST['new-cedula'];
                $oldced = $_POST['old-cedula'];
                $nombre = $_POST['nombre'];
                $segundonombre = $_POST['segundonombre'];
                $apellido = $_POST['apellido'];
                $rol = $_POST['rol'];
                $oldnombre = $_POST['old-nombre'];
                $oldsegundonombre = $_POST['old-segundonombre'];
                $oldapellido = $_POST['old-apellido'];
                $oldrol = $_POST['old-rol'];
                $errores = "";

                if(empty($newced)){
                    $newced = "0";
                }

                $query = "SELECT * FROM usuarios WHERE cedula = $newced";
                $resultado = mysqli_query($conn, $query);
                if(mysqli_num_rows($resultado) == 1){
                    echo "<script>alert('La cédula introducida ya existe')</script>";
                }
                else{
                    
                    if (empty($newced)){
                        if(empty($oldced)){
                            $errores = $errores . " <li>Debe ingresar un valor en cédula</li>\n";
                        }
                        else{
                           $newced = $oldced; 
                        }
                        
                    }
                    elseif(!is_numeric($newced)){
                        $errores = $errores . " <li>Debe ingresar un valor numérico en cédula</li>\n";
                    }
                    elseif(strlen($newced) != 8){
                        $errores = $errores . " <li>Debe ingresar un valor de 8 caractéres en cédula</li>\n";
                    }
                    if (empty($nombre)){
                        $nombre = $oldnombre;
                    }
                    elseif(!ctype_alpha($nombre)){
                        $errores = $errores . " <li>Debe ingresar un valor de texto en nombre</li>\n";
                    }
                    if (empty($segundonombre)){
                        $segundonombre = $oldsegundonombre;
                    }
                    elseif(!ctype_alpha($segundonombre)){
                        $errores = $errores . " <li>Debe ingresar un valor de texto en segundo nombre</li>\n";
                    }
                    if (empty($apellido)){
                        $apellido = $oldapellido;
                    }
                    elseif(!preg_match("/^[a-zA-Z\s]+$/",$apellido)){
                        $errores = $errores . " <li>Debe ingresar un valor de texto en apellidos</li>\n";
                    }
                    if(empty($rol)){
                        $rol = $oldrol;
                    }
                    
                    if($errores != ""){
                        // Se muestran los errores al final del formulario
                        
                    }
                    else{
                        //Si no hay errores, se actualizan los datos nuevos ingresados y se sobreescriben los anteriores en la tabla usuarios
                        $query = "UPDATE usuarios SET cedula = '$newced', nombre = '$nombre', segundo_nombre = '$segundonombre', apellido = '$apellido', rol = '$rol' WHERE cedula = $oldced";
                        mysqli_query($conn, $query);

                        //Finalmente se refresca la página
                        header('Location: ModUser.php');
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
                            <?php if($_SESSION['idioma'] == "es"){ echo "Modificar Usuario";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Modify User";} ?>
                        </h1>
                    </div>
                    <form method="POST" id="formulario-modificar" enctype="multipart/form-data">
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Ingrese la cédula";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Register ID card";} ?>
                        </label>
                        <input type="text" name="cedula" id="cedula-modificar" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Ingrese la cédula nueva";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Register new ID card";} ?>
                        </label>
                        <input type="text" name="new-cedula" id="cedula-modificar"
                            class="form-control">
                        
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Cédula antigua";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Old ID card";} ?>
                        </label>
                        <br>
                        <!-- En estos inputs haremos un echo de las variables que tendrán los datos actuales de la cédula ingresada -->
                        <input type="text" name="old-cedula" id="cedula-modificar2"
                            class=".form-control-sm" placeholder="" readonly value="<?php echo $oldced ?>">
                        <br>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Ingrese el nombre nuevo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Register new name";} ?>
                        </label>
                        <input type="text" name="nombre" id="nombre-modificar" class="form-control">
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Nombre antiguo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Old name";} ?>
                        </label>
                        <br>
                        <input type="text" name="old-nombre" id="nombre-modificar"
                            class=".form-control-sm" readonly value="<?php echo $oldnombre ?>">
                        <br>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Ingrese el nuevo segundo nombre";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Register new secondary name";} ?>
                        </label>
                        <input type="text" name="segundonombre" id="segundonombre-modificar" class="form-control">
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Segundo nombre antiguo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Old secondary name";} ?>
                        </label>
                        <br>
                        <input type="text" name="old-segundonombre" id="segundonombre-modificar"
                            class=".form-control-sm" readonly value="<?php echo $oldsegundonombre ?>">
                        <br>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Ingrese el apellido nuevo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Register new last name";} ?>
                        </label>
                        <input type="text" name="apellido" id="apellido-modificar" class="form-control">
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Apellido antiguo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Old last name";} ?>
                        </label>
                        <br>
                        <input type="text" name="old-apellido" id="apellido-modificar"
                            class=".form-control-sm" readonly value="<?php echo $oldapellido ?>">
                        <br>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "ROL antiguo";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Old ROL";} ?>
                        </label>
                        <br>                                                        
                        <input type="text" name="old-rol" id="rol-modificar" readonly value="<?php echo $oldrol ?>">
                        <br>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Seleccione el nuevo ROL ";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Choose a new ROL ";} ?>
                        </label>
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
                            <option value="Operador">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Operador";} ?>
							    <?php if($_SESSION['idioma'] == "en"){ echo "Operator";} ?>
                            </option>
                            <option value="Oficina">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Oficina";} ?>
							    <?php if($_SESSION['idioma'] == "en"){ echo "Office";} ?>
                            </option>
                            <option value="Gerencia">Gerencia</option>
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