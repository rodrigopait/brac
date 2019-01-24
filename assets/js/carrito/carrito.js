/**CARRITO DE VUELOS**/
function agregarCarrito(id) {
	var element = document.getElementById(id);
	if($('.'+id).length) {
		//llamada al fichero PHP con AJAX
		var params= {'id' : id}
		$.ajax({
		    data:  params,
		    url:  'index.php?controller=Cart&method=addFlightToCart',
		    type:  'post',
		    success:  function (response) {
		    	var data = JSON.parse(response);
		    	if (data[0].data == 'Agregado') {
		    		element.classList.remove(id);
		    		element.classList.remove("btn-primary");
		    		element.classList.add("btn-success");
		    		element.innerHTML= "Agregado <span class='glyphicon glyphicon-shopping-cart'>";
		    		alertify.success('Agregado al Carrito');
		    	}
		    	else{
		    		location.href ="index.php?controller=Login&method=login";
		    	}
		    }
		});
	}
	else {
		//llamada al fichero PHP con AJAX
		var params= {'id' : id}
		$.ajax({
		    data:  params,
		    url:  'index.php?controller=Cart&method=removeFlightFromCart',
		    type:  'post',
		    success:  function (response) {
		    	var data = JSON.parse(response);
		    	if (data[0].data == 'Eliminado') {
		    		element.classList.add(id);
		    		element.classList.remove("btn-success");
		    		element.classList.add("btn-primary");
		    		element.innerHTML= "Agregar al Carrito <span class='glyphicon glyphicon-shopping-cart'>";
		    		alertify.error('Eliminado del Carrito');
		    	}
		    	else{
		    		location.href ="index.php?controller=Login&method=login";
		    	}
		    }
		});
		
	}

}


function eliminarVueloCarrito(id) {	
	var element = document.getElementById(id);
	var params= {'id' : id}
	$.ajax({
	    data:  params,
	    url:  'index.php?controller=Cart&method=removeFlightFromCart',
	    type:  'post',
	    success:  function (response) {
	    	var data = JSON.parse(response);
	    	if ((data[0].session.directos).length > 0 || (data[0].session.escalas).length > 0  ) {
	    		var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
	    		el.style.display = (el.style.display == 'none') ? 'block' : 'none';
	    		console.log('hola')
	    	}
	    	else{
	    		location.href ="index.php?controller=Login&method=login";
	    	}
	    }
	});
}




/**CARRITO DE HABITACIONES**/
function agregarHabitacionCarrito(id, f_desde, f_hasta) {
	var element = document.getElementById(id);
	if($('.'+id).length) {
		//llamada al fichero PHP con AJAX
		var params= {'id' : id, 'fechaDesde': f_desde, 'fechaHasta': f_hasta}
		$.ajax({
		    data:  params,
		    url:  'index.php?controller=Cart&method=addRoomToCart',
		    type:  'post',
		    success:  function (response) {
		    	var data = JSON.parse(response);
		    	if (data[0].data == 'Agregado') {
		    		element.classList.remove(id);
		    		element.classList.remove("btn-primary");
		    		element.classList.add("btn-success");
		    		element.innerHTML= "Agregado <span class='glyphicon glyphicon-shopping-cart'>";
		    		alertify.success('Agregado al Carrito');
		    	}
		    	else{
		    		location.href ="index.php?controller=Login&method=login";
		    	}
		    }
		});
	}
	else {
		//llamada al fichero PHP con AJAX
		var params= {'id' : id}
		$.ajax({
		    data:  params,
		    url:  'index.php?controller=Cart&method=removeRoomFromCart',
		    type:  'post',
		    success:  function (response) {
		    	var data = JSON.parse(response);
		    	if (data[0].data == 'Eliminado') {
		    		element.classList.add(id);
		    		element.classList.remove("btn-success");
		    		element.classList.add("btn-primary");
		    		element.innerHTML= "Agregar <span class='glyphicon glyphicon-shopping-cart'>";
		    		alertify.error('Eliminado del Carrito');
		    	}
		    	else{
		    		location.href ="index.php?controller=Login&method=login";
		    	}
		    }
		});
		
	}



}

function eliminarHabitacionCarrito(element_id, id) {
	var element = $('#'+element_id);
	var params = {'id' : id}
	$.ajax({
		    data:  params,
		    url:  'index.php?controller=Cart&method=removeRoomFromCart',
		    type:  'post',
		    success:  function (response) {
		    	var data = JSON.parse(response);
		    	if (data[0].data == 'Eliminado') {
		    		element.remove();
		    		alertify.error('Eliminado del Carrito');
		    	}
		    	else{
		    		location.href ="index.php?controller=Login&method=login";
		    	}
		    }
		});
		
	}




/*$( document ).ready(function() {

	  $(".agregarCarrito").click(function() {
	  $(".agregarCarrito").removeClass("btn-primary");
	  $(".agregarCarrito").addClass("btn-success");
	  $(".agregarCarrito").text("Agregado");
	  $()

	});
});*/