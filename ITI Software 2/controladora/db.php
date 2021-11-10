<?php
    session_start();
    $conn = mysqli_connect(
        $ipadress='localhost',
        'root',
        '',
        'itisoftware'
        
    );
    $_SESSION['ipadress']=$ipadress;
?>