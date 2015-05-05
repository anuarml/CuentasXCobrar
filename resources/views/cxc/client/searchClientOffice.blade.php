@extends('templates.search')

@section('table-header')
    <th data-field="state" data-radio="true"></th>
    <th data-field="id" data-align="right" data-sortable="true">ID</th>
    <th data-field="name" data-align="center" data-sortable="true">Nombre</th>
    <th data-field="address" data-sortable="true">Direccion</th>
@endsection

@section('action')
	<form id="clientOfficeForm" class="form-horizontal" role="form" method="POST" action="{{ url('/cxc/movimiento/save-client-office/'.$movID) }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="clientOfficeID" id="clientOfficeID" value="">
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
			
			$('#clientOfficeID').val(selections[0].id);
			$('#clientOfficeForm').submit();
		});
	</script>
@endsection