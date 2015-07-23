var proBalance = $('#pro_balance');
var previousProBalanceAmount = 0;

proBalance.change(function(){

	var nProBalance = parseFloat(proBalance.val());
	if(nProBalance < 0 || isNaN(nProBalance)){
		proBalance.val(moneyFormatForNumbers(previousProBalanceAmount));
		//proBalance.val(previousProBalanceAmount.toFixed(2));
		return;
	}

	var totalCharge = $('#totalCharge');
	var totalChargeAmount;

	totalChargeAmount = calculateTotal(totalCharge.val(), nProBalance, previousProBalanceAmount)
	
	totalCharge.val(totalChargeAmount.toFixed(2));
	totalCharge.change();

	previousProBalanceAmount = nProBalance;
	proBalance.val(moneyFormatForNumbers(nProBalance));
	//proBalance.val(nProBalance.toFixed(2));
});

proBalance.focus(function(){
	proBalance.val('');
});

proBalance.blur(function(){
	if(proBalance.val()==''){
		proBalance.val(moneyFormatForNumbers(previousProBalanceAmount));
		//proBalance.val(previousProBalanceAmount.toFixed(2));
	}
});

var change = $('#change');
var previousChangeAmount = 0;
var paymentTypeListChangeAllowed = [];

change.change(function(){

	var nChange = change.val();
	if(nChange < 0 || isNaN(nChange)){

		change.val(previousChangeAmount.toFixed(2));
		return;
	}

	nChange = parseFloat(nChange);

	var totalChangeAllowed = $('#totalChangeAllowed');
	var ntotalChangeAllowed = parseFloat(totalChangeAllowed.val()) || 0;

	if(nChange > ntotalChangeAllowed){
		change.val('0.00')
		nChange = 0;

		alert("El cambio excede el cambio permitido");
	}

	var totalCharge = $('#totalCharge');
	var nTotalCharge = parseFloat(totalCharge.val()) || 0;
	var totalChargeAmount;
	totalChargeAmount = calculateTotal(nTotalCharge, -nChange, -previousChangeAmount);

	totalCharge.val(totalChargeAmount.toFixed(2));
	totalCharge.change();

	previousChangeAmount = nChange;
	change.val(nChange.toFixed(2));

});

change.focus(function(){
	change.val('');
});

change.blur(function(){
	if(change.val()==''){
		change.val(previousChangeAmount.toFixed(2));
	}
});

$('#totalCharge').change(function(){
	var totalCharge = $(this);

	calcTaxes(totalCharge.val());
	calculateChargeDifference();
});	

function calculateChargeDifference(){
	var totalAmount = $('#totalAmount');
	var totalCharge = $('#totalCharge');

	var nTotalAmount = parseFloat(totalAmount.val()) || 0;
	var nTotalCharge = parseFloat(totalCharge.val()) || 0;
	var nDifference = new Decimal(nTotalAmount).minus(nTotalCharge).toNumber();

	/*if(nDifference<0){
		nDifference = 0;
	}*/
	$('#difference').val(nDifference.toFixed(2));
}

$('#totalAmount').change(function(){
	calculateChargeDifference();
});

$('#totalChangeAllowed').change(function(){
	change.change();
});

$(window).load(function(){
	if(nChangeAmount){
		change.val(nChangeAmount);
	}else{
		change.val('0.00');
	}
	change.change();
	proBalance.change();
});