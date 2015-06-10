var proBalance = $('#pro_balance');
var previousProBalanceAmount = 0.00;
//previousProBalanceAmount = parseFloat(previousProBalanceAmount).toFixed(2);
proBalance.change(function(){
	//var nProBalance = parseFloat(proBalance.val()).toFixed(2);
	var nProBalance = proBalance.val();
	if(nProBalance < 0 || isNaN(nProBalance)){
		//console.log(isNaN(nProBalance));
		//var proBalanceAmount = 0;
		//proBalance.val(proBalanceAmount.toFixed(2));
		previousProBalanceAmount = parseFloat(previousProBalanceAmount).toFixed(2);
		proBalance.val(previousProBalanceAmount);

	}
	//if(nProBalance == 0) proBalance.val('0.00');
	var totalChargeAmount;
	totalChargeAmount = calculateTotalAmount();
	var totalCharge = $('#totalCharge');
	totalCharge.val(totalChargeAmount.toFixed(2));
	totalCharge.change();
	previousProBalanceAmount = parseFloat(proBalance.val());
	proBalance.val(parseFloat(proBalance.val()).toFixed(2));
});

proBalance.focus(function(){
	proBalance.val('');
});

proBalance.blur(function(){
	if(proBalance.val()==''){
		previousProBalanceAmount = parseFloat(previousProBalanceAmount).toFixed(2);
		proBalance.val(previousProBalanceAmount);
		//proBalance.change()
	}
});


