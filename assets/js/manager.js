function ciudades(idPais,idCiudad){
  	var pais = $("#"+idPais).val();
  	var params= {'id' : pais}

  	//llamada al fichero PHP con AJAX
  	$.ajax({
  	    data:  params,
  	    url:  'index.php?controller=City&method=citiesCountry',
  	    type:  'post',
  	    success:  function (response) {

  	    	var cities = JSON.parse(response);
  	    	var options = "<option disabled selected>Elija una ciudad</option>";
  	    	$.each(cities, function (index, value) {
  	    	options += "<option value ="+value.id+">"+value.nombre+"</option>";
  	    	});
  	    	$('#'+idCiudad).prop('disabled', false);
  	    	$('#'+idCiudad).html(options);
  	    }
  	});
 }

 function modelos(idMarca,idModelo){
   	var marca = $("#"+idMarca).val();
   	var params= {'id' : marca}

   	//llamada al fichero PHP con AJAX
   	$.ajax({
   	    data:  params,
   	    url:  'index.php?controller=Car&method=modelsBrand',
   	    type:  'post',
   	    success:  function (response) {

   	    	var models = JSON.parse(response);
   	    	var options = "<option disabled selected>Elija un modelo</option>";
   	    	$.each(models, function (index, value) {
   	    	options += "<option value="+value.id+">"+value.descripcion+"</option>";
   	    	});
   	    	$('#'+idModelo).prop('disabled', false);
   	    	$('#'+idModelo).html(options);
   	    }
   	});
  }



  function ciudadesConConcessionarias(idPais,idCiudad){
    	var pais = $("#"+idPais).val();
    	var params= {'id' : pais}

    	//llamada al fichero PHP con AJAX
    	$.ajax({
    	    data:  params,
    	    url:  'index.php?controller=City&method=citiesConcessionaire',
    	    type:  'post',
    	    success:  function (response) {

    	    	var cities = JSON.parse(response);
    	    	var options = "<option disabled selected>Elija una ciudad</option>";
    	    	$.each(cities, function (index, value) {
    	    	options += "<option value ="+value.id+">"+value.nombre+"</option>";
    	    	});
    	    	$('#'+idCiudad).prop('disabled', false);
    	    	$('#'+idCiudad).html(options);
    	    }
    	});
   }


  function concesionarias(idCiudad,idConcesionaria){
  	var ciudad = $("#"+idCiudad).val();
  	var params= {'id' : ciudad}

  	//llamada al fichero PHP con AJAX
  	$.ajax({
  	    data:  params,
  	    url:  'index.php?controller=Concessionaire&method=concessionaireFrom',
  	    type:  'post',
  	    success:  function (response) {

  	    	var concesionarias = JSON.parse(response);

  	    	var options = "<option disabled selected>Elija una concesionaria</option>";
  	    	$.each(concesionarias, function (index, value) {
  	    	options += "<option value="+value.id+">"+value.nombre+"</option>";
  	    	});
  	    	$('#'+idConcesionaria).prop('disabled', false);
  	    	$('#'+idConcesionaria).html(options);
  	    }
  	});
  }

  function ciudadesConHabitaciones(idPais,idCiudad){
      var pais = $("#"+idPais).val();
      var params= {'id' : pais}

      //llamada al fichero PHP con AJAX
      $.ajax({
          data:  params,
          url:  'index.php?controller=City&method=citiesRooms',
          type:  'post',
          success:  function (response) {

            var cities = JSON.parse(response);
            var options = "<option disabled selected>Elija una ciudad</option>";
            $.each(cities, function (index, value) {
            options += "<option value ="+value.id+">"+value.nombre+"</option>";
            });
            $('#'+idCiudad).prop('disabled', false);
            $('#'+idCiudad).html(options);
          }
      });
   }

   function hoteles(idCiudad,idHotel){
    var ciudad = $("#"+idCiudad).val();
    var params= {'id' : ciudad}

    //llamada al fichero PHP con AJAX
    $.ajax({
        data:  params,
        url:  'index.php?controller=Hotel&method=hotelsFrom',
        type:  'post',
        success:  function (response) {

          var concesionarias = JSON.parse(response);

          var options = "<option disabled selected>Elija una hotel</option>";
          $.each(concesionarias, function (index, value) {
          options += "<option value="+value.id+">"+value.nombre+"</option>";
          });
          $('#'+idHotel).prop('disabled', false);
          $('#'+idHotel).html(options);
        }
    });
   }

//Eliminar cuenta de usuario
$( document ).ready(function() {
  $('#eliminar').click(function() {
      alertify.confirm("¿Estas seguro?.",
        function(){
          window.location.href = "index.php?controller=User&method=userDelete";
        });
  });



//----------------------------------------VALIDACIONES---------------------------------

  //resetear campos
  $('#reset').click(function(){
    $('#airline-error').text('');
  })

  //validacion para agregar una aerolinea
  $('#formAerolinea').submit(function(event){
    let airline=$('#airline').val();
    
    if (airline.trim() == "") {
      $('#airline-error').text('Debe ingresar una aerolinea');
      event.preventDefault();

    }
    else{
      $.ajax({
        url: 'index.php?controller=Airline&method=verifyDuolicity',
        type: 'post',
        data: {airline: airline},
        success:  function (response) {
          console.log(response);
        }
      });

      alertify.success('Agregado');

    }
  });

  //validacion para agregar una hotel
  $('#formHotel').submit(function(event){
    let name=$('#nombre').val();
    let country=$('#pais').val();
    let city=$('#ciudad').val();
    
    let errores=new Array();
    


    if (airline.trim() == "") {
      $('#airline-error').text('Debe ingresar una aerolinea');
      event.preventDefault();

    }
    else{
      $.ajax({
        url: 'index.php?controller=Airline&method=verifyDuolicity',
        type: 'post',
        data: {airline: airline},
        success:  function (response) {
          console.log(response);
        }
      });

      alertify.success('Agregado');

    }
  });





});
