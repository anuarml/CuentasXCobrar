<script type="text/javascript">

/*
	Cambio de pestaña por medio de URL.
*/
var url = document.location.toString();
var movementId;
if (url.match('#')) {
    $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
} 
// Change hash for page-reload
$('.nav-tabs a').on('shown', function (e) {
    window.location.hash = e.target.hash;
})


/*
	Pestaña Datos Generales.
*/
$("#searchClient").on("click", function(e){
	window.location= "{{ url('cxc/movimiento/buscar/cliente') }}";
});

$("#searchClientOffice").on("click", function(e){
	toolbar.saveMov('searchClientOffice');
});

$("#searchMovReference").on("click", function(e){
	toolbar.saveMov('searchMovReference');
});

$("#showClientBalance").on("click", function(e){
	toolbar.saveMov('showClientBalance');
});

$("#Mov").on("change", function(e){
	
	$('#hidden_mov').val(this.value);
	this.disabled = true;
	verifyMov();
});


/*
	Pestaña Documentos(Detalle).
*/
$("#newDocumentRow").on("click", function() {addDocumentRow();});

var suggesPPVisibility = 'hidden';

function addDocumentRow(cxcD, cxcDocument){

	var cxcD = cxcD || new CxcD();
	var cxcDocument = cxcDocument || new CxcDocument();
	var emptyPlace = aCxcD.indexOf(null);
	var insertedDocumentPlace;

	// No hay un espacio en null.
	if(emptyPlace == -1) {
		// Se agrega al final.
		insertedDocumentPlace = aCxcD.length;
		cxcD.tableRowID = insertedDocumentPlace;
		aCxcD.push(cxcD);
		aCxcDocs.push(cxcDocument);
	}
	else {
		// Se agrega en el espacio vacio.
		insertedDocumentPlace = emptyPlace;
		cxcD.tableRowID = insertedDocumentPlace;
		aCxcD[emptyPlace] = cxcD;
		aCxcDocs[emptyPlace] = cxcDocument;
	}

	$('#documentsTable tbody').append(
		"<tr id='document-"+insertedDocumentPlace+"'>"+
			"<td style='text-align: center;' class='apply'>"+(cxcD.apply || '')+"</td>"+
			"<td style='text-align: center;' class='consecutive'>"+(cxcD.apply_id || '')+"</td>"+
			"<td style='text-align: center;' class='amount' id='tdDocumentAmount'>$"+(cxcD.amount.toFixed(2) || '')+"</td>"+
			"<td style='text-align: center;' class='difference'>"+cxcDocument.difference(cxcD.amount)+"</td>"+
			"<td style='text-align: center;' class='differencePercentage'>"+cxcDocument.diferencePercent(cxcD.amount)+"</td>"+
			"<td style='text-align: center;' class='concept'>"+(cxcDocument.concept || '')+"</td>"+
			"<td style='text-align: center;' class='reference'>"+(cxcDocument.reference || '')+"</td>"+
			"<td style='text-align: center;' class='discountPPP' "+suggesPPVisibility+">$"+(cxcD.p_p_discount.toFixed(2) || '')+"</td>"+
			"<td style='text-align: center;' class='suggestPPP' "+suggesPPVisibility+">"+(cxcDocument.pp_suggest.toFixed(2) || '')+"</td>"+
			"<td style='text-align: center;'>"+
				"<div class='deleteDocument'>"+
					"<div class='glyphicon glyphicon-remove'></div>"+
				"</div>"+
			"</td>"+
		"</tr>");

	if(cxcDocument.pp_suggest != 0){
		showPPSuggest();
	}

	@if($mov->status == 'SINAFECTAR' || $mov->status == '')
		$("#documentsTable tbody tr:last .apply").on("click", editApply);
		$("#documentsTable tbody tr:last .consecutive").on("click", editConsecutive);
		$("#documentsTable tbody tr:last .amount").on("click", editAmount);
		$("#documentsTable tbody tr:last .discountPPP").on("click", editDiscountPPP);
		$("#documentsTable tbody tr:last .deleteDocument").on("click", function(){

			var $killrow = $(this).parent('td').parent('tr');
			var documentNum = $killrow.attr('id').split('-')[1];

			// Actualizar importe total
			if(aCxcD[documentNum])
				updateTotalAmount(aCxcD[documentNum].amount + aCxcD[documentNum].p_p_discount , 0);

			aCxcD[documentNum] = null;
			aCxcDocs[documentNum] = null;

			$killrow.remove();
		});
	@endif


	$("#documentsTable tbody tr:last .apply").on("focusout", function(e){
		var applyTD = $(this);
		var applyText = $("#documentApply").val();
		applyTD.on("click", editApply);
		applyTD.empty();
		applyTD.html(applyText);
	});


	$("#documentsTable tbody tr:last .consecutive").on("focusout", function(e){
		var consecutiveTD = $(this);
		var consecutiveText = $("#consecutive").val();

		consecutiveTD.on("click", editConsecutive);
		consecutiveTD.empty();
		consecutiveTD.html(consecutiveText);
	});


	$("#documentsTable tbody tr:last .amount").on("focusout", function(e){
		var amountTD = $(this);
		var amountValue = $("#documentAmount").val();

		amountTD.on("click", editAmount);
		amountTD.empty();
		if(amountValue != '')
			amountTD.html('$' + parseFloat(amountValue).toFixed(2));
		else
			amountTD.html('$' + parseFloat(cxcD.amount).toFixed(2))
	});


	$("#documentsTable tbody tr:last .discountPPP").on("focusout", function(e){
		var discountTD = $(this);
		var discountValue = $("#discountPPP").val();
		
		discountTD.on("click", editDiscountPPP);
		discountTD.empty();
		discountTD.html(discountValue);

		if(discountValue == ''){
			discountTD.html('$' + parseFloat(cxcD.p_p_discount).toFixed(2) );
		}
		else{
			discountTD.html('$' + parseFloat(discountValue).toFixed(2) );
		}
	});

	// Actualizar importe total
	updateTotalAmount(0, cxcD.amount + cxcD.p_p_discount);
}

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

		aCxcD[documentRow].apply =  $(this).val();
		clearRowInfo(this);
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

		$('#clickedRow').val(getDocNumber(this));
		toolbar.saveMov('searchConsecutive');
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
			"<input type='number' class='form-control' id='documentAmount' min='0'>" +
		"</div>");

	
	$("#btnCalculator").on("click", function(e){
		documentAmount = document.getElementById("documentAmount");
		input.innerHTML = documentAmount.value;

		docRow = getDocNumber(this);
	});

	$("#documentAmount").on("change", function(){
		var documentRow = getDocNumber(this);
		var previousAmount = aCxcD[documentRow].amount;
		var actualAmount = aCxcD[documentRow].amount = $(this).val();

		updateRowDifference(this);

		// Actualizar importe total
		updateTotalAmount(previousAmount, actualAmount);
	});

	$("#documentAmount").val(amountValue);

	amountTD.off('click');
}

