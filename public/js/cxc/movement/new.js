// Javascript to enable link to tab
var url = document.location.toString();
if (url.match('#')) {
    $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
} 

// Change hash for page-reload
$('.nav-tabs a').on('shown', function (e) {
    window.location.hash = e.target.hash;
})

$("#searchClient").on("click", function(e){
	/*$(e.target).append("<input type='number' class='form-control' id='documentAmount' min='0' step='any'>");
	$("#documentAmount").focus();*/
	window.location= "357/buscar/cliente";
});

$("#searchClientOffice").on("click", function(e){
	/*$(e.target).append("<input type='number' class='form-control' id='documentAmount' min='0' step='any'>");
	$("#documentAmount").focus();*/
	window.location= "357/buscar/sucursal-cliente";
});

$("#searchMovReference").on("click", function(e){
	/*$(e.target).append("<input type='number' class='form-control' id='documentAmount' min='0' step='any'>");
	$("#documentAmount").focus();*/
	window.location= "357/buscar/referencia-movimiento";
});

$("#showClientBalance").on("click", function(e){
	/*$(e.target).append("<input type='number' class='form-control' id='documentAmount' min='0' step='any'>");
	$("#documentAmount").focus();*/
	window.location= "357/consultar/saldo-cliente";
});


var documentsNumber = 0;

