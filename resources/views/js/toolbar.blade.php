<script type="text/javascript">

var toolbar = {

	movStatus : '{{$mov->status}}',
	movID : '{{$mov->ID}}',

	confirmSaveChanges : function(defaultCallback, action){

		if( !toolbar.movStatus || toolbar.movStatus == 'SINAFECTAR'){
			$('#confirmModalBody').html('<img width="25px" src="{{asset("img/save.png")}}">&nbsp;&nbsp;&nbsp;&nbsp;¿Guardar cambios?');
			$('#confirmModal').find('.btn-default').click(defaultCallback);
			$('#confirmModal').find('.btn-primary').click(function(){
				toolbar.saveMov(action);
			});
			$('#confirmModal').modal('show');
		}
		else {
			defaultCallback();
		}
	},

	confirmCancelMov : function(){

		$('#confirmModalBody').html('<img width="25px" src="{{asset("img/cancel.png")}}">&nbsp;&nbsp;&nbsp;&nbsp;¿Cancelar el movimiento?');
		$('#confirmModal').find('.btn-primary').click(function(){ toolbar.cancelMov();});
		$('#confirmModal').modal('show');
	},

	confirmDeleteMov : function(){

		$('#confirmModalBody').html('<img width="25px" src="{{asset("img/delete.png")}}">&nbsp;&nbsp;&nbsp;&nbsp;¿Eliminar el movimiento?');
		$('#confirmModal').find('.btn-primary').click(function(){ toolbar.deleteMov(); });
		$('#confirmModal').modal('show');
	},

	showAlertModal: function(message){
		$('#alertModalBody').html(message);
		$('#alertModal').modal('show');
	},

	newMov : function(){
		$('#loading').show();
		toolbar.redirect("{{ url('cxc/movimiento/nuevo') }}", 'POST');
	},

	saveMov : function(actionType){

		if(!toolbar.verifySave()){
			return;
		}

		console.log('save');

		$('#loading').show();

		$('#action').val(actionType);
		$('#documentsJson').val( JSON.stringify(aCxcD) );
		$('#cxcMovForm').submit();
	},

	printMov : function(){
		generateText();
	},

	openMov : function(){
		//toolbar.redirect("{{ url('cxc/movimiento/abrir') }}", 'GET');
		$('#loading').show();
		window.location = "{{ url('cxc/movimiento/abrir')}}";
	},

	deleteMov: function(){
		if(!toolbar.verifyDelete()){
			return;
		}
		$('#loading').show();
		toolbar.redirect("{{ url('cxc/movimiento/delete') }}", 'POST');
	},

	affectMov : function(){
		
		if(!toolbar.verifyAffect()){
			return;
		}

		$('#loading').show();
		if(toolbar.movStatus == 'PENDIENTE'){
			window.location = "{{ url('cxc/movimiento/affect') }}";
		}
		else{
			toolbar.saveMov('affect');
		}
	},

	cancelMov: function(){
		if(!toolbar.verifyCancel()){
			return;
		}
		$('#loading').show();
		toolbar.redirect("{{ url('cxc/movimiento/cancel') }}", 'POST');
	},

	verifySave: function(){
		var success = false;
		var clientID = $('#client_id').val();
		var currency = $('#currency').val();
		var mov = $('#hidden_mov').val();

		if(toolbar.movStatus && toolbar.movStatus != 'SINAFECTAR'){
			toolbar.showAlertModal('Solo se pueden guardar movimientos con estatus \'SINAFECTAR\'.');
			return success;
		}
		if(!clientID){
			toolbar.showAlertModal('Es necesario seleccionar un cliente.');
			return success;
		}
		if(!mov){
			toolbar.showAlertModal('Es necesario seleccionar un movimiento.');
			return success;
		}
		if(!currency){
			toolbar.showAlertModal('Es necesario seleccionar una moneda.');
			return success;
		}

		success = true;

		return success;
	},

	verifyAffect: function(){
		var success = false;
		var movType = '{{$mov->Mov}}';

		if(toolbar.movStatus && toolbar.movStatus != 'SINAFECTAR' && toolbar.movStatus != 'PENDIENTE'){
			toolbar.showAlertModal('Solo se pueden afectar movimientos con estatus \'SINAFECTAR\' o \'PENDIENTE\'.');
			return success;
		}

		if(movType == 'Cobro'){
			var rounding = 1;
			var totalAmount = parseFloat($('#totalAmount').val()) || 0;
			var totalCharge = parseFloat($('#totalCharge').val()) || 0;

			totalAmount = new Decimal(totalAmount);

			var minimunCharge = totalAmount.minus(rounding).toNumber();
			var maximunCharge = totalAmount.plus(rounding).toNumber();

			if( totalCharge < minimunCharge || totalCharge > maximunCharge ){
				toolbar.showAlertModal('El cobro no cuadra con el importe total.');
				return success;
			}
		}

		success = true;

		return success;
	},

	verifyCancel: function(){
		var success = false;

		if(toolbar.movStatus && toolbar.movStatus != 'PENDIENTE' && toolbar.movStatus != 'CONCLUIDO'){
			toolbar.showAlertModal('Solo se pueden cancelar movimientos con estatus \'PENDIENTE\' o \'CONCLUIDO\'.');
			return success;
		}

		success = true;

		return success;
	},

	verifyDelete: function(){
		var success = false;

		if(toolbar.movStatus && toolbar.movStatus != 'SINAFECTAR'){
			toolbar.showAlertModal('Solo se pueden eliminar movimientos con estatus \'SINAFECTAR\'.');
			return success;
		}

		success = true;

		return success;
	}
};

