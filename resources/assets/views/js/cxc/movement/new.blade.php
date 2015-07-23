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
	$('#loading').show();
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

@if($mov->status == 'SINAFECTAR' || $mov->status == '')
$(document).ready(function(){

	$('#documentsTable tbody').on('contextmenu', function(e) {

		var dataIndex = $(e.target).closest('tr').attr('data-index');

		if(typeof dataIndex == 'undefined'){
			return false;
		}

		var documentsTableData = $('#documentsTable').bootstrapTable('getData');
		var row;

		if(!documentsTableData || !documentsTableData.length || !(row = documentsTableData[dataIndex]) ) return false;

		//console.log(row);
		showEditRowModal(row)

		if(e.preventDefault)
			e.preventDefault();
		else
			e.returnValue= false;

		return false;
	});

	$('#documentsTable').bootstrapTable('showColumn','actions');
});
@endif
/*
	Pestaña Documentos(Detalle).
*/
var applyOptions = '';


$("#newDocumentRow").on("click", function() {
	var clientID = $('#client_id').val();

	if(!clientID){
		toolbar.showAlertModal('Selecciona un cliente.');
		return;
	}

	var confirmModalBody = $('#confirmModalBody');
	
	confirmModalBody.empty();
	addApplySelect(confirmModalBody);
	addConsecutiveInput(confirmModalBody);

	$('#confirmModal').find('.btn-primary').click(function(){
		var apply = $('#documentApply').val();

		$('#confirmModal').modal('hide');

		addDocumentRow(new CxcD({apply:apply}));
	});

	$('#confirmModal').modal('show');
});

var clientDiscount = parseInt('{{ $clientDiscount }}') || 0;
var movStatus = '{{$mov->status}}';

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

	$('#documentsTable').bootstrapTable('insertRow',{
		index:insertedDocumentPlace,
		row:{
			id:insertedDocumentPlace,
			apply: cxcD.apply,
			apply_id: cxcD.apply_id,
			amount: cxcD.amount,
			difference: cxcDocument.difference(cxcD.amount),
			difference_percent: cxcDocument.diferencePercent(cxcD.amount),
			concept: cxcDocument.concept,
			reference: cxcDocument.reference,
			pp_discount: cxcD.p_p_discount,
			pp_suggest: cxcDocument.pp_suggest,
			actions: "<div class='deleteDocument'><div class='glyphicon glyphicon-remove'></div></div>"
		}
	});

	if( (movStatus == '' || movStatus == 'SINAFECTAR') && clientDiscount && cxcDocument.pp_suggest){
		$('#documentsTable').bootstrapTable('showColumn','pp_suggest');
	}

	// Actualizar importe total
	updateTotalAmount(0, cxcD.amount + cxcD.p_p_discount);

	return insertedDocumentPlace;
}

var actionEvents = {
    'click .deleteDocument' : function (e, value, row, index) {
        //alert('You click like icon, row: ' + JSON.stringify(row));
        var documentNum = row.id;
        // Actualizar importe total
		if(aCxcD[documentNum])
			updateTotalAmount(aCxcD[documentNum].amount + aCxcD[documentNum].p_p_discount , 0);

		aCxcD[documentNum] = null;
		aCxcDocs[documentNum] = null;

        $('#documentsTable').bootstrapTable('removeByUniqueId', documentNum);
    }/*,
    'click .edit': function (e, value, row, index) {
        alert('You click edit icon, row: ' + JSON.stringify(row));
        console.log(value, row, index);
    },
    'click .remove': function (e, value, row, index) {
        alert('You click remove icon, row: ' + JSON.stringify(row));
        console.log(value, row, index);
    }*/
};

function addApplySelect(element, value){

	if(typeof value == 'undefined')
		value = '';

	element.append(
		'<label for="documentApply">Aplica</label>'+
		'<select class="form-control input-sm" id="documentApply">'+
			applyOptions+
		'</select>'
	);

	$('#documentApply').val(value);

	$('#documentApply').change(function(){
		var rowid = $('#rowid').val();

		if(typeof rowid == 'undefined')
			return;
		
		clearRowInfo(rowid);
	});
}

