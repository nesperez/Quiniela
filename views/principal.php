<?php include ("./top.php"); ?>

<?php

session_start();
if (isset($_SESSION['usuario'])) {
    # code...
}else{
header('Location: ../index.php');
}
