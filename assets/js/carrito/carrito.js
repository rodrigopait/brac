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

/*$( document ).ready(function() {

	  $(".agregarCarrito").click(function() {
	  $(".agregarCarrito").removeClass("btn-primary");
	  $(".agregarCarrito").addClass("btn-success");
	  $(".agregarCarrito").text("Agregado");
	  $()

	});
});*/