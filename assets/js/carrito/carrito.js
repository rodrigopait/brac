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
		    		console.log(data[0].session);
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
	var element = document.getElementById('flight'+'_'+id);
	console.log(element);
	
	var params= {'id' : id}
	$.ajax({
	    data:  params,
	    url:  'index.php?controller=Cart&method=removeFlightFromCart',
	    type:  'post',
	    success:  function (response) {
	    	var data = JSON.parse(response);
	    	console.log(data[0].carrito.vuelos.escalas);
	    	if (data[0].data == 'Eliminado') {
		    	element.remove();
		    	if ((data[0].carrito.vuelos.escalas).length < 1 && (data[0].carrito.vuelos.directos).length < 1 ){
		    		
		    		$('#vuelos').remove();
		    		if (data[0].carrito.rooms.length <1 && data[0].carrito.cars.length <1 ) {
		    			$('#compra').remove();
		    		}
		    	}

		    	alertify.error('Eliminado del Carrito');
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
		    		if ((data[0].carrito.rooms).length < 1){
		    			$('#rooms').remove();
			    		if (
			    			(data[0].carrito.vuelos.escalas).length < 1 && 
			    			(data[0].carrito.vuelos.directos).length < 1 &&
			    			(data[0].carrito.cars).length <1 
			    		) {
			    			$('#compra').remove();
			    		}
		    		}
		    		alertify.error('Eliminado del Carrito');
		    	} else {
		    		location.href ="index.php?controller=Login&method=login";
		    	}
		    }
		});
		
	}

function comprar(carrito){
	$.ajax({
	    url:  'index.php?controller=Cart&method=cartPurchase_check',
	    type:  'post',
	    success:  function (response) {
	    	

	    }
	});
}


/**CARRITO DE AUTOS**/
function agregarAutoCarrito(id, f_desde, f_hasta) {
	var element = document.getElementById(id);
	if($('.'+id).length) {
		//llamada al fichero PHP con AJAX
		var params= {'id' : id, 'fechaDesde': f_desde, 'fechaHasta': f_hasta}
		$.ajax({
		    data:  params,
		    url:  'index.php?controller=Cart&method=addCarToCart',
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
		    url:  'index.php?controller=Cart&method=removeCarFromCart',
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

function eliminarAutoCarrito(element_id, id) {
	var element = $('#'+element_id);
	var params = {'id' : id}
	$.ajax({
		    data:  params,
		    url:  'index.php?controller=Cart&method=removeCarFromCart',
		    type:  'post',
		    success:  function (response) {
		    	var data = JSON.parse(response);
		    	if (data[0].data == 'Eliminado') {
		    		element.remove();
		    		if ((data[0].carrito.cars).length < 1){
		    			$('#cars').remove();
			    		if (
			    			(data[0].carrito.vuelos.escalas).length < 1 && 
			    			(data[0].carrito.vuelos.directos).length < 1 &&
			    			(data[0].carrito.rooms).length <1 
			    		) {
			    			$('#compra').remove();
			    		}
		    		}
		    		alertify.error('Eliminado del Carrito');
		    	}
		    	else{
		    		location.href ="index.php?controller=Login&method=login";
		    	}
		    }
		});
		
	}

function comprar(carrito){
	$.ajax({
	    url:  'index.php?controller=Cart&method=cartPurchase_check',
	    type:  'post',
	    success:  function (response) {
	    	

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