function editDiscountPPP(e){

	var discountTD = $(e.target);
	var discountValue = discountTD.html();

	discountTD.empty();
	discountTD.append("<input type='number' class='form-control' id='discountPPP'>");

	$("#discountPPP").change( function() {
		var documentRow = getDocNumber(this);
		var previousAmount = aCxcD[documentRow].p_p_discount;
		var actualAmount = aCxcD[documentRow].p_p_discount = $(this).val();
		// Actualizar importe total
		updateTotalAmount(previousAmount, actualAmount);
	});
	
	$("#discountPPP").focus();
	$("#discountPPP").val(discountValue);
	discountTD.off('click');
}

function showPPSuggest(){

	if( $('.suggestPPP').attr('hidden') == 'hidden'){

		suggesPPVisibility = '';
		$('.discountPPP').attr('hidden',false);
		$('.suggestPPP').attr('hidden',false);
		$('.discountPPPHeader').attr('hidden',false);
		$('.suggestPPPHeader').attr('hidden',false);
	}
}

function getDocNumber(element){
	var idRow = $(element).closest('tr').attr('id');
	idRow = idRow.split('-');
	//docRow = idRow[1];
	return idRow[1];
}

function updateRowDifference(element){
	var row = $(element).closest('tr');
	var docPosition = getDocNumber(element);

	var cxcD = aCxcD[docPosition];
	var cxcDoc = aCxcDocs[docPosition];

	row.find('.difference').html(cxcDoc.difference(cxcD.amount));
	row.find('.differencePercentage').html(cxcDoc.diferencePercent(cxcD.amount));
}