//previousChangeAmount = parseFloat(previousChangeAmount);
/*change.change(function(){
	//var nChange = parseFloat(change.val()).toFixed(2);
	var nChange = change.val();
	if(nChange < 0 || isNaN(nChange)){
		//console.log(isNaN(nChange));
		//var changeAmount = 0;
		//change.val(changeAmount.toFixed(2));
		previousChangeAmount = parseFloat(previousChangeAmount).toFixed(2);
		change.val(previousChangeAmount);
	}
	//nChange = parseFloat(nChange).toFixed(2);
	nChange = parseFloat(nChange);
	if(nChange == 0) change.val('0.00');
	var totalAmount = $('#totalAmount');
	var totalCharge = $('#totalCharge');
	if(nChange > 0){
		//console.log(totalCharge.val());
		//console.log(totalAmount.val());
		//var nTotalAmount = parseFloat(totalAmount.val()).toFixed(2);
		//var nTotalCharge = parseFloat(totalCharge.val()).toFixed(2);
		var nTotalAmount = parseFloat(totalAmount.val());
		var nTotalCharge = parseFloat(totalCharge.val());
		if(nTotalCharge <= nTotalAmount){
			change.val('0.00');
			alert("No se puede dar cambio, el cobro total es menor o igual al importe total")
		}else{ 
			var nDifferenceChargeAmount = new Decimal(nTotalCharge).minus(nTotalAmount).toNumber();
			//var chargeAndChange = new Decimal(totalCharge.val()).plus(nChange).toNumber().toFixed(2);
			//nChange = parseFloat(nChange).toFixed(2);
			//nDifferenceChargeAmount = parseFloat(nDifferenceChargeAmount).toFixed(2);
			nDifferenceChargeAmount = parseFloat(nDifferenceChargeAmount);
			console.log(nChange);
			console.log(nDifferenceChargeAmount);
			if(nChange <= nDifferenceChargeAmount) {
				//console.log(nDifferenceChargeAmount);
				//console.log(nChange);
				//previousChangeAmount = parseFloat(previousChangeAmount).toFixed(2);
				//change.val(previousChangeAmount);
				//alert("El cambio excede la diferencia entre el cobro total y el importe total");
				previousChangeAmount = parseFloat(change.val());
				change.val(parseFloat(change.val()).toFixed(2));
			}else{
				previousChangeAmount = parseFloat(previousChangeAmount).toFixed(2);
				change.val(previousChangeAmount);
				//calcTaxes(previousAmount);
				alert("El cambio excede la diferencia entre el cobro total y el importe total");
			}
		}
	}
	//previousChangeAmount = parseFloat(change.val()).toFixed(2);
	//change.val(parseFloat(change.val()).toFixed(2));
});*/
var change = $('#change');
var previousChangeAmount = 0.00;
var paymentTypeListChangeAllowed = [];
change.change(function(){
	//var nChange = parseFloat(change.val()).toFixed(2);
	var nChange = change.val();
	if(nChange < 0 || isNaN(nChange)){
		//console.log(isNaN(nChange));
		//var changeAmount = 0;
		//change.val(changeAmount.toFixed(2));
		previousChangeAmount = parseFloat(previousChangeAmount).toFixed(2);
		change.val(previousChangeAmount);
	}
	//nChange = parseFloat(nChange).toFixed(2);
	nChange = parseFloat(nChange);
	/*console.log(nChange);
	var totalCharge = $('#totalCharge');
	var nTotalCharge = parseFloat(totalCharge.val());
	if(nChange == 0){
		change.val('0.00');
		nChange = parseFloat(change.val());
		nTotalCharge = calculateDifferenceOfSameAmount(nTotalCharge, nChange, previousChangeAmount);
	} */
	//var totalAmount = $('#totalAmount');
	//if(nChange > 0){
		//console.log(totalCharge.val());
		//console.log(totalAmount.val());
		//var nTotalAmount = parseFloat(totalAmount.val()).toFixed(2);
		//var nTotalCharge = parseFloat(totalCharge.val()).toFixed(2);
		//var nTotalAmount = parseFloat(totalAmount.val());
		var totalChangeAllowed = $('#totalChangeAllowed');
		var ntotalChangeAllowed = parseFloat(totalChangeAllowed.val());
		var totalCharge = $('#totalCharge');
		var nTotalCharge = parseFloat(totalCharge.val());
		//ntotalChangeAllowed = calculateTotalChangeAllowed();
		//totalChangeAllowed.val(ntotalChangeAllowed.toFixed(2));
		//totalChangeAllowed.change();
		if(nChange > ntotalChangeAllowed){
			change.val('0.00')
			nChange = 0;
			//nTotalCharge = calculateDifferenceOfSameAmount(nTotalCharge, previousChangeAmount, nChange);
			//change.val(previousChangeAmount);
			//change.change();
			alert("El cambio excede el cambio permitido");
		}
		else{
			//var totalCharge = $('#totalCharge');
			//var nTotalCharge = parseFloat(totalCharge.val());
			//nTotalCharge = nTotalCharge - nChange;
			//var ntotalChangeAllowed2 = new Decimal(nTotalCharge).minus(nChange).toNumber();
			//nTotalCharge = parseFloat(ntotalChangeAllowed2).toFixed(2);
			//previousChangeAmount = parseFloat(previousChangeAmount).toFixed(2);
			//change.val(previousChangeAmount);
			//nTotalCharge = calculateDifferenceOfTotalAmount(nTotalCharge, nChange, previousChangeAmount);
			//nTotalCharge = calculateDifferenceOfSameAmount(nTotalCharge, previousChangeAmount, nChange);
			//if(nTotalCharge<0){
			//nTotalCharge = 0
			//}
			//nTotalCharge -= parseFloat($('#change').val());
			//console.log(nTotalCharge);
			//nTotalCharge = nTotalCharge - nChange;
			//console.log(nTotalCharge);
			//totalCharge.val(nTotalCharge.toFixed(2));
			//totalCharge.change();
			//console.log(previousChangeAmount);
			//console.log(nChange);
			//previousChangeAmount = nChange;
			//change.val(parseFloat(change.val()).toFixed(2));
		}
		var totalChargeAmount;
		totalChargeAmount = calculateTotalAmount();
		//totalChargeAmount = totalChargeAmount - nChange;
		totalCharge.val(totalChargeAmount.toFixed(2));
		//totalCharge.val(nTotalCharge.toFixed(2));
		totalCharge.change();
		//console.log(previousChangeAmount);
		//console.log(nChange);
		previousChangeAmount = nChange;
		change.val(parseFloat(change.val()).toFixed(2));
		/*if(nTotalCharge <= nTotalAmount){
			change.val('0.00');
			alert("No se puede dar cambio, el cobro total es menor o igual al importe total")
		}else{ 
			var nDifferenceChargeAmount = new Decimal(nTotalCharge).minus(nTotalAmount).toNumber();
			//var chargeAndChange = new Decimal(totalCharge.val()).plus(nChange).toNumber().toFixed(2);
			//nChange = parseFloat(nChange).toFixed(2);
			//nDifferenceChargeAmount = parseFloat(nDifferenceChargeAmount).toFixed(2);
			nDifferenceChargeAmount = parseFloat(nDifferenceChargeAmount);
			console.log(nChange);
			console.log(nDifferenceChargeAmount);
			if(nChange <= nDifferenceChargeAmount) {
				//console.log(nDifferenceChargeAmount);
				//console.log(nChange);
				//previousChangeAmount = parseFloat(previousChangeAmount).toFixed(2);
				//change.val(previousChangeAmount);
				//alert("El cambio excede la diferencia entre el cobro total y el importe total");
				previousChangeAmount = parseFloat(change.val());
				change.val(parseFloat(change.val()).toFixed(2));
			}else{
				previousChangeAmount = parseFloat(previousChangeAmount).toFixed(2);
				change.val(previousChangeAmount);
				//calcTaxes(previousAmount);
				alert("El cambio excede la diferencia entre el cobro total y el importe total");
			}
		}*/
	//}
	//previousChangeAmount = parseFloat(change.val()).toFixed(2);
	//change.val(parseFloat(change.val()).toFixed(2));
});

