var proBalance = $('#pro_balance');
var previousProBalanceAmount = 0;

proBalance.change(function(){

	var nProBalance = parseFloat(moneyFormatToNumber(proBalance.val())) || 0;
	if(nProBalance < 0 || isNaN(nProBalance)){
		proBalance.val(moneyFormatForNumbers(previousProBalanceAmount));
		//proBalance.val(previousProBalanceAmount.toFixed(2));
		return;
	}

	var totalCharge = $('#totalCharge');
	var nTotalCharge = parseFloat(moneyFormatToNumber(totalCharge.val())) || 0;
	var totalChargeAmount;
	//console.log("proBalance: " + nProBalance);
	//console.log("previousProBalance: " + previousProBalanceAmount);
	//console.log("totalCharge pro antes: " + nTotalCharge);
	totalChargeAmount = calculateTotal(nTotalCharge, nProBalance, previousProBalanceAmount);
	//totalChargeAmount = calculateTotal(moneyFormatToNumber(totalCharge.val()), nProBalance, previousProBalanceAmount)
	//console.log("totalCharge pro despues: " + totalChargeAmount);
	totalCharge.val(moneyFormatForNumbers(totalChargeAmount));
	totalCharge.change();

	previousProBalanceAmount = nProBalance;
	proBalance.val(moneyFormatForNumbers(nProBalance));
	calculateChange();
	//proBalance.focus();
	//proBalance.blur();
	//proBalance.val(nProBalance.toFixed(2));
});

proBalance.focus(function(){
	proBalance.val('');
});

proBalance.blur(function(){
	if(proBalance.val()==''){
		proBalance.val(moneyFormatForNumbers(previousProBalanceAmount));
		proBalance.change();
		//proBalance.val(previousProBalanceAmount.toFixed(2));
	}
});

var change = $('#change');
var previousChangeAmount = 0;
var paymentTypeListChangeAllowed = [];

change.change(function(){

	var nChange = moneyFormatToNumber(change.val());
	if(nChange < 0 || isNaN(nChange)){

		change.val(moneyFormatForNumbers(previousChangeAmount));
		console.log(nChange);
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
	var nTotalCharge = parseFloat(moneyFormatToNumber(totalCharge.val())) || 0;
	//console.log("Total Charge:" + nTotalCharge)
	var totalChargeAmount;
	totalChargeAmount = calculateTotal(nTotalCharge, -nChange, -previousChangeAmount);

	totalCharge.val(moneyFormatForNumbers(totalChargeAmount));
	totalCharge.change();

	previousChangeAmount = nChange;
	change.val(moneyFormatForNumbers(nChange));

});

change.focus(function(){
	change.val('');
});

change.blur(function(){
	if(change.val()==''){
		change.val(moneyFormatForNumbers(previousChangeAmount));
		change.change();
	}
});

$('#totalCharge').change(function(){
	var totalCharge = $(this);
	var nTotalCharge = parseFloat(moneyFormatToNumber(totalCharge.val())) || 0;
	//console.log("HOla" + nTotalCharge);
	calcTaxes(nTotalCharge);
	calculateChargeDifference();
	//calculateChange();

});	

function calculateChargeDifference(){
	var totalAmount = $('#totalAmount');
	var totalCharge = $('#totalCharge');

	var nTotalAmount = parseFloat(moneyFormatToNumber(totalAmount.val())) || 0;
	var nTotalCharge = parseFloat(moneyFormatToNumber(totalCharge.val())) || 0;
	var nDifference = new Decimal(nTotalAmount).minus(nTotalCharge).toNumber();

	/*if(nDifference<0){
		nDifference = 0;
	}*/
	$('#difference').val(moneyFormatForNumbers(nDifference));
	$('#difference').change();
}

function calculateChange(){
	var difference = $('#difference');
	var change = $('#change');
	var differenceVal = parseFloat(moneyFormatToNumber(difference.val())) || 0;
	var changeVal = parseFloat(moneyFormatToNumber(change.val())) || 0;
	//var totalChangeVal = calculateTotal(changeVal, changeVal, previousChangeAmount);
	//console.log("TotalChangeVal "+ totalChangeVal);
	var changeAmount = (-1)*(differenceVal)+changeVal;

	var totalChangeAllowed = $('#totalChangeAllowed');
	var ntotalChangeAllowed = parseFloat(moneyFormatToNumber(totalChangeAllowed.val())) || 0;
	var totalAmount = $('#totalAmount');
	var totalCharge = $('#totalCharge');
	var nTotalAmount = parseFloat(moneyFormatToNumber(totalAmount.val())) || 0;
	var nTotalCharge = parseFloat(moneyFormatToNumber(totalCharge.val()));
	var nProBalance = parseFloat(moneyFormatToNumber(proBalance.val())) || 0;
	//console.log("total charge " + nTotalCharge);
	//console.log("change "+ changeAmount);
	//console.log("allow " + ntotalChangeAllowed);
	//console.log("pro " + nProBalance);
	//console.log("total amount" + nTotalAmount);
	if(changeAmount>ntotalChangeAllowed){
		
		$('#change').val(moneyFormatForNumbers(ntotalChangeAllowed));
	}else if((nTotalCharge-nProBalance+changeVal)<nTotalAmount){
		//console.log("entro");
		$('#change').val(moneyFormatForNumbers(0.00));
	}else{
		$('#change').val(moneyFormatForNumbers(changeAmount));
	}
	
	$('#change').change();

}

$('#totalAmount').change(function(){
	calculateChargeDifference();
	//calculateChange();
});

$('#totalChangeAllowed').change(function(){
	//change.change();
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