function agregarCarrito(id) {
	console.log(id);
	$("."+id).removeClass("btn-primary");
	$("."+id).addClass("btn-success");
	$("."+id).text("Agregado");
}

/*$( document ).ready(function() {

	  $(".agregarCarrito").click(function() {
	  $(".agregarCarrito").removeClass("btn-primary");
	  $(".agregarCarrito").addClass("btn-success");
	  $(".agregarCarrito").text("Agregado");
	  $()

	});
});*/