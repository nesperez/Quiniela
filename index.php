<!DOCTYPE html>
<html lang="es">
<head>
	<title>Don Quiniela</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1" >
	<link rel="stylesheet" href="style/estilo.css">
</head>
	<body>
		<div class="error">
			<span>Datos de Ingreso no válidos, inténtalo de nuevo</span>
		</div>
		<div class="estatus">
			<span>Usuario bloqueado por exceder el numero de intentos permitidos</span>
		</div>
		 <div class="logout">
            <span>Cierre de sesion exitoso</span>
        </div>
		 <h1>Don Quiniela</h1>
		 <div>
		<form action="" method="post" class="form-busqueda" id="formlg">
			  <h2 class="form-titulo">Acceso</h2>
			   <div class="conteiner">
			<input type="text" pattern="[A-Za-z0-9_-.]{1,15}" placeholder="&#128273; Usuario" required name="usuario" class="input-48">
			<input type="password" pattern="[A-Za-z0-9_-.]{1,15}" placeholder="&#128273; Contraseña" required name="password" class="input-48">
			<input type="submit" value="Login" class="btn-enviar">
			 </div>
		</form>
	</div>
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="js/main.js"></script>
	</body>
</html>
