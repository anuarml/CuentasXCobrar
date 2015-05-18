@extends('templates.search')

@section('table-header')
    <th data-field="state" data-radio="true"></th>
    <th data-field="MovID" data-align="right" data-sortable="true">MovID</th>
    <th data-field="Mov" data-align="center" data-sortable="true">Movimiento</th>
    <th data-field="concept" data-sortable="true">Concepto</th>
    <th data-field="client_id" data-sortable="true">Client</th>
    <th data-field="amount" data-sortable="true">Importe</th>
    <th data-field="status" data-sortable="true">Estatus</th>
    <th data-field="emission_date" data-sortable="true">Emision</th>
@endsection

@section('action')
	<form id="searchMovForm" class="form-horizontal" role="form" method="POST" action="{{ url('cxc/movimiento/save-mov') }}">
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
			
			$('#movID').val(selections[0].MovID);
			$('#searchMovForm').submit();
		});
	</script>
@endsection