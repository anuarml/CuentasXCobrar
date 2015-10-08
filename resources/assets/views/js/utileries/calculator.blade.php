<script type="text/javascript">
// Get all the keys from document
var keys = document.querySelectorAll('#calculator span');
var operators = ['+', '-', '*', '/', '%'];
//var operatorRegExp = /[+-*]/;
var decimalAdded = false;
var isPercentage = false;
var equation;
var firstbtnVal;
var pressedBtn = false;
var resultInput; 

var input = document.querySelector('.screen');
var docRow;

//console.log("weon");
// Add onclick event to all the keys and perform operations
for(var i = 0; i < keys.length; i++) {
	
	keys[i].onclick = function(e) {
		// Get the input and button values
		//var input = document.querySelector('.screen');
		var inputVal = input.innerHTML;
		var btnVal = this.innerHTML;
		
		// Now, just append the key values (btnValue) to the input string and finally use javascript's eval function to get the result
		// If clear key is pressed, erase everything
		if(btnVal == 'C') {
			input.innerHTML = '';
			decimalAdded = false;
			isPercentage = false;
		}
		// If eval key is pressed, calculate and display the result
		else if(btnVal == '=') {
		    equation = inputVal;
			var lastChar = equation[equation.length - 1];
			
			// Replace all instances of x and ÷ with * and / respectively. This can be done easily using regex and the 'g' tag which will replace all instances of the matched character/substring
			//equation = equation.replace(/x/g, '*').replace(/÷/g, '/');
			
			// Final thing left to do is checking the last character of the equation. If it's an operator or a decimal, remove it
			//&& operators.indexOf(lastChar) < 4
			if(operators.indexOf(lastChar) > -1 || lastChar == '.'){
				/*if(operators.indexOf(lastChar) == 4){
					isPercentage = true;
				}*/
				equation = equation.replace(/.$/, '');
			}
			
			/*if((operators.indexOf(btnVal) >-1) && operators.indexOf(btnVal) <=3){
				firstbtnVal = btnVal;
				console.log(firstbtnVal);
			}*/
			
			if(equation){
				if(operators.indexOf(lastChar) > -1){
					var result;
					isPercentage = false;
					result = calculateResult(equation, isPercentage);
					input.innerHTML = eval(result);
				}else{
					input.innerHTML = eval(equation);
				}
				
				/*var oCalculadora = {};
				oCalculadora.calculatorPressed = true;
				oCalculadora.value = parseFloat(input.innerHTML);
				oStorage.store('oCalculadora', oCalculadora);
				console.log(oCalculadora.calculatorPressed);*/
				/*var documentAmount = document.getElementById("documentAmount");
				documentAmount.value = input.innerHTML;*/
				//var row = $()
				//CxcD.amount = input.innerHTML;
				//aCxcD[docRow].amount = ;
				//$('#documentAmount').val(parseFloat(input.innerHTML) || 0);
				//$('#documentAmount').change();
				//console.log(aCxcD[docRow].amount);
				//$('#document-'+docRow + ' .amount').html(input.innerHTML);// = input.innerHTML;
				//console.log($('#document-'+docRow + ' .amount').html());
				//$('#calculatorModal').modal('toggle');
				//toolbar.saveMov('resultCalculator');
				//window.location	= "{{ url('cxc/movimiento/mov/238#documentos') }}";

				resultInput.val(parseFloat(input.innerHTML) || 0);
				resultInput.change();
				$('#calculatorModal').modal('toggle');
			}
				
			decimalAdded = false;
		}
		
		// Basic functionality of the calculator is complete. But there are some problems like 
		// 1. No two operators should be added consecutively.
		// 2. The equation shouldn't start from an operator except minus
		// 3. not more than 1 decimal should be there in a number
		
		// We'll fix these issues using some simple checks
		
		// indexOf works only in IE9+
		
		
		else if(operators.indexOf(btnVal) > -1) {
			
			
			// Operator is clicked
			// Get the last character from the equation
			var lastChar = inputVal[inputVal.length - 1];
			
			// Only add operator if input is not empty and there is no operator at the last
			if(inputVal != '' && operators.indexOf(lastChar) == -1) 
				input.innerHTML += btnVal;
			
			// Allow minus if the string is empty
			else if(inputVal == '' && btnVal == '-') 
				input.innerHTML += btnVal;
			
			// Replace the last operator (if exists) with the newly pressed operator
			if(operators.indexOf(lastChar) > -1 && inputVal.length > 1) {
				// Here, '.' matches any character while $ denotes the end of string, so anything (will be an operator in this case) at the end of string will get replaced by new operator
				input.innerHTML = inputVal.replace(/.$/, btnVal);
			}
			
			decimalAdded =false;
		}
		
		// Now only the decimal problem is left. We can solve it easily using a flag 'decimalAdded' which we'll set once the decimal is added and prevent more decimals to be added once it's set. It will be reset when an operator, eval or clear key is pressed.
		else if(btnVal == '.') {
			if(!decimalAdded) {
				input.innerHTML += btnVal;
				decimalAdded = true;
			}
		}
		
		// if any other key is pressed, just append it
		else {
			input.innerHTML += btnVal;
		}
		
		if((operators.indexOf(btnVal) >-1) && operators.indexOf(btnVal) <=3 && pressedBtn == false){
			firstbtnVal = btnVal;
			console.log(firstbtnVal);
			pressedBtn = true;
		}
		
		if((operators.indexOf(btnVal) > -1) && inputVal.length>=3){
			equation = inputVal;
			//console.log(equation);
			//equation = equation.replace(/x/g, '*').replace(/÷/g, '/');
			var result;
			if(equation){
				if(operators.indexOf(btnVal) == 4){
					isPercentage = true;
					result = calculateResult(equation, isPercentage);
					input.innerHTML = eval(result);	
					pressedBtn = false;
				}else{
					isPercentage = false;
					result = calculateResult(equation, isPercentage);
					input.innerHTML = eval(result);
					input.innerHTML += btnVal;
					firstbtnVal = btnVal;
				}
				console.log(firstbtnVal);
				inputVal.length = 0;
			}
			
		}

		// prevent page jumps
		e.preventDefault();	
	}
}

function calculateResult(equation, isPercentage){
	var operation = equation;
	var firstNum;
	var operator = firstbtnVal;
	var secondNum;
	var percentageResult;
	var resultOfSplit;
	var result;
	console.log(equation);
	//console.log(operator);
	//resultOfSplit = equation.split(/[\+\-\*\/]/);
	resultOfSplit = equation.split(operator);
	console.log('1stn: '+resultOfSplit[0]);
	console.log('2ndn: '+resultOfSplit[1]);
	firstNum = new Decimal(resultOfSplit[0]);
	secondNum = new Decimal(resultOfSplit[1]);
	console.log(firstNum);
	console.log(secondNum);
	if(isPercentage){
		percentageResult = secondNum.dividedBy(100).times(firstNum);
	}else{
		percentageResult = secondNum;
	}
	console.log(percentageResult);
	switch(operator){
		case '+':
			result = firstNum.plus(percentageResult);
			break;
		case '-':
			result = firstNum.minus(percentageResult);
			break;
		case '*':
			result = firstNum.times(percentageResult);
			break;
		case '/':
			result = firstNum.dividedBy(percentageResult);
			break;	 
	}
	
	return result;
}

</script>