$("#newDocumentRow").on("click", function(){

	var emptyPlace = aCxcD.indexOf(null);
	var insertedDocumentPlace;

	// No hay un espacio en null.
	if(emptyPlace == -1) {
		// Se agrega al final.
		insertedDocumentPlace = aCxcD.length;
		aCxcD.push(new cxcD);
	}
	else {

		// Se agrega en el espacio vacio.
		aCxcD[emptyPlace] = new cxcD;
		insertedDocumentPlace = emptyPlace;
	}
	console.log(aCxcD);
	console.log(documentsNumber);
	console.log($($('#documentsTable tbody').prop('children')[0]).index());

	$('#documentsTable tbody').append(
		"<tr id='document-"+insertedDocumentPlace+"'>"+
			"<td style='text-align: center;' class='apply'></td>"+
			"<td style='text-align: center;' class='consecutive'></td>"+
			"<td style='text-align: center;' class='amount'></td>"+
			"<td style='text-align: center;' class='difference'></td>"+
			"<td style='text-align: center;' class='differencePercentage'></td>"+
			"<td style='text-align: center;' class='concept'></td>"+
			"<td style='text-align: center;' class='reference'></td>"+
			"<td style='text-align: center;' class='discountPPP' hidden></td>"+
			"<td style='text-align: center;' class='suggestPPP' hidden></td>"+
			"<td style='text-align: center;'>"+
				"<div class='deleteDocument'>"+
					/*"<button type='button' class='btn btn-link btn-sm'><span class='glyphicon glyphicon-remove'></span></button>" +*/
					"<div class='glyphicon glyphicon-remove'></div>"+
				"</div>"+
			"</td>"+
			/*"<td style='text-align: center;'>"+
				"<div class='editrow'>"+
					"<div class='glyphicon glyphicon-pencil'></div>"+
				"</div>"+
			"</td>"+
			"<td style='text-align: center;'>"+
				"<div class = 'calculator' align= 'center'>"+
					"<div class='fa fa-calculator'></div>"+
				"</div>"+
			"</td>"+*/
		"</tr>");
	
	$("#documentsTable tbody tr:last .deleteDocument").on("click", function(){

		var $killrow = $(this).parent('td').parent('tr');
	    /*$killrow.addClass("danger");
		$killrow.fadeOut(1000, function(){
	    	$(this).remove();
		});*/
		var documentNum = $killrow.attr('id').split('-')[1];
		console.log(documentNum);
		aCxcD[documentNum] = null;
		//aCxcD.splice( documentsNumber, 1);
		console.log(aCxcD);

		$killrow.remove();

		documentsNumber--;
	});

	$("#documentsTable tbody tr:last .apply").on("click", function(e){
		$(e.target).append("<select class='form-control' id='documentApply'><option>a</option><option>b</option></select>");
		$("#documentApply").focus();
	});

	$("#documentsTable tbody tr:last .apply").on("focusout", function(e){
		console.log($(this) + "gorgojo");
		$("#documentApply option:selected").text();
		$(this).empty();
	});

	$("#documentsTable tbody tr:last .consecutive").on("click", function(e){
		
		if($(e.currentTarget).children().length > 0) return;
		else{
			$(e.target).append(
				"<div class='input-group'>"+
					"<span class='input-group-btn'>"+
						"<button type='button' class='btn btn-default btn-sm' id='searchConsecutive'>"+
							"<span class='glyphicon glyphicon-search'></span>"+
						"</button>"+
					"</span>"+
					"<input type='text' class='form-control input-sm' id='consecutive' readonly>"+
				"</div>");
		}

		$("#searchConsecutive").on("click", function(e){
			/*$(e.target).append("<input type='number' class='form-control' id='documentAmount' min='0' step='any'>");
			$("#documentAmount").focus();*/
			window.location= "357/buscar/documento/2048";
		});

		$("#searchConsecutive").focus();


		//window.location("/cxc/documento/buscar");
	});

	$("#documentsTable tbody tr:last .consecutive").on("focusout", function(e){
		console.log($(this) + "gorgojo");
		$("#consecutive").text();
		$(this).empty();
	});

	

	$("#documentsTable tbody tr:last .amount").on("click", function(e){
		if($(e.currentTarget).children().length > 0) return;
		else{
			$(e.target).append(
				"<div class='input-group'>"+
					"<span class='input-group-btn'>"+
						"<button type='button' class='btn btn-default' id='calculator'>"+
							"<span class='fa fa-calculator'></span>"+
						"</button>"+
					"</span>"+
					"<input type='number' class='form-control' id='documentAmount' min='0' step='any'>" +
				"</div>"
				);
		}

		$("#calculator").on("click", function(e){
			//alert("hola");
			window.location="calculadora";
		});

		//$(this).focus();

	});

	$("#documentsTable tbody tr:last .amount").on("focusout", function(e){
			console.log($("#documentAmount").is(":focus"));
			console.log($("#calculator").is(":focus"));
			console.log($(this) + "gorgojo");
			$("#documentAmount").text();
			$(this).empty();
		/*if(!($("#documentAmount").is(":focus")) && !($("#calculator").is(":focus"))){
			console.log($(this) + "gorgojo");
			$("#documentAmount").text();
			$(this).empty();
		}*/
		
	});

	/*$("#documentAmount,#calculator").on("focusout", function(e){
		console.log($("#documentAmount").is(":focus"));
			console.log($("#calculator").is(":focus"));
		if(!($("#calculator").is(":focus"))){
			console.log($(this) + "gorgojo");

			$("#documentAmount").text();
			$(this).empty();
		}
		alert("hola");
	});*/

	$("#documentsTable tbody tr:last .discountPPP").on("click", function(e){
		$(e.target).append("<input type='number' class='form-control' id='discountPPP' min='0' step='any'>");
		$("#discountPPP").focus();
	});

	$("#documentsTable tbody tr:last .discountPPP").on("focusout", function(e){
		console.log($(this) + "gorgojo");
		$("#discountPPP").text();
		$(this).empty();
	});

	/*$(".apply").on("click", function(e){
		//$(this).remove();
		//console.log($(this));
		$(e.target).append("<input type='text' id='txtApply'>")
		//$("#txtApply").focus();
	})*/

	/*$(".apply").on("focusout", function(e){
		//e.preventDefault();
		console.log($(this) + "gorgojo");
		$(this).empty();
	})*/
	documentsNumber++;
});

