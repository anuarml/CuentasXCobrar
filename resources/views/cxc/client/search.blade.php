@extends('templates.search')

@section('content')

<table data-toggle="table" data-url="/cxc/cliente/clientes" data-height="400" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true">
	<thead>
	<tr>
	    <th data-field="state" data-checkbox="true"></th>
	    <th data-field="id" data-align="right" data-sortable="true">Item ID</th>
	    <th data-field="name" data-align="center" data-sortable="true">Item Name</th>
	    <th data-field="price" data-sortable="true">Item Price</th>
	</tr>
	</thead>
</table>

@endsection

@section('scripts')
<script src="{{ asset('js/bootstrap-table.min.js') }}"></script>
@endsection