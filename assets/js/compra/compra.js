function removeRoom(id,compraId,precio){

	var params= {'id' : id, 'compraId':compraId, 'precio':precio}
	$.ajax({
	    data:  params,
	    url:  'index.php?controller=User&method=deletePurchaseRoom',
	    type:  'post',
	    success:  function (response) {
	    	var data = JSON.parse(response);
	    	if (data[0].data == 'eliminado') {
	    		location.href ="index.php?controller=User&method=userPurchasesDetail&id="+compraId;
	    	}
	    }
	});
}

function removeCar(id,compraId,precio){

	var params= {'id' : id, 'compraId':compraId, 'precio':precio}
	console.log(params);
	$.ajax({
	    data:  params,
	    url:  'index.php?controller=User&method=deletePurchaseCar',
	    type:  'post',
	    success:  function (response) {
	    	var data = JSON.parse(response);
	    	if (data[0].data == 'eliminado') {
	    		location.href ="index.php?controller=User&method=userPurchasesDetail&id="+compraId;
	    	}
	    }
	});
}

function removeFlight(id,compraId,precio){

	var params= {'id' : id, 'compraId':compraId, 'precio':precio}
	$.ajax({
	    data:  params,
	    url:  'index.php?controller=User&method=deletePurchaseFlight',
	    type:  'post',
	    success:  function (response) {
	    	console.log(response);
	    	var data = JSON.parse(response);
	    	if (data[0].data == 'eliminado') {
	    		location.href ="index.php?controller=User&method=userPurchasesDetail&id="+compraId;
	    	}
	    }
	});
}