change.focus(function(){
	change.val('');
});

change.blur(function(){
	if(change.val()==''){
		previousChangeAmount = parseFloat(previousChangeAmount).toFixed(2);
		change.val(previousChangeAmount);
		//change.change();
	}
});

/*var amount1 = $("#amount1");
var previousAmount1 = 0.00;
amount1.change(function(){
	var nChange = amount1.val();
	if(nChange < 0 || isNaN(nChange)){
		console.log(isNaN(nChange));
		var changeAmount = 0;
		amount1.val(changeAmount.toFixed(2));
	}
	previousAmount1 = amount1.val();
});

amount1.focus(function(){
	amount1.val('');
});

amount1.blur(function(){
	if(amount1.val()==''){
		amount1.val(previousAmount1);
	}
});*/

var totalCharge = $('#totalCharge');

totalCharge.change(function(){
	var totalAmount = $('#totalAmount');
	var nTotalAmount = parseFloat(totalAmount.val());
	var nTotalCharge = parseFloat(totalCharge.val());
	var nDifference = new Decimal(nTotalAmount).minus(nTotalCharge).toNumber();
	/*console.log(nTotalAmount);
	console.log(nTotalCharge);
	console.log(new Decimal(nTotalAmount));
	console.log(new Decimal(nTotalAmount).minus(nTotalCharge));
	console.log(nDifference);*/
	if(nDifference<0){
		nDifference = 0;
	}
	//console.log(nDifference);
	$('#difference').val(nDifference.toFixed(2));
	$('#difference').change();
	if(nTotalCharge<0){
		totalCharge.val('0.00');
		totalCharge.change();
	}
});	

/*$('#charges').on('click', '#amount1', function(){
	var amount1 = $("#amount1");
	//console.log(amount1);
	var previousAmount1 = 0.00;
	amount1.change(function(){
		var nChange = amount1.val();
		if(nChange < 0 || isNaN(nChange)){
			console.log(isNaN(nChange));
			var changeAmount = 0;
			amount1.val(changeAmount.toFixed(2));
		}
		previousAmount1 = amount1.val();
	});

	amount1.focus(function(){
		amount1.val('');
	});

	amount1.blur(function(){
		if(amount1.val()==''){
			amount1.val(previousAmount1);
		}
	});
	//amount1.change();
});*/
//totalCharge.change();

