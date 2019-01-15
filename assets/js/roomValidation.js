
$("#roomCreateValidation").submit(function(event){
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
	$.ajax({
		type: "POST",
		url: "index.php?controller=Room&method=roomCreate&parameters=hola",
		async: false,
		data: {},
		success: function () {

		}
	});
	/*
	if (errors == 0){
		var response = '';
		$.ajax({
			type: "POST",
			url: "index.php?controller=Room&method=verifyDuplicity",
			async: false,
			data: {
				hotel: hotel,
				precio: precio,
				capacidad: capacidad
			},
			success: function (text) {
				response = text;
			}
		});
		if (response == 0){
			$.ajax({
				type: "POST",
				url: "index.php?controller=Room&method=roomAdd",
				async: false,
				data: {
					pais: pais,
					ciudad: ciudad,
					hotel: hotel,
					precio: precio,
					capacidad: capacidad
				},
				success: function (text) {
					response = text;
				}
			});
		}
		else{
			$.ajax({
				type: "POST",
				url: "index.php?controller=Room&method=roomCreate&parameters=hola",
				async: false,
				data: {},
				success: function () {
					
				}
			});
		}
	}
	else{
		event.preventDefault();
	}*/
});