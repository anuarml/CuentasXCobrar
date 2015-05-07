@extends('templates.search')

@section('table-header')
    <th data-field="state" data-radio="true"></th>
    <th data-field="MovID" data-align="center" data-sortable="true">MovID</th>
    <th data-field="balance" data-align="center" data-sortable="true">Saldo</th>
    <th data-field="total_amount" data-align="center" data-sortable="true">Importe Total</th>
    <th data-field="emission_date" data-align="center" data-sortable="true">Emisión</th>
    <th data-field="expiration" data-align="center" data-sortable="true">Vencimiento</th>
@endsection

@section('action')
	<form id="documentForm" class="form-horizontal" role="form" method="POST" action="{{ url('/cxc/movimiento/save-document/'.$movID) }}">
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
			
			$('#movID').val(selections[0].mov_id);
			$('#documentForm').submit();
		});
	</script>
@endsection