function clearRowInfo(element){
	var row = $(element).closest('tr');
	var docPosition = getDocNumber(element);

	var cxcD = aCxcD[docPosition];
	var cxcDoc = aCxcDocs[docPosition];

	cxcD.apply_id = null;
	cxcD.amount = null;
	cxcD.p_p_discount = null;

	cxcDoc.balance = null;
	cxcDoc.concept = null;
	cxcDoc.reference = null;

	row.find('.consecutive').html('');
	row.find('.amount').html('');
	row.find('.difference').html('');
	row.find('.differencePercentage').html('');
	row.find('.concept').html('');
	row.find('.reference').html('');
	row.find('.discountPPP').html('');
	row.find('.suggestPPP').html('');
}

function updateTotalAmount(previousAmount, actualAmount){
	var totalChargeInput = $('#totalAmount');
	var totalCharge = new Decimal(parseFloat(totalChargeInput.val()) || 0);

	actualAmount = new Decimal(parseFloat(actualAmount) || 0);

	totalCharge = totalCharge.plus(actualAmount.minus(parseFloat(previousAmount) || 0));

	totalChargeInput.val(totalCharge.toNumber().toFixed(2));
	totalChargeInput.change();
}



/*
	Pestaña Desglose Cobro.
*/
var numberOfCharges = 1;
var charges = [null,null,null,null,null];
var paymentTypeList = [];
var nChangeAmount = "{{$mov->change}}";
$("#newChargeRow").on("click", function() {addChargeRow();});