function calculateTotalCharge(){
	/*var amount1 = $("#amount1");
	var amount2 = $("#amount2");
	var amount3 = $("#amount3");
	var amount4 = $("#amount4");
	var amount5 = $("#amount5");
		
	amount1.change(function(){
		console.log(amount1.val());
	});

	if(amount1){
		console.log(amount1.val());
	}
	if(amount2){
		
		console.log(amount2.val());
	}
	if(amount3){
		
		console.log(amount3.val());
	}
	if(amount4){
		
		console.log(amount4.val());
	}
	if(amount5){
		
		console.log(amount5.val());
	}
	*/
	//console.log('hola');
	/*for (var i = 1; i < 2; i++) {
		console.log('amount'+i);
		$('#charges').on('click', function(){
			//alert("weon funciona");

			var amount = $('#amount1');
			amount.change(function(){
				console.log(amount.val());
			});
		});
	}*/
	var totalCharge = $('#totalCharge');
	var nTotalCharge = parseInt(totalCharge.val());

	$('#charges').on('click', '#amount1', function(){
		//alert("weon funciona");

		var amount = $("#amount1");
		var events = $._data(amount.get(0), 'events').change;
		var numberOfEvents = events.length;
		//console.log(numberOfEvents);
		if(numberOfEvents<2){
			//console.log(events);
			//var previousAmount = parseInt(amount.val());
			var previousAmount = 0.00;
			amount.change(function(){
				//console.log(previousAmount);
				var nAmount =  parseInt(amount.val());
				//console.log(nAmount);
				nTotalCharge += nAmount-previousAmount;
				//console.log(nTotalCharge);
				if(nTotalCharge<1) nTotalCharge = 0;
				totalCharge.val(nTotalCharge);
				previousAmount = nAmount;
				/*var nAmount =  parseInt(amount.val());
				console.log(nAmount);
				//totalCharge.val(totalCharge.val() + amount.val());
				nTotalCharge = nAmount;
				console.log(nTotalCharge);
				totalCharge.val(nTotalCharge);*/
			});
		}
		

		/*var events = $._data(amount.get(0), 'events');
		console.log(events);
		var numberOfEvents = events.size();
		console.log(numberOfEvents);
		var previousAmount = parseInt(amount.val());*/
	});

	/*$('#charges').on('click', '#amount2', function(){
		//alert("weon funciona");
		var amount = $("#amount2");
		amount.change(function(){
			console.log(amount.val());
		});
	});

	$('#charges').on('click', '#amount3', function(){
		//alert("weon funciona");
		var amount = $("#amount3");
		amount.change(function(){
			console.log(amount.val());
		});
	});

	$('#charges').on('click', '#amount4', function(){
		//alert("weon funciona");
		var amount = $("#amount4");
		amount.change(function(){
			console.log(amount.val());
		});
	});

	$('#charges').on('click', '#amount5', function(){
		//alert("weon funciona");
		var amount = $("#amount5");
		amount.change(function(){
			console.log(amount.val());
		});
	});*/

}
/*var amount1 = $("#amount1");
var amount2 = $("#amount2");
var amount3 = $("#amount3");
var amount4 = $("#amount4");
var amount5 = $("#amount5");*/

$(document).ready(function(){
	proBalance.change();
	//change.change();
	totalCharge.change();
	//$('#totalChangeAllowed').val('0.00');
	//var totalChangeAllowed = $('#totalChangeAllowed');
	//var ntotalChangeAllowed = parseFloat(totalChangeAllowed.val());
	//ntotalChangeAllowed = calculateTotalChangeAllowed();
	//console.log(ntotalChangeAllowed);
	//totalChangeAllowed.val(ntotalChangeAllowed.toFixed(2));
	//console.log(totalChangeAllowed.val());
	//totalChangeAllowed.change();
	//for(var i=0; i<aCharges.length; i++){

	//}

	/*for (var i = 1; i < 6; i++) {
		if($('#amount'+i)){
			$('#amount'+i).change();
		}
	}*/
	/*if(amount1 && amount2 && amount3 && amount4 && amount5){
		$("#newChargeRow").prop('disabled',true);
	}*/

	/*amount1.change();
	amount2.change();
	amount3.change();
	amount4.change();
	amount5.change();*/
	//console.log("hola");
	//calculateTotalCharge();

});

$(window).load(function(){
	//alert(nChangeAmount);
	change.val(nChangeAmount);
	change.change();
});