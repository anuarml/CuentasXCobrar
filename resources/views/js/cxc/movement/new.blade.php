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

//var documentsNumber = 0;

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
			"<td style='text-align: center;' class='amount'>$"+(cxcD.amount.toFixed(2) || '')+"</td>"+
			"<td style='text-align: center;' class='difference'>"+cxcDocument.difference(cxcD.amount)+"</td>"+
			"<td style='text-align: center;' class='differencePercentage'>"+cxcDocument.diferencePercent(cxcD.amount)+"</td>"+
			"<td style='text-align: center;' class='concept'>"+(cxcDocument.concept || '')+"</td>"+
			"<td style='text-align: center;' class='reference'>"+(cxcDocument.reference || '')+"</td>"+
			"<td style='text-align: center;' class='discountPPP' "+suggesPPVisibility+">"+(cxcD.p_p_discount.toFixed(2) || '')+"</td>"+
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
	
	/*$("#documentsTable tbody tr:last .deleteDocument").on("click", function(){

		var $killrow = $(this).parent('td').parent('tr');
		var documentNum = $killrow.attr('id').split('-')[1];

		// Actualizar importe total
		if(aCxcD[documentNum])
			updateTotalAmount(aCxcD[documentNum].amount, 0);

		aCxcD[documentNum] = null;
		aCxcDocs[documentNum] = null;

		$killrow.remove();

		//documentsNumber--;
	});*/

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
				updateTotalAmount(aCxcD[documentNum].amount, 0);

			aCxcD[documentNum] = null;
			aCxcDocs[documentNum] = null;

			$killrow.remove();

			//documentsNumber--;
		});
	@endif
	//$("#documentsTable tbody tr:last .apply").on("click", editApply);

	$("#documentsTable tbody tr:last .apply").on("focusout", function(e){
		var applyTD = $(this);
		var applyText = $("#documentApply").val();
		applyTD.on("click", editApply);
		applyTD.empty();
		applyTD.html(applyText);
	});

	//$("#documentsTable tbody tr:last .consecutive").on("click", editConsecutive);

	$("#documentsTable tbody tr:last .consecutive").on("focusout", function(e){
		var consecutiveTD = $(this);
		var consecutiveText = $("#consecutive").val();

		consecutiveTD.on("click", editConsecutive);
		consecutiveTD.empty();
		consecutiveTD.html(consecutiveText);
	});

	//$("#documentsTable tbody tr:last .amount").on("click", editAmount);

	$("#documentsTable tbody tr:last .amount").on("focusout", function(e){
		var amountTD = $(this);
		var amountValue = $("#documentAmount").val();

		amountTD.on("click", editAmount);
		amountTD.empty();
		amountTD.html(amountValue);
	});

	//$("#documentsTable tbody tr:last .discountPPP").on("click", editDiscountPPP);

	$("#documentsTable tbody tr:last .discountPPP").on("focusout", function(e){
		var discountTD = $(this);
		var discountValue = $("#discountPPP").val();
		
		discountTD.on("click", editDiscountPPP);
		discountTD.empty();
		discountTD.html(discountValue);
	});

	$("#totalAmount").val();

	// Actualizar importe total
	updateTotalAmount(0, cxcD.amount);

	//documentsNumber++;

}

var numberOfCharges = 1;
var charges = [null,null,null,null,null];
var paymentTypeList = [];
var nChangeAmount = "{{$mov->change}}";
$("#newChargeRow").on("click", function() {addChargeRow();});

