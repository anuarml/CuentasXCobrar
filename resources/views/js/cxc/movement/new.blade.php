<script type="text/javascript">
// Javascript to enable link to tab
var url = document.location.toString();
var movementId;
if (url.match('#')) {
    $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
} 


// Change hash for page-reload
$('.nav-tabs a').on('shown', function (e) {
    window.location.hash = e.target.hash;
})

$("#searchClient").on("click", function(e){
	window.location= "{{ url('cxc/movimiento/buscar/cliente') }}";
	//toolbar.saveMov('searchClient');
});

$("#searchClientOffice").on("click", function(e){
	//getMovidFromUrl();
	toolbar.saveMov('searchClientOffice');
	//window.location= "331/buscar/sucursal-cliente";
});

$("#searchMovReference").on("click", function(e){
	toolbar.saveMov('searchMovReference');
	//window.location= "331/buscar/referencia-movimiento";
});

$("#showClientBalance").on("click", function(e){
	toolbar.saveMov('showClientBalance');
	//window.location= "331/consultar/saldo-cliente";

});


$("#Mov").on("change", function(e){
	
	$('#hidden_mov').val(this.value);
	this.disabled = true;
	//var movToVerify = $("#Mov").val();
	//console.log(movToVerify);
	//verifyMov(movToVerify);
	verifyMov();
});

/*
	Documents
*/

$("#newDocumentRow").on("click", function() {addDocumentRow();});

var documentsNumber = 0;

function addDocumentRow(cxcD){

	var cxcD = cxcD || new CxcD();
	var emptyPlace = aCxcD.indexOf(null);
	var insertedDocumentPlace;

	// No hay un espacio en null.
	if(emptyPlace == -1) {
		// Se agrega al final.
		insertedDocumentPlace = aCxcD.length;
		cxcD.tableRowID = insertedDocumentPlace;
		aCxcD.push(cxcD);
	}
	else {
		// Se agrega en el espacio vacio.
		insertedDocumentPlace = emptyPlace;
		cxcD.tableRowID = insertedDocumentPlace;
		aCxcD[emptyPlace] = cxcD;
		

	}



	$('#documentsTable tbody').append(
		"<tr id='document-"+insertedDocumentPlace+"'>"+
			"<td style='text-align: center;' class='apply'>"+(cxcD.apply || '')+"</td>"+
			"<td style='text-align: center;' class='consecutive'>"+(cxcD.apply_id || '')+"</td>"+
			"<td style='text-align: center;' class='amount'>"+(cxcD.amount || '')+"</td>"+
			"<td style='text-align: center;' class='difference'></td>"+
			"<td style='text-align: center;' class='differencePercentage'></td>"+
			"<td style='text-align: center;' class='concept'></td>"+
			"<td style='text-align: center;' class='reference'></td>"+
			"<td style='text-align: center;' class='discountPPP' hidden>"+(cxcD.p_p_discount || '')+"</td>"+
			"<td style='text-align: center;' class='suggestPPP' hidden></td>"+
			"<td style='text-align: center;'>"+
				"<div class='deleteDocument'>"+
					"<div class='glyphicon glyphicon-remove'></div>"+
				"</div>"+
			"</td>"+
		"</tr>");
	
	$("#documentsTable tbody tr:last .deleteDocument").on("click", function(){

		var $killrow = $(this).parent('td').parent('tr');
		var documentNum = $killrow.attr('id').split('-')[1];

		aCxcD[documentNum] = null;

		$killrow.remove();

		documentsNumber--;
	});

	$("#documentsTable tbody tr:last .apply").on("click", editApply);

	$("#documentsTable tbody tr:last .apply").on("focusout", function(e){
		var applyTD = $(this);
		var applyText = $("#documentApply").val();
		applyTD.on("click", editApply);
		applyTD.empty();
		applyTD.html(applyText);
	});

	$("#documentsTable tbody tr:last .consecutive").on("click", editConsecutive);

	$("#documentsTable tbody tr:last .consecutive").on("focusout", function(e){
		var consecutiveTD = $(this);
		var consecutiveText = $("#consecutive").val();

		consecutiveTD.on("click", editConsecutive);
		consecutiveTD.empty();
		consecutiveTD.html(consecutiveText);
	});

	$("#documentsTable tbody tr:last .amount").on("click", editAmount);

	$("#documentsTable tbody tr:last .amount").on("focusout", function(e){
		var amountTD = $(this);
		var amountValue = $("#documentAmount").val();

		amountTD.on("click", editAmount);
		amountTD.empty();
		amountTD.html(amountValue);
	});

	$("#documentsTable tbody tr:last .discountPPP").on("click", editDiscountPPP);

	$("#documentsTable tbody tr:last .discountPPP").on("focusout", function(e){
		var discountTD = $(this);
		var discountValue = $("#discountPPP").val();
		
		discountTD.on("click", editDiscountPPP);
		discountTD.empty();
		discountTD.html(discountValue);
	});

	documentsNumber++;
}

var numberOfCharges = 1;
var charges = [null,null,null,null,null];

