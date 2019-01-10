function roomCreateValidation() {
	var pais = $("#pais").val();
	var ciudad = document.getElementById("ciudad").value;
	var precio = $("#precio").val();
	var hotel = document.getElementById("hotel").value;
	var capacidad = $("#capacidad").val();
	console.log(pais);
	console.log(ciudad);
	console.log(precio);
	console.log(capacidad);

	// if (pais == ''){
	// 	alert("Por favor ingrese el pais de la propiedad.");
		return false;
	// }
	// if (ciudad == ''){
	// 	alert("Por favor ingrese la ciudad de la propiedad.");
	// 	return false;
	// }
	// if (precio == ''){
	// 	alert("Por favor ingrese el precio de la propiedad.");
	// 	return false;
	// }
	// if (hotel == ''){
	// 	alert("Por favor ingrese el numero de habitaciones de la propiedad.");
	// 	return false;
	// }
	// if (capacidad == ''){
	// 	alert("Por favor ingrese la capacidad de la propiedad.");
	// 	return false;
	// }
}
