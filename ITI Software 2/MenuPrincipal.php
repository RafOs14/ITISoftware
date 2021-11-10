<?php include("controladora/db.php") ?>
<?php 
//Iniciaremos la sesión en este php y recibiremos el rol que enviamos desde el login, lo almacenaremos en $rolsesion
//Esto se realizará en todos los php de ahora en adelante
$rolsesion = $_SESSION['rolsesion'];
$idsesion = $_SESSION['id'];
$nombresesion = $_SESSION['nombre'];
$apellidosesion = $_SESSION['apellido'];
if (!isset($_SESSION['idioma'])){
    $_SESSION['idioma'] = "es";}
if(empty($rolsesion)){
  echo "<script>alert('No hay una sesión iniciada, vuelve a loguearte');window.location='Login.php'</script>";
} ?>
<!doctype html>
<html lang="en">
    
    <head>
        <?php include("Modelos/Head.php") ?>
        <title>
            <?php if($_SESSION['idioma'] == "es"){ echo "Menú Principal";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Main Menu";} ?>
        </title>
    </head>

    <body>
        <div class="wrapper">
            <?php include("Modelos/BarraLateral.php") ?>

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

                        
                        <?php include("Modelos/UserInfo.php") ?>
                    </div>
                </nav>
            </div>
        </div>
        <?php include("Modelos/Scripts.php") ?>
    </body>
</html>