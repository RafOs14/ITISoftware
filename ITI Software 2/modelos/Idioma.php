<?php 
    session_start();
    $idioma = $_GET['idi'];
	$_SESSION['idioma'] = $idioma;
    header("Location:../Login.php");
?>