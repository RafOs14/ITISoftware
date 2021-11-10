<?php include("controladora/db.php") ?>
<?php
	//Se inicia una sesión dummy para vaciar sus variables y luego ser destruída, 
	//esto es para que al cerrar sesión un tercero no pueda regresar a la página anterior del navegador 
	//en una sesión que no le corresponda
	
	//Ahora iniciamos una sesión nueva y creamos una variable que se moverá entre las distintas páginas del sitio
	//Esta variable almacenará el rol con el que entrará el usuario actual en el login
	$rolsesion="";
	if (!isset($_SESSION['idioma'])){
		$_SESSION['idioma'] = "es";}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		
		<!-- Bootstrap CSS -->
    	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css"/> 
    	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    	<script src="https://kit.fontawesome.com/8b5fc6bcd0.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="css/estilologin.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Login</title>
	</head>

	<body>

	<?php
		//Una vez demos en el botón "Conectarse" se tomarán los datos ingresados en "usuario" y "contraseña" y se enviarán a sus variables
		if (isset($_POST['login'])){
			$usuario = $_POST['usuario'];
			$pass = $_POST['pass'];
			$rolsesion = "";
			//Se hace una consulta a la base de datos que constará de la conexión, más la búsqueda de todos los datos de la tabla usuarios
			//donde la cédula ingresada coincida con alguna fila de la tabla "cedula"
			$queryusuario = mysqli_query($conn, "SELECT * FROM usuarios WHERE cedula = '$usuario'");
			//Guardamos en una variable la cantidad de líneas encontradas donde la cédula ingresada haya coincidido con la de la tabla
			$nrows = mysqli_num_rows($queryusuario);
			//Buscamos los datos en esa fila y los guardamos en un array donde podremos usarlos luego según su columna en la tabla
			$buscarpass = mysqli_fetch_array($queryusuario);
			//Buscamos en el array guardado en la columna "rol" el dato que correspondería al rol del usuario que pretenda ingresar
			$rolsesion = $buscarpass['rol'];
			$idsesion = $buscarpass['id'];
			$nombresesion = $buscarpass['nombre'];
			$apellidossesion = $buscarpass['apellido'];
			if(strpos($apellidossesion, " ")===true){
				$apellidosesion = $idapellidosesion;
			}
			else{
				$apellidos = explode(" ", $apellidossesion);
				$apellidosesion = $apellidos[0];
			}
			//Guardamos ese dato de rol en un array asociativo que nos permitirá enviar el dato de ese rol al resto de las páginas del sitio
			$_SESSION['rolsesion']=$rolsesion;
			$_SESSION['id']=$idsesion;
			$_SESSION['nombre']=$nombresesion;
			$_SESSION['apellido']=$apellidosesion;
			//Se evalúa si existe una línea que haya coincidido con la cédula ingresada, y se compara la contraseña ingresada
			//con la decodificación de la contraseña almacenada en la columna "pass" de la tabla de usuarios
			if (($nrows == 1) && (password_verify($pass, $buscarpass['pass']))){
					//Si tanto la cédula como la contraseña no presentan errores, seremos enviados al menú principal logueados con el rol correspondiente
					header('Location: MenuPrincipal.php');
			}			
			else{
				//Si alguno de los datos está mal, saltará un error y nos devolverá al Login nuevamente
				echo "<script>alert('El usuario o la contraseña son incorrectas');window.location='Login.php'</script>";
			}
		}

	?>
		<!-- Aquí estará el formulario de ingreso -->
        <section class="contenedor">
		    <div class="form">
				<img class="mb-5" src="img/logofinal2.png" alt="logo">
					<br>
			    <form class="login-form" action="Login.php" method="post">
					<div class="form-control btn-dark-md" >
						<div class="fw-bold fs-3 " >
							
						<!--<div class="fs-5 font-monospace text-warning">-->
							<div class="d-flex justify-content-center">
							<!--<a href="Modelos/Idioma.php?idi=es" style="text-decoration:none">Español</a>
							<a href="Modelos/Idioma.php?idi=en" style="text-decoration:none">English</a></div>-->								
								<a href="Modelos/Idioma.php?idi=es" style="text-decoration:none"><img style="width:45px; height: 45px; margin:5px" src="img/espana.png" alt="español"></a>							
								<a href="Modelos/Idioma.php?idi=en" style="text-decoration:none"><img style="width:45px; height: 45px; margin:5px" src="img/eeuu.png" alt="ingles"></a></div>								
							</div>
					<br>
			    	<div class="form-floating mb-3">
  						<input type="nombre" class="form-control" id="floatingInput" name="usuario" placeholder="Usuario" required>
  						<label for="floatingInput">
							<?php if($_SESSION['idioma'] == "es"){ echo "Usuario";} ?>
							<?php if($_SESSION['idioma'] == "en"){ echo "User";} ?>
						</label>
					</div>
					<div class="form-floating">
  						<input type="password" class="form-control" id="floatingPassword" name="pass" placeholder="Password" required>
  						<label for="floatingPassword">
							<?php if($_SESSION['idioma'] == "es"){ echo "Contraseña";} ?>
							<?php if($_SESSION['idioma'] == "en"){ echo "Password";} ?>
						</label>
					</div>
					<br>
					<input type="hidden" name="rolsesion" value="<?php echo ($rolsesion)?>">
			    	<div class="login">
					    <input class="btn btn-primary btn-lg" type="submit" name="login" 
							value=<?php if($_SESSION['idioma'] == "es"){ echo "Ingresar";} ?>
								<?php if($_SESSION['idioma'] == "en"){ echo "Login";} ?>>
				    </div>					
			    </form>
		    </div>
        </section>
    	
    	<!-- Option 1: Bootstrap Bundle with Popper -->
    	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    
	</body>
</html>