function verifyMov(/*movToVerify*/){
	var selectedMov = $('#Mov').val();
	//console.log(movToVerify);
	//console.log(selectedMov);
	switch(selectedMov){
		case 'Anticipo':
			console.log(selectedMov);
			//$('#documentos').empty();
			//$('#documentos').remove();
			//console.log($('#documentos'));
			$('#tabDocumentos').remove();
			//var tabDocuments = document.getElementById("documentos");
			//console.log(tabDocuments);
			//tabDocuments.hidden = true;
			//tabDocuments.disabled = true;
			//tabDocuments.remove();
			//tabDocuments.empty();
			break;
	}
}