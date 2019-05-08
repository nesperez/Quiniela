jQuery(document).on('submit','#formlg',function(event){
event.preventDefault();
jQuery.ajax({
	url:'conexion/login.php',
	type:'POST',
	dataType:'json',
	data:$(this).serialize(),
	beforeSend:function(){
		$('.btn-enviar').val('Validando...');

	}
})
.done(function(respuesta){
	console.log(respuesta);
	if (!respuesta.error) {
	location.href='views/principal.php';
	}else{


		if (respuesta.error==true && respuesta.estatus == "0") {
	$('.estatus').slideDown('slow');
		setTimeout(function(){
			$('.estatus').slideUp('slow');
	},3000);
		$('.btn-enviar').val('Login');
	location.href('login.php');
}


if (respuesta.error==true && respuesta.estatus == 1) {

		$('.error').slideDown('slow');
		setTimeout(function(){
			$('.error').slideUp('slow');
	},3000);
		$('.btn-enviar').val('Login');
	location.href('login.php');
}

	}

})

.fail(function(resp){
	console.log(resp.responseText);

})

.always(function(){
	console.log("complete");
});
});
