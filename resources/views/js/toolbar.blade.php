<script type="text/javascript">

var toolbar = {

	confirmSaveChanges : function(){

		$('#confirmModalBody').html('<img width="25px" src="{{asset("img/save.png")}}">&nbsp;&nbsp;&nbsp;&nbsp;¿Guardar cambios?');
		$('#confirmModal').find('.btn-default').click(toolbar.newMov);
		$('#confirmModal').find('.btn-primary').click(function(){
			var tempRedirect = window.sessionStorage.getItem('toolbar-temp-redirect');
			window.sessionStorage.setItem('toolbar-redirect',tempRedirect);
			toolbar.saveMov();
		});
		$('#confirmModal').modal('show');
	},

	confirmCancelMov : function(){

		$('#confirmModalBody').html('<img width="25px" src="{{asset("img/cancel.png")}}">&nbsp;&nbsp;&nbsp;&nbsp;¿Cancelar el movimiento?');
		$('#confirmModal').find('.btn-primary').click(function(){console.log('cancel');});
		$('#confirmModal').modal('show');
	},

	confirmDeleteMov : function(){

		$('#confirmModalBody').html('<img width="25px" src="{{asset("img/delete.png")}}">&nbsp;&nbsp;&nbsp;&nbsp;¿Eliminar el movimiento?');
		$('#confirmModal').find('.btn-primary').click(function(){console.log('delete');});
		$('#confirmModal').modal('show');
	},

	newMov : function(){
		toolbar.redirect("{{ url('cxc/movimiento/nuevo') }}", 'POST');
	},

	saveMov : function(){
		console.log('save');
		$('#documentsJson').val( JSON.stringify(aCxcD) );
		$('#cxcMovForm').submit();
	},

	printMov : function(){
		generateText();
	},

	checkRedirect: function(){
		var redirect = window.sessionStorage.getItem('toolbar-redirect');
		var base = '{{ url() }}';

		if(redirect){
			window.sessionStorage.removeItem('toolbar-redirect');
			toolbar.redirect(base + '/' + redirect);
		}
	},

	openMov : function(){
		window.location = "{{ url('cxc/movimiento/abrir')}}";
	}
};

$('#newMov').click(function(){
	window.sessionStorage.setItem('toolbar-temp-redirect','cxc/movimiento/nuevo');
	toolbar.confirmSaveChanges();
});
$('#openMov').click(toolbar.openMov);
/*$('#openMov').click(function(){
	//window.sessionStorage.setItem('toolbar-temp-redirect','cxc/movimiento/nuevo');
	toolbar.confirmSaveChanges();
});*/
$('#saveMov').click(toolbar.saveMov);
$('#deleteMov').click(toolbar.confirmDeleteMov);
$('#cancelMov').click(toolbar.confirmCancelMov);
$('#printMov').click(toolbar.printMov);

$('#confirmModal').on('hide.bs.modal', function (event) {
	var modal = $(this);
	modal.find('.btn-primary').off('click');
	console.log('hide');
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
	link.download = "info.txt";
    link.id = "downloadlink";
    link.style.display = "none";
    var actualDate = new Date();
    var date = actualDate.getDate() + "/" + (actualDate.getMonth() + 1) + "/" + actualDate.getFullYear();
	var hour = actualDate.getHours() + ":" + actualDate.getMinutes() + ":" + actualDate.getSeconds();
	//var mov = $('#cxcMovForm').serializeArray();

	/*var userName = '{{--$user->name--}}';
	var userCompany = '{{--$user->getSelectedCompany()--}}';
	var userOffice = '{{--$officeName--}}';*/
	var userName = 'Administrador del sistema';
	var userCompany = 'ASSIS TU VESTIR';
	var userOffice = 'Matriz';
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

	var TextOfTicket = putSpaces(1, fourteenSpaces + date + " " + hour);
	TextOfTicket += putSpaces(1, fourteenSpaces + userCompany + " " + userOffice);
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
		var docAmount = aCxcD[i].amount;
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
	TextOfTicket += putSpaces(1,'Leyenda...');
	TextOfTicket += twentyfourSpaces + twentyfourSpaces + twentyfourSpaces+ twentyfourSpaces;
	TextOfTicket += putSpaces(1,"_____________________");
	TextOfTicket += putSpaces(1,userName);
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

toolbar.checkRedirect();


</script>