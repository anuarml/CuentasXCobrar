//Se debe usar cuando se tengan numeros que tengan menos de 3 decimales
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function moneyFormatForNumbers(x){
	if(typeof x != 'number'){
		console.error('[app.js] moneyFormatForNumbers(): '+x+' is a '+typeof(x)+' not a number.');
		return null;
	}

	x = x.toFixed(2);
	x = numberWithCommas(x);

	return x;
}

function moneyFormatToNumber(x){
	
	try{
		if(typeof x == 'number'){
			console.log('[app.js] moneyFormatToNumber(): Nothing to convert '+x+' is already a number.');
			return x;
		}

		if(typeof x != 'string'){
			console.error('[app.js] moneyFormatToNumber(): '+x+' is a '+typeof(x)+' not a string.');
			return 0;
		}

		return parseFloat(x.replace(/,/g,'')) || 0;
	}catch(ex){
		console.log(ex);
	}
	
}


//Se debe usar cuando se tengan numeros que tengan mas de 3 decimales
/*function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}*/