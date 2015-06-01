var proBalance = $('#pro_balance');
var previousProBalanceAmount = 0.00;
proBalance.change(function(){
	var nProBalance = proBalance.val();
	if(nProBalance < 0 || isNaN(nProBalance)){
		//console.log(isNaN(nProBalance));
		//var proBalanceAmount = 0;
		//proBalance.val(proBalanceAmount.toFixed(2));
		proBalance.val(previousProBalanceAmount);
	}
	previousProBalanceAmount = proBalance.val();
});

proBalance.focus(function(){
	proBalance.val('');
});

proBalance.blur(function(){
	if(proBalance.val()==''){
		proBalance.val(previousProBalanceAmount);
	}
});

var change = $('#change');
var previousChangeAmount = 0.00;
change.change(function(){
	var nChange = change.val();
	if(nChange < 0 || isNaN(nChange)){
		//console.log(isNaN(nChange));
		//var changeAmount = 0;
		//change.val(changeAmount.toFixed(2));
		change.val(previousChangeAmount);
	}
	previousChangeAmount = change.val();
});

change.focus(function(){
	change.val('');
});

change.blur(function(){
	if(change.val()==''){
		change.val(previousChangeAmount);
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
	var nTotalAmount = totalAmount.val();
	var nTotalCharge = totalCharge.val();
	var nDifference = new Decimal(nTotalAmount).minus(nTotalCharge).toNumber();
	/*console.log(nTotalAmount);
	console.log(nTotalCharge);
	console.log(new Decimal(nTotalAmount));
	console.log(new Decimal(nTotalAmount).minus(nTotalCharge));
	console.log(nDifference);*/
	if(nDifference<0){
		nDifference = 0;
	}
	console.log(nDifference);
	$('#difference').val(nDifference);
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
				console.log(previousAmount);
				var nAmount =  parseInt(amount.val());
				console.log(nAmount);
				nTotalCharge += nAmount-previousAmount;
				console.log(nTotalCharge);
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
	change.change();
	totalCharge.change();
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