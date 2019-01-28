$( document ).ready(function() {
	
	$("#button-validacion").click(function(){
		var pais = $("#pais").val();
		var ciudad = $("#ciudad").val();
		var hotel = $("#hotel").val();
		var precio = $("#precio").val();
		var capacidad = $("#capacidad").val();
		var errors = 0;
		$('#pais-error').text('');
		$('#ciudad-error').text('');
		$('#hotel-error').text('');
		$('#precio-error').text('');
		$('#capacidad-error').text('');
		
		if (pais == null){
			$('#pais-error').text('Debe ingresar el pais de la habitación.');
			errors+=1;
		}
		if (ciudad == null){
			$('#ciudad-error').text('Debe ingresar el pais de la habitación.');
			errors++;
		}
		if (precio == null){
			$('#precio-error').text('Debe ingresar el pais de la habitación.');
			errors+=1;
		}
		if (hotel == null){
			$('#hotel-error').text('Debe ingresar el pais de la habitación.');
			errors+=1;
		}
		if (capacidad == null){
			$('#capacidad-error').text('Debe ingresar el pais de la habitación.');
			errors+=1;
		}
		var data={'precio':precio, 'hotel':hotel, 'capacidad':capacidad} 
		$.ajax({
			data:data,
			type: "POST",
			url: "index.php?controller=Room&method=roomAdd",
			success: function (response) {

				var datos = JSON.parse(response);
				if (datos[0].msj == 'Agregado') {
					console.log('hola');
					$('#alerta-msj').removeAttr("hidden")
					$("#pais").val('');
					$("#ciudad").val('');
					$("#hotel").val('');
					$("#precio").val('');
					$("#capacidad").val('');		
				}
			}
		});
	});



});