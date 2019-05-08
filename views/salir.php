<?php
session_start();
date_default_timezone_set('America/Mexico_City');
$user=$_SESSION['usuario']['usuario'];
session_destroy();
header('Location: ../index.php');

 ?>
