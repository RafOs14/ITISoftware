<div class="collapse navbar-collapse justify-content-md-end" id="navBarUserInfo">
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item  mb-3 active">                      
            <a class="nav-link">
                <?php if($_SESSION['idioma'] == "es"){ echo "Bienvenido";} ?>
                <?php if($_SESSION['idioma'] == "en"){ echo "Welcome";} ?> <?php echo "$nombresesion"?>
            </a>                                
        </li>
        <li class="nav-item mb-3"> 
            <a class="nav-link"><?php echo "$apellidosesion"?></a>
        </li>
        <li class="nav-item mb-3">
            <a class="nav-link">ID <?php echo "$idsesion"?></a>
        </li>                            
    </ul>                            
</div>