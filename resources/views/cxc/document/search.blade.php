@extends('templates.search')

@section('table-header')
    <th data-field="state" data-radio="true"></th>
    <th data-field="mov_id" data-align="center" data-sortable="true">Cliente</th>
    <th data-field="balance" data-align="center" data-sortable="true">Nombre</th>
    <th data-field="total_amount" data-align="center" data-sortable="true">RFC</th>
    <th data-field="expiration" data-align="center" data-sortable="true">Vencimiento</th>
    <th data-field="emission_date" data-align="center" data-sortable="true">Emisión</th>
@endsection

@section('action')
	<form id="clientForm" class="form-horizontal" role="form" method="POST" action="{{ url('/cxc/movimiento/save-client/'.$movID) }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="clientID" id="clientID" value="">
		<input type="hidden" name="clientID" id="clientID" value="">
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
			
			$('#clientID').val(selections[0].id);
			$('#clientForm').submit();
		});
	</script>
@endsection

['Mov','mov_id', 'balance', 'total_amount', 'expiration', 'emission_date'];