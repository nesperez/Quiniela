<?php
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest') {
	require("./bd_access.php");
	session_start();

$usuario   = $_POST['usuario'];
$password  = $_POST['password'];
//$status    = '1';
$query     = ("SELECT * FROM user WHERE usuario='$usuario' AND pass='$password'");
$conexion  = new Conexion();
$respuesta = $conexion->consultar($query);
error_log("hola");
if (!empty($respuesta) AND $respuesta['estatus']==1 ){
	$_SESSION['usuario']=$respuesta;
	echo json_encode(array('error' =>false));

	$acceso="Aceptado";
}
else{
	$query1     = ("SELECT intentos,usuario,estatus FROM user WHERE usuario='$usuario'");
    $respuestaError = $conexion->consultar($query1);
    $intentos=$respuestaError['intentos'];
    $usuarioError=$respuestaError['usuario'];
    $estatus=$respuestaError['estatus'];


if ($intentos=='1' AND $estatus=='1') {
    $queryBlock     = ("UPDATE user SET `estatus`='0', `intentos`='0' WHERE `usuario`='$usuarioError'");
    $respuestaBlock = $conexion->consultar($queryBlock);

    $acceso="Bloqueado por intentos de ingreso";
    enviarMailBitacora($usuarioError);
    echo json_encode(array('error'=>true,'estatus'=>0));
}elseif($intentos>'1' AND $estatus=='1'){
    $intentos=$intentos-1;
    $queryError     = ("UPDATE user SET `intentos`='$intentos' WHERE `usuario`='$usuarioError'");
    $respuestaError = $conexion->consultar($queryError);
	$acceso="Password invalido";
    echo json_encode(array('error'=>true,'estatus'=>$estatus));
    }

    if ($estatus=='0') {

        echo json_encode(array('error'=>true,'estatus'=>$estatus));
        $acceso="Bloqueado por intentos de ingreso";
 }

}

}

function enviarMailBitacora($u_error){

        $password='api:key-5wec77ueem3hnnmzg6yn-nbg4bq2vom2';
        $correo='https://api.mailgun.net/v3/mg.facemasnegocio.com/messages';
        $datosMail['to']        = 'nesperez.17@gmail.com';
        $datosMail['html']      = 'El password del usuario: '.$u_error.' ha sido bloqueada debido a 3 intentos fallidos, favor de cambiar password y notificarlo al usuario';
        $datosMail['from']      = 'tudios@elescorpiondorado.com';
        $datosMail['subject']   = 'Usuario Bloqueado';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPAUTH,       CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD,        $password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
        curl_setopt($ch, CURLOPT_URL,            $correo);
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $datosMail);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($ch);
        curl_close($ch);
    }

$conexion->close();

?>