$('#newMov').click(function(){
	//window.sessionStorage.setItem('toolbar-temp-redirect','cxc/movimiento/nuevo');
	toolbar.confirmSaveChanges(toolbar.newMov, 'new');
});
//$('#openMov').click(toolbar.openMov);
$('#openMov').click(function(){
	//window.sessionStorage.setItem('toolbar-temp-redirect','cxc/movimiento/abrir');
	toolbar.confirmSaveChanges(toolbar.openMov, 'open');
});
//$('#saveMov').click(toolbar.saveMov);
$('#saveMov').click(function(){
	toolbar.saveMov('save');
});
$('#deleteMov').click(toolbar.confirmDeleteMov);
$('#affectMov').click(function(){
	toolbar.affectMov();
});
$('#cancelMov').click(toolbar.confirmCancelMov);
$('#printMov').click(toolbar.printMov);

$('#confirmModal').on('hidden.bs.modal', function (event) {
	var modal = $(this);
	var btnPrimary = modal.find('.btn-primary');
	var btnDefault = modal.find('.btn-default');

	btnPrimary.html('Si');
	btnPrimary.off('click');

	btnDefault.html('No');
	btnDefault.off('click');

	console.log('hidden');
});

function generateText(){
	var textFile = null,
    makeTextFile = function (text) {
	    var data = new Blob([text], {type: 'text/plain',
									endings: 'native'});

	    // If we are replacing a previously generated file we need to
	    // manually revoke the object URL to avoid memory leaks.
	    if (textFile !== null) {
	      window.URL.revokeObjectURL(textFile);
	    }
	    textFile = window.URL.createObjectURL(data);

	    return textFile;
	};

	var create = document.getElementById('print');
	var link = document.createElement('a');
	var movMovID = '{{$mov->MovID}}';
	link.download = movMovID+'.txt';
    link.id = "downloadlink";
    link.style.display = "none";
    var actualDate = new Date();
    var date = actualDate.getDate() + "/" + (actualDate.getMonth() + 1) + "/" + actualDate.getFullYear();
	var hour = actualDate.getHours() + ":" + actualDate.getMinutes() + ":" + actualDate.getSeconds();
	//var mov = $('#cxcMovForm').serializeArray();
	var userName = '{{$user->name}}';
	var userCompany = '{{$mov->companyName->name}}';
	var userOffice = '{{$officeName}}';
	var clientId = $('#client_id').val();
	var clientName = document.getElementById('client[name]').value;
	console.log(userCompany);
	/*var userName = 'Administrador del sistema';
	var userCompany = 'ASSIS TU VESTIR';
	var userOffice = 'Matriz';*/
	var j=0;
	var nSpaceCounter = 0;
	var fourteenSpaces = "              ";
	var sixteenSpaces = "                ";
	var twentyfourSpaces = "                        ";
	/*for(var i=1;i<6;i++){
		var amount = $('#amount1').val();
		if(amount1){
			var charge_type1 = $('#charge_type1').val();
			var reference1 = $('#reference1').val();
		}
	}*/
	
	//console.log(movMovID);
	var TextOfTicket = putSpaces(1, centerText(date + " " + hour));
	TextOfTicket += putSpaces(1, centerText(userCompany));
	TextOfTicket += putSpaces(1, centerText(userOffice));
	TextOfTicket += putSpaces(1, centerText("Cobro: " + movMovID));
	TextOfTicket += putSpaces(1, centerText(clientId + " " + clientName));
    TextOfTicket += putSpaces(1,"-----------------------------------------------");
    /*for(var i=0;i<nDocumentsLenght;i++){
		var docName = documents[i].apply;
		var docConsecutive = documents[i].consecutive;
		var docAmount = documents[i].amount;
		TextOfTicket += putSpaces(1,docName);
		TextOfTicket += putSpaces(2,docConsecutive);
		TextOfTicket += putSpaces(2,"$" + docAmount,"right");
	}*/
	var nDocumentsLenght = aCxcD.length;
	for(var i=0;i<nDocumentsLenght;i++){
		var docName = aCxcD[i].apply;
		var docConsecutive = aCxcD[i].apply_id;
		var docAmount = moneyFormatForNumbers(aCxcD[i].amount);
		console.log(docAmount);
		TextOfTicket += putSpaces(1,docName);
		TextOfTicket += putSpaces(2,docConsecutive);
		TextOfTicket += putSpaces(2,"$" + docAmount + "  ","right");
	}
	TextOfTicket += putSpaces(1,"-----------------------------------------------");
	/*for(var j=0;j<nPaymentsLenght;j++){
		var payName = payments[j].name;
		var payType = payments[j].type;
		var payAmount = payments[j].amount;
		TextOfTicket += putSpaces(1,payName);
		TextOfTicket += putSpaces(2,payType);
		TextOfTicket += putSpaces(2,"$" + payAmount,"right");
	}*/

	for(var i=1;i<6;i++){
		var amount = $('#amount'+i).val();
		if(amount){
			var chargeName = 'Cobro'+i;
			var chargeType = $('#charge_type'+i).val();
			var chargeAmount = $('#amount'+i).val();
			TextOfTicket += putSpaces(1,chargeName);
			TextOfTicket += putSpaces(2,chargeType);
			TextOfTicket += putSpaces(2,'$'+chargeAmount + "  ",'right');
				
		}
	}
	TextOfTicket += putSpaces(1,"-----------------------------------------------");
	var totalAmount = $('#totalAmount').val();
	var change = $('#change').val();
	TextOfTicket += putSpaces(2,'Total:') + putSpaces(2,"$" + totalAmount + "  ","right");
	TextOfTicket += putSpaces(2,'Cambio:') + putSpaces(2,"$" + change + "  " ,"right");
	TextOfTicket += twentyfourSpaces + twentyfourSpaces;
	TextOfTicket += putSpaces(1,'Recibi:' + "________________________________");
	TextOfTicket += twentyfourSpaces + twentyfourSpaces + twentyfourSpaces+ twentyfourSpaces;
	TextOfTicket += putSpaces(1,"________________________");
	TextOfTicket += putSpaces(1,userName);
	var legend = "IMPORTANTE: Favor de conservar este comprobante para futuras aclaraciones.";
	TextOfTicket += legend;
	TextOfTicket += twentyfourSpaces + twentyfourSpaces + twentyfourSpaces+ twentyfourSpaces;
	/*var canvas = document.getElementById("pruebaImagen");
	var contextCanvas = canvas.getContext("2d");
	var img = document.getElementById("logoAssis");
	contextCanvas.drawImage(img,10,10);*/

    link.href = makeTextFile(TextOfTicket);
    link.click();
}

