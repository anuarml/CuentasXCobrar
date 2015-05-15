@extends('templates.search')

@section('table-header')
    <th data-field="state" data-radio="true"></th>
    <th data-field="Mov" data-align="center" data-sortable="true">Mov</th>
    <th data-field="MovID" data-align="center" data-sortable="true">MovID</th>
    <th data-field="emission_date" data-align="center" data-sortable="true">Fecha de Emisión</th>
    <th data-field="expiration_date" data-align="center" data-sortable="true">Fecha de Vencimiento</th>
    <th data-field="balance" data-align="center" data-sortable="true">Saldo</th>
@endsection

@section('action')
	<form id="movReferenceForm" class="form-horizontal" role="form" method="POST" action="{{ url('/cxc/movimiento/save-movement-reference/'.$movID) }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="movReferenceID" id="movReferenceID" value="">
	</form>
@endsection

@section('scripts')
	<script type="text/javascript">
		$('#selectButton').click(function() {
			var selections = $('#searchTable').bootstrapTable('getSelections');

			if(selections.length < 1) {
				$('#alertModalBody').html('Elige una {{$searchType}}.');
				$('#alertModal').modal('show');
				return;
			}
			
			$('#movReferenceID').val(selections[0].MovID);
			$('#movReferenceForm').submit();
		});
	</script>
@endsection