var numberOfCharges = 1;
var charges = [null,null,null,null,null];
/*window.charges = [1,null,null,null,null];*/
/*var numberOfDocuments = 0;
function document(apply, consecutive, amount, difference, differencePercentage, concept, reference){
	this.apply;
	this.consecutive;
	this.amount;
	this.difference;
	this.differencePercentage;
	this.concept;
	this.reference;
}*/
//console.log(window.charges);
$("#newChargeRow").on("click", function(){
	
	if(numberOfCharges > 5 ) return;

	var indexNumber = charges.indexOf(null);
	var chargeNumber = indexNumber + 1
	//console.log(indexNumber);

	//if(chargeNumber<=1){
		$('#charges').append(
			"<div class='form-group' id='charge"+chargeNumber+"'>" +	    	
				"<div class='col-sm-4'>" +
					/*"<label for='chargeAmount'>Importe " + chargeNumber + "</label>" +*/
					"<label for='amount"+chargeNumber+"'>Importe</label>" +
					"<div class='input-group'>"+
						"<div class='input-group-addon'>$</div>"+
						"<input type='number' class='form-control input-sm' id='amount"+chargeNumber+"' name='amount"+chargeNumber+"' min='0' step='any'>"+
					"</div>"+
				"</div>" +
				"<div class='col-sm-4'>" +
					/*"<label for='wayOfPayment'>Forma Cobro " + chargeNumber + "</label>"+*/
					"<label for='charge_type"+chargeNumber+"'>Forma Cobro</label>"+
					"<select id='charge_type"+chargeNumber+"' name='charge_type"+chargeNumber+"' class='form-control input-sm'>"+
						"<option></option>" +
					"</select>" +
				"</div>" +
				"<div class='col-sm-3'>" +
					/*"<label for='chargeReference'>Referencia " + chargeNumber+ "</label>"+*/
					"<label for='reference"+chargeNumber+"'>Referencia</label>"+
					"<input type='text' class='form-control input-sm' id='reference"+chargeNumber+"' name='reference"+chargeNumber+"'>"+
				"</div>" + 
				"<div class='col-sm-1' id='deleteCharge"+chargeNumber+"'><br>" +
					"<span class='glyphicon glyphicon-remove' style='font-size:30px; text-align:center; display: block;'></span>"+
				"</div>" +
				"<hr>" + 
			"</div>");

	/*}else{
		console.log("#charge"+(chargeNumber-1))
		console.log(numberOfCharges);
		$("#charge"+(chargeNumber-1)).after(
			"<div class='form-group' id='charge"+chargeNumber+"'>" +	    	
				"<div class='col-sm-4'>" +
					"<label for='chargeAmount'>Importe " + chargeNumber + "</label>" +
					"<div class='input-group'>"+
						"<div class='input-group-addon'>$</div>"+
						"<input type='number' class='form-control input-sm' id='chargeAmount' min='0' step='any'>"+
					"</div>"+
				"</div>" +
				"<div class='col-sm-4'>" +
					"<label for='wayOfPayment'>Forma Cobro " + chargeNumber + "</label>"+
					"<select id='wayOfPayment' class='form-control input-sm'>"+
						"<option></option>" +
					"</select>" +
				"</div>" +
				"<div class='col-sm-3'>" +
					"<label for='chargeReference'>Referencia " + chargeNumber + "</label>"+
					"<input type='text' class='form-control input-sm' id='chargeReference'>"+
				"</div>" + 
				"<div class='col-sm-1' id='deleteCharge"+chargeNumber+"'><br>" +
					"<span class='glyphicon glyphicon-remove' style='font-size:30px; text-align:center; display: block;'></span>"+
				"</div>" +
				"<hr>" + 
			"</div>");
	}*/

	$("#charges div:last#deleteCharge"+chargeNumber).on("click", function(){
		charges[indexNumber] = null;
		numberOfCharges--;
		//console.log("despues: "+numberOfCharges);
		var $killrow = $(this).parent('div');
			$killrow.remove();
	});
	
	/*$("#charges div:last").on("click", function(){
		numberOfCharges--;
		console.log("despues: "+numberOfCharges);
		var $killrow = $(this).parent('div');
			$killrow.remove();
	});*/

	charges[indexNumber] = numberOfCharges;
	numberOfCharges++;
	//console.log("antes: "+numberOfCharges);


});
/*<select class='form-control'><option>Parangaricutirimicuaro</option></select>*/
