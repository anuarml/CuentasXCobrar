function verifyMov(/*movToVerify*/){
	var selectedMov = $('#Mov').val();
	//console.log(movToVerify);
	//console.log(selectedMov);
	switch(selectedMov){
		case 'Anticipo':
			//console.log(selectedMov);
			//$('#documentos').empty();
			//$('#documentos').remove();
			//console.log($('#documentos'));
			$('#tabDocs').remove();
			$('#dvProBalance').attr('hidden', true);
			//tabDocs
			//var tabDocuments = document.getElementById("documentos");
			//console.log(tabDocuments);
			//tabDocuments.hidden = true;
			//tabDocuments.disabled = true;
			//tabDocuments.remove();
			//tabDocuments.empty();
			break;
	}
}