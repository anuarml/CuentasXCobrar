@extends('templates.search')

@section('table-header')
    <th data-field="state" data-radio="true"></th>
    <th data-field="MovID" data-align="center" data-sortable="true">MovID</th>
    <th data-field="balance" data-align="center" data-sortable="true" data-formatter="moneyFormatter">Saldo</th>
    <th data-field="total_amount" data-align="center" data-sortable="true" data-formatter="moneyFormatter">Importe Total</th>
    <th data-field="emission_date" data-align="center" data-sortable="true">Emisión</th>
    <th data-field="expiration" data-align="center" data-sortable="true">Vencimiento</th>
    <th data-field="concept" data-align="center" data-sortable="true">Concepto</th>
@endsection

@section('action')
	<form id="documentForm" class="form-horizontal" role="form" method="POST" action="{{ url('/cxc/movimiento/save-document/'.$movID.'/'.$row) }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="movID" id="movID" value="">
		<input type="hidden" name="balance" id="balance" value="">
	</form>
@endsection

@section('scripts')
	<script type="text/javascript">
		$('#selectButton').click(function() {
			var selections = $('#searchTable').bootstrapTable('getSelections');

			if(selections.length < 1) {
				$('#alertModalBody').html('Elige un {{$searchType}}.');
				$('#alertModal').modal('show');
				return;
			}
			
			$('#movID').val(selections[0].MovID);
			$('#balance').val(selections[0].balance);
			$('#documentForm').submit();
		});
	</script>
@endsection
