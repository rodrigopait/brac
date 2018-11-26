function publish_validation(){
	var nombre = document.getElementById("nombre").value;
	var precio = document.getElementById("precio").value;
	var habitaciones = document.getElementById("habitaciones").value;
	var capacidad = document.getElementById("capacidad").value;
	var banos = document.getElementById("banos").value;
	var calle = document.getElementById("calle").value;
	var numero = document.getElementById("numero").value;
	var pais = document.getElementById("pais").value;
	var provincia = document.getElementById("provincia").value;
	var ciudad = document.getElementById("ciudad").value;
	var codigo_postal = document.getElementById("codigo_postal").value;
	var tipo_propiedad = document.getElementsByName("tipo_propiedad")[0].value;
	<?php
    if ($_SESSION['rol'] == 1){
		echo 'var image = document.getElementById("normal_image").value;';
    }
    else{
       	echo 'var image = document.getElementById("premium_image").value;';
    }
    ?>
    if (nombre == ''){
		alert("Por favor ingrese el nombre de la propiedad.");
		return false;
	}
	if (calle == ''){
		alert("Por favor ingrese la calle de la propiedad.");
		return false;
	}
	if (numero == ''){
		alert("Por favor ingrese el numero de la propiedad.");
		return false;
	}
	if (pais == ''){
		alert("Por favor ingrese el pais de la propiedad.");
		return false;
	}
	if (provincia == ''){
		alert("Por favor ingrese la provincia de la propiedad.");
		return false;
	}
	if (ciudad == ''){
		alert("Por favor ingrese la ciudad de la propiedad.");
		return false;
	}
	if (codigo_postal == ''){
		alert("Por favor ingrese el codigo postal de la propiedad.");
		return false;
	}
	if (tipo_propiedad == ''){
		alert("Por favor ingrese el tipo de la propiedad.");
		return false;
	}
	if (precio == ''){
		alert("Por favor ingrese el precio de la propiedad.");
		return false;
	}
	if (habitaciones == ''){
		alert("Por favor ingrese el numero de habitaciones de la propiedad.");
		return false;
	}
	if (capacidad == ''){
		alert("Por favor ingrese la capacidad de la propiedad.");
		return false;
	}
	if (banos == ''){
		alert("Por favor ingrese el numero de baños de la propiedad.");
		return false;
	}
	if (image == ''){
		alert("Por favor ingrese una imagen de la propiedad.");
		return false;
	}
}