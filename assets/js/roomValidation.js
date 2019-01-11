
$("#roomCreateValidation").submit(function(event){
	var pais = $("#pais").val();
	var ciudad = $("#ciudad").val();
	var hotel = $("#hotel").val();
	var precio = $("#precio").val();
	var capacidad = $("#capacidad").val();
	var errors = 0;
	
	if (pais == ''){
		alert("Por favor ingrese el pais de la habitación.");
		errors+=1;
	}
	if (ciudad == null){
		alert("Por favor ingrese la ciudad de la habitación.");
		errors++;
	}
	if (precio == ''){
		alert("Por favor ingrese el precio de la habitación.");
		errors+=1;
	}
	if (hotel == null){
		alert("Por favor ingrese el hotel de la habitación.");
		errors+=1;
	}
	if (capacidad == ''){
		alert("Por favor ingrese la capacidad de la habitación.");
		errors+=1;
	}
	
	if (errors == 0){
		var res = $.ajax({
			url: 'index.php?controller=Room&method=verifyDuplicity',
			type: 'post',
			data: {
				hotel: hotel,
				precio: precio,
				capacidad: capacidad
			}
		});
		console.log(res['responseText']);
		event.preventDefault();
	}
	else
	$("#capacidad").text('12');
	event.preventDefault();
});
//action="index.php?controller=Room&method=roomAdd" 