function addConsecutiveInput(element,value){

	if(typeof value == 'undefined')
		value = '';

	element.append(
		'<label for="consecutive">Consecutivo</label>'+
		'<div class="input-group">'+
			'<span class="input-group-btn">'+
				'<button type="button" class="btn btn-default btn-sm" id="searchConsecutive">'+
					'<span class="glyphicon glyphicon-search"></span>'+
				'</button>'+
			'</span>'+
			'<input type="text" class="form-control input-sm" id="consecutive" value="'+value+'" readonly>'+
		'</div>'
	);

	$("#searchConsecutive").click( function(e){

		var apply = $('#documentApply').val();

		if(!apply){
			toolbar.showAlertModal('Selecciona un aplica.');
			return;
		}

		var rowid = $('#rowid').val();

		if( typeof rowid == 'undefined' ){
			rowid = addDocumentRow(new CxcD({apply:apply}));
		}
		else{
			updateRowInfo();
		}

		$('#confirmModal').modal('hide');

		$('#clickedRow').val(rowid);
		toolbar.saveMov('searchConsecutive');
	});
}

function addAmountInput(element,value){
	if(typeof value == 'undefined')
		value = '';

	element.append(
		'<label for="documentAmount">Importe</label>'+
		'<div class="input-group">'+
			'<span class="input-group-btn">'+
				'<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#calculatorModal" id="btnCalculator">'+
					'<span class="fa fa-calculator"></span>'+
				'</button>'+
			'</span>'+
			'<input type="number" class="form-control input-sm" id="documentAmount" value="'+value+'">' +
		'</div>'
	);

	$("#btnCalculator").on("click", function(e){
		documentAmount = document.getElementById("documentAmount");
		input.innerHTML = documentAmount.value;

		docRow = $('#rowid').val();
	});

	$("#documentAmount").on("change", function(){
		//var documentRow = $('#rowid').val();
		//var previousAmount = aCxcD[documentRow].amount;
		//var actualAmount = aCxcD[documentRow].amount = $(this).val();

		//Actualizar en el boton 'actualizar'
		//updateRowDifference(documentRow);

		// Actualizar importe total
		//updateTotalAmount(previousAmount, actualAmount);

		var rowid = $('#rowid').val();
		var amount = parseFloat($(this).val()) || 0;
		var balance = 0;
		var doc = aCxcDocs[rowid];

		if(doc){
			balance = doc.balance;
		}
		//console.log(amount,balance,doc);
		var difference = new Decimal(balance).minus(amount).toNumber();
		//console.log(difference);
		$('#doc-difference').val(difference.toFixed(2));
	});
}

function addDiscountInput(element,value){
	if(typeof value == 'undefined')
		value = '';

	element.append(
		'<label for="discountPPP">Descuento</label>'+
		'<input type="number" class="form-control input-sm" id="discountPPP" value="'+value+'">'
	);
}

function addDifferenceInput(element, value){
	informationInput =
		'<label for="doc-difference" class="control-label">Diferencia</label>'+
		'<div class="input-group">'+
			'<div class="input-group-addon">$</div>'+
			'<input type="text" id="doc-difference" class="form-control input-sm" readonly value="'+value+'">'+
		'</div>';

	element.append(informationInput);
}

function addInformationInput(element, label, id, value){
	informationInput =
		'<label for="'+id+'" class="control-label">'+label+'</label>'+
		'<input type="text" id="'+id+'" class="form-control input-sm" readonly value="'+value+'">';

	element.append(informationInput);
}

function addHiddenInput(element, id, value){
	informationInput =
		'<input type="hidden" id="'+id+'" value="'+value+'">';

	element.append(informationInput);
}

