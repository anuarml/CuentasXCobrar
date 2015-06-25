@extends('templates.search')

@section('table-header')
    <th data-field="state" data-radio="true"></th>
    <th data-field="ID" data-align="right" data-sortable="true" data-visible="false">ID</th>
    <th data-field="MovID" data-align="right" data-sortable="true">MovID</th>
    <th data-field="Mov" data-align="center" data-sortable="true">Movimiento</th>
    <th data-field="concept" data-sortable="true">Concepto</th>
    <th data-field="client_id" data-sortable="true">Cliente</th>
    <th data-field="total_amount" data-sortable="true" data-formatter="moneyFormatter">Importe</th>
    <th data-field="status" data-sortable="true">Estatus</th>
    <th data-field="emission_date" data-sortable="true">Emision</th>
@endsection

@section('action')
	<form id="searchMovForm" class="form-horizontal" role="form" method="POST" action="{{ url('cxc/movimiento/open-selected-mov') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="movID" id="movID" value="">
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
			
			$('#movID').val(selections[0].ID);
			$('#loading').show();
			$('#searchMovForm').submit();

		});
	</script>
@endsection