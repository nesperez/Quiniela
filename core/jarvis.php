<?php
/*
Desarrolló: Pérez Castro Nestor Abel
Contacto:
  nesperez.17@gmail.com
Fecha: 08/05/2019
Version 0.1
Descripción:
Motor de busca y construccion de tablas
*/

#error_reporting(false);
ini_set('display_errors', '0');
$date_inicio = $_POST['fecha_inicio'];
$date_fin = $_POST['fecha_fin'];

$csv ="UUID, FECHA_EMISION,RFC EMISOR, RAZON SOCIAL EMISOR ,RFC RECEPTOR, RAZON SOCIAL RECEPTOR, SERIE, FOLIO,SUBTOTAL, DESCUENTO, IMPUESTOS RETENIDOS, IMPUESTOS TRASLADADOS,TOTAL, MONEDA, TIPO CAMBIO, TIPO DOCUMENTO,METODO DE PAGO, FORMA DE PAGO, DESCRIPCION\n";
include('../conexion/bd_access.php');
$query =("SELECT * FROM equipos");
error_log($query);

$conexion = new Conexion();
$respuesta=$conexion->consultar($query);
error_log(print_r($respuesta,true));

?>