function addChargeRow(charge){

	var charge = charge || new Charge();
	var emptyPlace = aCharges.indexOf(null);
	var chargeNumber;
	
	if(numberOfCharges > 5 ) return;

	// No hay un espacio en null.
	if(emptyPlace == -1) {
		// Se agrega al final.
		chargeNumber = aCharges.length + 1;
		//charge.tableRowID = chargeNumber;
		aCharges.push(charge);
	}
	else {
		// Se agrega en el espacio vacio.
		chargeNumber = emptyPlace + 1;
		//charge.tableRowID = chargeNumber;
		aCharges[emptyPlace] = charge;
	}

	var options = '';

	for(var i=1; i < paymentTypeList.length; i++){
		var paymentType = paymentTypeList[i];
		options += '<option value="'+paymentType.payment_type+'">'+paymentType.payment_type+'</option>';
	}

	@if($mov->status == 'SINAFECTAR' || $mov->status == '')
		$('#charges').append(
		"<div class='form-group' id='charge-"+chargeNumber+"'>" +	    	
			"<div class='col-sm-4'>" +
				"<label for='amount"+chargeNumber+"'>Importe</label>" +
				"<div class='input-group'>"+
					"<div class='input-group-addon'>$</div>"+
					"<input type='number' class='form-control input-sm' id='amount"+chargeNumber+"' name='amount"+chargeNumber+"' value='"+ (charge.amount.toFixed(2) || '0.00') +"' min='0' step='any'>"+
				"</div>"+
			"</div>" +
			"<div class='col-sm-4'>" +
				"<label for='charge_type"+chargeNumber+"'>Forma Cobro</label>"+
				"<select id='charge_type"+chargeNumber+"' name='charge_type"+chargeNumber+"' class='form-control input-sm'>"+
					
					options +
				"</select>" +
			"</div>" +
			"<div class='col-sm-3'>" +
				"<label for='reference"+chargeNumber+"'>Referencia</label>"+
				"<input type='text' class='form-control input-sm' id='reference"+chargeNumber+"' name='reference"+chargeNumber+"' value='"+ (charge.reference || '') +"'>"+
			"</div>" + 
			"<div class='col-sm-1' id='deleteCharge"+chargeNumber+"'><br>" +
				"<span class='glyphicon glyphicon-remove' style='font-size:30px; text-align:center; display: block;'></span>"+
			"</div>" +
			"<hr>" + 
		"</div>");
	@else
		$('#charges').append(
		"<div class='form-group' id='charge-"+chargeNumber+"'>" +	    	
			"<div class='col-sm-4'>" +
				"<label for='amount"+chargeNumber+"'>Importe</label>" +
				"<div class='input-group'>"+
					"<div class='input-group-addon'>$</div>"+
					"<input type='number' class='form-control input-sm' id='amount"+chargeNumber+"' name='amount"+chargeNumber+"' value='"+ (charge.amount.toFixed(2) || '0.00') +"' min='0' step='any' readonly>"+
				"</div>"+
			"</div>" +
			"<div class='col-sm-4'>" +
				"<label for='charge_type"+chargeNumber+"'>Forma Cobro</label>"+
				"<input type='text' class='form-control input-sm' id='charge_type"+chargeNumber+"' name='charge_type"+chargeNumber+"' value='"+ (charge.payment_type || '') +"' readonly>"+
				/*"<select id='charge_type"+chargeNumber+"' name='charge_type"+chargeNumber+"' class='form-control input-sm' disabled='true'>"+
					options +
				"</select>" +*/
			"</div>" +
			"<div class='col-sm-3'>" +
				"<label for='reference"+chargeNumber+"'>Referencia</label>"+
				"<input type='text' class='form-control input-sm' id='reference"+chargeNumber+"' name='reference"+chargeNumber+"' value='"+ (charge.reference || '') +"' readonly>"+
			"</div>" + 
			"<hr>" + 
		"</div>");
	@endif

	

	$('#charge_type'+chargeNumber).val(charge.payment_type || '');
	

	var amountInput = $('#amount'+chargeNumber);

	amountInput.change( function(){
		
		var amountInput = $(this);
		var totalChargeInput = $('#totalCharge');

		var nTotalCharge = parseFloat(totalChargeInput.val());
		var nAmount = parseFloat(amountInput.val());
		var previousAmount = 0;
		//Se obtiene el cobro correspondiente al input del arreglo de cobros.
		var charge = getCharge(amountInput);

		if(!charge) return;

		// Se obtiene el importe anterior almacenado en el arreglo de cobros.
		previousAmount = charge.amount;

		// Si se introduce un valor negativo o no númerico se regresa al valor anterior.
		if(nAmount < 0 || isNaN(nAmount)){

			amountInput.val(previousAmount.toFixed(2));
			return;
		}

		// Se actualiza el importe del cobro.
		charge.amount = nAmount;
		//Se formatea el nuevo valor y se muestra.
		amountInput.val(nAmount.toFixed(2));

		// Se calcula el cobro total.
		nTotalCharge = calculateTotal(nTotalCharge,nAmount,previousAmount);

		// Se actualiza el cobro total en la vista.
		totalChargeInput.val(nTotalCharge.toFixed(2));
		totalChargeInput.change();

		
		var paymentTypeAllowChange = charge.payment_type && paymentTypeListChangeAllowed[charge.payment_type] == 1;

		// Si el tipo de pago permite cambio se calcula el campo: totalChangeAllowed.
		if(paymentTypeAllowChange){
			var totalChangeAllowedInput = $('#totalChangeAllowed');
			var totalChangeAllowed = totalChangeAllowedInput.val();
			
			// Se actualiza el cambio permitido.
			totalChangeAllowed = calculateTotal(totalChangeAllowed, nAmount, previousAmount);

			totalChangeAllowedInput.val(totalChangeAllowed.toFixed(2));
			totalChangeAllowedInput.change();
		}
	});

	amountInput.focus( function(){
		$(this).val('');
	});

	amountInput.blur( function(){
		var amountInput = $(this);
		if(amountInput.val()==''){

			var charge = getCharge(amountInput);

			if(!charge) return;

			var previousAmount = charge.amount;

			amountInput.val(previousAmount.toFixed(2));
		}
	});

	$('#charge_type'+chargeNumber).change( function(){

		var chargeTypeInput = $(this);
		var charge = getCharge(chargeTypeInput);

		if(!charge) return;

		var previousChargeType = charge.payment_type;

		charge.payment_type = chargeTypeInput.val();


		var previousPaymentTypeAllowChange = previousChargeType && paymentTypeListChangeAllowed[previousChargeType] == 1;
		var paymentTypeAllowChange = charge.payment_type && paymentTypeListChangeAllowed[charge.payment_type] == 1;

		if(paymentTypeAllowChange != previousPaymentTypeAllowChange){

			var totalChangeAllowedInput = $('#totalChangeAllowed');
			var totalChangeAllowed = parseFloat(totalChangeAllowedInput.val()) || 0;

			if(paymentTypeAllowChange && !previousPaymentTypeAllowChange){

				totalChangeAllowed = calculateTotal(totalChangeAllowed, charge.amount, 0);
			}
			else if(!paymentTypeAllowChange && previousPaymentTypeAllowChange){
				
				totalChangeAllowed = calculateTotal(totalChangeAllowed, 0, charge.amount);
			}

			totalChangeAllowedInput.val(totalChangeAllowed.toFixed(2));
			totalChangeAllowedInput.change();
		}
	});

	$('#deleteCharge'+chargeNumber).click( function(){
		var deleteChargeButton = $(this);
		var chargeNum = getChargeNumber(deleteChargeButton);

		var amountInput = $('#amount'+(chargeNum+1));
		amountInput.val(0);
		amountInput.change();

		aCharges[chargeNum] = null;
		
		numberOfCharges--;

		var $killrow = $(this).parent('div');
		$killrow.remove();
	});

	$('#reference'+chargeNumber).change( function(){
		//amountInput.change(); wtf??????
		var referenceInput = $(this);
		var charge = getCharge(referenceInput);

		if(!charge) return;

		charge.reference = referenceInput.val();
	});


	//amountInput.change();
	//$('#charge_type'+chargeNumber).change();
	//$('#reference'+chargeNumber).change();
	if(charge.amount) {
		var totalChargeInput = $('#totalCharge');
		var totalCharge = parseFloat(totalChargeInput.val()) || 0;

		totalCharge = calculateTotal(totalCharge, charge.amount, 0);

		totalChargeInput.val(totalCharge.toFixed(2));
		//totalChargeInput.change();
	}

	numberOfCharges++;
}