$("#newChargeRow").on("click", function(){
	
	if(numberOfCharges > 5 ) return;

	var indexNumber = charges.indexOf(null);
	var chargeNumber = indexNumber + 1

	$('#charges').append(
		"<div class='form-group' id='charge"+chargeNumber+"'>" +	    	
			"<div class='col-sm-4'>" +
				"<label for='amount"+chargeNumber+"'>Importe</label>" +
				"<div class='input-group'>"+
					"<div class='input-group-addon'>$</div>"+
					"<input type='number' class='form-control input-sm' id='amount"+chargeNumber+"' name='amount"+chargeNumber+"' min='0' step='any'>"+
				"</div>"+
			"</div>" +
			"<div class='col-sm-4'>" +
				"<label for='charge_type"+chargeNumber+"'>Forma Cobro</label>"+
				"<select id='charge_type"+chargeNumber+"' name='charge_type"+chargeNumber+"' class='form-control input-sm'>"+
					"<option></option>" +
				"</select>" +
			"</div>" +
			"<div class='col-sm-3'>" +
				"<label for='reference"+chargeNumber+"'>Referencia</label>"+
				"<input type='text' class='form-control input-sm' id='reference"+chargeNumber+"' name='reference"+chargeNumber+"'>"+
			"</div>" + 
			"<div class='col-sm-1' id='deleteCharge"+chargeNumber+"'><br>" +
				"<span class='glyphicon glyphicon-remove' style='font-size:30px; text-align:center; display: block;'></span>"+
			"</div>" +
			"<hr>" + 
		"</div>");

	$("#charges div:last#deleteCharge"+chargeNumber).on("click", function(){
		charges[indexNumber] = null;
		numberOfCharges--;
		var $killrow = $(this).parent('div');
		$killrow.remove();
	});

	charges[indexNumber] = numberOfCharges;
	numberOfCharges++;
});

function editApply(e){

	var applyTD = $(e.target);
	var applyTDText = applyTD.html();

	var options = '';
	for(var i=0; i < applyList.length; i++){
		options += '<option value="'+applyList[i]+'">'+applyList[i]+'</option>';
	}

	applyTD.empty();
	applyTD.append("<select class='form-control' id='documentApply'>"+options+"</select>");

	$("#documentApply").on("change", function(){
		var documentRow = getDocNumber(this);
		//console.log(documentRow);
		aCxcD[documentRow].apply =  $(this).val();
		
		console.log(aCxcD);
	});

	$("#documentApply").val(applyTDText);
	$("#documentApply").focus();
	applyTD.off('click');
}

function editConsecutive(e){
	
	if($(e.currentTarget).children().length > 0) return;
	
	var consecutiveTD = $(e.target);
	var consecutiveTDText = consecutiveTD.html();

	consecutiveTD.empty();
	consecutiveTD.append(
		"<div class='input-group'>"+
			"<span class='input-group-btn'>"+
				"<button type='button' class='btn btn-default btn-sm' id='searchConsecutive'>"+
					"<span class='glyphicon glyphicon-search'></span>"+
				"</button>"+
			"</span>"+
			"<input type='text' class='form-control input-sm' id='consecutive' readonly>"+
		"</div>");

	$("#searchConsecutive").on("click", function(e){
		//var idRow = $(this).closest('tr').attr('id');

		$('#clickedRow').val(getDocNumber(this));
		toolbar.saveMov('searchConsecutive');
		//window.location= "{{ url('cxc/movimiento/mov/357/buscar/documento/2048') }}";
	});

	$("#searchConsecutive").focus();

	$("#consecutive").val(consecutiveTDText);

	consecutiveTD.off('click');
}

function editAmount(e){
	if($(e.currentTarget).children().length > 0) return;

	var amountTD = $(e.target);
	var amountValue = amountTD.html();

	amountTD.empty();
	amountTD.append(
		"<div class='input-group'>"+
			"<span class='input-group-btn'>"+
				"<button type='button' class='btn btn-default' data-toggle='modal' data-target='#calculatorModal' id='btnCalculator'>"+
					"<span class='fa fa-calculator'></span>"+
				"</button>"+
			"</span>"+
			"<input type='number' class='form-control' id='documentAmount' min='0' step='any'>" +
		"</div>");

	
	$("#btnCalculator").on("click", function(e){
		documentAmount = document.getElementById("documentAmount");
		input.innerHTML = documentAmount.value;

		//var idRow = $(this).closest('tr').attr('id');
		//idRow = idRow.split('-');
		docRow = getDocNumber(this);
		//console.log( $(this).parent().parent().parent().parent());
		//console.log( $(this).closest('tr'));
		//console.log("id="+docRow);
	});

	$("#documentAmount").on("change", function(){
		var documentRow = getDocNumber(this);
		//console.log(documentRow);
		aCxcD[documentRow].amount = $(this).val();
		
		console.log(aCxcD);
	});

	$("#documentAmount").val(amountValue);

	amountTD.off('click');
}

function editDiscountPPP(e){

	var discountTD = $(e.target);
	var discountValue = discountTD.html();

	discountTD.empty();
	discountTD.append("<input type='number' class='form-control' id='discountPPP' min='0' step='any'>");
	
	$("#discountPPP").focus();
	$("#discountPPP").val(discountValue);
	discountTD.off('click');
}

function getDocNumber(element){
	var idRow = $(element).closest('tr').attr('id');
	idRow = idRow.split('-');
	//docRow = idRow[1];
	return idRow[1];
}

</script>