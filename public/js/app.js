//Se debe usar cuando se tengan numeros que tengan menos de 3 decimales
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function moneyFormatForNumbers(x){
	x = x.toFixed(2)
	x = numberWithCommas(x);
	//console.log(x);
	return x;
}

function moneyFormatToNumber(x){
	
	try{
		if(!x) x='0';
		return x.replace(/,/g,'');
	}catch(ex){
		console.log(ex.stack);
	}
	
}


//Se debe usar cuando se tengan numeros que tengan mas de 3 decimales
/*function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}*/