function addChargeRow(charge){
//$("#newChargeRow").on("click", function(){
	var charge = charge || new Charge();
	var emptyPlace = aCharges.indexOf(null);
	var chargeNumber;
	//var chargesLenght = aCharges.length;

	
	if(numberOfCharges > 5 ) return;

	// No hay un espacio en null.
	if(emptyPlace == -1) {
		// Se agrega al final.
		chargeNumber = aCharges.length + 1;
		charge.tableRowID = chargeNumber;
		aCharges.push(charge);
	}
	else {
		// Se agrega en el espacio vacio.
		chargeNumber = emptyPlace + 1;
		charge.tableRowID = chargeNumber;
		aCharges[emptyPlace] = charge;
		

	}

	var options = '';

	for(var i=1; i < paymentTypeList.length; i++){
		var paymentType = paymentTypeList[i];
		options += '<option value="'+paymentType.payment_type+'">'+paymentType.payment_type+'</option>';
	}

	//var indexNumber = aCharges.indexOf(null);
	//var chargeNumber = indexNumber + 1
	@if($mov->status == 'SINAFECTAR' || $mov->status == '')
		$('#charges').append(
		"<div class='form-group' id='charge-"+chargeNumber+"'>" +	    	
			"<div class='col-sm-4'>" +
				"<label for='amount"+chargeNumber+"'>Importe</label>" +
				"<div class='input-group'>"+
					"<div class='input-group-addon'>$</div>"+
					"<input type='number' class='form-control input-sm' id='amount"+chargeNumber+"' name='amount"+chargeNumber+"' value='"+ (charge.amount || '0.00') +"' min='0' step='any'>"+
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
					"<input type='number' class='form-control input-sm' id='amount"+chargeNumber+"' name='amount"+chargeNumber+"' value='"+ (charge.amount || '0.00') +"' min='0' step='any' readonly>"+
				"</div>"+
			"</div>" +
			"<div class='col-sm-4'>" +
				"<label for='charge_type"+chargeNumber+"'>Forma Cobro</label>"+
				"<select id='charge_type"+chargeNumber+"' name='charge_type"+chargeNumber+"' class='form-control input-sm' disabled='true'>"+
					options +
				"</select>" +
			"</div>" +
			"<div class='col-sm-3'>" +
				"<label for='reference"+chargeNumber+"'>Referencia</label>"+
				"<input type='text' class='form-control input-sm' id='reference"+chargeNumber+"' name='reference"+chargeNumber+"' value='"+ (charge.reference || '') +"' readonly>"+
			"</div>" + 
			"<hr>" + 
		"</div>");
	@endif

	

	$('#charge_type'+chargeNumber).val(charge.payment_type || '');
	
	/*var previousAmount = 0.00;
	amount1.change(function(){
		var nChange = amount1.val();
		if(nChange < 0 || isNaN(nChange)){
			console.log(isNaN(nChange));
			var changeAmount = 0;
			amount1.val(changeAmount.toFixed(2));
		}
		previousAmount = amount1.val();
	});

	amount1.focus(function(){
		amount1.val('');
	});

	amount1.blur(function(){
		if(amount1.val()==''){
			amount1.val(previousAmount);
		}
	});*/
	
	var previousAmount = 0.00;
	var previousChangeAllowed = 0.00;
	var previousSelectedChargeType = '';
	var selectedChargeType = '';
	//var total = 0;
	//previousAmount = parseFloat(previousAmount).toFixed(2);
	$("#charges div#charge-" + chargeNumber + " #amount"+chargeNumber).on("change", function(){
		var totalCharge = $('#totalCharge');
		//var nTotalCharge = parseFloat(totalCharge.val()).toFixed(2);
		var nTotalCharge = parseFloat(totalCharge.val());
		var nAmount = $(this).val();
		//console.log(nAmount);
		if(nAmount < 0 || isNaN(nAmount)){
			//console.log(isNaN(nAmount));
			/*if(previousAmount == 0){
				var changeAmount = 0;
				$(this).val(changeAmount.toFixed(2));
			}else{*/
			previousAmount = parseFloat(previousAmount).toFixed(2)
			$(this).val(previousAmount);
			charge.amount = parseFloat($(this).val());
			
			//}
		}else{
			//nTotalCharge += (nAmount-previousAmount);
			//var nTotalCharge2 = new Decimal(nTotalCharge).plus(nAmount).toNumber();
			//console.log(nTotalCharge2);
			//var nTotalCharge3 = new Decimal(nTotalCharge2).minus(previousAmount).toNumber();
			//console.log(nTotalCharge3);
			//nTotalCharge = parseFloat(nTotalCharge3);
			nAmount = parseFloat(nAmount);
			nTotalCharge = calculateDifferenceOfSameAmount(nTotalCharge,nAmount,previousAmount);
			//nTotalCharge = nTotalCharge + nAmount;
			//nTotalCharge = nTotalCharge - previousAmount;
			if(nTotalCharge<1) nTotalCharge = 0;
			//nTotalCharge = calculateTotalAmount();
			totalCharge.val(nTotalCharge.toFixed(2));
			totalCharge.change();
			//selectedChargeType = $('#charge_type'+chargeNumber+' option:selected').text();
			//console.log(selectedChargeType);
			//console.log(parseFloat($(this).val()).toFixed(2));
			//var isChangeAllowed = parseInt(paymentTypeListChangeAllowed[selectedChargeType]);
			//console.log(selectedChargeType);
			//if(isChangeAllowed){
				
				//console.log('si acepto');
				//var change = $('#change');
				//var nchange = parseFloat(change.val());
				//var totalChangeAllowed = $('#totalChangeAllowed');
				//var ntotalChangeAllowed = parseFloat(totalChangeAllowed.val());
				//console.log(ntotalChangeAllowed);
				//console.log(nAmount);
				//console.log(previousAmount);
				//Caso cuando se pone primero el amount y luego se selecciona la forma de cobro
				//if(nAmount == previousAmount){
					//var ntotalChangeAllowed2 = new Decimal(ntotalChangeAllowed).plus(nAmount).toNumber();
					//ntotalChangeAllowed = parseFloat(ntotalChangeAllowed2);
					//ntotalChangeAllowed = nAmount;
				//}else{
					//var ntotalChangeAllowed2 = new Decimal(ntotalChangeAllowed).plus(nAmount).toNumber();
					//var ntotalChangeAllowed3 = new Decimal(ntotalChangeAllowed2).minus(previousAmount).toNumber();
					//ntotalChangeAllowed = parseFloat(ntotalChangeAllowed3);
					//ntotalChangeAllowed = calculateDifferenceOfSameAmount(ntotalChangeAllowed,nAmount,previousAmount);
				//}
				//ntotalChangeAllowed = ntotalChangeAllowed + parseFloat($(this).val());
				//console.log(ntotalChangeAllowed);
				
				//console.log(aCharges[chargeNumber-1]);
				//console.log("Numoer de cargo: " + chargeNumber);
				//Se guarda en el cobro lo que tiene al final
				//totalChangeAllowed.val(ntotalChangeAllowed.toFixed(2));
				//totalChangeAllowed.change();
				//change.change();
			//}
			//console.log("Cargo: " + aCharges[0].reference);
			previousAmount = nAmount;
			//previousChangeAllowed = ntotalChangeAllowed; 
			$(this).val(parseFloat($(this).val()).toFixed(2));
			
			aCharges[chargeNumber-1].amount = parseFloat($(this).val());
			aCharges[chargeNumber-1].payment_type = selectedChargeType;
			aCharges[chargeNumber-1].reference = $('#reference'+chargeNumber).val();
			var totalChangeAllowed = $('#totalChangeAllowed');
			var ntotalChangeAllowed = parseFloat(totalChangeAllowed.val());
			ntotalChangeAllowed = calculateTotalChangeAllowed();
			totalChangeAllowed.val(ntotalChangeAllowed.toFixed(2));
			totalChangeAllowed.change();
			var change = $('#change');
			//change.change();
			/*isChangeAllowed = parseInt(paymentTypeListChangeAllowed[aCharges[chargeNumber-1].payment_type]);
			console.log(isChangeAllowed);
			if(isChangeAllowed){
			total += aCharges[chargeNumber-1].amount;
			}*/
			
			/*for(var i=0; i<aCharges.length; i++){
				if(aCharges[i]){
					if(isChangeAllowed){
						total = total + aCharges[i].amount;
					}
				}
			}*/
			/*console.log("Amount: " + chargeNumber);
			console.log(aCharges[chargeNumber-1].amount);
			console.log("Payment Type: " + chargeNumber);
			console.log(aCharges[chargeNumber-1].payment_type)
			console.log("Total: " + total);*/
			//var change = $('#change');
			//change.change()
			
		}
		//previousSelectedChargeType = $('#charge_type'+chargeNumber+' option:selected').text();
		//console.log("Antes:"+previousSelectedChargeType);
		//previousAmount = $(this).val();
	});

	$("#charges div#charge-" + chargeNumber + " #amount"+chargeNumber).on("focus", function(){
		$(this).val('');
	});

	$("#charges div#charge-" + chargeNumber + " #amount"+chargeNumber).on("blur", function(){
		if($(this).val()==''){
			previousAmount = parseFloat(previousAmount).toFixed(2);
			$(this).val(previousAmount);
			//$(this).change();
		}
	});

	$("#charges div#charge-" + chargeNumber + " #charge_type"+chargeNumber).on("change", function(){
		selectedChargeType = $('#charge_type'+chargeNumber+' option:selected').text();
		if(selectedChargeType != previousSelectedChargeType && 
			parseInt(paymentTypeListChangeAllowed[selectedChargeType]) != parseInt(paymentTypeListChangeAllowed[previousSelectedChargeType])){
			//console.log("Ahora:"+selectedChargeType);
			//console.log("Antes:"+previousSelectedChargeType);
			if(parseInt(paymentTypeListChangeAllowed[selectedChargeType])){
				//console.log(parseFloat($('#amount'+chargeNumber).val()).toFixed(2));
				//console.log($('#totalChangeAllowed').val())
				$('#amount'+chargeNumber).change();
				$('#totalChangeAllowed').change();
			}else{
				var totalChangeAllowed = $('#totalChangeAllowed');
				var ntotalChangeAllowed = parseFloat(totalChangeAllowed.val());
				var nAmount = parseFloat($('#amount'+chargeNumber).val());
				var ntotalChangeAllowed2 = new Decimal(ntotalChangeAllowed).minus(nAmount).toNumber();
				ntotalChangeAllowed = parseFloat(ntotalChangeAllowed2);
				//ntotalChangeAllowed = ntotalChangeAllowed - nAmount;
				if(ntotalChangeAllowed < 0) ntotalChangeAllowed =0;
				totalChangeAllowed.val(ntotalChangeAllowed.toFixed(2));
				totalChangeAllowed.change();
				$('#amount'+chargeNumber).change();
				//if(nAmount != previousAmount){
					
				//}
			}
		}
	});

	$("#charges div:last#deleteCharge"+chargeNumber).on("click", function(){
		$('#amount'+chargeNumber).val(0.00);
		$('#amount'+chargeNumber).change();
		var $killrow = $(this).parent('div');
		var chargeNum = $killrow.attr('id').split('-')[1];
		chargeNum = chargeNum -1;
		aCharges[chargeNum] = null;
		//console.log(aCharges[chargeNum]);
		//console.log(aCharges.length)
		//console.log(aCharges);
		numberOfCharges--;
		//var $killrow = $(this).parent('div');
		$killrow.remove();
	});

	$("#charges div#charge-" + chargeNumber + " #reference"+chargeNumber).on("change", function(){
		$('#amount'+chargeNumber).change();
	});




	//charges[indexNumber] = numberOfCharges;
	
	//var totalChangeAllowed = $('#totalChangeAllowed');
	//var ntotalChangeAllowed = parseFloat(totalChangeAllowed.val());
	//ntotalChangeAllowed = calculateTotalChangeAllowed();
	//console.log(ntotalChangeAllowed);
	//totalChangeAllowed.val(ntotalChangeAllowed.toFixed(2));
	//console.log(totalChangeAllowed.val());
	//totalChangeAllowed.change();
	$('#amount'+chargeNumber).change();
	$('#charge_type'+chargeNumber).change();
	numberOfCharges++;
}//);

