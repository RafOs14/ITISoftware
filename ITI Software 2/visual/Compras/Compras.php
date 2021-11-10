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
            <?php if($_SESSION['idioma'] == "es"){ echo "Ingreso de Compras";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Purchases Entries";} ?>
        </title>
    </head>
    
    <body>
        <?php
            $can="";
            $errores="";
            $opciones="";
            $contador="";
            $query = "SELECT * FROM tipo_equipamiento";
            $tipoeq = mysqli_query($conn, $query);
            while($lineas = mysqli_fetch_array($tipoeq)){
                if($_SESSION['idioma'] == "es"){ $opciones = $opciones."<option value=$lineas[0]>$lineas[2]</option>";}
                if($_SESSION['idioma'] == "en"){ $opciones = $opciones."<option value=$lineas[0]>$lineas[3]</option>";}
                }
            if($_SESSION['idioma'] == "es"){
                $idioma = "Agregar línea";
                $eliminar = "Borrar";
              }
            if($_SESSION['idioma'] == "en"){ 
                $idioma =  "Add row";
                $eliminar = "Delete";
            }
            $query = "SELECT * FROM tipo_equipamiento";
            $tipoeq = mysqli_query($conn, $query);
            $lineas = mysqli_num_rows($tipoeq);

            if(isset($_POST['confirmar'])){
                $contador = $_POST['contador'];
                $i = 1;
                $o = 1;
                $orden = $_POST['orden'];
                $proveedor = $_POST['proveedor'];
                $tipo = $_POST['tipo'];
                $cantidad = $_POST['cantidad'];
                $precio = $_POST['precio'];
                $fecha = date('Y-m-d', strtotime($_POST['fecha']));
                $compra = $_POST['compra'];

                $query = "INSERT INTO proveedor_tipo_equipamiento(nro_orden, rut_proveedor, id_tipo_equipamiento, precio, cantidad, fecha, tipo_compra) VALUES ('$orden', '$proveedor', '$tipo', '$precio', '$cantidad', '$fecha', '$compra')";
                $resultado = mysqli_query($conn, $query);

                $queryeq = mysqli_query($conn, "SELECT * FROM tipo_equipamiento WHERE id = '$tipo'");
                $reseq = mysqli_fetch_array($queryeq);
                $can = $reseq['cantidad'];
                $can = $can+$cantidad;

                $newquery = mysqli_query($conn, "UPDATE tipo_equipamiento SET cantidad = '$can' WHERE id = '$tipo'");

                while($i < $contador && $o < 100){
                    if(empty($_POST["tipo$o"])){
                        $o++;
                    }
                    else{
                        $tipo = $_POST["tipo$o"];
                        $cantidad = $_POST["cantidad$o"];
                        $precio = $_POST["precio$o"];
                        $query = "INSERT INTO proveedor_tipo_equipamiento(nro_orden, rut_proveedor, id_tipo_equipamiento, precio, cantidad, fecha, tipo_compra) VALUES ('$orden', '$proveedor', '$tipo', '$precio', '$cantidad', '$fecha', '$compra')";
                        $resultado = mysqli_query($conn, $query);

                        $queryeq = mysqli_query($conn, "SELECT * FROM tipo_equipamiento WHERE id = '$tipo'");
                        $reseq = mysqli_fetch_array($queryeq);
                        $can = $reseq['cantidad'];
                        $can = $can+$cantidad;

                        $newquery = mysqli_query($conn, "UPDATE tipo_equipamiento SET cantidad = '$can' WHERE id = '$tipo'");
                        $o++;
                        $i++;
                    }
                }
                header('Location: Compras.php');
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
                            <?php if($_SESSION['idioma'] == "es"){ echo "Ingreso de Compras";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Purchases Entries";} ?>
                        </h1>
                    </div>
                    <form action="Compras.php" method="POST" id="formulario-modificar" enctype="multipart/form-data">
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Orden de compra";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Purchase order";} ?>
                        </label>
                        <input type="text" name="orden" id="orden" class="form-control">
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "RUT proveedor";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Vendor's RUT";} ?>
                        </label>
                        <input type="text" name="proveedor" id="proveedor" class="form-control">
                        <br>
                        <div class="container">
                        <table id="myTable" class="table order-list">
                            <thead>
                                <tr>
                                    <td>
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Introduzca tipo de insumo...";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Register consumable type";} ?>
                                    </td>
                                    <td>
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Cantidad";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Quantity";} ?>
                                    </td>
                                    <td>
                                        <?php if($_SESSION['idioma'] == "es"){ echo "Precio";} ?>
                                        <?php if($_SESSION['idioma'] == "en"){ echo "Price";} ?>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-sm-4">
                                    <select class="form-control" name="tipo" id="tipo">
                                        <?php echo $opciones ?>
                                    </select>
                                    </td>
                                    <td class="col-sm-4">
                                    <input type="text" name="cantidad"  class="form-control"/>
                                    </td>
                                    <td class="col-sm-3">
                                    <input type="text" name="precio" id="precio" class="form-control">
                                    </td>
                                    <td class="col-sm-2"><a class="deleteRow"></a>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" style="text-align: center;">
                                    <input type="button" class="btn btn-lg bg-success text-light btn-block " id="addrow" value="<?php echo $idioma ?>" />
                                        <!--<input type="button" class="btn btn-lg bg-success text-light btn-block " id="addrow" value="Add Row" />-->
                                    </td>
                                </tr>
                                <tr>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                        <br>
                        <label for="nombre">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Fecha";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Date";} ?>
                        </label>
                        <input type="date" name="fecha" id="fecha" class="form-control" max="<?php echo date("Y-m-d"); ?>">
                        <br>
                        <label for="com">
                            <?php if($_SESSION['idioma'] == "es"){ echo "Tipo de adquisición";} ?>
                            <?php if($_SESSION['idioma'] == "en"){ echo "Type of acquisition";} ?>
                        </label>
                        <select name="compra" id="compra">
                            <option value="" selected>
                                <?php if($_SESSION['idioma'] == "es"){ echo "Seleccione tipo de adquisición...";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Select type of acquisition..";} ?>
                            </option>
                            <option value="Compra Directa">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Compra directa";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Direct purchase";} ?>
                            </option>
                            <option value="Licitación">
                                <?php if($_SESSION['idioma'] == "es"){ echo "Licitación";} ?>
                                <?php if($_SESSION['idioma'] == "en"){ echo "Bidding";} ?>
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
                        <input type="hidden" name="contador" id="contador">
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
        <script>$(document).ready(function () {
            var counter = 1;
            var columnas = 1;
            $( "#contador" ).val(columnas);

            $("#addrow").on("click", function () {
                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><select class="form-control" name="tipo' + counter + '"><?php echo $opciones ?></select></td>';
                cols += '<td><input type="text" class="form-control" name="cantidad' + counter + '"/></td>';
                cols += '<td><input type="text" class="form-control" name="precio' + counter + '"/></td>';
                cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="<?php echo $eliminar ?>"></td>';
                newRow.append(cols);
                $("table.order-list").append(newRow);
                columnas++;
                counter++;
                $( "#contador" ).val(columnas);
            });



            $("table.order-list").on("click", ".ibtnDel", function (event) {
                $(this).closest("tr").remove();
                columnas -= 1
                $( "#contador" ).val(columnas);
            });

            });
        </script>
    </body>
</html>