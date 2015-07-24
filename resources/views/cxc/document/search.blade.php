@extends('templates.search')

@section('table-header')
    <th data-field="state" data-checkbox="true"></th>
    <th data-field="MovID" data-align="center" data-sortable="true">MovID</th>
    <th data-field="balance" data-align="center" data-sortable="true" data-formatter="moneyFormatter">Saldo</th>
    <th data-field="total_amount" data-align="center" data-sortable="true" data-formatter="moneyFormatter">Importe Total</th>
    <th data-field="emission_date" data-align="center" data-sortable="true">Emisión</th>
    <th data-field="expiration" data-align="center" data-sortable="true">Vencimiento</th>
    <th data-field="delinquent_days" data-align="center" data-sortable="true">Días</th>
    <th data-field="concept" data-align="center" data-sortable="true">Concepto</th>
    <th data-field="factor" data-visible="false" data-switchable="false" data-searchable="false">Factor</th>
    <th data-field="shipment_state" data-visible="false" data-switchable="false" data-searchable="false">EmbarqueEstado</th>
@endsection

@section('action')
	<form id="documentForm" class="form-horizontal" role="form" method="POST" action="{{ url('/cxc/movimiento/save-document/'.$movID.'/'.$row) }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<!--<input type="hidden" name="movID" id="movID" value="">
		<input type="hidden" name="balance" id="balance" value="">-->
		<input type="hidden" name="json-documents" id="json-documents" value="">
	</form>
@endsection

@section('scripts')
	<script type="text/javascript">
		$('#selectButton').click(function() {
			var selections = $('#searchTable').bootstrapTable('getSelections');

			if(!selections || selections.length < 1) {
				$('#alertModalBody').html('Elige un {{$searchType}}.');
				$('#alertModal').modal('show');
				return;
			}
			
			/*$('#movID').val(selections[0].MovID);
			$('#balance').val(selections[0].balance);*/
			var documents = [];

			for(var i=0; i < selections.length; i++){
				documents.push({
					'movID':selections[i].MovID,
					'balance':selections[i].balance * selections[i].factor
				});
			}
			console.log(documents);
			var jsonDocuments = JSON.stringify(documents);

			$('#json-documents').val(jsonDocuments);
			$('#loading').show();
			$('#documentForm').submit();
		});

		$('#cancelButton').click(function(e) {
			e.preventDefault();

			$('#loading').show();

		    var form = document.createElement('form');
    
		    var csrfInput = document.createElement('input');
		    csrfInput.type= 'hidden';
		    csrfInput.name = '_token';
		    csrfInput.value = '{{csrf_token()}}';
		    form.appendChild(csrfInput);

		    form.method = 'POST';
		    form.action = "{{ url('cxc/movimiento/cancel-document/'.$movID.'/'.$row) }}";
		    form.submit();
		});

		function rowFormatter(row, index){
			
			var formatter = {};

			if(row && row.shipment_state && row.shipment_state.toUpperCase() == 'TRANSITO'){
				formatter.classes = 'success';
			}

			return formatter;
		}
		
	</script>
@endsection
