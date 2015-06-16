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
			$('#dvTotalAmount').attr('hidden', true);
			$('#dvDifference').attr('hidden', true);
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

/*document.onreadystatechange = function () {
  var state = document.readyState
  if (state == 'interactive') {
       document.getElementById('contents').style.visibility="hidden";
  } else if (state == 'complete') {
      //setTimeout(function(){
         document.getElementById('interactive');
         document.getElementById('load').style.visibility="hidden";
         document.getElementById('contents').style.visibility="visible";
      //},1000);
  }
}*/