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
	

  //validacion para agregar una hotel
  $('#formHotel').submit(function(event){
    let name=$('#nombre').val();
    let country=$('#pais').val();
    let city=$('#ciudad').val();
    
    let errores=new Array();
    


    if (airline.trim() == "") {
      $('#').text('Debe ingresar una ');
      event.preventDefault();

    }
    else{
      $.ajax({
        url: 'index.php?controller=&method=verifyDuplicity',
        type: 'post',
        data: {airline: airline},
        success:  function (response) {
          console.log(response);
          
        },
        error: function (response) {
            event.preventDefault();
            alertify.danger('No se pudo agregar');
        }
      });

      
      
    }
  });

    $("#button-airline").click(function(){

      var airline = $('#airline').val(); 


      var errors = 0;

      var data={  'nombre':airline}
      
      $.ajax({
        data:data,
        type: "POST",
        url: "index.php?controller=Airline&method=airlineAdd",
        success: function (response) {
            $('#alerta-msj').removeAttr("hidden")
            $('#airline').val(''); 
        }
      });
    });

    $("#button-hotel").click(function(){

      var nombre = $('#nombre').val();
      var pais = $('#pais').val(); 
      var ciudad = $('#ciudad').val();
      var estrellas = $('#estrellas').val(); 



      var errors = 0;

      var data={  'nombre':nombre, 'pais':pais, 'ciudad':ciudad, 'estrellas':estrellas}
      
      $.ajax({
        data:data,
        type: "POST",
        url: "index.php?controller=Hotel&method=hotelAdd",
        success: function (response) {
            $('#alerta-msj').removeAttr("hidden")
            $('#nombre').val('');
            $('#pais').val('a');
            $('#ciudad').val('');
            $('#ciudad').prop('disabled','disabled')
            $('#estrellas').val('1');  

        }
      });
    });

    $("#button-concessionaire").click(function(){

      var nombre = $('#nombre').val();
      var pais = $('#pais').val(); 
      var ciudad = $('#ciudad').val();  


      var errors = 0;

      var data={  'nombre':nombre,'pais':pais,'ciudad':ciudad}
      
      $.ajax({
        data:data,
        type: "POST",
        url: "index.php?controller=Concessionaire&method=concessionaireAdd",
        success: function (response) {
            $('#alerta-msj').removeAttr("hidden")
            $('#nombre').val('');
            $('#pais').val('a');
            $('#ciudad').val('');
            $('#ciudad').prop('disabled','disabled')
        }
      });
    });

    $("#button-comerciante").click(function(){

      var nombre = $('#nombre').val();
      var apellido = $('#apellido').val(); 
      var usuario = $('#usuario').val();
      var email = $('#email').val();
      var dni = $('#dni').val();
      var clave = $('#clave').val();


      var errors = 0;

      var data={  'nombre':nombre,'apellido':apellido,'usuario':usuario,'email':email,'dni':dni,'clave':clave}
      
      $.ajax({
        data:data,
        type: "POST",
        url: "index.php?controller=User&method=userComercialAdd",
        success: function (response) {
            $('#alerta-msj').removeAttr("hidden");
            $('#nombre').val('');
            $('#apellido').val('');
            $('#usuario').val('');
            $('#email').val('');
            $('#dni').val('');
            $('#clave').val('');
        }
      });
    });




});
  function newFunction(errores) {
  	errores = 1;
  	return errores;
  }

  function formAerolinea() {
  	let airline = $('#airline').val();
  	if (airline.trim() == "") {
  		$('#airline-error').text('Debe ingresar una aerolinea');
  		return false
  	} else {
  		$.ajax({
  			url: 'index.php?controller=Airline&method=verifyDuplicity',
  			type:'post',
  			data: {
  				airline: airline
  			},
  			success:function (response) {
  				if (response > 0) {
  					$('#airline-error').text('Ya existe culeao aerolinea');
  					return 
  				} else {
  					alertify.success('Agregado');
  					$('#airline-error').text('');
  					return true
  				}
  			}
  		}).then(response);
  	}
  	if ($('#airline-error').text() != '') {
  		event.preventDefault()
  	}
  	//event.preventDefault()
  }