function calculateTotalChangeAllowed(){
	var total = 0;
	//console.log(aCharges);
	for(var i=0; i<aCharges.length; i++){
		if(aCharges[i]){
			var isChangeAllowed = parseInt(paymentTypeListChangeAllowed[aCharges[i].payment_type]);
			if(isChangeAllowed){
				/*var totalChangeAllowed = $('#totalChangeAllowed');
				var ntotalChangeAllowed = parseFloat(totalChangeAllowed.val());
				console.log("TotalChange: " + ntotalChangeAllowed);
				var chargeNumber = i+1;
				var charge = $('#amount'+chargeNumber);
				console.log(charge)
				var nChargeAmount = parseFloat(charge.val());
				console.log("ChargeAmount: " + nChargeAmount);
				total = calculateDifferenceOfTotalAmount(ntotalChangeAllowed, nChargeAmount, parseFloat(aCharges[i].amount));*/
				total = total + aCharges[i].amount;
				//console.log("Amount: " + i);
				//console.log(aCharges[i].amount);
				//console.log("Payment Type: " + i);
				//console.log(aCharges[i].payment_type)
			}
		}
	}
	//console.log("Total: " + total);
	return total;
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
	var totalCharge = new Decimal(totalChargeInput.val() || 0);

	actualAmount = new Decimal(actualAmount || 0);

	totalCharge = totalCharge.plus(actualAmount.minus(previousAmount));

	totalChargeInput.val(totalCharge.toNumber().toFixed(2));

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

function calculateDifferenceOfSameAmount(amount, actualAmount, previousAmount){
	var amount2 = new Decimal(amount).plus(actualAmount);
	//console.log("1: " + amount2);
	var amount3 = amount2.minus(previousAmount).toNumber();
	//console.log("2: " + amount3);
	//console.log(amount3);
	amount = parseFloat(amount3);
	return amount;
}

function calculateDifferenceOfTotalAmount(amount, plusAmount, minusAmount){
	//console.log("amount: " + amount);
	//console.log("plusAmount: " + plusAmount);
	//console.log("minusAmount: " + minusAmount);
	var amount2 = new Decimal(amount).minus(minusAmount).toNumber();
	//console.log("1: " + amount2);
	var amount3 = new Decimal(amount2).plus(plusAmount).toNumber();
	//console.log("2: " + amount3);
	//var amount4 = new Decimal(amount3).minus(plusAmount).toNumber();
	//console.log("3: " + amount4);
	//var amount5 = new Decimal(amount4).minus(plusAmount).toNumber();
	//console.log("3: " + amount5);
	amount = parseFloat(amount3);
	return amount;
}

function calculateTotalAmount(){
	var total = 0;
	var change = $('#change');
	var proBalance = $('#pro_balance');
	var nChange = parseFloat(change.val());
	var nProBalance = parseFloat(proBalance.val());
	for(var i=0; i<aCharges.length; i++){
		if(aCharges[i]){
			total +=  aCharges[i].amount;
		}
	}
	total -= nChange;
	total += nProBalance;
	//console.log("Total: " + total); 	
	return total;
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

