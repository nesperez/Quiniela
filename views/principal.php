<?php include ("./top.php");
#include ("../core/jarvis.php");



session_start();
if (isset($_SESSION['usuario'])) {
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reporte Facturas</title>
    <link rel="stylesheet" href="estilo.css">
  </head>
  <body>
  <form action="../core/jarvis.php" class="formulario" method="post">
    <h1 class="formulario__titulo">Reporte por Conceptos</h1>
    <input type="submit" class="formulario__submit"></input>
  </form>
  </body>
  </html>
  <?php
}else{
header('Location: ../index.php');
}
 ?>