function getChargeNumber(element){
	var elementID = $(element).attr('id');
	var chargeNumber = -1;

	if(!elementID || elementID.length < 1)
		return chargeNumber;

	chargeNumber = parseInt(elementID.charAt(elementID.length - 1)) || 0;

	return chargeNumber - 1;
}

function getCharge(element){
	var chargeNumber = getChargeNumber(element);
	var charge = null;

	// Se valida que exista el cobro en el arreglo de cobros.
	if(!aCharges || !(charge = aCharges[chargeNumber])){
		console.error('No existe el cobro en memoria.');
		return null;
	}

	return charge;
}

function calculateTotal(amount, actualAmount, previousAmount){
	
	amount = new Decimal(parseFloat(amount) || 0);
	actualAmount = parseFloat(actualAmount) || 0;
	previousAmount = parseFloat(previousAmount) || 0;

	amount = amount.plus(actualAmount);
	amount = amount.minus(previousAmount);

	return amount.toNumber();
}

function calcTaxes(amountWithTaxes){
	var amount;
	var taxes;
	var IVA = 1.16;

	amountWithTaxes = parseFloat(amountWithTaxes) || 0;
	amountWithTaxes = new Decimal(amountWithTaxes);

	amount = amountWithTaxes.div(IVA);
	taxes = amountWithTaxes.minus(amount).toNumber();

	$('#amount').val(amount.toNumber().toFixed(2));
	$('#taxes').val(taxes.toFixed(2));

}

</script>