function showEditRowModal(row){

	$('#confirmModal').find('.btn-primary').html('Actualizar');
	$('#confirmModal').find('.btn-default').html('Cancelar');

	$('#confirmModal').find('.btn-primary').click(function(){
		updateRowInfo();
	});

	var confirmModalBody = $('#confirmModalBody');
	
	confirmModalBody.empty();

	confirmModalBody.append('<input type="hidden" id="rowid" value="'+row.id+'">');
	addApplySelect(confirmModalBody, row.apply);
	addConsecutiveInput(confirmModalBody, row.apply_id);

	addAmountInput(confirmModalBody, row.amount);
	addDifferenceInput(confirmModalBody, row.difference);
	
	if( (movStatus == '' || movStatus == 'SINAFECTAR') && clientDiscount){
	//if(row.pp_suggest){
		addDiscountInput(confirmModalBody, row.pp_discount);
		addInformationInput(confirmModalBody, 'Sugerencia', 'suggestPPP', row.pp_suggest);
	}

	addInformationInput(confirmModalBody, 'Concepto', 'doc-concept', row.concept);
	
	if(row.reference)
		addInformationInput(confirmModalBody, 'Referencia', 'doc-reference', row.reference);
	//else
		//addHiddenInput(confirmModalBody, 'doc-reference', row.reference);

	var balance = 0;
	if(aCxcDocs[row.id] && aCxcDocs[row.id].balance){
		balance = aCxcDocs[row.id].balance;
	}
	addHiddenInput(confirmModalBody, 'doc-balance', balance);

	$('#confirmModal').modal('show');
}

function updateRowInfo(){
	
	var rowid = $('#rowid').val();
	var apply = $('#documentApply').val();
	var apply_id = $('#consecutive').val();
	var amount = parseFloat($('#documentAmount').val()) || 0;
	var pp_discount = parseFloat($('#discountPPP').val()) || 0;
	var pp_suggest = parseFloat($('#suggestPPP').val()) || 0;
	var reference = $('#doc-reference').val() || '';
	var concept = $('#doc-concept').val() || '';
	var balance = $('#doc-balance').val() || 0;

	var cxcD = aCxcD[rowid];
	var cxcDoc = aCxcDocs[rowid];

	var tableData = $('#documentsTable').bootstrapTable('getData');
	var row = null;

	if(!tableData || !(row = tableData[rowid]))
		return;

	//console.log(row);
	//return;
	//console.log(cxcD);
	var difference = cxcDoc.difference(amount);
	var diferencePercent = cxcDoc.diferencePercent(amount);

	var previousAmount = cxcD.amount;
	var previousDiscount = cxcD.p_p_discount;

	cxcD.amount = amount;
	cxcD.p_p_discount = pp_discount;
	cxcD.apply = apply;
	cxcD.apply_id = apply_id;

	cxcDoc.balance = balance;
	cxcDoc.concept = concept;
	cxcDoc.reference = reference;
	cxcDoc.pp_suggest = pp_suggest;

	console.log(cxcD);
	$('#confirmModal').modal('hide');

	//addDocumentRow(new CxcD({apply:apply}));
	row.apply = apply;
	row.apply_id = apply_id;
	row.amount = amount;
	row.pp_discount = pp_discount;
	row.difference = difference;
	row.difference_percent = diferencePercent;

	row.pp_suggest = pp_suggest;
	row.reference = reference;
	row.concept = concept;

	console.log(row,aCxcD,aCxcDocs);
	//console.log(row);

	$('#documentsTable').bootstrapTable('updateRow',{
		index:rowid,
		row:row
	});

	// Actualizar importe total
	updateTotalAmount(previousAmount + previousDiscount, cxcD.amount + cxcD.p_p_discount);
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

function clearRowInfo(rowid){

	$('#consecutive').val('');
	$('#documentAmount').val(0);
	$('#discountPPP').val(0);
	$('#doc-difference').val(0);
	$('#doc-reference').val('');
	$('#doc-concept').val('');
	$('#suggestPPP').val(0);
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
			"<div class='col-xs-2 col-xs-offset-4 col-sm-offset-0 col-sm-1 ' id='deleteCharge"+chargeNumber+"'><br>" +
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

function moneyFormatter(value){
	var valueFormatted = parseFloat(value) || 0;
	return '$' + moneyFormatForNumbers;
	//return '$'+valueFormatted.toFixed(2);
}

</script>

