function verifyMov(){
	var selectedMov = $('#Mov').val();

	switch(selectedMov){
		case 'Anticipo':
			$('#tabDocs').remove();
			$('#dvProBalance').attr('hidden', true);
			$('#dvTotalAmount').attr('hidden', true);
			$('#dvDifference').attr('hidden', true);
			break;
	}
}