function putSpaces(columns, line, align){
	var maxSpaces = 48;
	var maxColumnLength = maxSpaces/columns;
	var lengthOfLine = line.length;
	if(lengthOfLine>maxColumnLength){
		line = line.substring(0,maxColumnLength);
	}else{
		var numberOfSpaces = maxColumnLength - lengthOfLine;	
		for(var i=0;i<numberOfSpaces;i++){
			if(align == "right"){
				line = " " + line;
			}else{
				line += " ";
			}
		}
	}
	return line;
}

function centerText(text){
	var maxSpaces = 48;
	var nTextLenght = text.length;
	var nTextLenghtSpaces = (maxSpaces - nTextLenght)/2;
	var nTextSpaces = "";
	for (var i = 0; i < nTextLenghtSpaces; i++) {
		nTextSpaces = nTextSpaces + " ";
	}
	nTextSpaces += text;
	return nTextSpaces;
}

function divideTextInLines(text){
	var nTextLenght = text.length;
	var maxSpaces = 48;
	var slicedText = "";
	for (var i = 0; i < nTextLenght; i=i+maxSpaces) {
		if (nTextLenght > i+maxSpace) {
			slicedText = text.slice(i,i+maxSpaces);
		}else{
			slicedText = text.slice(i,nTextLenght);
		}
	}

	
}

toolbar.redirect = function(url, method) {
	@if (count($errors) > 0)
		return;
	@endif

    var form = document.createElement('form');
    
    if(method = 'POST'){
	    var csrfInput = document.createElement('input');
	    csrfInput.type= 'hidden';
	    csrfInput.name = '_token';
	    csrfInput.value = '{{csrf_token()}}';
	    form.appendChild(csrfInput);
	}

    form.method = method;
    form.action = url;
    form.submit();
};

</script>