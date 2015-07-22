<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Reporte de cobranza</title>

	<link rel="icon" type="image/jpg" href="{{ asset('/img/money.jpg') }}" />
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<!--<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>-->
	<link href="{{ asset('/css/bootstrap-table.min.css') }}" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script type="text/javascript">
        function preloader(){
            document.getElementById("loading").style.display = "none";
            //document.getElementById("content").style.display = "block";
        }
        window.onload = preloader;
	</script>
</head>
<body>
	<div id="loading"></div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="row">
					<div class="panel panel-default">
						<div class="panel-heading">Reporte de cobranza</div>
						<div class="panel-body">
							@if (count($errors) > 0)
								<div class="alert alert-danger">
									Resuelve los siguientes problemas.<br><br>
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
							<div class="row">
								<div class="col-xs-6 col-sm-4">
									<label for="totalCharged">Total cobrado:</label>
									<div class='input-group'>
				    					<div class='input-group-addon'>$</div>
										<input class="form-control input-sm" type="text" id="totalCharged" name="totalCharged" value="0.00" readonly>
									</div>
								</div>
								<div class="col-xs-6 col-sm-4">
									<label for="assignedCharged">Asignado cobrado:</label>
									<div class='input-group'>
				    					<div class='input-group-addon'>$</div>
										<input class="form-control input-sm" type="text" id="assignedCharged" name="assignedCharged" value="0.00" readonly>
									</div>
								</div>
								<div class="col-xs-6 col-sm-4">
									<label for="unassignedCharged">No asignado cobrado:</label>
									<div class='input-group'>
				    					<div class='input-group-addon'>$</div>
										<input class="form-control input-sm" type="text" id="unassignedCharged" name="unassignedCharged" value="0.00" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								<table id="showTable" data-toggle="table" data-url="{{ url($dataURL) }}" data-search="true" data-show-columns="true" data-show-refresh="true">
									<thead>
										<tr>
											<th data-field="client" data-align="center" data-sortable="true">Cliente</th>
										    <th data-field="mov" data-align="center" data-sortable="true">Mov</th>
										    <th data-field="movID" data-align="center" data-sortable="true">MovID</th>
										    <th data-field="balance" data-align="center" data-sortable="true" data-formatter="moneyFormatter">Saldo</th>
										    <th data-field="cashed" data-align="center" data-sortable="true" data-formatter="moneyFormatterRed">Cobrado</th>
										    <th data-field="assigned" data-align="center" data-sortable="true" data-formatter="booleanFormatter">Asignado</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
	<!--<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>-->
	<script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-table.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-table-es-MX.min.js') }}"></script>
	<script type="text/javascript">
		function moneyFormatter(value){
			var valueFormatted = parseFloat(value) || 0;

			return '$'+valueFormatted.toFixed(2);
		}
		function moneyFormatterRed(value){
			var valueFormatted = parseFloat(value) || 0;
			var style = '';
			if(value==0){
				style = 'color:red';
			}
			return '<span style="'+style+'">$'+valueFormatted.toFixed(2)+'</span>';
		}
		function booleanFormatter(value){
			var icon = '';
			var style = '';
			
			if(value == 1){
				style = 'color:green';
				icon = 'glyphicon glyphicon-ok';
			}
			else if(value == 2) {
				style = 'color:black';
				icon = 'glyphicon glyphicon-stop';
			}
			else {
				style = 'color:red';
				icon = 'glyphicon glyphicon-remove';
			}

			return '<span class="'+icon+'" aria-hidden="true" style="'+style+'"></span>';
		}
		
		$('#showTable').attr('data-height',$( window ).height() - 90 );

		$('#showTable').bootstrapTable({}).on('load-success.bs.table', function (e, data) {
            var charges = $('#showTable').bootstrapTable('getData');
			var nTotalCharged = 0;
			var nAssignedCharged = 0;
			var nUnassignedCharged = 0;

			if(charges){

				for(var i=0; i<charges.length; i++){

					var charge = charges[i];
					var chargeCashed = parseFloat(charge.cashed) || 0;

					nTotalCharged += chargeCashed;

					if(charge.assigned){
						nAssignedCharged += chargeCashed;
					}
					else{
						nUnassignedCharged += chargeCashed;
					}
				}

				$('#totalCharged').val(nTotalCharged.toFixed(2));
				$('#assignedCharged').val(nAssignedCharged.toFixed(2));
				$('#unassignedCharged').val(nUnassignedCharged.toFixed(2));
			}
        });

		$(window).resize(function () {
            var searchTable = $('#showTable');

            var tableHeight = 400;
	        if( $( window ).height()-80 > tableHeight){
	        	tableHeight = $( window ).height();
	        }

	        //searchTable.attr('data-height',tableHeight);
            searchTable.bootstrapTable('resetView',{'height':tableHeight});
            //searchTable.bootstrapTable('resetWidth');
        });
	</script>

</body>
</html> 