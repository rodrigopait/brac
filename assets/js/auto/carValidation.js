$( document ).ready(function() {
	
	$("#button-validacion").click(function(){

		var paisOrigen = $('#paisOrigen').val(); 
		var ciudadOrigen = $('#ciudadOrigen').val();
		var concesionaria = $('#concesionaria').val();
		var marca = $('#marca').val();
		var modelo = $('#modelo').val();
		var precio = $('#precio').val();
		var autonomia = $('#autonomia').val();
		var capacidad = $('#capacidad').val();
		var patente = $('#patente').val();
		var gama = $('#gama').val();

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
		var data=	{'paisOrigen':paisOrigen,
				  	'ciudadOrigen':ciudadOrigen,
					'concesionaria':concesionaria,
					'marca':marca,
					'modelo':modelo,
					'precio':precio,
					'autonomia':autonomia,
					'capacidad':capacidad,
					'patente':patente,
					'gama':gama}
		
		$.ajax({
			data:data,
			type: "POST",
			url: "index.php?controller=Car&method=carAdd",
			success: function (response) {

				var datos = JSON.parse(response);
				if (datos[0].msj == 'Agregado') {
					console.log('hola');
					$('#alerta-msj').removeAttr("hidden")
					$('#paisOrigen').val(''); 
					$('#ciudadOrigen').val('');
					$('#concesionaria').val('');
					$('#marca').val('');
					$('#modelo').val('');
					$('#precio').val('');
					$('#autonomia').val('');
					$('#capacidad').val('');
					$('#patente').val('');
					$('#gama').val('');		
				}
			}
		});
	});



});