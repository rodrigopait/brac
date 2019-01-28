$( document ).ready(function() {
	
	$("#button-validacion").click(function(){

		var paisOrigen = $('#paisOrigen').val(); 
		var ciudadOrigen = $('#ciudadOrigen').val();
		var paisDestino = $('#paisDestino').val(); 
		var ciudadDestino = $('#ciudadDestino').val();
		var aerolinea = $('#aerolinea').val();
		var fechaPartida = $('#fechaPartida').val();
		var precio = $('#precio').val();
		var hora = $('#hora').val();
		var duracion = $('#duracion').val();
		var economica = $('#economica').val();
		var ejecutiva = $('#ejecutiva').val();
		var primera = $('#primera').val();

		var errors = 0;
		
/*		if (pais == null){
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
		}*/
		var data={	'paisOrigen':paisOrigen, 
					'ciudadOrigen':ciudadOrigen,
					'paisDestino':paisDestino,
					'ciudadDestino':ciudadDestino,
					'aerolinea':aerolinea,
					'fechaPartida':fechaPartida,
					'precio':precio,
					'hora':hora,
					'duracion':duracion,
					'economica':economica,
					'ejecutiva':ejecutiva,
					'primera':primera}

		console.log(data);
		
		$.ajax({
			data:data,
			type: "POST",
			url: "index.php?controller=Flight&method=flightAdd",
			success: function (response) {
					$('#alerta-msj').removeAttr("hidden")

					$('#paisOrigen').val(''); 
					$('#ciudadOrigen').val('');
					$('#paisDestino').val(''); 
					$('#ciudadDestino').val('');
					$('#concesionaria').val('');
					$('#aerolinea').val('');
					$('#fechaPartida').val('');
					$('#precio').val('');
					$('#hora').val('');
					$('#duracion').val('');
					$('#economica').val('');
					$('#ejecutiva').val('');
					$('#primera').val('');	
			}
		});
	});

});