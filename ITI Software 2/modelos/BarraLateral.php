<?php $ipadress = $_SESSION['ipadress'] ?>
<?php 
    if (!isset($_SESSION['idioma'])){
		$_SESSION['idioma'] = "es";
    }?>
<nav id="sidebar">
    <div class="sidebar-header">
        <a href="<?php $ipadress?>/ITI%20Software%202/MenuPrincipal.php"><img class="logo" src="<?php $ipadress?>/ITI%20Software%202/img/logobarra.jpg" alt=""></a>
    </div>

    <ul class="list-unstyled components">
        <!-- En esta barra lateral se evaluará el rol que haya guardado en $rolsesion, 
        dependiendo de su valor, podremos ver o interactuar con las siguientes opciones del menú -->
        <p><a href="<?php $ipadress?>/ITI%20Software%202/MenuPrincipal.php" style="color: white;">
            <?php if($_SESSION['idioma'] == "es"){ echo "Menú Principal";} ?>
            <?php if($_SESSION['idioma'] == "en"){ echo "Main Menu";} ?></a></p>
        <li>
            <?php if($rolsesion == 'Administrador' || $rolsesion == 'Informática' || $rolsesion == 'Compras' || $rolsesion == 'Taller'){ 
                if($rolsesion == 'Taller'){ ?>
                <a href="<?php $ipadress?>/ITI%20Software%202/Visual/Compras/ComprasProveedores.php"><i class="fas fa-barcode"></i>
                <?php if($_SESSION['idioma'] == "es"){ echo "Compras";} ?>
                <?php if($_SESSION['idioma'] == "en"){ echo "Purchases";} ?></a><?php 
                }   else{ ?>
            <a href="<?php $ipadress?>/ITI%20Software%202/Visual/Compras/Compras.php"><i class="fas fa-barcode"></i>
                <?php if($_SESSION['idioma'] == "es"){ echo "Compras";} ?>
                <?php if($_SESSION['idioma'] == "en"){ echo "Purchases";} ?></a>
            <?php } }?>                 
        </li>
        <li>
        <?php if($rolsesion == 'Administrador' || $rolsesion == 'Informática' || $rolsesion == 'Auditoría' || $rolsesion == 'Subdirección B'){ ?>
            <a href="<?php $ipadress?>/ITI%20Software%202/Visual/Auditoria/Auditoria.php"><i class="fas fa-folder-open"></i>
                <?php if($_SESSION['idioma'] == "es"){ echo "Auditoría";} ?>
                <?php if($_SESSION['idioma'] == "en"){ echo "Audit";} ?></a>
            <?php }?>
        </li>
        <li>
            <?php if($rolsesion == 'Administrador' || $rolsesion == 'Taller' || $rolsesion == 'Informática' || $rolsesion == 'Oficina' || $rolsesion == 'Subdirección A' || $rolsesion == 'Subdirección B' || $rolsesion == 'Compras'){
                if($rolsesion == 'Compras' || $rolsesion == 'Subdirección B'){
                    ?><a href="<?php $ipadress?>/ITI%20Software%202/Visual/Solicitudes/SolicitudesCompras.php"><i class="fas fa-envelope"></i>
                    <?php if($_SESSION['idioma'] == "es"){ echo "Solicitudes";} ?>
                <?php if($_SESSION['idioma'] == "en"){ echo "Requests";} ?></a><?php 
                }   elseif($rolsesion == 'Taller'){ ?>
                    <a href="<?php $ipadress?>/ITI%20Software%202/Visual/Solicitudes/SolicitudesFallas.php"><i class="fas fa-envelope"></i>
                    <?php if($_SESSION['idioma'] == "es"){ echo "Solicitudes";} ?>
                <?php if($_SESSION['idioma'] == "en"){ echo "Requests";} ?></a><?php 
                    }   else{ ?>
            <a href="<?php $ipadress?>/ITI%20Software%202/Visual/Solicitudes/Solicitudes.php"><i class="fas fa-envelope"></i>
                <?php if($_SESSION['idioma'] == "es"){ echo "Solicitudes";} ?>
                <?php if($_SESSION['idioma'] == "en"){ echo "Requests";} ?></a> 
            <?php } }?>                    
        </li>
        <li>
            <?php if($rolsesion == 'Administrador' || $rolsesion == 'Informática' || $rolsesion == 'Taller'){ ?>
            <a href="<?php $ipadress?>/ITI%20Software%202/Visual/Taller/Taller.php"><i class="fas fa-wrench"></i>
                <?php if($_SESSION['idioma'] == "es"){ echo "Taller";} ?>
                <?php if($_SESSION['idioma'] == "en"){ echo "Workshop";} ?></a>
            <?php }?>
        </li>                
        <li >
            <?php if($rolsesion == 'Administrador' || $rolsesion == 'Informática'){ ?>
            <a href="<?php $ipadress?>/ITI%20Software%202/Visual/Usuarios/AddUser.php"><i class="far fa-user"></i>
                <?php if($_SESSION['idioma'] == "es"){ echo "Usuarios";} ?>
                <?php if($_SESSION['idioma'] == "en"){ echo "Users";} ?></a>
            <?php }?>
        </li>                
    </ul>

    <ul class="list-unstyled CTAs">
        <li>
            <a href="<?php $ipadress?>/ITI%20Software%202/Modelos/SesionDes.php" class="download">
                <?php if($_SESSION['idioma'] == "es"){ echo "Cerrar Sesión";} ?>
                <?php if($_SESSION['idioma'] == "en"){ echo "Log Out";} ?></a>                    
        </li>                
    </ul>
</nav>